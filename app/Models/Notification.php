<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
   use HasFactory;
    protected $fillable = [
        'renewable_id',
        'message',
        
    ];

    public function renewable(){
        return $this->belongsTo(Renewable::class, 'renewable_id');
    }
}
