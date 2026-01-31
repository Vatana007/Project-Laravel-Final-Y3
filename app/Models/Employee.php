<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    // This links to the 'employees' table in your database
    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_id',
        'start_date', // Required by your table
    ];

    // Link to the Position model
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}