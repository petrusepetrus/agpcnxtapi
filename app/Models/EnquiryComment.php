<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'enquiry_id',
        'comment',
    ];

    /**
     * Each comment belongs to an enquiry
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class);
    }

}
