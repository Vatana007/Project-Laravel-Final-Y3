<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $guarded = [];
    public $timestamps = false; // Usually details don't need separate timestamps
}