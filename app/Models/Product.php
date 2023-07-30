<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\ProductCategory;

class Product extends Model
{

    protected $fillable = [
        'product_code',
        'image',
        'name',
        'selling_price',
        'purchase_price',
        'stock',
        'category_id'
    ];

    protected $hidden = [];

    // Relasi
    public function category() {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }
}
