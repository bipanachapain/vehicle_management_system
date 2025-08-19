<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [

    'id', 
    'user_id',
    'vehicle_type_id',
    'name',
    'purchase_date'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
    public function renewables()
    {
        return $this->hasMany(Renewable::class);
    }
    public function renewableHistories()
    {
        return $this->hasMany(RenewableHistory::class);
    }
}
