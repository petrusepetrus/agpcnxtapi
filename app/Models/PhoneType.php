<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PhoneType extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_type'
    ];

    /**
     * Each phone belongs to one or more users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phoneUser(){
        return $this->hasMany('App\Models\PhoneUser');
    }

    /**
     * Each phone will be of a particular type (home, business, mobile...)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phonePhoneType(){
        return $this->hasMany(Pivot::class,'phone_type_id');
    }
}
