<?php

  namespace App\Http\Controllers;

  use App\Models\Item;
  use App\Models\Brand;
  use App\Models\Category;
  use App\Exports\ItemsExport;
  use Maatwebsite\Excel\Facades\Excel;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Storage;
  use PDF;
  use Dompdf\Dompdf;

  class ItemController extends Controller
  {
      public function index(Request $request)
      {
          $query = Auth::user()->is_admin ? Item::query() : Auth::user()->items();

          if ($request->filled('search')) {
              $search = $request->input('search');
              $query->where(function ($q) use ($search) {
                  $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
              });
          }

          if ($request->filled('status')) {
              $query->where('status', $request->input('status'));
          }

          $items = $query->with('brand', 'category')->paginate(5)->appends($request->query());

          return view('items.index', compact('items'));
      }

      public function create()
      {
          $brands = Auth::user()->is_admin ? Brand::all() : Auth::user()->brands;
          $categories = Auth::user()->is_admin ? Category::all() : Auth::user()->categories;
          return view('items.create', compact('brands', 'categories'));
      }

      public function store(Request $request)
      {
          $request->validate([
              'brand_id' => 'required|exists:brands,id',
              'category_id' => 'required|exists:categories,id',
              'code' => 'required|unique:items|max:255',
              'name' => 'required|max:255',
              'attachment' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
          ]);

          $data = [
              'brand_id' => $request->brand_id,
              'category_id' => $request->category_id,
              'code' => $request->code,
              'name' => $request->name,
              'status' => $request->status ?? 'Active',
          ];

          if ($request->hasFile('attachment')) {
              $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
          }

          Auth::user()->items()->create($data);

          return redirect()->route('items.index')->with('success', 'Item created successfully.');
      }

      public function edit(Item $item)
      {
          $this->authorizeItem($item);
          $brands = Auth::user()->is_admin ? Brand::all() : Auth::user()->brands;
          $categories = Auth::user()->is_admin ? Category::all() : Auth::user()->categories;
          return view('items.edit', compact('item', 'brands', 'categories'));
      }

      public function update(Request $request, Item $item)
      {
          $this->authorizeItem($item);
          $request->validate([
              'brand_id' => 'required|exists:brands,id',
              'category_id' => 'required|exists:categories,id',
              'code' => 'required|unique:items,code,' . $item->id . '|max:255',
              'name' => 'required|max:255',
              'attachment' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
          ]);

          $data = [
              'brand_id' => $request->brand_id,
              'category_id' => $request->category_id,
              'code' => $request->code,
              'name' => $request->name,
          ];

          if ($request->hasFile('attachment')) {
              if ($item->attachment) {
                  Storage::disk('public')->delete($item->attachment);
              }
              $data['attachment'] = $request->file('attachment')->store('attachments', 'public');
          }

          $item->update($data);

          return redirect()->route('items.index')->with('success', 'Item updated successfully.');
      }

      public function destroy(Item $item)
      {
          $this->authorizeItem($item);
          if ($item->attachment) {
              Storage::disk('public')->delete($item->attachment);
          }
          $item->delete();
          return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
      }

      public function exportCsv()
      {
          return Excel::download(new ItemsExport, 'items.csv');
      }

      public function exportExcel()
      {
          return Excel::download(new ItemsExport, 'items.xlsx');
      }

      public function exportPdf()
      {
          $items = Auth::user()->is_admin ? Item::with('brand', 'category')->get() : Auth::user()->items()->with('brand', 'category')->get();
          $pdf = PDF::loadView('items.pdf', compact('items'));
          return $pdf->download('items.pdf');
      }

      private function authorizeItem(Item $item)
      {
          if (!Auth::user()->is_admin && $item->user_id !== Auth::user()->id) {
              abort(403, 'Unauthorized action.');
          }
      }
  }
