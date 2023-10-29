<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggan;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\RequestStoreOrUpdatePelanggan;

class DataPelangganController extends Controller
{
    public function index()
    {
        $pelanggans = DataPelanggan::whereIn('status', ['berlangganan', 'diputus sementara', 'berhenti berlangganan'])->latest()->with('user','getPaket')->paginate(5);
        return view('dashboard.data-pelanggan.index', compact('pelanggans'));
    }

    public function create()
{
    $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json';
    $response = Http::get($url);
    $provinsis = $response->json();
    // $pakets = Paket::all();
    $confirmedUsers = DataPelanggan::where('status', 'sudah dikonfirmasi')->get();
    $defaultStatus = 'berlangganan'; // Set the default status here

    return view('dashboard.data-pelanggan.create', compact('confirmedUsers', 'provinsis', 'defaultStatus'));
}
public function store(RequestStoreOrUpdatePelanggan $request)
{

    $provinsi = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/province/' . $request->provinsi . '.json')->json();
    $kota = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regency/' . $request->kota . '.json')->json();

   $id_pelanggan = $request->id_pelanggan;
   $pelanggan = DataPelanggan::find($id_pelanggan);
   $pelanggan->status = $request->status;
   $pelanggan->update();
    return redirect(route('data-pelanggan.index'))->with('success', 'Data pelanggan berhasil ditambahkan');
}

    public function edit($id)
    {
        $pelanggan = DataPelanggan::findOrFail($id);
        $statusOptions = [
            'berlangganan' => 'Berlangganan',
            'diputus sementara' => 'Diputus Sementara',
            'berhenti berlangganan' => 'Berhenti Berlangganan',
        ];

        return view('dashboard.data-pelanggan.edit', compact('pelanggan', 'statusOptions'));
    }

    public function update(RequestStoreOrUpdatePelanggan $request, $id)
    {
        // $validated = $request->validated() + [
        //     'updated_at' => now(),
        // ];
        // $pelanggan = DataPelanggan::findOrfail($id);
        // $pelanggan->update($validated);
        $pelanggan = DataPelanggan::findOrFail($id);
        $pelanggan->status = $request->status;
        $pelanggan->update();

        return redirect(route('data-pelanggan.index'))->with('success', 'Data pelanggan  berhasil diubah');
    }

    public function destroy($id)
    {
        $pelanggan = DataPelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect(route('data-pelanggan.index'))->with('success', 'Data pelanggan berhasil dihapus');
    }
}
