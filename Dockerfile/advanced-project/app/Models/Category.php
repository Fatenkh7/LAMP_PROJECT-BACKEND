<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'category_description',
    ];
    public $timestamps = false;

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function fixed_transactions()
    {
        return $this->hasMany(FixedTransaction::class);
    }
    public function recurring_transactions()
    {
        return $this->hasMany(RecurringTransaction::class);
    }
}
