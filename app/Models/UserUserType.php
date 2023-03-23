<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserUserType extends Pivot
{
    protected $table='user_user_type';

    protected $fillable=[
        'user_id',
        'user_type_id',
        'user_type_status_id'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function userType(){
        return $this->belongsTo(UserType::class,'user_type_id');
    }

    public function userTypeStatus(){
        return $this->belongsTo(UserTypeStatus::class,'user_type_status_id');
    }
}
