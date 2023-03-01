<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedTransaction extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'type',
        'amount',
        'is_paid',
        'date_time'
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

//     public function category()
// {
//     return $this->belongsTo(Category::class, 'categories_id');
// }

    public function fixed_keys()
    {
        return $this->belongsTo(FixedKey::class);
    }
}
