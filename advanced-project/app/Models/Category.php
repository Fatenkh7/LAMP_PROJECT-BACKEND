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
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
    public function fixedIncomes()
    {
        return $this->hasMany(FixedIncome::class);
    }
    public function fixedExpenses()
    {
        return $this->hasMany(FixedExpense::class);
    }
    public function recurringIncome()
    {
        return $this->hasMany(RecurringIncome::class);
    }
    public function recurringExpense()
    {
        return $this->hasMany(RecurringExpense::class);
    }
}
