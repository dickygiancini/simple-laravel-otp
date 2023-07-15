<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserVerificationRequest;
use App\Mail\VerificationEmail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserVerificationController extends Controller
{
    //
    public function notice()
    {
        $sendEmail = $this->sendEmail();

        if($sendEmail->status !== 200) {
            Session::flash('error', $sendEmail->message);
        }

        return view('verification.verify');
    }

    public function verify(UserVerificationRequest $request)
    {
        if($request->validated()) {

            DB::beginTransaction();
            try {
                //code...

                $user = Auth::user();

                User::where('id', $user->id)->update([
                    'is_verified' => 1,
                    'otp' => null,
                    'email_send_at' => null,
                    'email_verified_at' => Carbon::now()
                ]);
                DB::commit();
                return redirect()->route('home');
            } catch (\Throwable $th) {
                //throw $th;
                DB::rollback();
                Log::error("[UserVerificationController::class, 'verify'] => ".$th->getMessage());
                return back()->withErrors(['message' => 'Failed when verify user data. Please contact administrator']);
            }
        }
    }

    public function sendEmail()
    {
        $otp = self::generateRandomOTP();
        $encrypted = Hash::make($otp);

        $user = Auth::user();
        User::where('id', $user->id)->update([
            'otp' => $encrypted,
            'email_send_at' => Carbon::now(),
        ]);

        $sentEmail = Mail::to($user->email)->send(new VerificationEmail($otp, $user->name));

        if (!$sentEmail instanceof \Illuminate\Mail\SentMessage) {
            //email sent failed
            return (object)[
                'status' => 500,
                'message' => 'Error when sending email from our back end, please contact Administrator'
            ];
        }

        return (object)[
            'status' => 200,
            'message' => 'Success'
        ];
    }

    public function resendEmail()
    {
        try {
            //code...
            $send = $this->sendEmail();

            if(!$send) {
                throw new Exception("Failed when send email from our backend, please contact administrator");
            }

            return response()->json(['message' => 'Success resending OTP to your email address!'], 200);

        } catch (\Throwable $th) {
            //throw $th;

            $msg = $th->getMessage();
            if(env('APP_DEBUG') === false) {
                $msg = 'Error when sending OTP email from our back end, please contact administrator';
            }

            return response()->json(['message' => $msg], 500);
        }
    }

    private static function generateRandomOTP()
    {
        $min = 100000; // Minimum OTP value (6 digits)
        $max = 999999; // Maximum OTP value (6 digits)

        return mt_rand($min, $max);
    }
}
