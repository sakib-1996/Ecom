<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'product_id',
        'brand_id',
        'cat_id',
        'subCat_id',
        'childCat_id',
        'weight',
        'minimum_purchase',
        'barcode',
        'refundable',
        'cash_on_delivary',
        'thum_img',
        'description',
        'related_product',
        'status',
        'druft',
        'short_des'
    ];

    protected $casts = [
        'refundable' => 'boolean',
        'cash_on_delivary' => 'boolean',
        'related_product' => 'array',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subCat_id');
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class, 'childCat_id');
    }

    public function productQtys()
    {
        return $this->hasMany(ProductQty::class);
    }
    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }

    // public function seo()
    // {
    //     return $this->hasOne(ProductSEO::class);
    // }

}
