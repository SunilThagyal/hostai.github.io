<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable implements MustVerifyEmail
{
    // use SoftDeletes;
    use HasSlug, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'slug',
        'first_name',
        'last_name',
        'email',
        'password',
        'location',
        'profile_file',
        'profile_url',
        'certificate_file',
        'certificate_url',
        'created_by',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'fullName',
    ];

    /**
     * Get user full name
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function firstName(): Attribute
    // {
    //     return Attribute::make(
    //         set: fn ($value) => explode(" ", $value)[0],
    //     );
    // }

    /**
     * Interact with the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    // protected function lastName(): Attribute
    // {
    //     return Attribute::make(
    //         set: function($value) {
    //             $fullName = explode(" ", $value);
    //             array_shift($fullName);

    //             return count($fullName) ? implode(" ", $fullName) : null;
    //         }
    //     );
    // }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $data = [
            'name' => $this->first_name,
            'email' => $this->email,
        ];

        return $this->notify(new PasswordReset($token, $data));
    }

    public function userSites()
    {
        return $this->hasMany(UserSite::class);
    }

    public function workerSite()
    {
        return $this->hasOne(UserSite::class);
    }

    public function contractor()
    {
        return $this->hasOne(Contractor::class);
    }

    public function managers()
    {
        return $this->hasMany(Manager::class, 'project_manager_id');
    }

    public function assignedManagers()
    {
        return $this->hasOne(Manager::class, 'user_id','id');
    }
    public function Worker()
    {
        return $this->hasOne(Worker::class);
    }

    public function userDocuments()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function safetyDocuments()
    {
        return $this->hasMany(UserDocument::class)->where('document_type', 'safety');
    }

    public function adminDocuments()
    {
        return $this->hasMany(UserDocument::class)->where('document_type', 'administrative');
    }

    public function contractorDocuments()
    {
        return $this->hasMany(ContractorDocument::class);
    }

    public function architectContractors()
    {
        return $this->hasMany(Contractor::class, 'manager_id');
    }

    public function contractorWorkers()
    {
        return $this->hasMany(Worker::class, 'contractor_id');
    }

    public function architectWorkers()
    {
        return $this->hasMany(Worker::class, 'manager_id');
    }

    public function unapprovedContractors()
    {
        return $this->hasOne(Contractor::class,'user_id','id')->where('document_status','submitted');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['first_name', 'last_name'])
            ->saveSlugsTo('slug');
    }
}
