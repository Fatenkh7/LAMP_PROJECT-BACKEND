<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
    ];
    public $timestamps = false;
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
public function recurring_expennses()
{
    return $this->hasMany(RecurringExpense::class);
}
public function recurring_incomes()
{
    return $this->hasMany(RecurringIncome::class);
}
public function profit_goals()
{
    return $this->hasMany(ProfitGoal::class);
}
public function categories()
{
    return $this->hasMany(Category::class);
}
}
