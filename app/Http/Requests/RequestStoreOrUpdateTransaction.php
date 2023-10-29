<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStoreOrUpdateTransaction extends FormRequest
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
            'nominal' => 'required',
            'abodemen' => 'required|in:0',
            'status' => 'required|in:sudah bayar',
            'tgl_trans' => 'required|date',
        ];
    }
    public function messages()
    {
        return [
            'id_pelanggan.required' => 'Kolom ID Pelanggan harus diisi.',
            'tgl_trans.required' => 'kolom Tanggal Transaksi harus diisi.',
            'tgl_trans.date' => 'Tanggal Transaksi harus berupa waktu.',

        ];
    }
}
