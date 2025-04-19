<?php

  namespace App\Http\Controllers;

  use App\Models\Brand;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class BrandController extends Controller
  {
      public function index()
      {
          $brands = Auth::user()->is_admin
              ? Brand::paginate(5)
              : Auth::user()->brands()->paginate(5);
          return view('brands.index', compact('brands'));
      }

      public function create()
      {
          return view('brands.create');
      }

      public function store(Request $request)
      {
          $request->validate([
              'code' => 'required|unique:brands|max:255',
              'name' => 'required|max:255',
          ]);

          Auth::user()->brands()->create([
              'code' => $request->code,
              'name' => $request->name,
              'status' => $request->status ?? 'Active',
          ]);

          return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
      }

      public function edit(Brand $brand)
      {
          $this->authorizeBrand($brand);
          return view('brands.edit', compact('brand'));
      }

      public function update(Request $request, Brand $brand)
      {
          $this->authorizeBrand($brand);
          $request->validate([
              'code' => 'required|unique:brands,code,' . $brand->id . '|max:255',
              'name' => 'required|max:255',
          ]);

          $brand->update([
              'code' => $request->code,
              'name' => $request->name,
          ]);

          return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
      }

      public function destroy(Brand $brand)
      {
          $this->authorizeBrand($brand);
          $brand->delete();
          return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
      }

      private function authorizeBrand(Brand $brand)
      {
          if (!Auth::user()->is_admin && $brand->user_id !== Auth::user()->id) {
              abort(403, 'Unauthorized action.');
          }
      }
  }
