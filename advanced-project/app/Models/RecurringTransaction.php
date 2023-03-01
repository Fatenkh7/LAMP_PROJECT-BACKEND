<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurringTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'type',
        'amount',
        'start_date',
        'end_date',
        'schedule'
    ];
    // Define the allowed types as a static variable
    public static $allowedTypes = ['income', 'expense'];
    public static $allowedSchedule = ['yearly', 'monthly', 'weekly'];
    public static $allowedPaid = ['0', '1'];
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
