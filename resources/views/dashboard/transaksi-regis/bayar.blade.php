@extends('layouts.app')
@section('title', 'Bayar Registrasi')

@section('title-header', 'Bayar Registrasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('transaksi-regis.index') }}">Data Registrasi</a></li>
    <li class="breadcrumb-item active">Bayar Registrasi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Bayar Registrasi</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('transaksi-regis.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="id_pelanggan">ID Pelanggan</label>
                                        <select class="form-control" id="id_pelanggan" name="id_pelanggan">
                                            <option value="" selected>---Pilih ID---</option>
                                            @foreach ($confirmedUsers as $user)
                                                <option value="{{ $user->id }}">{{ $user->id_pelanggan }} - {{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="tgl_trans">Tanggal Transaksi</label>
                                        <input type="date" class="form-control @error('tgl_trans') is-invalid @enderror" id="tgl_trans"
                                            placeholder="Tanggal Transaksi" value="{{ old('tgl_trans') }}" name="tgl_trans">

                                        @error('tgl_trans')
                                            <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="nominal">Nominal</label>
                                        <input type="text" class="form-control @error('nominal') is-invalid @enderror"
                                            id="nominal" value="150000"
                                            name="nominal" readonly>

                                        @error('nominal')
                                             <div class="d-block invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" id="status" name="status" value="{{ $defaultStatus }}" readonly>
                                    </div>
                                    @error('status')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                                <a href="{{route('transaksi-regis.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



