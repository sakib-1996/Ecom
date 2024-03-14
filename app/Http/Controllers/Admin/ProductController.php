<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
        return view('admin.pages.product.index', compact('products'));
    }

    public function createProductPage()
    {
        $categories = Category::get();
        $brands = Brand::get();
        return view('admin.pages.product.create', compact('categories', 'brands'));
        // dd($request->all());
    }

    public function createProduct(Request $request)
    {
        // dd($request->brand_id);
        $request->validate([
            'title' => 'required|string',
            'product_id' => 'required',
            'weight' => 'nullable|string',
            'minimum_purchase' => 'required|string',
            'tags' => 'required|string',
            'thum_img' => 'required|image|mimes:jpeg,png,webp,jpg|max:2048',
            'description' => 'required|string',
            // 'meta_title' => 'required|string',
            'category_id' => 'required'
        ]);
        // dd($request->all());
        $product = new Product;
        $product->title = $request->title;
        $product->slug = Str::slug($request->title, '-');
        $product->product_id = '#'.$request->product_id;
        $product->brand_id = $request->brand_id;
        $product->cat_id = $request->category_id;
        $product->subCat_id = $request->subCat_id;
        $product->childCat_id = $request->childCat_id;
        $product->weight = $request->weight;
        $product->minimum_purchase = $request->minimum_purchase;
        $product->tags = $request->tags;
        $product->barcode = $request->product_id;
        $product->description = $request->description;
        $product->related_product = $request->product_id;

        if ($request->refundable === 'on') {
            $product->refundable = 1;
        }
        $product->refundable = 0;

        if ($request->cash_on_delivary === 'on') {
            $product->cash_on_delivary = 1;
        }
        $product->cash_on_delivary = 0;


        // Working with image
        $photo = $request->file('thum_img');
        $photoname = uniqid() . '.' . $photo->getClientOriginalExtension();
        $directory = 'public/files/product/';
        $image = Image::make($photo)->fit(900, 900)->encode();
        Storage::put($directory . $photoname, $image);
        $product->thum_img = 'files/product/' . $photoname;
        $product->save();


















        $notification = ['message' => 'Brand Inserted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    public function addQty($productId)
    {
        $product = Product::find($productId);
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.pages.product.addQty',compact('product','sizes','colors'));
    }
}
