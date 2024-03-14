<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('admin.pages.category.index', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
        ]);

        $slug = Str::slug($request->category_name, '-');
        // dd($request->all());
        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => $slug,
        ]);

        $notification = array('message' => 'Category Inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //edit method
    public function editCategory($id)
    {
        $data = Category::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
        return response()->json($data);
    }
    public function updateCategory(Request $request)
    {

        $categoryId = $request->input('id'); // Assuming 'id' is the name of the field holding the category ID

        $validated = $request->validate([
            'category_name' => 'required|max:255|unique:categories,category_name,' . $categoryId,
        ]);

        $category = Category::findorfail($categoryId);
        // dd($category);
        $slug = Str::slug($request->category_name, '-');
        $category->update([
            'category_name' => $request->category_name,
            'category_slug' => $slug,
        ]);
        $notification = array('message' => 'Category Updated Successfull!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //delete method
    public function destroyCategory($id)
    {
        // dd($id);

        $category = Category::find($id);
        $category->delete();

        $notification = array('message' => 'Category Deleted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
