@extends('layouts.app')
@section('title', 'Data Transaksi Regis')

@section('title-header', 'Data Transaksi Regis')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Data Transaksi Registrasi</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-transparent border-0 text-dark">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="card-title h3">Data Transaksi Registrasi</h2>
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
        <label for="period_filter">Periode tanggal</label>
        <select class="form-control" id="period_filter" name="period_filter" onchange="this.form.submit()">
            <option value="all" {{ request('period_filter') === 'all' ? 'selected' : '' }}>Semua</option>
            <option value="day" {{ request('period_filter') === 'day' ? 'selected' : '' }}>Hari Ini</option>
            <option value="week" {{ request('period_filter') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
            <option value="year" {{ request('period_filter') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
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
                                        <td>{{ $transaction->dataPelanggan->id_pelanggan }}</td>
                                        <td>{{ $transaction->dataPelanggan->nama }}</td>
                                        <td>{{ $transaction->getPaket->nama_paket }}</td>
                                        <td>Rp  {{ number_format($transaction->nominal,0,',','.') }}</td>
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

        // Public/js/filter-transactions.js

document.addEventListener('DOMContentLoaded', function () {
    const filterSelect = document.getElementById('period_filter');
    const tableRows = document.querySelectorAll('tbody tr');

    filterSelect.addEventListener('change', function () {
        const selectedValue = this.value;

        tableRows.forEach(function (row) {
            const tanggalTransaksi = row.querySelector('td:nth-child(6)').textContent; // Mengambil tanggal transaksi dari kolom ke-6

            if (selectedValue === 'all' || isDateMatchingFilter(new Date(tanggalTransaksi), selectedValue)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });

    function isDateMatchingFilter(transactionDate, selectedFilter) {
        const today = new Date();
        if (selectedFilter === 'day') {
            return transactionDate.toDateString() === today.toDateString();
        } else if (selectedFilter === 'week') {
            const oneWeekAgo = new Date(today);
            oneWeekAgo.setDate(today.getDate() - 7);
            return transactionDate >= oneWeekAgo && transactionDate <= today;
        } else if (selectedFilter === 'year') {
            return transactionDate.getFullYear() === today.getFullYear();
        }
    }
});


        $(document).ready(function() {
        $('#download-pdf').click(function() {
            window.location.href = '/generate-pdf-report-regis'; // Sesuaikan dengan URL yang sesuai
        });
    });

    // Menambahkan event listener pada tombol "Excel"
    document.getElementById("download-excel").addEventListener("click", function () {
        window.location.href = "{{ route('transactions-regis.excel') }}";
    });

    // Menambahkan event listener pada tombol "Word"
    $(document).ready(function() {
        $('#download-word').click(function() {
            window.location.href = '/generate-word-report-regis'; // Sesuaikan dengan URL yang sesuai
        });
    });
</script>

@endsection
