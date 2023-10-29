@extends('layouts.auth')
@section('title', 'Register')

@section('content')
    <div class="modal fade" id="modalCam" tabindex="-1" role="dialog" aria-labelledby="modalCamLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCamLabel">Kamera</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <video id="cameraFeed" autoplay class="w-100"></video>
                    <img id="capturedPhoto" alt="Captured Photo">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="captureButton">Ambil Gambar</button>
                    <button type="button" class="btn btn-success" id="uploadButton">Upload</button>
                    <button type="button" class="btn btn-danger" id="retryButton">Ulangi</button>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-primary py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8">
                            <h1 class="text-white">Selamat Datang!</h1>
                            <p class="text-lead text-white">Mohon isi data yang valid dan sesuai agar kami bisa memproses
                                data kamu</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>

        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5 py-lg-5">
                            <div class="text-center text-muted mb-4">
                                <small class="small mt-2 pt-1 mb-0">Sudah Punya Akun? <a href="/login"
                                        class="fw-bold link-danger">Masuk</a></small>
                            </div>
                            <form role="form" action="{{ route('register.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <!-- Form inputs -->
                                <div class="form-group">
                                    <input class="form-control" name="nama" placeholder="Nama Lengkap" type="text"
                                        value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i></div>
                                    @enderror
                                </div>
                                <!-- Add other form inputs similarly -->
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input class="form-control" name="email" placeholder="E-mail" type="email"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        </div>
                                        <input class="form-control" name="telp" placeholder="Nomor Telepon"
                                            type="number" value="{{ old('telp') }}">
                                    </div>
                                    @error('telp')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <select class="form-control" id="provinsi" name="provinsi">
                                            <option value="" selected>---Pilih Provinsi---</option>
                                            @foreach ($provinsis as $provinsi)
                                                <option value="{{ $provinsi['id'] }}"
                                                    {{ $selectedProvinsi == $provinsi['id'] || old('provinsi') == $provinsi['id'] ? 'selected' : '' }}>
                                                    {{ $provinsi['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('provinsi')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <select class="form-control" id="kota" name="kota">
                                            <option value="">---Pilih Provinsi terlebih dahulu---</option>
                                        </select>
                                    </div>
                                    @error('kota')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                        </div>
                                        <input class="form-control" name="kode_pos" placeholder="Kode Pos"
                                            type="number" value="{{ old('kode_pos') }}">
                                    </div>
                                    @error('kode_pos')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-pin"></i></span>
                                        </div>
                                        <input class="form-control" name="alamat" placeholder="Alamat Lengkap"
                                            type="text" value="{{ old('alamat') }}">
                                    </div>
                                    @error('alamat')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        </div>
                                        <select class="form-control" id="paket" name="paket">
                                            <option value="" selected>---Pilih Paket---</option>
                                            @foreach ($pakets as $paket)
                                                <option value="{{ $paket->id }}"
                                                    data-abodemen="Rp {{ number_format($paket->abodemen, 0, ',', '.') }}"
                                                    data-value="{{ $paket->abodemen }}"
                                                    @if (optional($selectedPaket)->id == $paket->id) selected
                                                    @elseif (old('paket') == $paket->id)
                                                    selected @endif>
                                                    {{ $paket->nama_paket }} {{ $paket->paket }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('paket')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                        </div>
                                        <input type="hidden" name="abodemen" id="inputabodemen" value="{{ old('abodemen') }}">
                                        <input class="form-control" id="abodemen"
                                            placeholder="Abodemen" readonly type="text">
                                    </div>
                                    @error('abodemen')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="password" placeholder="Password"
                                            type="password" value="{{ old('password') }}" id="password">
                                        <div class="input-group-prepend">
                                            <button type="button" onclick="seePassword(this, 'password')"
                                                class="input-group-text" id="seePass"><i
                                                    class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input class="form-control" name="password_confirmation"
                                            placeholder="Konfirmasi Password" type="password"
                                            value="{{ old('password_confirmation') }}" id="password_confirmation">
                                        <div class="input-group-prepend">
                                            <button type="button"
                                                onclick="seePasswordConfirmation(this, 'password_confirmation')"
                                                class="input-group-text" id="seePassConfirmation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">*{{ $message }} <i
                                                class="fas fa-arrow-up"></i>
                                        </div>
                                    @enderror
                                </div>
                                <!-- Upload method selection -->
                                <div class="form-group">
                                    <select id="uploadSelect" name="uploadSelect" class="form-control">
                                        <option value="">Pilih Upload atau Gunakan Kamera</option>
                                        <option value="webcam">Capture using Webcam</option>
                                        <option value="file">Upload File</option>
                                    </select>
                                    @error('foto_ktp')
                                        <div class="d-block invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Upload file input -->
                                <div class="form-group">
                                    <input type="hidden" name="image" id="image" class="image">
                                    <input type="file" class="form-control @error('foto_ktp') is-invalid @enderror"
                                        id="foto_ktp" placeholder="Upload Foto KTP" name="foto_ktp" style="display: none;" accept="image/jpeg,image/png,image/jpg,image/svg">
                                </div>

                                <!-- Submit button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary my-4">Langganan</button>
                                    <button type="button" class="btn btn-primary d-none" data-toggle="modal" id="button-open-cam" data-target="#modalCam">
                                        Open Cam
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('c_js')
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                console.log("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
        var dataAbodemen = $('#paket').find(':selected').attr('data-abodemen');
        var abodemenValue = $('#paket').find(':selected').attr('data-value');

        // Perbarui abodemen berdasarkan pilihan paket jika belum ada data dari landing page
        if (!abodemenValue) {
            abodemenValue = dataAbodemen;
            updateAbodemen(abodemenValue);
        }

        console.log(dataAbodemen);
    }

        getLocation()

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

        var paketSelect = document.getElementById('paket');
        var abodemenInput = document.getElementById("abodemen");
        var inputValue = document.querySelector('input[name="abodemen"]');
        var selectedOption = paketSelect.options[paketSelect.selectedIndex];
        // Tambahkan event listener pada pilihan paket
$('#paket').on('change', function() {
    var selectedOption = $(this).find(':selected');
    var selectedAbodemen = selectedOption.attr('data-abodemen');
    abodemenInput.value = selectedAbodemen;
    inputValue.value = selectedOption.attr('data-value');
});


        if (selectedOption) {
            var selectedAbodemen = selectedOption.getAttribute('data-abodemen');
            var valueAbodemen = selectedOption.getAttribute('data-value');
            abodemenInput.value = selectedAbodemen;
            inputValue.value = valueAbodemen;
        }

        // Event listener untuk menangani perubahan pilihan provinsi
        $('#provinsi').on('change', function() {
            var provinsiId = $(this).val();
            var kotaSelect = $('#kota');

            // Jika pengguna memilih "Pilih Provinsi", reset daftar kota
            if (!provinsiId) {
                kotaSelect.html('<option value="">Pilih Provinsi terlebih dahulu</option>');
                return;
            }

            // Kirim permintaan ke server untuk mendapatkan daftar kota berdasarkan provinsiId
            var url = '/api/kota/' + provinsiId;
            $.get(url, function(data) {
                var options = '<option value="">Pilih Kota</option>';
                $.each(data, function(index, kota) {
                    options += '<option value="' + kota.id + '">' + kota.name +
                        '</option>';
                });
                kotaSelect.html(options);
            });
        });
    </script>
    <script>
        @if (Session::has('successRegistered'))
            Swal.fire({
                title: 'Terimakasih Permintaanmu Sudah Terkirim',
                text: "{{ session('successRegistered') }}",
                icon: 'success',
                showClass: {
                    popup: 'animate_animated animate_fadeInDown'
                },
                hideClass: {
                    popup: 'animate_animated animate_fadeOutUp'
                },
                confirmButtonText: 'Kembali ke Halaman Utama'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('landingPage') }}";
                }
            });
        @endif

        $(document).ready(function() {
            $('#provinsi').select2();
            $('#kota').select2();
        });

            // app.js
            document.addEventListener("DOMContentLoaded", function() {
                const cameraFeed = document.getElementById("cameraFeed");
                const capturedPhoto = document.getElementById("capturedPhoto");
                const captureButton = document.getElementById("captureButton");
                const uploadSelect = document.getElementById("uploadSelect"); // Select element
                const photoInput = document.getElementById("foto_ktp"); // File input element
                const uploadButton = document.getElementById("uploadButton");
                const retryButton = document.getElementById("retryButton");
                // buat variable button open cam
                const buttonOpenCam = document.getElementById("button-open-cam");

                photoInput.style.display = "none";

                const webcamSettings = {
                    width: 640,
                    height: 480,
                    image_format: "jpeg",
                    jpeg_quality: 90,
                    force_flash: false,
                    flip_horiz: true,
                };

                Webcam.set(webcamSettings);

                let isCapturing = false; // To track if capturing is ongoing
                let berhasilTakeFoto = false;

                buttonOpenCam.addEventListener("click", function() {
                    Webcam.attach(cameraFeed);
                    isCapturing = !isCapturing
                })

                $(document).ready(function() {
                    var modalCam = $('#modalCam');

                    modalCam.on('hidden.bs.modal', function() {
                        isCapturing = !isCapturing;
                        Webcam.reset();
                    });
                });

                captureButton.addEventListener("click", function() {
                    isCapturing = !isCapturing; // Toggle capturing when the button is clicked
                    berhasilTakeFoto = true;

                    // Menyembunyikan tombol "Take Snapshot"
                    captureButton.classList.add("d-none");
                    // Menampilkan tombol "Upload" dan "Ulang"
                    uploadButton.classList.remove("d-none");
                    retryButton.classList.remove("d-none");

                });

                function captureAndDisplay() {
                    if (isCapturing) {
                        Webcam.snap(function(data_uri) {
                            if (berhasilTakeFoto) {
                                $(".image").val(data_uri);
                                uploadButton.classList.remove("d-none"); // Menampilkan button "Upload" setelah gambar diambil
                                retryButton.classList.remove("d-none"); // Menampilkan button "Ulangi" setelah gambar diambil
                            } else {
                                $(".image").val("none");
                                uploadButton.classList.add("d-none"); // Menyembunyikan button "Upload" jika gambar belum diambil
                                retryButton.classList.add("d-none"); // Menyembunyikan button "Ulangi" jika gambar belum diambil
                            }
                            capturedPhoto.src = data_uri;
                        });
                        requestAnimationFrame(captureAndDisplay);
                    } else {
                        cancelAnimationFrame(requestAnimationFrame(captureAndDisplay));
                    }
                }

                Webcam.on("load", function() {
                    captureAndDisplay(); // Start capturing and displaying
                });

                uploadButton.addEventListener("click", function() {
                    // Ambil data URI dari gambar yang diambil dari webcam
                    const dataUri = capturedPhoto.src;
                    if (dataUri) {
                        $(".image").val(dataUri);

                        // function setFileFromDataURI() {
                            let blob = dataURItoBlob(dataUri);
                            let file = new File([blob], "foto_ktp.jpg", { type: "image/jpeg" });
                            const fileList = new DataTransfer();
                            fileList.items.add(file);

                            // Set the files property of the file input to the FileList
                            photoInput.files = fileList.files;
                        // }

                        function dataURItoBlob(dataUri) {
                            var byteString = atob(dataUri.split(',')[1]);
                            var mimeString = dataUri.split(',')[0].split(':')[1].split(';')[0];
                            var ab = new ArrayBuffer(byteString.length);
                            var ia = new Uint8Array(ab);
                            for (var i = 0; i < byteString.length; i++) {
                                ia[i] = byteString.charCodeAt(i);
                            }
                            return new Blob([ab], { type: mimeString });
                        }

                                $("#modalCam").modal("hide");

                        // Membuat objek blob dari data URI
                        // fetch(dataUri)
                        //     .then(response => response.blob())
                        //     .then(blob => {
                        //         // Membuat objek File dari blob
                        //         const file = new File([blob], "captured_photo.jpg", { type: "image/jpeg" });

                        //         // Menyimpan objek File ke input file foto_ktp
                        //         const fileInput = document.getElementById("foto_ktp");
                        //         fileInput.files = new FileList([file]);

                        //         // Menutup modal menggunakan JavaScript
                        //         // document.getElementById("modalCam").style.display = "none";

                        //         // Atau, menutup modal menggunakan jQuery (jika jQuery tersedia)
                        //         $("#modalCam").modal("hide");
                        // });
                    }
                });

                retryButton.addEventListener("click", function() {
                // Kode untuk mengulangi pengambilan gambar
                    capturedPhoto.src = ""; // Menghapus gambar yang telah diambil
                    berhasilTakeFoto = false; // Setel flag berhasilTakeFoto ke false
                    isCapturing = true; // Mulai pengambilan gambar kembali

                    // Menampilkan kembali tombol "Take Snapshot" dan menyembunyikan tombol "Upload" dan "Ulang"
                    captureButton.classList.remove("d-none");
                    uploadButton.classList.add("d-none");
                    retryButton.classList.add("d-none");
                    Webcam.attach(cameraFeed); // Melekatkan kamera kembali setelah diulang
                });

                // Listen for select change event
                uploadSelect.addEventListener("change", function() {
                    const selectedOption = uploadSelect.value;
                    if (selectedOption === "webcam") {
                        // Show webcam and hide file input
                        cameraFeed.style.display = "block";
                        capturedPhoto.style.display = "block";
                        photoInput.style.display = "none";
                        // button open cam hapus class d-none
                        buttonOpenCam.classList.remove("d-none");
                    } else if (selectedOption === "file") {
                        // Show file input and hide webcam
                        cameraFeed.style.display = "none";
                        capturedPhoto.style.display = "none";
                        photoInput.style.display = "block";
                        // button open cam tambah class d-none
                        buttonOpenCam.classList.add("d-none");
                    }
                });
            });
        </script>
    @endsection
