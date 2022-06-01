<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = Auth::id();
        return [
            'name' => ['required', 'string', Rule::unique('users','name')->ignore($user)],
            'email' => ['required', 'string', 'email', Rule::unique('users','name')->ignore($user)],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()],
            'password_confirm' => ['required', 'same:password'],
        ];
    }
}
