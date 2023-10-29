@extends('layouts.app')
@section('title', 'Lokasi Tiang ')

@section('title-header', 'Lokasi Tiang')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Lokasi Tiang</li>
@endsection

@if (Auth::user()->role == 'admin' || Auth::user()->role == 'masteradmin' || Auth::user()->role == 'teknisi')
@section('action_btn')
<a href="{{route('lokasi-tiang.create')}}" class="btn btn-default">Tambah Lokasi Tiang</a>
@endsection
@endif

   
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Daftar Lokasi Tiang</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Box</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Kode Pos</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lokasi_tiangs as $lokasi_tiang)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lokasi_tiang->nama_box }}</td>
                                        <td>{{ $lokasi_tiang->provinsi }}</td>
                                        <td>{{ $lokasi_tiang->kota }}</td>
                                        <td>{{ $lokasi_tiang->kode_pos }}</td>
                                        <td><a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($lokasi_tiang->alamat) }}" target="_blank">{{ $lokasi_tiang->alamat }}</td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'masteradmin' || Auth::user()->role == 'teknisi')
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('lokasi-tiang.edit', $lokasi_tiang->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                            <form id="delete-form-{{ $lokasi_tiang->id }}" action="{{ route('lokasi-tiang.destroy', $lokasi_tiang->id) }}" class="d-none" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{$lokasi_tiang ->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                        </td> 
                                        @endif
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
                                        {{ $lokasi_tiangs->links() }}
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
