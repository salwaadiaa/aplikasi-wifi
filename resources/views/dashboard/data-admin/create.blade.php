@extends('layouts.app')
@section('title', 'Tambah Data Admin')

@section('title-header', 'Tambah Data Admin')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('data-admin.index') }}">Data Admin</a></li>
    <li class="breadcrumb-item active">Tambah Data Admin</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Data Admin</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-admin.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                        placeholder="Nama Admin" value="{{ old('nama') }}" name="nama">

                                    @error('nama')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="email" placeholder="Email Admin" value="{{ old('email') }}"
                                        name="email">

                                    @error('email')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="telp">Nomor Handphone</label>
                                    <input type="tel" class="form-control @error('telp') is-invalid @enderror" id="telp"
                                        placeholder="Nomor Handphone" value="{{ old('telp') }}" name="telp">

                                    @error('telp')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="role">Role</label>
                                    <select class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                        @php
                                            $roles = ['admin', 'masteradmin', 'teknisi'];
                                        @endphp
                                        <option value="" selected>---Role---</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}" @if (old('role') == $role) selected @endif>
                                                {{ $role }}</option>
                                        @endforeach
                                    </select>

                                    @error('role')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="password">Katasandi</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <button type="button" onclick="seePassword(this, 'password')" class="input-group-text"
                                            id="seePass"><i class="fas fa-eye"></i></button>
                                        </div>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                        placeholder="Katasandi Admin" name="password">
                                    @error('password')
                                        <div class="d-block invalid-feedback">{{ $message }} <i
                                            class="fas fa-arrow-up"></i>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="confirmation_password">Konfirmasi katasandi</label>
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <button type="button" onclick="seePasswordConfirmation(this, 'confirmation_password')" class="input-group-text" id="seePassConfirmation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <input type="password" class="form-control @error('confirmation_password') is-invalid @enderror"
                                        id="confirmation_password" placeholder="Konfirmasi katasandi Admin"
                                        name="confirmation_password">
                                    @error('confirmation_password')
                                        <div class="d-block invalid-feedback">{{ $message }} <i
                                            class="fas fa-arrow-up"></i>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="form-group mb-3">
                            <label for="avatar">Avatar</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                id="avatar" placeholder="Avatar Admin"
                                name="avatar">

                            @error('avatar')
                                <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> --}}

                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{route('data-admin.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    function seePassword(button, targetInputId) {
        var input = document.getElementById(targetInputId);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

function seePasswordConfirmation(button, targetInputId) {
    var input = document.getElementById(targetInputId);
    var icon = button.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

</script>
@endsection
