<?php

namespace App\Http\Controllers;

use App\Models\EnquiryStatus;
use Illuminate\Http\Request;

class EnquiryStatusController extends Controller
{
    public function index()
    {
        return EnquiryStatus::get(['enquiry_status','id'])->sortBy('enquiry_status');
    }
}
