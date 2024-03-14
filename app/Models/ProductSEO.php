<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSEO extends Model
{
    use HasFactory;
    protected $fillable = [
        'meta_title',
        'meta_des',
        'meta_img',
        'meta_slug',
    ];
}