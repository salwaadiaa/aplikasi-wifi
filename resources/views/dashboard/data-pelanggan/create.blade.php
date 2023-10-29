@extends('layouts.app')
@section('title', 'Tambah Data Pelanggan')

@section('title-header', 'Tambah Data Pelanggan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('data-admin.index') }}">Data Pelanggan</a></li>
    <li class="breadcrumb-item active">Tambah Data Pelanggan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Data Pelanggan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('data-pelanggan.store') }}" method="POST" role="form" enctype="multipart/form-data">
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
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{route('data-pelanggan.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('c_js')
    <script>
        // Event listener untuk menangani perubahan pilihan provinsi
    document.getElementById('provinsi').addEventListener('change', function() {
        var provinsiId = this.value;
        var kotaSelect = document.getElementById('kota');
        // console.log(provinsiId);

        // Jika pengguna memilih "Pilih Provinsi", reset daftar kota
        if (!provinsiId) {
            kotaSelect.innerHTML = '<option value="">Pilih Provinsi terlebih dahulu</option>';
            return;
        }

        // Kirim permintaan ke server untuk mendapatkan daftar kota berdasarkan provinsiId
        var url = '/api/kota/' + provinsiId;
        fetch(url)
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                // console.log(data);
                var options = '<option value="">Pilih Kota</option>';
                data.forEach(function(kota) {
                    options += '<option value="' + kota.id + '">' + kota.name + '</option>';
                });
                console.log(options);
                kotaSelect.innerHTML = options;
            });
    });


    </script>
@endsection
