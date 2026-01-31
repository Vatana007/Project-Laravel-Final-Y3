<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Optimized to count products automatically
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    // --- FIX: Add this missing function ---
    public function create()
    {
        return view('categories.create');
    }
    // --------------------------------------

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories']);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('success', 'Category added!');
    }

    public function destroy(Category $category)
    {
        // Fix: Use withTrashed() to find ALL products (even deleted ones)
        // and unlink them from this category.
        $category->products()->withTrashed()->update(['category_id' => null]);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required']);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Category updated');
    }
}