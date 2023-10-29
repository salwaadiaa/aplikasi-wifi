<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdateLokasi extends FormRequest
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
            'nama_box' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'kode_pos' => 'required|numeric|min:0',
            'alamat' => 'required|string|max:255',
        ];
    }
    public function messages()  
    {
        return [
            'nama_paket.required' => 'kolom nama paket harus diisi.',
            'nama_paket.max' => 'nama paket tidak boleh lebih dari 255 karakter.',
            'paket.required' => 'kolom paket harus diisi.',
            'paket.max' => 'paket tidak boleh lebih dari 255 karakter.',
    
        ];

        
    }
}
