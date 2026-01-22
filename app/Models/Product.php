<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'supplier_id', 'name', 'barcode', 
        'cost_price', 'sale_price', 'qty', 'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}