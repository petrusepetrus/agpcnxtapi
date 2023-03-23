<?php

use App\Http\Controllers\AddressTypeController;
use App\Http\Controllers\AddressUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EnquiryCommentController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\EnquiryStatusController;
use App\Http\Controllers\EnquiryTypeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PhoneTypeController;
use App\Http\Controllers\PhoneUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\UserTypeStatusController;
use App\Http\Controllers\UserUserTypeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/auth', AuthController::class);
    Route::get('/users/{id}', function (Request $id) {
        return User::findOrFail($id);
    });
    Route::get('/users', [UserController::class, 'searchUsers']);
    Route::get('/user/{id}',[UserController::class,'show']);
    Route::post('/user/{id}',[UserController::class,'update']);
    Route::get('/user-exists/{email}',[UserController::class,'checkUserExists']);

    Route::get('/user-roles/{id}',[UserController::class,'getUserRoles']);
    Route::get('/user-permissions/{id}',[UserController::class,'getUserPermissions']);
    Route::get('/user-types/user/{id}', [UserController::class, 'getUserUserTypes']);
    Route::post('/update-user-types/user/{id}', [UserController::class, 'updateUserTypes']);

    Route::get('/user-addresses/{id}', [UserController::class, 'getUserAddresses']);
    Route::get('/user-phones/{id}', [UserController::class, 'getUserPhones']);


    Route::get('/get-notification-preference/user/{id}', [UserController::class, 'getUserNotificationPreference']);
    Route::post('/create-notification-preference/user/{id}', [UserController::class, 'createUserNotificationPreference']);
    Route::post('/update-notification-preference/user/{id}', [UserController::class, 'updateUserNotificationPreference']);

    Route::get('/get-notification-topics',[NotificationController::class,'index']);
    Route::get('/get-notification-topics/user/{id}', [UserController::class, 'getUserNotificationTopics']);

    Route::get('/address-types', [AddressTypeController::class, 'index']);
    Route::get('/available-address-types/user/{id}', [AddressUserController::class, 'getAvailableAddressTypes']);
    Route::post('/store-address/user/{id}', [AddressUserController::class, 'store']);
    Route::post('/update-address/user/{id}/address/{addressid}', [AddressUserController::class, 'update']);
    Route::delete('/delete-address/user/{id}/address/{addressid}', [AddressUserController::class, 'destroy']);

    Route::get('/user-types', [UserTypeController::class, 'index']);
    Route::get('/user-type-status', [UserTypeStatusController::class, 'index']);
    Route::get('/available-user-types/user/{id}', [UserUserTypeController::class, 'getAvailableUserTypes']);

    Route::get('/available-phone-types/user/{id}', [PhoneUserController::class, 'getAvailablePhoneTypes']);
    Route::post('/store-phone/user/{id}',[PhoneUserController::class,'store']);
    Route::post('/update-phone/user/{id}/phone/{phoneid}',[PhoneUserController::class,'update']);
    Route::delete('/delete-phone/user/{id}/phone/{phoneid}',[PhoneUserController::class,'destroy']);

    Route::get('/enquiries', [EnquiryController::class, 'searchEnquiries']);
    Route::get('/enquiry/{id}',[EnquiryController::class,'show']);
    Route::delete('/delete-enquiry/{id}',[EnquiryController::class,'destroy']);

    Route::get('/enquiry-statuses', [EnquiryStatusController::class, 'index']);

    Route::post('/create-enquiry-comment/enquiry/{id}',[EnquiryController::class,'addEnquiryComment']);
    Route::post('/update-enquiry-comment/enquiry/{id}',[EnquiryCommentController::class,'update']);
    Route::delete('/delete-enquiry-comment/{id}',[EnquiryCommentController::class,'destroy']);
    Route::get('/get-enquiry-comments/enquiry/{id}',[EnquiryController::class,'getEnquiryComments']);

    Route::post('/update-enquiry-status/{id}/status/{status}', [EnquiryController::class, 'updateEnquiryStatus']);

    Route::post('/invite/enquirer/', [InvitationController::class, 'store']);
});

Route::get('/countries', [CountryController::class, 'getCountries']);
Route::get('/phone-types', [PhoneTypeController::class, 'index']);
Route::get('/enquiry-types', [EnquiryTypeController::class, 'index']);
Route::post('/store-enquiry',[EnquiryController::class,'store']);
Route::get('/retrieve-invitation/{id}', [InvitationController::class, 'show']);
Route::post('/revoke-invitation/{id}', [InvitationController::class, 'revoke']);

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact your nominated representative.'], 404);
});

