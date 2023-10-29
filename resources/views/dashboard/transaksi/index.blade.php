@extends('layouts.app')
@section('title', 'Data Transaksi Paket')

@section('title-header', 'Data Transaksi Paket')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Transaksi Paket</li>
@endsection

@section('action_btn')
<a href="{{route('transaksi.bayar')}}" class="btn btn-default">Bayar</a>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title h3">Data Transaksi Paket</h2>
                        <div class="btn-group">
                        <button id="download-pdf" class="btn btn-danger pdf-button">
                            <i class="fas fa-file-pdf"></i> PDF
</button>
                        <button id="download-excel" class="btn btn-success excel-button">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>

                        <button id="download-word" class="btn btn-info word-button">
                            <i class="fas fa-file-word"></i> Word
                        </button>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                        <label for="date_range">Periode tanggal</label>
                        <select class="form-control" id="period_filter">
                            <option value="all">Semua</option>
                            <option value="day">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="year">Tahun Ini</option>
                        </select>
                    </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-flush table-hover">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>Id Pelanggan</th>
                                    <th>Nama</th>
                                    <th>Paket</th>
                                    <th>Abodemen</th>
                                    <th>Nominal Transaksi</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop untuk menampilkan data transaksi di sini --}}
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaction->id_pelanggan }}</td>
                                        <td>{{ $transaction->nama }}</td>
                                        <td>{{ $transaction->getPaket->nama_paket }} | {{ $transaction->getPaket->paket }}</td>
                                        @if ($transaction->status_transaksi == 'register')
                                            <td>0</td>
                                        @else
                                            <td>{{ $transaction->abodemen }}</td>
                                        @endif
                                        <td>{{ $transaction->nominal }}</td>
                                        <td>{{ $transaction->tgl_trans }}</td>
                                        <td>{{ $transaction->status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Script untuk menghapus data
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

        // JavaScript untuk menangani perubahan elemen select
document.getElementById('period_filter').addEventListener('change', function () {
    var selectedValue = this.value;

    // Lakukan filter data di halaman berdasarkan selectedValue
    // Tampilkan atau sembunyikan baris berdasarkan filter

    // Menggunakan JavaScript biasa
    var tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(function (row) {
        var tanggalTransaksi = row.querySelector('td:nth-child(7)').textContent; // Mengambil tanggal transaksi dari kolom ke-7

        if (selectedValue === 'all' || isDateMatchingFilter(new Date(tanggalTransaksi), selectedValue)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});

// Fungsi untuk memeriksa apakah tanggal sesuai dengan filter yang dipilih
function isDateMatchingFilter(transactionDate, selectedFilter) {
    const today = new Date();
    if (selectedFilter === 'day') {
        return transactionDate.toDateString() === today.toDateString();
    } else if (selectedFilter === 'week') {
        // Misalnya, Anda ingin memfilter berdasarkan minggu ini
        // Anda perlu menentukan aturan Anda sendiri untuk "minggu ini"
        const oneWeekAgo = new Date(today);
        oneWeekAgo.setDate(today.getDate() - 7);
        return transactionDate >= oneWeekAgo && transactionDate <= today;
    } else if (selectedFilter === 'year') {
        return transactionDate.getFullYear() === today.getFullYear();
    }
}


// Fungsi untuk memeriksa apakah tanggal adalah hari ini
function isToday(date) {
    const today = new Date();
    return date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear();
}
        $(document).ready(function() {
        $('#download-pdf').click(function() {
            window.location.href = '/generate-pdf-report'; // Sesuaikan dengan URL yang sesuai
        });
    });

    // Menambahkan event listener pada tombol "Excel"
    document.getElementById("download-excel").addEventListener("click", function () {
        window.location.href = '/word-paket';
    });

    // Menambahkan event listener pada tombol "Word"
    $(document).ready(function() {
        $('#download-word').click(function() {
            window.location.href = '/generate-word-report'; // Sesuaikan dengan URL yang sesuai
        });
    });
</script>

@endsection
