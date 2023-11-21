<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\IsActive;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'username'    => ['required','string',new IsActive],
            'password' => 'required|min:8',
        ]);

        if($validator->fails()){
            //Error Response Send
            $responseData = [
                'status'        => false,
                'validation_errors' => $validator->errors(),
            ];
            return response()->json($responseData, 401);
        }

        DB::beginTransaction();
        try {
            $remember_me = !is_null($request->remember) ? true : false;
            $credentialsOnly = [
                'username'    => $request->username,
                'password' => $request->password,
            ];

            if(Auth::attempt($credentialsOnly, $remember_me)){
                $user = Auth::user();
                $accessToken = $user->createToken(config('auth.api_token_name'))->plainTextToken;
                DB::commit();
                //Success Response Send
                $responseData = [
                    'status'            => true,
                    'message'           => 'You have logged in successfully!',
                    'userData'          => [
                        'id'           => $user->id,
                        'name'   => $user->name ?? '',
                        'username'    => $user->username ?? '',
                        'email'    => $user->email ?? '',
                        'phone'    => $user->phone ?? '',
                        'address'    => $user->address->name ?? '',
                        'profile_image'=> $user->profile_image_url ?? '',
                        'Pin'=>  $user->device? $user->device->pin : '',
                    ],
                    'remember_me_token' => $user->remember_token,
                    'access_token'      => $accessToken
                ];
                return response()->json($responseData, 200);

            } else{
                //Error Response Send
                $responseData = [
                    'status'        => false,
                    'error'         => trans('messages.wrong_credentials'),
                ];
                return response()->json($responseData, 401);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            //dd($e->getMessage().'->'.$e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 401);
        }
    }

    public function LoginWithPin(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => ['required','email','exists:users'],
            'pin'    => ['required','numeric','exists:devices','digits:4'],
        ]);

        if($validator->fails()){
            $responseData = [
                'status'        => false,
                'validation_errors' => $validator->errors(),
            ];
            return response()->json($responseData, 401);
        }

        try{
            $user = User::where('email', $request->email)
            ->whereHas('device', function ($query) {
                $query->where('deleted_at', null);
            })->with('device')->first();
            //dd($request->pin,$user->device->pin);
            if(!$user){
                $responseData = [
                    'status'        => false,
                    'error'         => trans('messages.wrong_credentials'),
                ];
                return response()->json($responseData, 401);
            }
            elseif($request->pin !== $user->device->pin){
                $responseData = [
                    'status'        => false,
                    'error'         => trans('messages.invalid_pin'),
                ];
                return response()->json($responseData, 401);
            }
            else{
                $accessToken = $user->createToken(config('auth.api_token_name'))->plainTextToken;
                $responseData = [
                    'status'            => true,
                    'message'           => 'You have logged in successfully!',
                    'userData'          => [
                        'id'           => $user->id,
                        'name'   => $user->name ?? '',
                        'username'    => $user->username ?? '',
                        'email'    => $user->email ?? '',
                        'phone'    => $user->phone ?? '',
                        'address'    => $user->address->name ?? '',
                        'profile_image'=> $user->profile_image_url ?? '',
                    ],
                    'access_token'      => $accessToken
                ];
                return response()->json($responseData, 200);
            }
        }catch (\Exception $e) {
            //dd($e->getMessage().'->'.$e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 401);
        }

    }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), ['email' => ['required','email','exists:users',new IsActive]], getCommonValidationRuleMsgs());

        if($validator->fails()){
            //Error Response Send
            $responseData = [
                'status'        => false,
                'validation_errors' => $validator->errors(),
            ];
            return response()->json($responseData, 401);
        }

        DB::beginTransaction();
        try {
            //$token = generateRandomString(64);
            $token = rand(100000, 999999);
            $email_id = $request->email;
            $user = User::where('email', $email_id)->first();
            if(!$user){
                $responseData = [
                    'status'        => false,
                    'error'         => trans('messages.invalid_email'),
                ];
                return response()->json($responseData, 401);
            }

            DB::table('password_resets')->insert([
                'email'         => $email_id,
                'token'         => $token,
                'created_at'    => Carbon::now()
            ]);

            $user->otp = $token;
            $user->subject = "Reset Password OTP";
            $user->expiretime = '2 Minutes';
            //dd($user);
            $user->sendPasswordResetOtpNotification($request, $user);
            DB::commit();
            //Success Response Send
            $responseData = [
                'status'        => true,
                'otp_time_allow' => config('auth.passwords.users.expire').' Minutes',
                'otp' => $token,
                'message'         => trans('messages.otp_sent_email'),
            ];
            return response()->json($responseData, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage().'->'.$e->getLine());
            //Return Error Response
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.error_message'),
            ];
            return response()->json($responseData, 401);
        }
    }

    public function verifyOtp(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email|exists:password_resets,email',
            'otp'   => 'required|numeric|min:6'
        ]);
        if ($validation->fails()) {
            $responseData = [
                'status'        => false,
                'validation_errors' => $validation->errors(),
            ];
            return response()->json($responseData, 401);
        }
        $email = $request->email;
        $otpToken = $request->otp;

        $passwordReset = DB::table('password_resets')->where('token', $otpToken)
                ->where('email', $email)
                ->orderBy('created_at','desc')
                ->first();

        if (!$passwordReset){
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.invalid_otp'),
            ];
            return response()->json($responseData, 401);
        }


        if (Carbon::parse($passwordReset->created_at)->addMinutes(config('auth.passwords.users.expire'))->isPast()) {
            $responseData = [
                'status'        => false,
                'error'         => trans('messages.expire_otp'),
            ];
            return response()->json($responseData, 401);
        }

        $responseData = [
            'status'        => true,
            'token'         => encrypt($otpToken),
            'message'         => trans('messages.verified_otp'),
        ];
        return response()->json($responseData, 200);
    }

    public function resetPassword(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'token' => 'required',
            'email'     => 'required|email|exists:password_resets,email',
            'password'  => 'required|string|min:8',
            'confirmed_password' => 'required|string|min:8',
        ]);

        if ($validation->fails()) {
            $responseData = [
                'status'        => false,
                'validation_errors' => $validation->errors(),
            ];
            return response()->json($responseData, 401);
        }
        $token = decrypt($request->token);
        $passwordReset = DB::table('password_resets')->where('token',$token)
                ->where('email', $request->email)
                ->orderBy('created_at','desc')
                ->first();

        if (!$passwordReset)
        {
            $responseData = [
                'status'        => false,
                'validation_errors' => trans('messages.invalid_token_email'),
            ];
            return response()->json($responseData, 401);
        }

        $user = User::where('email', $passwordReset->email)->first();
        if (!$user){
            $responseData = [
                'status'        => false,
                'validation_errors' => trans('messages.invalid_email'),
            ];
            return response()->json($responseData, 401);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        DB::table('password_resets')->where('email',$passwordReset->email)->delete();
        $responseData = [
            'status'        => true,
            'message'         => trans('passwords.reset'),
        ];
        return response()->json($responseData, 200);
    }

}
