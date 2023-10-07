<?php
use Illuminate\Support\Str as Str;


if (!function_exists('getCommonValidationRuleMsgs')) {
	function getCommonValidationRuleMsgs()
	{
		return [
			'password.required' => 'The new password is required.',
			'password.min' => 'The new password must be at least 8 characters',
			'password.different' => 'The new password and current password must be different.',
			'password.confirmed' => 'The password confirmation does not match.',
			'password_confirmation.required' => 'The new password confirmation is required.',
			'password_confirmation.min' => 'The new password confirmation must be at least 8 characters',
			'email.required' => 'Please enter email address.',
			'email.email' => 'Email is not valid. Enter email address for example test@gmail.com',
            'email.exists' => "Please Enter Valid Registered Email!",
		];
	}
}

if (!function_exists('generateRandomString')) {
	function generateRandomString($length = 20) {

		$randomString = Str::random($length);

		return $randomString;
	}
}


?>
