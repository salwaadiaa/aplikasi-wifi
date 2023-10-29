@extends('layouts.app')
@section('title', 'Tambah Paket')

@section('title-header', 'Tambah Paket')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('paket.index') }}">Paket</a></li>
    <li class="breadcrumb-item active">Tambah Paket</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Paket</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('paket.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="nama_paket">Nama Paket</label>
                                    <input type="text" class="form-control @error('nama_paket') is-invalid @enderror" id="nama_paket"
                                        placeholder="Input Nama Paket" value="{{ old('nama_paket') }}" name="nama_paket">

                                    @error('nama_paket')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="paket">Paket</label>
                                    <input type="text" class="form-control @error('paket') is-invalid @enderror"
                                        id="paket" placeholder="Input Paket" value="{{ old('paket') }}"
                                        name="paket">

                                    @error('paket')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="abodemen">Abodemen</label>
                                    <input type="number" class="form-control @error('abodemen') is-invalid @enderror"
                                        id="abodemen" placeholder="Input Abodemen" value="{{ old('abodemen') }}"
                                        name="abodemen">

                                    @error('abodemen')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                    <a href="{{route('paket.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

