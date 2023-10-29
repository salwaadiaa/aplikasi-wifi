<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'nama' => 'required|max:255',
            'email' => 'required|email|',
            'telp' => 'required|regex:/^[0-9]{10,15}$/|',
            'role' => 'required|in:masteradmin,admin,user,teknisi',
        ];

        if($this->isMethod('POST')){
            $rules['password'] = 'required|min:6';
            $rules['confirmation_password'] = 'required|same:password';
            $rules['email'] .= 'unique:users,id,'.$this->user()->id;
            $rules['avatar'] = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nama.required' => 'Kolom nama harus diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'telp.required' => 'kolom no telepon harus diisi.',
            'telp.regex' => 'mohon masukan no telepon yang valid.',
            'password.required' => 'Kolom password harus diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Kolom role harus diisi.',
            'role.in' => 'Role tidak valid.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar tidak valid.',
            'avatar.max' => 'Gambar tidak boleh lebih dari 2MB.',
            'confirmation_password.required' => 'Kolom konfirmasi password harus diisi.',
            'confirmation_password.same' => 'Konfirmasi password tidak sama.',
        ];
    }
}
