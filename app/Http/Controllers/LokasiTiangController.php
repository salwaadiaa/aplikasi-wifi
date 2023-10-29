<?php

namespace App\Http\Controllers;

use App\Models\LokasiTiang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\RequestStoreOrUpdateLokasi;

class LokasiTiangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lokasi_tiangs = LokasiTiang::latest()->paginate(5);
        return view('dashboard.lokasi-tiang.index', compact('lokasi_tiangs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json';
        $response = Http::get($url);
        $provinsis = $response->json();
        
        return view('dashboard.lokasi-tiang.create', compact('provinsis'));
    }
    
    // ... Other controller methods ...
    
    public function getKotaByProvinsi($provinsiId)
    {
        $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' . $provinsiId . '.json';
        $response = Http::get($url);
        $kotas = $response->json();
        
        return response()->json($kotas);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestStoreOrUpdateLokasi $request)
{
    $validated = $request->validated() + [
        'created_at' => now(),
    ];
    
    // Get the selected province and city IDs from the hidden input fields
    $selectedProvinsiId = $request->input('provinsi'); // Ubah nama input sesuai dengan nama yang Anda gunakan
    $selectedKotaId = $request->input('kota'); // Ubah nama input sesuai dengan nama yang Anda gunakan
    
    // Make API calls to retrieve province and city data
    $provinsi = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/province/' . $selectedProvinsiId . '.json')->json();
    $kota = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regency/' . $selectedKotaId . '.json')->json();
    
    // Combine the retrieved data with the validated form data
    $dataToStore = array_merge($validated, [
        'province_name' => $provinsi['name'], // Sesuaikan dengan kunci yang sesuai
        'city_name' => $kota['name'], // Sesuaikan dengan kunci yang sesuai
    ]);

    // $lokasi_tiang = LokasiTiang::create($dataToStore);
    
    $lokasi_tiang = LokasiTiang::create([
        'nama_box' => $request->nama_box,
        'provinsi' => $provinsi['name'],
        'kota' => $kota['name'],
        'kode_pos' => $request->kode_pos,
        'alamat' => $request->alamat,
        // 'longitude' => $request->longitude,
        // 'latitude' => $request->latitude,
    ]);
    return redirect(route('lokasi-tiang.index'))->with('success', 'Lokasi berhasil ditambahkan');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LokasiTiang  $lokasiTiang
     * @return \Illuminate\Http\Response
     */
    public function show(RequestStoreOrUpdateLokasi $request, $id)
{
    $validated = $request->validated() + [
        'updated_at' => now(),
    ];
    $lokasi_tiang = LokasiTiang::findOrFail($id);

    // Retrieve the list of provinces from the API
    $apiResponse = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'); // Pastikan URL yang benar
    $provinsis = $apiResponse->json();

    return view('dashboard.lokasi-tiang.edit', compact('lokasi_tiang', 'provinsis'));
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LokasiTiang  $lokasiTiang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lokasi_tiang = LokasiTiang::findOrFail($id);
        $apiResponse = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json'); // Pastikan URL yang benar
        $provinsis = $apiResponse->json();

        return view('dashboard.lokasi-tiang.edit', compact('lokasi_tiang', 'provinsis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LokasiTiang  $lokasiTiang
     * @return \Illuminate\Http\Response
     */
    public function update(RequestStoreOrUpdateLokasi $request, $id)
    {
        $validated = $request->validated() + [
            'updated_at' => now(),
        ];
        $lokasi_tiang = LokasiTiang::findOrFail($id);
        
        // Get the selected province and city IDs from the hidden input fields
        $selectedProvinsiId = $request->input('provinsi'); // Ubah nama input sesuai dengan nama yang Anda gunakan
        $selectedKotaId = $request->input('kota'); // Ubah nama input sesuai dengan nama yang Anda gunakan
        
        // Make API calls to retrieve province and city data
        $provinsi = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/province/' . $selectedProvinsiId . '.json')->json();
        $kota = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regency/' . $selectedKotaId . '.json')->json();
        
        // Update the model with the retrieved data and validated form data
        $lokasi_tiang->update([
            'nama_box' => $request->nama_box,
            'provinsi' => $provinsi['name'],
            'kota' => $kota['name'],
            'kode_pos' => $request->kode_pos,
            'alamat' => $request->alamat,
        ]);
    
        return redirect(route('lokasi-tiang.index'))->with('success', 'Lokasi berhasil diubah');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LokasiTiang  $lokasiTiang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lokasi_tiang = LokasiTiang::findOrFail($id);
        $lokasi_tiang->delete();
        
        return redirect(route('lokasi-tiang.index'))->with('success', 'lokasi berhasil dihapus');
    }
}
