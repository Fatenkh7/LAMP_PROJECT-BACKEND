<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class FixedExpenses extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'amount',
        'date',
    ];
    public $timestamps = false;
}

