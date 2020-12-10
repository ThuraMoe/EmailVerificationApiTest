<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\EmployeePersonal;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class VerificationController extends Controller
{
    use MustVerifyEmail;

    /**
     * Show the email verification notice.
     */

    public function show()
    {

    }

    /**
     * Mark the authenticated user's email address as verified.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request) {
        $userID = $request['id'];
        try {
            $user = EmployeePersonal::findOrFail($userID);
            $date = date("Y-m-d g:i:s");
            $user->email_verified_at = $date; // to enable the “email_verified_at field of that user be a current time stamp by mimicing the must verify email feature
            $user->save();
            return response()->json('Email verified!');
            // if email is verified, then redirect to the url you want
            // we will redirect to our front-end server
            // return Redirect::to('http://localhost:3000/dashboard');
        } catch (\Throwable $th) {
            Log::debug($th->getMessage());
            return response()->json(['status' => 'Email verification fail!', 'error' => $th->getMessage()]);
        }
            
    }

    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $id = $request->user_id;
        try {
            $user = EmployeePersonal::findOrFail($id);
            if ($user->hasVerifiedEmail()) {
                return response()->json('User already have verified email!', 422);
            }
            $user->sendApiEmailVerificationNotification();
            return response()->json('The notification has been resubmitted');
        } catch (\Throwable $th) {
            return response()->json(['message' => 'User not found', 'error' => $th->getMessage()]);
        }
            
    }
}
