<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::user()->role->name === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('user')->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'role_id.required' => 'Role harus dipilih'
        ];
    }
}
