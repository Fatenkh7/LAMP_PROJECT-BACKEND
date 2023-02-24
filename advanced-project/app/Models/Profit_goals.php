<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profit_goals extends Model
{
    use HasFactory;
    protected $fillable = [
        'goal_title',
        'goal_amount',
        'goal_description',
        'start_date',
        'end_date',
    ];
    public $timestamps = false;
}
