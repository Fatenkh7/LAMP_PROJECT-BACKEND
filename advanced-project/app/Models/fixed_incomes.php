<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fixed_incomes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'amount',
        'currency',
        'date_time',
    ];
}
