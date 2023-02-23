<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recurring_income extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'amount',
        'currency',
        'start_date',
        'end_date',
    ];
}
