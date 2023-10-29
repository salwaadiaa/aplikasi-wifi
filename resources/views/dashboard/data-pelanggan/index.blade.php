@extends('layouts.app')
@section('title', 'Data Pelanggan')

@section('title-header', 'Data Pelanggan')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Pelanggan</li>
@endsection

@section('action_btn')
<a href="{{route('data-pelanggan.create')}}" class="btn btn-default">Tambah Data Pelanggan</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Data Pelanggan</h2>
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
                                    <th>Tanggal Bayar Selanjutnya</th>
                                    <th>Status</th>
                                    <th>action</th>
                                    {{-- <th>Role</th> --}}
                                    {{-- <th>Avatar</th> --}}
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pelanggans as $pelanggan)
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
                                        <td>Rp {{ number_format($pelanggan->abodemen,0,',','.') }}</td>
                                        <td>{{ $pelanggan->tgl_join }}</td>
                                        <td>{{ $pelanggan->tgl_bayar }}</td>
                                        <td>{{ $pelanggan->status }}</td>

                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('data-pelanggan.edit', $pelanggan->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                            <form id="delete-form-{{ $pelanggan->id }}" action="{{ route('data-pelanggan.destroy', $pelanggan->id) }}" class="d-none" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{$pelanggan ->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">
                                        {{ $pelanggans->links() }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteForm(id){
            Swal.fire({
                title: 'Hapus data',
                text: "Anda akan menghapus data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete-form-${id}`).submit()
                }
            })
        }
    </script>
@endsection
