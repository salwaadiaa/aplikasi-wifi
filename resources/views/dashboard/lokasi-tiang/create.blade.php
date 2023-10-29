@extends('layouts.app')
@section('title', 'Tambah Lokasi')

@section('title-header', 'Tambah Lokasi')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('lokasi-tiang.index') }}">Lokasi Tiang</a></li>
    <li class="breadcrumb-item active">Tambah Lokasi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h5 class="mb-0">Formulir Tambah Tiang</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lokasi-tiang.store') }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group mb-3">
                                    <label for="nama_box">Nama Box</label>
                                    <input type="text" class="form-control @error('nama_box') is-invalid @enderror" id="nama_box"
                                        placeholder="Input Nama Box" value="{{ old('nama_box') }}" name="nama_box">

                                    @error('nama_box')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group mb-3">
                                <label for="kode_pos">Kode Pos</label>
                                    <input type="text" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos"
                                        placeholder="Input Kode Pos" value="{{ old('kode_pos') }}" name="kode_pos">

                                    @error('kode_pos')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="provinsi">Provinsi</label>
                                <select class="form-control" id="provinsi_input" name="provinsi">
                                    <option value="" selected>---Pilih Provinsi---</option>
                                    @foreach ($provinsis as $provinsi)
                                        <option value="{{ $provinsi['id'] }}" {{ (old('provinsi') == $provinsi['id']) ? 'selected' : '' }}>
                                            {{ $provinsi['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kota">Kota</label>
                                <select class="form-control" id="kota_input" name="kota">
                                    <option value="">---Pilih Provinsi terlebih dahulu---</option>
                                </select>
                                @error('kota')
                                    <div class="invalid-feedback d-block">*{{ $message }} <i class="fas fa-arrow-up"></i></div>
                                @enderror
                                </div>
                                </div>
                                </div>
                        <div class="row">    
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="alamat">Alamat Lengkap</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                        id="alamat" placeholder="Input Alamat Lengkap" name="alamat">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Tambah</button>
                                <a href="{{route('lokasi-tiang.index')}}" class="btn btn-sm btn-secondary">Kembali</a>
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
    const provinsiInput = document.getElementById('provinsi_input');
    const kotaSelect = document.getElementById('kota_input');

    // Event listener untuk menangani perubahan pilihan provinsi
    provinsiInput.addEventListener('change', function() {
        const provinsiId = this.value;
        console.log(provinsiId);

        // Jika pengguna memilih "Pilih Provinsi", reset daftar kota
        if (!provinsiId) {
            kotaSelect.innerHTML = '<option value="">Pilih Provinsi terlebih dahulu</option>';
            return;
        }

        // Kirim permintaan ke server untuk mendapatkan daftar kota berdasarkan provinsiId
        const url = `/api/kota/${provinsiId}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const options = data.map(kota => `<option value="${kota.id}">${kota.name}</option>`).join('');
                kotaSelect.innerHTML = `<option value="">Pilih Kota</option>${options}`;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
</script>




@endsection







