<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringIncome extends Model
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
