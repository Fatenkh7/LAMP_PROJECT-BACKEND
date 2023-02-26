<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringExpense extends Model
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
