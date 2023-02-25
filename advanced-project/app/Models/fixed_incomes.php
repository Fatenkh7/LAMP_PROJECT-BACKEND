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
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
