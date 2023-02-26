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
    
    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function fixed_incomes()
    {
        return $this->hasMany(FixedIncome::class);
    }
    public function fixed_expenses()
    {
        return $this->hasMany(FixedExpense::class);
    }
    public function recurring_incomes()
    {
        return $this->hasMany(RecurringIncome::class);
    }
    public function recurring_expenses()
    {
        return $this->hasMany(RecurringExpense::class);
    }
}
