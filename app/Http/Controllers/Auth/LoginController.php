<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Rules\IsActive;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    //
    public function index()
    {
        //
        return view('auth.login');
    }

    public function login(Request $request){


        $validated = $request->validate([
            'username'    => ['required','string',new IsActive],
            'password' => 'required|min:8',

        ],[
            'username.required' => 'The Username is required.',
            'password.required' => 'The Password is required.',
        ]);

        $remember_me = !is_null($request->remember_me) ? true : false;
        $credentialsOnly = [
            'username'    => $request->username,
            'password' => $request->password,
        ];
        try {

            $user = User::where('username',$request->username)->first();
            if($user){
                if (Auth::attempt($credentialsOnly, $remember_me)) {

                    return redirect()->route('dashboard')->with('success',trans('quickadmin.qa_login_success'));
                }

                return redirect()->route('login')->withErrors(['wrongcrendials' => trans('auth.failed')])->withInput($request->only('username', 'password'));

            }else{
                return redirect()->route('login')->withErrors(['username' => trans('quickadmin.qa_invalid_username')])->withInput($request->only('username'));
            }

        } catch (ValidationException $e) {
            return redirect()->route('login')->withErrors($validated)->withInput($request->only('username', 'password'));
        }

    }

    public function logout()
        {
            Auth::guard('web')->logout();
            // Redirect to the login page
            return redirect()->route('login');
        }

}
