@extends('layouts.app')
@section('title', 'Dashboard')
@php
    $auth = Auth::user();
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3 text-dark">Data Pelanggan Yang Belum Bayar</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Pelanggan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Kode Pos</th>
                                    <th>Alamat Lengkap</th>
                                    <th>Paket</th>
                                    <th>Abodemen</th>
                                    <th>Tanggal Join</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Status</th>
                                    {{-- <th>Role</th> --}}
                                    {{-- <th>Avatar</th> --}}
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataPelangganBelumBayarPaket as $pelanggan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pelanggan->id_pelanggan }}</td>
                                        <td>{{ $pelanggan->nama }}</td>
                                        <td>{{ $pelanggan->email }}</td>
                                        <td>{{ $pelanggan->telp }}</td>
                                        <td>{{ $pelanggan->provinsi }}</td>
                                        <td>{{ $pelanggan->kota }}</td>
                                        <td>{{ $pelanggan->kode_pos }}</td>
                                        <td>{{ $pelanggan->alamat }}</td>
                                        <td>{{ $pelanggan->getPaket->nama_paket }}</td>
                                        <td>Rp {{ number_format($pelanggan->abodemen, 0, ',', '.') }}</td>
                                        <td>{{ $pelanggan->tgl_join }}</td>
                                        <td>{{ $pelanggan->tgl_bayar }}</td>
                                        <td>{{ $pelanggan->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
