<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = auth()->user();
        return [
            'name' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:30|regex:/^[A-Za-z0-9.]+$/|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
        ];
    }
}
