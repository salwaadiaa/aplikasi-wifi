<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'id_pelanggan' => ['required', 'char', 'size:10', 'unique:data_pelanggans'],
            'no_ktp' => ['required', 'char', 'size:16', 'unique:data_pelanggans'],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telp' => ['required', 'string', 'regex:/^\+62\d{9,14}$/'],
            'alamat' => ['required', 'string'],
            'paket' => ['required', 'string'],
            'abodemen' => ['required', 'integer'],
            'abodemen' => ['required', 'numeric'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ];
    }
    
    public function messages()  
    {
        return [
            'id_pelanggan.required' => 'Kolom ID tidak boleh kosong.',
            'id_pelanggan.size' => 'ID harus memiliki 10 karakter.',
            'id_pelanggan.unique' => 'ID sudah digunakan oleh pengguna lain.',
            'no_ktp.required' => 'Kolom Nomor KTP tidak boleh kosong.',
            'no_ktp.size' => 'Nomor KTP harus memiliki 16 karakter.',
            'no_ktp.unique' => 'Nomor KTP sudah digunakan oleh pengguna lain.',
            'nama.required' => 'Kolom Nama tidak boleh kosong.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Kolom Email wajib diisi.',
            'email.regex' => 'Email harus memiliki @.',
            'telp.required' => 'Kolom Nomor Telepon tidak boleh kosong.',
            'telp.regex' => 'Nomor Telepon harus diawali dengen +62 dan memiliki panjang 10-15 karakter.',
            'alamat.required' => 'Kolom Alamat tidak oleh kosong.',
            'paket.required' => 'Kolom Paket tidak oleh kosong.',
            'abodemen.required' => 'Kolom Abodemen tidak oleh kosong.',
            'abodemen.numeric' => 'abodemen harus berupa angka numeric.',
            'password.required' => 'kolom Password tidak boleh kosong.',
            'password.min' => 'Password harus memiliki minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai dengan password yang dimasukkan.',
            'password_confirmation.required' => 'Kolom Konfirmasi Password tidak boleh kosong.',
            'password_confirmation.min' => 'Konfirmasi password harus memiliki minimal 6 karakter.',
        ];
    }
}
