<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;
    protected $fillable=[
        'email',
        'sms',
        'opt_out'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
