<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'employment_type',
        'contractor_id',
        'manager_id',
        'sub_manager_ids',
        'worker_id',
        'remark',
        'is_approved',
        'approved_by',
        
    ];

    public static function boot(){
        parent::boot();
        static::creating(function ($worker) {
            $worker->worker_id = Str::uuid(36);
        });
    }

    public function subManagerIds(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => is_null($value) ? [] : explode(',', $value),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workerContractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function architect()
    {
        // dd($this->belongsTo(User::class, 'manager_id')->get()->toArray());
        return $this->belongsTo(User::class, 'manager_id');
    }



}
