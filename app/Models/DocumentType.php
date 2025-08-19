<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['id','name', 'duration'];


    public function messages()
{
    return $this->hasMany(Message::class);
}
}
