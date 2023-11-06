<?php

namespace App\Http\Requests\Customer;

use App\Rules\TitleValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        abort_if((Gate::denies('customer_create')), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => ['required','string','max:150', 'regex:/^[^\s]+$/'],
            'guardian_name' => ['required','string','max:150','regex:/^[^\s]+$/'],
            // 'email' => ['required','email','unique:customers,email'],
            'phone' => ['required','digits:10','numeric','unique:customers,phone'],
            'phone2' => ['nullable','digits:10','numeric','unique:customers,phone2'],
            'address_id'=>['required','numeric'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The Name is required.',
            'name.string' => 'The name should be a valid string.',
            'name.max' => 'The name should not exceed 150 characters.',
            'guardian_name.required' => 'The Husband/Father Name is required.',
            'guardian_name.string' => 'The Husband/Father Name should be a valid string.',
            'guardian_name.max' => 'The Husband/Father Name should not exceed 150 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already in use.',
            'phone.required' => 'The Phone number is required.',
            'phone.digits' => 'The Phone number must be 10 digits.',
            'phone.numeric' => 'The Phone number must be a number.',
            'phone.unique' => 'The Phone number has already been taken.',
            'address_id.required'=> 'The Address is required.',
        ];
    }
}
