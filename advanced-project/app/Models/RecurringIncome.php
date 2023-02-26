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
        'start_date',
        'end_date',
    ];
    public function currencies()
    {
        return $this->belongsTo(Currency::class);
    }
    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
