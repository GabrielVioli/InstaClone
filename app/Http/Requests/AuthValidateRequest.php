<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthValidateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:50|alpha_dash',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar'   => 'nullable|string',
            'bio'      => 'nullable|string|max:255',
        ];
    }
}
