@extends('layouts.app')
@section('title', 'Data Pendaftar')

@section('title-header', 'Data Pendaftar')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('home') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Data Pendaftar</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <h2 class="card-title h3">Data Pendaftar</h2>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Pendaftar</th>
                                    <th>Nama Pendaftar</th>
                                    <th>Email</th>
                                    <th>Nomo Telepon</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Kode Pos</th>
                                    <th>Alamat Lengkap</th>
                                    <th>Paket</th>
                                    <th>Abodemen</th>
                                    <th>Foto KTP</th>
                                    <th>Status</th>
                                    <th>action</th>
                                    {{-- <th>Role</th> --}}
                                    {{-- <th>Avatar</th> --}}
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->id_pelanggan }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->telp }}</td>
                                        <td>{{ $user->provinsi }}</td>
                                        <td>{{ $user->kota }}</td>
                                        <td>{{ $user->kode_pos }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        <td>{{ $user->getPaket->nama_paket }}</td>
                                        <td>Rp {{ number_format($user->abodemen, 0, ',', '.') }}</td>
                                        <td>
                                            <img src="{{ asset('/uploads/images/ktp/' . $user->foto_ktp) }}"
                                                alt="{{ $user->nama }}" width="100">
                                        </td>
                                        <td>
                                            @if ($user->status === 'belum dikonfirmasi')
                                                @csrf
                                                {{-- <a href="{{ route('data-pendaftar.send-notif', ['wa' => $user->telp]) }}" target="_blank" class="btn btn-primary">Konfirmasi</a> --}}
                                                <button data-user-id="{{ $user->id }}"
                                                    data-user-telp="{{ $user->telp }}"
                                                    data-snap-token="{{ $user->snap_token }}"
                                                    class="btn btn-primary pay-button">Konfirmasi</button>
                                            @else
                                                {{ $user->status }}
                                            @endif
                                        </td>
                                        <td class="d-flex jutify-content-center">
                                            <a target="_blank"
                                                href="{{ route('data-pendaftar.generate_pdf', $user->id) }}">
                                                <button type="button" class="btn btn-danger"><i
                                                        class="fas fa-file-pdf"></i> Print PDF</button>
                                            </a>
                                            <span style="margin: 0 10px;"></span>
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('data-pendaftar.destroy', $user->id) }}" class="d-none"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button onclick="deleteForm('{{ $user->id }}')" class="btn btn-light"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                        {{-- <td>
                                            {{ str()->title($user->role) }}
                                        </td> --}}
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
                                        {{ $users->links() }}
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
        var urlWhatsapp = "{{ route('data-pendaftar.send-notif', ['wa' => ':telp', 'virtualaccount' => ':va']) }}";
        var userIsLoggedIn = "{{ auth()->check() }}";
        var user = @json(auth()->user());
    </script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        function deleteForm(id) {
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

        // Fungsi untuk mengirim permintaan AJAX ke endpoint konfirmasi
        function konfirmasiPendaftar(userId) {
            // Buat permintaan AJAX ke endpoint konfirmasi dengan menggunakan userId
            fetch('/konfirmasi/' + userId, {
                    method: 'POST', // Sesuaikan dengan metode HTTP yang sesuai
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sesuaikan dengan token CSRF Anda
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Panggil fungsi untuk mengubah status tombol jika respons JSON diterima
                    ubahStatusTombol(userId);
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                });
        }

        // Fungsi untuk mengubah status tombol dan menonaktifkannya setelah konfirmasi
        function ubahStatusTombol(userId) {
            // Temukan tombol berdasarkan ID
            var tombol = document.getElementById('konfirmasiButton-' + userId);

            // Ubah teks dan kelas tombol untuk menandakan telah dikonfirmasi
            tombol.textContent = 'Sudah Dikonfirmasi';
            tombol.classList.remove('btn-primary');
            tombol.classList.add('btn-success'); // Ubah kelas sesuai kebutuhan

            // Matikan tombol agar tidak dapat diklik lagi
            tombol.disabled = true;
        }

        // Tambahkan peristiwa klik ke setiap tombol "Konfirmasi"
        // var tombolKonfirmasi = document.querySelectorAll('button.btn-primary');
        // tombolKonfirmasi.forEach(function(tombol) {
        //     tombol.addEventListener('click', function() {
        //         var userId = this.getAttribute('data-user-id');
        //         konfirmasiPendaftar(userId);
        //     });
        // });

        var tombolKonfirmasi = document.querySelectorAll('.pay-button');
        tombolKonfirmasi.forEach(function(tombol) {
            tombol.addEventListener('click', function(e) {
                var snapToken = this.getAttribute('data-snap-token');
                var userId = this.getAttribute('data-user-id');
                var telp = this.getAttribute('data-user-telp');
                e.preventDefault();
                // set localStorage
                localStorage.setItem('userId', userId);

                snap.pay(snapToken, {
                    // Optional
                    onSuccess: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);

                    },
                    // Optional
                    onPending: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        if (userIsLoggedIn == '1') {
                            window.location.href =
                                `{{ url('/data-pendaftar/send-notif/${telp}?va=${result.bca_va_number}&settlement=pending') }}`,
                                '_blank'
                        }

                    },
                    // Optional
                    onError: function(result) {
                        /* You may add your own js here, this is just example */
                        // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        console.log('error')
                    }
                });
            });
        });
    </script>
    @if (request()->filled('order_id'))
        <script>
            var order_id = "{{ request()->order_id }}";
            var status_trx = "{{ request()->transaction_status }}";
            if (localStorage.getItem('userId')) {
                fetch("{{ route('data-pendaftar.update', ':id') }}".replace(':id',
                        localStorage.getItem('userId')), {
                        method: 'PUT', // Sesuaikan dengan metode HTTP yang sesuai
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sesuaikan dengan token CSRF Anda
                        },
                    })
                    .then(response => {
                        if (response.status === 200) {
                            localStorage.removeItem('userId')
                            Snackbar.show({
                                text: "Pendaftar berhasil dikonfirmasi",
                                backgroundColor: '#28a745',
                                actionTextColor: '#212529',
                            })
                            setTimeout(() => {
                                window.location.href = "{{ route('data-pendaftar.index') }}"

                            }, 1000);
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            if (status_trx == 'capture') {
                const url = "{{ route('data-pendaftar.bayar-paket', [':id', ':orderId']) }}"
                    .replace(':id', user.id)
                    .replace(':orderId', order_id);

                fetch(url, {
                        method: 'GET', // Sesuaikan dengan metode HTTP yang sesuai
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sesuaikan dengan token CSRF Anda
                        },
                    })
                    .then(response => {
                        if (response.status === 200) {
                            Snackbar.show({
                                text: "Pembayaran paket berhasil dilakukan",
                                backgroundColor: '#28a745',
                                actionTextColor: '#212529',
                            })
                            setTimeout(() => {
                                window.location.href = "{{ route('data-pendaftar.index') }}"

                            }, 1000);
                        } else {
                            // Handle respons jika tidak berhasil
                        }
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        </script>
    @endif
@endsection
