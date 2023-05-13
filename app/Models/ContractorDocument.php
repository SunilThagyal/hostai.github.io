<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorDocument extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'document_name',
        'uploaded_file_name',
        'uploaded_file_url',
        'valid_between',
        'status'
    ];
    public function RejectedDocument()
    {

        return $this->hasOne(RejectedDocuments::class,'document_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class ,"user_id","user_id");
    }


}



