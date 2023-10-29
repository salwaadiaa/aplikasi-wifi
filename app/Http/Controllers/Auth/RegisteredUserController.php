<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Paket;
use App\Models\DataPelanggan;
use App\Providers\RouteServiceProvider;
use App\Models\Provinsi;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */

    public function create(Request $request)
    {
        $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json';
        $response = Http::get($url);
        $provinsis = $response->json();
        $pakets = Paket::all();
        $selectedProvinsi = $request->input('provinsi');
        $selected_paket_id =$request->input('selected_paket_id');
        $selectedPaket = null;

        if ($selected_paket_id){
            $selectedPaket = Paket::find($selected_paket_id);
        }
        // $id_pelanggan =  'ADN-' . sprintf('%04d', DataPelanggan::count()+ 1);
        return view('auth.register', compact('pakets', 'provinsis', 'selectedPaket', 'selectedProvinsi'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
        public function showRegistrationForm(Request $request)
    {
        $selectedPaket = null;
        $selectedProvinsi = $request->input('provinsi');

        $selectedPaketId = $request->query('selected_paket_id');
        if ($selectedPaketId) {
            $selectedPaket = Paket::find($selectedPaketId);
        }

        $pakets = Paket::pluck('paket', 'id');

        $apiResponse = Http::get('emsifa.com/api-wilayah-indonesia/api/provinces.json'); // Ganti URL API dengan URL yang sesuai
        $data = $apiResponse->json();

        return view('auth.register', compact('data', 'pakets', 'selectedPaket', 'selectedProvinsi'));
    }

    public function searchProvinsi(Request $request) {
        $query = $request->input('query');

        // Kirim permintaan ke API untuk mendapatkan daftar provinsi berdasarkan kata kunci
        $url = 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json?search=' . $query;
        $response = Http::get($url);
        $provinsis = $response->json();

        return response()->json($provinsis);
    }

    public function store(Request $request)
    {
        $customMessages = [
            'required' => 'Kolom :attribute harus diisi.',
            'max' => 'Kolom :attribute maksimal :max karakter.',
            'email' => 'Kolom :attribute harus berisi alamat email yang valid.',
            'unique' => 'Kolom :attribute sudah digunakan.',
            'regex' => 'Kolom :attribute tidak valid.',
            'image' => 'Kolom :attribute harus berupa file gambar.',
            'mimes' => 'Kolom :attribute harus berupa file gambar dengan format PNG, JPG atau JPEG.',
            'same' => 'Kolom :attribute harus sama dengan kolom konfirmasi password.',
            'integer' => 'Kolom :attribute harus berupa angka.'
        ];

        $request->validate([
            // 'id_pelanggan' => ['disabled'],
            'nama' => ['required', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telp' => ['required', 'regex:/^[0-9]{10,15}$/'],
            'alamat' => ['required'],
            'paket' => ['required'],
            'abodemen' => ['required'],
            'foto_ktp' => ['required', 'image', 'mimes:jpeg,png,jpg,svg', 'max:20348'],
            'provinsi' => ['required'],
            'kota' => ['required'],
            'kode_pos' => ['required', 'integer'],
            'password' => ['required'],
            'password_confirmation' => ['required', 'same:password'],
        ], $customMessages);

        if ($request->hasFile('foto_ktp')) {
            $fileName = time() . '.' . $request->foto_ktp->extension();
            $request->foto_ktp->move(public_path('/uploads/images/ktp'), $fileName);
            $path = $fileName;
        }

        $request->merge([
            'role' => 'user'
        ]);

        $provinsi = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/province/' . $request->provinsi . '.json')->json();
        $kota = Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/regency/' . $request->kota . '.json')->json();

        try {
            DB::beginTransaction();

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);

            $dataPelanggan = DataPelanggan::create([
                'user_id' => $user->id,
                'id_pelanggan' => 'ADN-' . sprintf('%04d', DataPelanggan::count()+ 1),
                'nama' => $request->nama,
                'email' => $request->email,
                'telp' => $request->telp,
                'alamat' => $request->alamat,
                'paket' => $request->paket,
                'abodemen' => $request->abodemen,
                'foto_ktp' => $path,
                'provinsi' => $provinsi['name'],
                'kota' => $kota['name'],
                'kode_pos' => $request->kode_pos,
                'status' => 'belum dikonfirmasi'
                // 'longitude' => $request->longitude,
                // 'latitude' => $request->latitude,
            ]);

            event(new Registered($user));
            DB::commit();
            // Auth::login($user);

            return redirect()->route('register')->with('successRegistered', 'Kami akan segera menghubungimu melalui WhatsApp untuk konfirmasi lebih lanjut');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


    }

}
