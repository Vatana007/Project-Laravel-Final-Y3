<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // These fields are allowed to be mass-assigned by the Controller
    protected $fillable = [
        'name',
        'phone',
        'address'
    ];

    // Optional: If you ever want to see which products belong to a supplier
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}