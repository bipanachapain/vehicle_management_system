<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Renewable extends Model
{
    use hasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'renewable_date',
        'document_type_id',
        'expired_date',
        'status',
    ];
     protected $casts = [
        'renewable_date' => 'date',
        'expired_date'   => 'date',
        'status'         => 'boolean',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    
    public function notifications()
{
    return $this->hasMany(Notification::class);
}

     public function renewableHistories()
    {
        return $this->hasMany(RenewableHistory::class);
    }
    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
    public function latestHistory()
    {
    return $this->hasOne(RenewableHistory::class)->latestOfMany();
   }
    
}
