<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\categories as Category;

class AdminSubcategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        // ✅ Use paginate instead of get
        $subcategories = Subcategory::with('category')->latest()->paginate(10); // 10 per page

        return view('admin.subcategories.index', compact('categories','subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
        ]);

        Subcategory::create([
            'subcategory_name' => $request->subcategory_name,
            'category_id' => $request->category_id,
        ]);

        return back()->with('success','Subcategory added successfully!');
    }
    // Edit
public function edit($id)
{
    $subcategory = Subcategory::findOrFail($id);
    $categories = Category::all();
    return view('admin.subcategories.edit', compact('subcategory', 'categories'));
}

// Update
public function update(Request $request, $id)
{
    $request->validate([
        'subcategory_name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,category_id',
    ]);

    $sub = Subcategory::findOrFail($id);
    $sub->update([
        'subcategory_name' => $request->subcategory_name,
        'category_id' => $request->category_id,
    ]);

    return redirect()->route('admin.subcategories')->with('success', 'Subcategory updated successfully!');
}

// Destroy
public function destroy($id)
{
    $sub = Subcategory::findOrFail($id);
    $sub->delete();

    return redirect()->route('admin.subcategories')->with('success', 'Subcategory deleted successfully!');
}

}
