<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Message extends Model
{
    use HasFactory;
protected $fillable = ['message', 'document_type_id'];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class);
    }
}
