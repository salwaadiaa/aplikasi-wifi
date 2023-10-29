<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;
use App\Http\Requests\RequestStoreOrUpdatePaket;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::latest()->paginate(10);
        return view('dashboard.paket.index', compact('pakets'));
    }

    public function create()
    {
        return view('dashboard.paket.create');
    }

    public function store(RequestStoreOrUpdatePaket $request)
    {
        $validated = $request->validated() + [
            'created_at' => now(),
        ];
        $paket = Paket::create($validated);

        return redirect(route('paket.index'))->with('success', 'paket berhasil ditambahkan');
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('dashboard.paket.edit', compact('paket'));
    }

    public function update(RequestStoreOrUpdatePaket $request, $id)
    {
        $validated = $request->validated() + [
            'updated_at' => now(),
        ];
        $paket = Paket::findOrfail($id);
        $paket->update($validated);

        return redirect(route('paket.index'))->with('success', 'paket berhasil diubah');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect(route('paket.index'))->with('success', 'paket berhasil dihapus');
    }

    public function showLanding()
    {
        $pakets = Paket::all();
        return view('layouts.layoutlanding', compact('pakets'));
    }
}
