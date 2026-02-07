<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'supplier_id', // <--- MAKE SURE THIS IS HERE
        'barcode',
        'cost_price',
        'sale_price',
        'qty',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ADD THIS FUNCTION
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}