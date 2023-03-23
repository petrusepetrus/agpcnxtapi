<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PhoneUser extends Pivot
{

    protected $table='phone_user';

    protected $fillable=[
        'user_id',
        'phone_id',
        'phone_type_id',
        'preferred_contact_number'
    ];

    /**
     * Each phone is attached to one or more users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Each user has one or more phones
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phone(){
        return $this->belongsTo(Phone::class,'phone_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phoneType(){
        return $this->belongsTo(PhoneType::class,'phone_type_id');
    }
}
