<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class RenewableHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'renewable_id',
        'user_id',
        'vehicle_id',
        'renewable_date',
        'expired_date',
        'renewable_type_id',
    ];

    public function renewable()
    {
        return $this->belongsTo(Renewable::class);
    }


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }       
   

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
