<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FixedTransaction;    

class FixedKey extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];
    public $timestamps = false;
    public function fixed_transactions()
{
    return $this->hasMany(FixedTransaction::class);
}
}
