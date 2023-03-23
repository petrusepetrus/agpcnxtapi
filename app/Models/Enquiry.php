<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'first_name',
        'last_name',
        'enquiry_date',
        'enquiry',
        'enquiry_type_id',
    ];

    /**
     * Each enquiry has a status
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enquiryStatus()
    {
        return $this->belongsTo(EnquiryStatus::class);
    }

    /**
     * Each enquiry has an associated enquiry type
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enquiryType()
    {
        return $this->belongsTo(EnquiryType::class);
    }

    /**
     * Each enquirer has the potential to become a user, in which
     * case the enquiry history is mapped back to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class,'email','email');
    }

    /**
     * Each enquiry can have on one or more comments attached to it
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enquiryComments()
    {
        return $this->hasMany(EnquiryComment::class);
    }
}
