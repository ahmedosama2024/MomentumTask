<?php

namespace App\Http\Requests\Website;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    private ?User $user;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $this->user = User::where('email', $this->email)->first();
        return [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (!$this->user) {
                        $fail(__('auth.failed'));
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user?->password)) {
                        $fail(__('auth.failed'));
                    }
                }
            ],
        ];
    }

    public function login(): User
    {
        return $this->user;
    }

    public function attributes(): array
    {
        return [
            'email' => __('users.attributes.email'),
            'password' => __('users.attributes.password'),
        ];
    }
}
