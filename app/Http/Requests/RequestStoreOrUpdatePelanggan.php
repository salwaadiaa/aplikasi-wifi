<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdatePelanggan extends FormRequest
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
            'id_pelanggan' => 'required|unique:data_pelanggans,id_pelanggan',
            'status' => 'required|in:berlangganan,diputus sementara,berhenti berlangganan',
        ];
    }
    public function messages()  
    {
        return [
            'id_pelanggan.required' => 'Kolom ID Pelanggan harus diisi.',
    
        ];
    }
}
