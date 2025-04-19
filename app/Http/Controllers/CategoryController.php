<?php

  namespace App\Http\Controllers;

  use App\Models\Category;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class CategoryController extends Controller
  {
      public function index()
      {
          $categories = Auth::user()->is_admin
              ? Category::paginate(5)
              : Auth::user()->categories()->paginate(5);
          return view('categories.index', compact('categories'));
      }

      public function create()
      {
          return view('categories.create');
      }

      public function store(Request $request)
      {
          $request->validate([
              'code' => 'required|unique:categories|max:255',
              'name' => 'required|max:255',
          ]);

          Auth::user()->categories()->create([
              'code' => $request->code,
              'name' => $request->name,
              'status' => $request->status ?? 'Active',
          ]);

          return redirect()->route('categories.index')->with('success', 'Category created successfully.');
      }

      public function edit(Category $category)
      {
          $this->authorizeCategory($category);
          return view('categories.edit', compact('category'));
      }

      public function update(Request $request, Category $category)
      {
          $this->authorizeCategory($category);
          $request->validate([
              'code' => 'required|unique:categories,code,' . $category->id . '|max:255',
              'name' => 'required|max:255',
          ]);

          $category->update([
              'code' => $request->code,
              'name' => $request->name,
          ]);

          return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
      }

      public function destroy(Category $category)
      {
          $this->authorizeCategory($category);
          $category->delete();
          return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
      }

      private function authorizeCategory(Category $category)
      {
          if (!Auth::user()->is_admin && $category->user_id !== Auth::user()->id) {
              abort(403, 'Unauthorized action.');
          }
      }
  }
