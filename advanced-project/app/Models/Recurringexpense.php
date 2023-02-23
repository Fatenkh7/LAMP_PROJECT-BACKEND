<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurringexpense extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'amount',
        'startDate',
        'endDate',
    ];
    public $timestamps = false;
}
