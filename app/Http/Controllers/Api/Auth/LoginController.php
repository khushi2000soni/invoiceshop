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
                    ],
                    'remember_me_token' => $user->remember_token,
                    'access_token'      => $accessToken
                ];
                return response()->json($responseData, 200);

            } else{

                //Error Response Send
                $responseData = [
                    'status'        => false,
                    'error'         => 'These credentials do not match our records!',
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
}
