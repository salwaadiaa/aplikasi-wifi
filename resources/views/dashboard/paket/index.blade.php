@extends('layouts.app')
@section('title', 'Pilihan Paket ')

@section('title-header', 'Pilihan Paket')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pilihan Paket</li>
@endsection

@if (Auth::user()->role == 'admin' || Auth::user()->role == 'masteradmin')
@section('action_btn')
<a href="{{route('paket.create')}}" class="btn btn-default">Tambah Pilihan Paket</a>
@endsection
@endif

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Pilihan Paket</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Paket</th>
                                    <th>Paket</th>
                                    <th>Abodemen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pakets as $paket)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $paket->nama_paket }}</td>
                                        <td>{{ $paket->paket }}</td>
                                        <td>Rp  {{ number_format($paket->abodemen,0,',','.') }}</td>
                                        @if (Auth::user()->role == 'admin' || Auth::user()->role == 'masteradmin')
                                        <td class="d-flex jutify-content-center">
                                            <a href="{{route('paket.edit', $paket->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                            <form id="delete-form-{{ $paket->id }}" action="{{ route('paket.destroy', $paket->id) }}" class="d-none" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{$paket ->id}}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
                                        {{ $pakets->links() }}
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
