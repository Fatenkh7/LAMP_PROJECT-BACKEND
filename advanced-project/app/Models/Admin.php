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
public function fixed_transactions()
{
    return $this->hasMany(FixedTransaction::class);
}
public function recurring_transactions()
{
    return $this->hasMany(RecurringTransaction::class);
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
