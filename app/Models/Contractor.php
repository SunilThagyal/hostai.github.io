<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'contractor_id',
        'company_name',
        'document_status',
        'manager_id',
        'is_approved',
        'approved_by',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userSites()
    {
        return $this->hasMany(UserSite::class,'user_id');
    }

    public function unapprovedContractors()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->where('role','subcontractor');
    }

    public function architect()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function contractorOf()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function scopeManagerCheck($query)
    {
        $user = Auth::user();
        if( $user->role == config('constants.project-manager') )
            $query->where('manager_id',$user->id);
        elseif( $user->role == config('constants.main-manager') )
            $query->where('manager_id',$user->assignedManagers->project_manager_id);
        return $query;
    }
}
