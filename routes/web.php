<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;

Route::get('/admin/login', function () {
    return view('admin.pages.auth.login');
})->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/admin/dashboard', function () {
    return view('admin.pages.dashboard.index');
})->name('admin.dashboard');

// category
Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
Route::post('/admin/category/store', [CategoryController::class, 'storeCategory'])->name('admin.storeCategory');
Route::get('/admin/category/delete/{id}', [CategoryController::class, 'destroyCategory'])->name('admin.deleteCategory');
Route::get('/admin/category/edit/{id}', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
Route::post('/admin/category/update', [CategoryController::class, 'updateCategory'])->name('admin.categoryUpdate');

// Sub category
Route::get('/admin/subCategory', [SubCategoryController::class, 'index'])->name('admin.subCategory');
Route::post('/admin/subCategory/store', [SubCategoryController::class, 'storeCategory'])->name('admin.storeSubCategory');
Route::get('/admin/subCategory/delete/{id}', [SubCategoryController::class, 'destroySubCategory'])->name('admin.deleteSubCategory');
Route::get('/admin/subCategory/edit/{id}', [SubCategoryController::class, 'editSubCategory'])->name('admin.editSubCategory');
Route::post('/admin/subCategory/update', [SubCategoryController::class, 'updateSubCategory'])->name('admin.updateSubCategory');


// === child category ===
Route::get('/admin/childCategory', [ChildCategoryController::class, 'index'])->name('admin.childCategory');
Route::post('/admin/childCategory/store', [ChildCategoryController::class, 'storeChildCategory'])->name('admin.storeChildCategory');
Route::get('/admin/childCategory/delete/{id}', [ChildCategoryController::class, 'destroyChildCategory'])->name('admin.deleteChildCategory');
Route::get('/admin/childCategory/edit/{id}', [ChildCategoryController::class, 'editChildCategory'])->name('admin.editChildCategory');
Route::post('/admin/childCategory/update', [ChildCategoryController::class, 'ChildcategoryUpdate'])->name('admin.ChildcategoryUpdate');

// === sabCategoryByCategoyId
Route::get('/admin/sabCategoryByCategoyId/{id}', [ChildCategoryController::class, 'sabCategoryByCategoyId']);
Route::get('/admin/chlidCategoryBySabCategoyId/{id}', [ChildCategoryController::class, 'chlidCategoryBySabCategoyId']);

// === Brand ====
Route::get('/admin/brand', [BrandController::class, 'index'])->name('admin.brand');
Route::post('/admin/brand/store', [BrandController::class, 'storeBrand'])->name('admin.storeBrand');
Route::get('/admin/brand/delete/{id}', [BrandController::class, 'destroyBrand'])->name('admin.destroyBrand');
Route::get('/admin/brand/edit/{id}', [BrandController::class, 'editBrand'])->name('admin.editBrand');
Route::post('/admin/brand/update', [BrandController::class, 'brandUpdate'])->name('admin.brandUpdate');


// === size =====
Route::get('/admin/settings/size', [SettingController::class, 'sizeIndex'])->name('settings.sizeIndex');
Route::post('/admin/settings/size/store', [SettingController::class, 'sizeStore'])->name('Settings.sizeStore');
Route::get('/admin/settings/size/edit/{id}', [SettingController::class, 'editSize'])->name('settings.editSize');
Route::post('/admin/settings/size/update', [SettingController::class, 'sizeUpdate'])->name('settings.sizeUpdate');
Route::get('/admin/settings/size/delete/{id}', [SettingController::class, 'destroySize'])->name('settings.destroySize');

// ====== color =====
Route::get('/admin/settings/color', [SettingController::class, 'colorIndex'])->name('settings.colorIndex');
Route::post('/admin/settings/color/store', [SettingController::class, 'colorStore'])->name('Settings.colorStore');
Route::get('/admin/settings/color/edit/{id}', [SettingController::class, 'editColor'])->name('settings.editColor');
Route::post('/admin/settings/color/update', [SettingController::class, 'colorUpdate'])->name('settings.colorUpdate');
Route::get('/admin/settings/color/delete/{id}', [SettingController::class, 'destroyColor'])->name('settings.destroyColor');

// === products =====
Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/products/create', [ProductController::class, 'createProductPage'])->name('products.create');
Route::post('/admin/products/create', [ProductController::class, 'createProduct']);
Route::get('/admin/products/edit/{productId}', [ProductController::class, 'editeProductPage'])->name('editeProduct');
Route::post('/admin/products/edit/{productId}', [ProductController::class, 'updateProduct']);
Route::get('/admin/products/delete/{productId}', [ProductController::class, 'deleteProduct'])->name('deleteProduct');
Route::post('/admin/products/druft/Update/{productId}', [ProductController::class, 'ProductDruftUpdate'])->name('products.druft.update');
Route::get('/search/productsByName', [ProductController::class, 'productsByName'])->name('products.search');

// === products Quantity =====
Route::get('/admin/products/addQty/{productId}', [ProductController::class, 'addQtyPage'])->name('products.addQty');
Route::post('/admin/products/addQty/{productId}', [ProductController::class, 'addQty']);
Route::get('/admin/products/QtyById/{qtyId}', [ProductController::class, 'QtyById']);
Route::post('/admin/products/QtyUpdate', [ProductController::class, 'QtyUpdate'])->name('products.QtyUpdate');
Route::post('/admin/products/Qty/druft/Update/{qtyId}', [ProductController::class, 'QtyDruftUpdate'])->name('qty.druft.update');
Route::get('/admin/products/Qty/delete/{qtyId}', [ProductController::class, 'QtyDelete'])->name('Qty.delete');
Route::get('/admin/products/{productId}', [ProductController::class, 'QtyDetails'])->name('products.QtyDetails');

// === products Discount =====
Route::get('/admin/products/discount/index/{productId}', [DiscountController::class, 'disIndex'])->name('products.disIndex');
Route::post('/admin/products/discount/addDis/{productId}', [DiscountController::class, 'addDis'])->name('products.addDis');
Route::post('/admin/products/discount/status/Update/{disId}', [DiscountController::class, 'discountStatusUpdate'])->name('discountStatusUpdate');
Route::get('/admin/products/discount/delete/{disId}', [DiscountController::class, 'DeleteDis'])->name('product.DeleteDis');
Route::get('/admin/products/discount/edit/{disId}', [DiscountController::class, 'editDiscount'])->name('admin.editDiscount');
Route::post('/admin/products/discount/update', [DiscountController::class, 'updateDiscount'])->name('admin.updateDiscount');


Route::get('/admin/hello', [SubCategoryController::class, 'hello']);
