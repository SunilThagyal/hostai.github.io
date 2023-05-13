<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class UserSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'site_id',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }
    public function userDocuments()
    {
        return $this->belongsTo(Site::class, 'user_id','user_id');
    }
}
