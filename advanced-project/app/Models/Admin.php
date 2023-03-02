<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;




class Admin extends Authenticatable implements JWTSubject

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

protected $hidden = [
    'password',
    'remember_token',
];
/**
 * The attributes that should be cast to native types.
 *
 * @var array
 */
protected $casts = [
    'email_verified_at' => 'datetime',
];

/**
 * Get the identifier that will be stored in the subject claim of the JWT.
 *
 * @return mixed
 */
public function getJWTIdentifier() {
    return $this->getKey();
}
/**
 * Return a key value array, containing any custom claims to be added to the JWT.
 *
 * @return array
 */
public function getJWTCustomClaims() {
    return [];
}    
}


