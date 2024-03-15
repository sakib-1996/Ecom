<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductQty;
use App\Models\ProductSEO;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ChildCategory;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Casts\Json;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('productQtys')->get();
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
        // Validate request data
        $request->validate([
            'title' => 'required|string',
            'product_id' => 'required|unique:products,product_id',
            'weight' => 'nullable|string',
            'minimum_purchase' => 'required|string',
            'tags' => 'required|string',
            'thum_img' => 'required|image|mimes:jpeg,png,webp,jpg|max:2048',
            'description' => 'required|string',
            'category_id' => 'required'
        ]);

        // Create a new Product instance
        $product = new Product;

        // Assign values from the request to the Product instance
        $product->title = $request->title;
        $product->slug = Str::slug($request->title, '-');
        $product->product_id = '#' . $request->product_id;
        $product->brand_id = $request->brand_id;
        $product->cat_id = $request->category_id;
        $product->subCat_id = $request->subCat_id;
        $product->childCat_id = $request->childCat_id;
        $product->weight = $request->weight;
        $product->minimum_purchase = $request->minimum_purchase;
        $product->tags = $request->tags;
        $product->barcode = $request->barcode;
        $product->description = $request->description;
        $product->related_product = $request->product_id;

        // Set refundable and cash_on_delivary based on request data
        $product->refundable = $request->has('refundable') ? 1 : 0;
        $product->cash_on_delivary = $request->has('cash_on_delivary') ? 1 : 0;

        // Handle product thumbnail image upload
        $product->thum_img = 'files/product/' . $this->handleImageUpload($request->file('thum_img'), 'public/files/product/');

        // Save the product
        $product->save();

        // Create and save SEO properties for the product
        $seoProperty = new ProductSEO;
        $seoProperty->product_id = $product->id;
        $seoProperty->meta_title = $request->meta_title;
        $seoProperty->meta_des = $request->meta_des;
        $seoProperty->meta_slug = $request->meta_slug;

        // Handle SEO thumbnail image upload
        $seoProperty->meta_img = 'files/product_seo/' . $this->handleImageUpload($request->file('meta_img'), 'public/files/product_seo/');

        $seoProperty->save();

        // Redirect back with a success message
        $notification = ['message' => 'Brand Inserted!', 'alert-type' => 'success'];
        return redirect()->route('products.index')->with($notification);
    }



    public function editeProductPage($productId)
    {
        $categories = Category::get();
        $brands = Brand::get();
        $product = Product::find($productId);
        $seoProperty = ProductSEO::find($productId);
        return view('admin.pages.product.editeProduct', compact('product', 'categories', 'brands', 'seoProperty'));
    }


    public function updateProduct(Request $request, $productId)
    {

        // dd($product_id);
        // Validate request data
        $request->validate([
            'title' => 'required|string',
            'product_id' => [
                'required',
                Rule::unique('products', 'product_id')->ignore($productId),
            ],
            'weight' => 'nullable|string',
            'minimum_purchase' => 'required|string',
            'tags' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required'
        ]);
        $product_id = str_replace('#', '', $request->product_id);
        // Find the product
        $product = Product::find($productId);

        // Update the product attributes
        $product->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'product_id' => '#' . $product_id,
            'brand_id' => $request->brand_id,
            'cat_id' => $request->category_id,
            'subCat_id' => $request->subCat_id,
            'childCat_id' => $request->childCat_id,
            'weight' => $request->weight,
            'minimum_purchase' => $request->minimum_purchase,
            'tags' => $request->tags,
            'barcode' => $request->barcode,
            'description' => $request->description,
            'related_product' => $request->product_id,

            // Set refundable and cash_on_delivary based on request data
            'refundable' => $request->has('refundable') ? 1 : 0,
            'cash_on_delivary' => $request->has('cash_on_delivary') ? 1 : 0,
        ]);


        if ($request->thum_img) {
            $imagePath = public_path('storage/' . $request->oldThum);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            // dd($request->thum_img);
            // Working with image
            $newThum_img = 'files/product/' . $this->handleImageUpload($request->file('thum_img'), 'public/files/product/');
            // dd($newThum_img);
            $product->update(['thum_img' => $newThum_img]);
        } else {
            $product->update(['thum_img' =>  $request->oldThum]);
        }

        $productSeo = ProductSEO::where('product_id', $productId)->first();

        $productSeo->update([
            'meta_title' => $request->meta_title,
            'meta_des' => $request->meta_des,
            'meta_slug' => $request->meta_slug,
        ]);
        // Handle SEO thumbnail image update

        if ($request->hasFile('meta_img')) {
            // Check if old image exists and delete it
            $oldImagePath = public_path('storage/' . $request->oldMeta_img);
            if (File::exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Working with new image
            $newMeta_img = 'files/product_seo/' . $this->handleImageUpload($request->file('meta_img'), 'public/files/product_seo/');
            $productSeo->update(['meta_img' => $newMeta_img]);
        } else {
            // No new image provided, retain the old one
            $product->update(['meta_img' => $request->oldMeta_img]);
        }
        // Redirect back with a success message
        $notification = ['message' => 'Product updated successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }


    public function deleteProduct($productId)
    {
        // Check if the product exists
        $product = Product::find($productId);
        if (!$product) {

            $notification = ['message' => 'Product Not Found !', 'alert-type' => 'error'];
            return redirect()->back()->with($notification);
        }

        // Delete the thumbnail image
        $productImg = $product->thum_img;
        $imagePath = public_path('storage/' . $productImg);
        if (File::exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the SEO image
        $productSeo = ProductSEO::where('product_id', $productId)->first();
        // dd($productSeo);
        if ($productSeo->meta_img) {
            $producSeotImg = $productSeo->meta_img;
            $seoImagePath = public_path('storage/' . $producSeotImg);
            if (File::exists($seoImagePath)) {
                unlink($seoImagePath);
            }
        }

        // Delete the product
        $productSeo->delete();
        $product->delete();

        // Redirect back with a success message
        $notification = ['message' => 'Product Deleted successfully!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }



    public function addQtyPage($productId)
    {
        $product = Product::find($productId);
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.pages.product.addQty', compact('product', 'sizes', 'colors'));
    }

    public function addQty(Request $request, $productId)
    {
        $request->validate([
            'qty' => 'required|numeric',
            'unit_price' => 'required',
            'purchase_price' => 'required',
            'size_id' => 'required_without_all:color_id,unit',
            'color_id' => 'required_without_all:size_id,unit',
            'unit' => 'required_without_all:size_id,color_id',
        ]);
        // dd($productId);
        ProductQty::create([
            'qty' => $request->qty,
            'unit_price' => $request->unit_price,
            'purchase_price' => $request->purchase_price,
            'size_id' => $request->size_id,
            'color_id' => $request->color_id,
            'unit' => $request->unit,
            'current_qty' => $request->qty,
            'product_id' => $productId,
        ]);
        $product = Product::find($productId);
        $product->update(['status' => true]);
        // Redirect back with a success message
        $notification = ['message' => 'Quantity Inserted!', 'alert-type' => 'success'];
        return redirect()->route('products.QtyDetails', $productId)->with($notification);
    }

    public function QtyDetails($productId)
    {
        $productQtys = ProductQty::where('product_id', $productId)
            ->with('size', 'color')
            ->get();
        $product = Product::find($productId);
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.pages.product.productQtyDetails', compact('productQtys', 'product', 'sizes', 'colors'));
    }


    public function QtyById($qtyId)
    {
        $qtyByid = ProductQty::find($qtyId);
        return response()->json($qtyByid);
    }


    public function QtyUpdate(Request $request)
    {
        $rules = [
            'unit_price' => 'required|numeric',
            'qty' => 'required',
            'purchase_price' => 'required|numeric',
            'size_id' => 'required_without_all:color_id,unit',
            'color_id' => 'required_without_all:size_id,unit',
            'unit' => 'required_without_all:size_id,color_id',
        ];

        $validatorMessages = [
            'unit_price.required' => 'Unit price is required.',
            'qty.required' => 'Qty  is required.',
            'unit_price.numeric' => 'Unit price must be a number.',
            'purchase_price.required' => 'Purchase price is required.',
            'purchase_price.numeric' => 'Purchase price must be a number.',
            'size_id.required_without_all' => 'Size is required when neither color nor unit is provided.',
            'color_id.required_without_all' => 'Color is required when neither size nor unit is provided.',
            'unit.required_without_all' => 'Unit is required when neither size nor color is provided.',
        ];

        $validator = Validator::make($request->all(), $rules, $validatorMessages);

        if ($validator->fails()) {
            $errorMessage = implode($validator->errors()->all());
            $notification = ['message' => $errorMessage, 'alert-type' => 'error'];
            return redirect()->back()->with($notification)->withInput();
        }
        // dd($request->id);

        if ($request->id) {
            $productQty = ProductQty::find($request->id);
            $unit = substr($request->unit, 0, 255);
            // dd($unit);
            $productQty->update([
                'unit_price' => $request->unit_price,
                'qty' => $request->qty,
                'current_qty' => $request->qty,
                'purchase_price' => $request->purchase_price,
                'size_id' => $request->size_id,
                'color_id' => $request->color_id,
                'unit' => $unit,
            ]);

            $notification = ['message' => 'Quantity Updated!', 'alert-type' => 'success'];
            return redirect()->back()->with($notification);
        }

        $notification = ['message' => 'Quantity Not Found !', 'alert-type' => 'error'];
        return redirect()->back()->with($notification);
    }

    public function QtyDelete($qtyId)
    {
        ProductQty::find($qtyId)->delete();

        $notification = ['message' => 'Quantity Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }


    public function QtyDruftUpdate($qtyId)
    {
        // dd($id);
        $qtyStatus = ProductQty::findOrFail($qtyId);
        $newStatus = $qtyStatus->druft == 0 ? 1 : 0;
        // dd($newStatus);
        $qtyStatus->update(['druft' => $newStatus]);
        return back();
    }

    public function ProductDruftUpdate($productId)
    {
        // dd($productId);
        $productDrStatus = Product::findOrFail($productId);
        $newDrStatus = $productDrStatus->druft == 0 ? 1 : 0;
        // dd($newDrStatus);
        $productDrStatus->update(['druft' => $newDrStatus]);
        return back();
    }










    private function handleImageUpload($imageFile, $directory)
    {
        // dd($imageFile);
        $imageName = uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $image = Image::make($imageFile)->fit(900, 900)->encode();
        Storage::put($directory . $imageName, $image);
        // dd($imageName);
        return $imageName;
    }
}
