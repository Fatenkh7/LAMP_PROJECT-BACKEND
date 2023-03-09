<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $fillable = [
        'currency',
        'rate'
    ];
    public $timestamps = false;
    public function fixed_transactions()
    {
        return $this->hasOne(FixedTransaction::class);
    }
    public function recurring_transactions()
    {
        return $this->hasOne(RecurringTransaction::class);
    }
    public function profit_goals()
    {
        return $this->hasOne(ProfitGoal::class);
    }

}
