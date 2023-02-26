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
    public function fixed_expenses()
    {
        return $this->hasOne(FixedExpense::class);
    }
    public function fixed_incomes()
    {
        return $this->hasOne(fixedIncome::class);
    }
    public function recurring_incomes()
    {
        return $this->hasOne(RecurringIncome::class);
    }
    public function recurring_expenses()
    {
        return $this->hasOne(RecurringExpense::class);
    }
    public function profit_goals()
    {
        return $this->hasOne(ProfitGoal::class);
    }

}
