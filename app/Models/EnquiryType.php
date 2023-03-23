<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryType extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_type',
    ];

    /**
     * Each enquiry has an associated type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enquiry(){
        return $this->hasOne(Enquiry::class);
    }
}
