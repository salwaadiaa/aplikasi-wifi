@extends('layouts.app')
@section('title', 'Ubah Data pengguna')

@section('title-header', 'Ubah Data pengguna')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('data-admin.index') }}">Data Admin</a></li>
    <li class="breadcrumb-item active">Ubah Data Admin</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Ubah Data Admin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-admin.update', $admin->id) }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                        placeholder="Nama Admin" value="{{ $admin->nama }}" name="nama">

                                    @error('nama')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Email Admin" value="{{ $admin->email }}"
                                        name="email">

                                    @error('email')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="telp">No Telepon</label>
                                    <input type="text" class="form-control @error('telp') is-invalid @enderror"
                                        id="telp" placeholder="telp Admin" value="{{ $admin->telp }}"
                                        name="telp">

                                    @error('telp')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="role">Role</label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                        @php
                                            $roles = ['admin', 'masteradmin', 'teknisi'];
                                        @endphp
                                        <option value="" selected>---Role---</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" @if ($admin->role == $role) selected @endif>
                                                {{ $role }}</option>
                                        @endforeach
                                    </select>

                                    @error('role')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        {{-- <div class="form-group mb-3">
                            <label for="avatar">Avatar</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                id="avatar" placeholder="Avatar pengguna"
                                name="avatar">
                            <div class="d-block invalid-feedback">Jangan upload gambar jika tidak diperlukan.</div>
                        </div> --}}

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
