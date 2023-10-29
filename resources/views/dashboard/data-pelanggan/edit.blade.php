@extends('layouts.app')
@section('title', 'Ubah Data Pelanggan')

@section('title-header', 'Ubah Data Pelanggan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('data-pelanggan.index') }}">Data Pelanggan</a></li>
    <li class="breadcrumb-item active">Ubah Data Pelanggan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Ubah Data Pelanggan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-pelanggan.update', $pelanggan->id) }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                        <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="id_pelanggan">ID Pelanggan</label>
                                    <input type="text" class="form-control" id="id_pelanggan" name="id_pelanggan"
                                         value="{{ $pelanggan->id_pelanggan }} - {{ $pelanggan->nama }}" readonly>

                                    @error('id_pelanggan')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label>Status</label>
                                @foreach ($statusOptions as $value => $label)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="{{ $value }}" value="{{ $value }}"
                                            {{ $pelanggan->status == $value ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                                    </div>
                                @endforeach

                                @error('status')
                                    <div class="d-block invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>


                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
                                <a href="{{ route('data-admin.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
