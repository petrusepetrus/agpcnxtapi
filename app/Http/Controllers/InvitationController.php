<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\EnquiryStatus;
use App\Models\Invitation;
use App\Notifications\InviteNotification;
use Carbon\Carbon;
use http\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;


class InvitationController extends Controller
{
    public function show($id)
    {
        try{
            $invitation = Invitation::where('invitation_token', $id)
                ->first();

                return $invitation;


        }catch(ModelNotFoundException $ex){
            abort(422,'Invalid invitation: invitation not found');
        }catch(\Exception $ex){
            abort(500,'Could not process the nominated invitation');
        }
    }

    public function store(Request $request)
    {
        Log::error($request->get('email'));
        $rules = array
        (
            'email' => 'required|unique:invitations'
        );
        $messages = array
        (
            'email.required' => 'You must include an email address',
            'email.unique' => 'An invitation already exists for this email',
        );
        $request->validate($rules, $messages);

        $rules = array
        (
            'email' => 'unique:users'
        );
        $messages = array
        (
            'email.unique' => 'A user with this email already exists in the system'
        );
        $request->validate($rules, $messages);


        $invitation_token = $this->generateInvitationToken();
        $registered = Carbon::now();
        $expires = Carbon::now()->addHours(72);

        $invitation = new Invitation([
            'invitation_token' => $invitation_token,
            'email' => $request->get('email'),
            'registered_at' => $registered,
            'expires_at' => $expires,
        ]);
        $invitation->save();

        $url = env('SPA_URL') . '/invite-registration?token=' . $invitation_token;

        Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));

        /*
         * Get the 'new' enquiry_status_id to add to the record
         */
        $new_status_id = EnquiryStatus::where('enquiry_status', '=', 'Invited')->value('id');
        $enquiry=Enquiry::where('id','=',$request->get('enquiry_id'))->first();

        $enquiry->enquiry_status_id = $new_status_id;
        $enquiry->save();

    }
    public function revoke($id)
    {
        try{
            $invitation = Invitation::where('invitation_token', $id)
                ->first();
            $invitation->delete();
        }catch(ModelNotFoundException $ex){
            abort(422,'Invalid invitation: invitation not found');
        }catch(\Exception $ex){
            abort(500,'Could not process the nominated invitation');
        }

    }

    public function generateInvitationToken()
    {
        do {
            $token = Str::random(20);
        } while (
            Invitation::where("invitation_token", "=", $token)->exists()
        );
        return $token;
    }


}
