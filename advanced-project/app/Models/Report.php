<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'report',
        'type_report',
        'start_date',
        'end_date',
    ];
    public $timestamps = false;

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }    
    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
