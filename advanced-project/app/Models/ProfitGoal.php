<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfitGoal extends Model
{
    use HasFactory;
    protected $fillable = [
        'goal_title',
        'goal_amount',
        'goal_description',
        'start_date',
        'end_date',
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
}
