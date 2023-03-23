<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\EnquiryComment;
use App\Models\EnquiryStatus;
use App\Models\EnquiryType;
use App\Models\User;
use App\Notifications\EnquiryAlert;
use App\Notifications\EnquiryReceived;
use App\Searches\EnquirySearch\EnquirySearch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Notification;


class EnquiryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $enquiry_list = EnquirySearch::apply($request);


        //$user_list=User::with('roles')
        //->with('permissions')
        //    ->with('userUserType')
        //    ->with('userUserType.userType')
        //->with('userUserType.userTypeStatus');


        if ($request->has('recordsPerPage')) {
            $recordsPerPage = $request->recordsPerPage;
        } else {
            $recordsPerPage = 5;
        }

        return $enquiry_list->paginate($recordsPerPage);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
         * Create the validation rules for the form Header
         * and Footer sections that are used in all types
         * of enquiries
         */
        $validation_rules = [
            'first_name' => [
                'required',
                'string'],
            'last_name' => [
                'required',
                'string'],
            'email' => ['required',
                'string',
                'email',
                'max:255'],
            'phone_number' => 'required',
            'international_dialling_code' => 'required',
            'country' => 'required',
            'phone_type' => 'required',
            'enquiry_type' => 'required',
            'terms_and_conditions' => 'required',
        ];
        /*
         * Extend the base validation rules with the validation rules
         * pertinent to the type of enquiry being made
         */
        switch ($request->enquiry_type) {
            case 'Something Else':
            case 'New Website':
                $validation_rules['enquiry'] = [
                    'required',
                    'string',
                    'max:512'];
                break;
            case 'Website Maintenance':
            case 'Search Engine Optimisation and Ranking':
            case 'Redesign of Existing Website':
                $validation_rules['business_name'] = [
                    'required',
                    'string',
                    'max:512'];
                $validation_rules['business_url'] = [
                    'required',
                    'string',
                    'max:512'];
                $validation_rules['enquiry'] = [
                    'required',
                    'string',
                    'max:512'];
                break;
        }
        /*
         * Validate the enquiry
         */
        $request->validate($validation_rules);
        /*
         * Format the new enquiry. Parameters missing in the request#
         * will be defaulted to null.
         */
        $enquiry = new Enquiry;
        $enquiry->first_name = $request->get('first_name');
        $enquiry->last_name = $request->get('last_name');
        $enquiry->name = $enquiry->first_name . ' ' . $enquiry->last_name;
        $enquiry->email = $request->get('email');
        $enquiry->phone_number = $request->get('phone_number');
        $enquiry->international_dialling_code = $request->get('international_dialling_code');
        $enquiry->country = $request->get('country');
        $enquiry->country_id = $request->get('country_id');
        $enquiry->phone_type = $request->get('phone_type');
        $enquiry->phone_type_id = $request->get('phone_type_id');
        $enquiry->enquiry_type = $request->get('enquiry_type');
        $enquiry->enquiry_type_id = $request->get('enquiry_type_id');

        $enquiry->business_name = $request->get('business_name');
        $enquiry->business_url = $request->get('business_url');
        $enquiry->other_social_media = $request->get('other_social_media');

        $enquiry->marketing_chk = $request->get( 'marketing_chk');
        $enquiry->ecommerce_chk = $request->get('ecommerce_chk');
        $enquiry->blog_chk = $request->get('blog_chk');
        $enquiry->portfolio_chk = $request->get('portfolio_chk');
        $enquiry->membership_chk = $request->get('membership_chk');
        $enquiry->personal_chk = $request->get('personal_chk');
        $enquiry->nonprofit_chk = $request->get('nonprofit_chk');

        $enquiry->google_chk = $request->get('google_chk');
        $enquiry->you_tube_chk = $request->get('you_tube_chk');
        $enquiry->facebook_chk = $request->get('facebook_chk');
        $enquiry->twitter_chk = $request->get('twitter_chk');
        $enquiry->tik_tok_chk = $request->get('tik_tok_chk');
        $enquiry->linked_in_chk = $request->get('linked_in_chk');
        $enquiry->snapchat_chk = $request->get('snapchat_chk');
        $enquiry->other_chk = $request->get('other_chk');
        $enquiry->other_social_media = $request->get('other_social_media');

        $enquiry->bare_bones_chk = $request->get('bare_bones_chk');
        $enquiry->maintenance_plus_chk = $request->get('maintenance_plus_chk');

        $enquiry->enquiry = $request->get('enquiry');
        $enquiry->mailing_list = $request->get('mailing_list');
        $enquiry->terms_and_conditions = $request->get('terms_and_conditions');
        $enquiry->enquiry_date = Carbon::now()->toDateTimeString();
        /*
         * Get the 'new' enquiry_status_id to add to the record
         */
        $new_status_id = EnquiryStatus::where('enquiry_status', '=', 'new')->first()->value('id');
        $enquiry->enquiry_status_id = $new_status_id;

        Log::error($enquiry);
        /*
         * And save it to the enquiry table
         */
        $enquiry->save();
        $email=$request->get('email');
        Log::error($email);
        Notification::route('mail',$email)
            ->notify(new EnquiryReceived);
        Notification::route('mail',env('MAIL_FROM_ADDRESS'))
            ->notify(new EnquiryAlert($enquiry));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        $enquiry = Enquiry::where('id', $id)
            ->with('enquiryType')
            ->with('enquiryStatus')
            ->with(['enquiryComments' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }])
            ->with(['user' => function ($query) {
                $query
                    ->with('roles')
                    ->with('permissions')
                    ->with('userUserType.userType')
                    ->with('userUserType.userTypeStatus')
                    ->with('notificationPreference');
            }])
            ->first();

        Log::error($enquiry);
        return $enquiry;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param $id
     * @param $status
     * @return void
     */
    public function update($id, $status)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $enquiry=Enquiry::where('id','=',$id);
        $enquiry->delete();
    }

    public function updateEnquiryStatus($id, $status)
    {
        $enquiry = Enquiry::where('id', $id)->first();
        $status = EnquiryStatus::where('enquiry_status', '=', $status)->first();
        $enquiry->enquiry_status_id = $status->id;
        $enquiry->save();
    }

    public function addEnquiryComment($id, Request $request)
    {
        Log::error($id." ".$request['enquiry_comment']);
        $enquiryComment =EnquiryComment::create([
            'enquiry_id' => $id,
            'comment' => $request['enquiry_comment']
        ]);
        Log::error($enquiryComment);
        $enquiryComment->save();
    }

    public function checkUserExists($email)
    {
        /*
         * ->with('roles')->with('permissions')->first()
         */
        $user = User::where('email', $email)
            ->with('roles')
            ->with('permissions')
            ->with('userUserType.userType')
            ->with('userUserType.userTypeStatus')
            ->with('notificationPreference')
            ->first();
        return $user;
    }

    public function searchEnquiries(Request $request)
    {
        //return Enquiry::with('enquiryType')->get();

        $enquiry_list = EnquirySearch::apply($request);
        //$user_list=User::with('roles')
        //->with('permissions')
        //    ->with('userUserType')
        //    ->with('userUserType.userType')
        //->with('userUserType.userTypeStatus');


        if ($request->has('recordsPerPage')) {
            $recordsPerPage = $request->recordsPerPage;
        } else {
            $recordsPerPage = 5;
        }

        return $enquiry_list->paginate($recordsPerPage);
    }

    public function getEnquiryComments($id)
    {
        $comments=EnquiryComment::where('enquiry_id','=',$id)->get();
        return $comments;
    }
}
