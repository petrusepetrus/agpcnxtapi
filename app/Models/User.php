<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles,HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
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

    /**
     * Each user can have one or more phones via the phoneUser pivot table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     */
    public function phones()
    {
        return $this
            ->belongsToMany('App\Models\Phone')
            ->withPivot('phone_type_id', 'preferred_contact_number')
            ->withTimestamps();
    }

    public function addresses()
    {
        return $this
            ->belongsToMany('App\Models\Address')
            ->withPivot('address_type_id', 'preferred_contact_address')
            ->withTimestamps();
    }

    public function userUserType()
    {
        return $this->hasMany('App\Models\UserUserType');
    }

    public function userTypes()
    {
        return $this->belongsToMany('App\Models\UserType')
            ->withTimestamps();
    }
    public function notificationPreference()
    {
        return $this->hasOne(NotificationPreference::class);
    }
    public function notificationTopics()
    {
        return $this
            ->belongsToMany(NotificationTopic::class,'notification_topic_user')
            ->withTimestamps();
    }
}
