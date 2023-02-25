<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'currency',
    ];
    public $timestamps = false;
    public function fixedExpense()
    {
        return $this->hasOne(FixedExpense::class);
    }
    public function fixedIncome()
    {
        return $this->hasOne(fixedIncome::class);
    }
    public function recurringIncome()
    {
        return $this->hasOne(RecurringIncome::class);
    }
    public function recurringExpense()
    {
        return $this->hasOne(RecurringExpense::class);
    }
    public function profitGoal()
    {
        return $this->hasOne(ProfitGoal::class);
    }

}
