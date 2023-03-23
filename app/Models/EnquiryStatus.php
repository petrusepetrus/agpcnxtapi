<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_status',
    ];

    /**
     * Each enquiry has an associated status
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enquiry()
    {
        return $this->hasOne('App\Models\Enquiry');
    }
}
