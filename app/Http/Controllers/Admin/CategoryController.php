<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\categories as Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
            'description'   => 'nullable',
            'image'         => 'nullable|image|max:2048'
        ]);

        $data = $request->only('category_name', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success','Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|unique:categories,category_name,' . $category->category_id . ',category_id',
            'description'   => 'nullable',
            'image'         => 'nullable|image|max:2048'
        ]);

        $data = $request->only('category_name', 'description');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success','Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success','Category deleted!');
    }
}
