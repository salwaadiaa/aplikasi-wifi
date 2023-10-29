<!--
=========================================================
* Argon Dashboard - v1.2.0
=========================================================
* Product Page: https://www.creative-tim.com/product/argon-dashboard

* Copyright  Creative Tim (http://www.creative-tim.com)
* Coded by www.creative-tim.com
=========================================================
* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="{{ asset('/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/assets/img/brand/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/css/argon.css?v=1.2.0') }}" type="text/css">

    {{-- toastr --}}
    {{-- <link rel="stylesheet" href="{{ asset('/assets/css/toastr.css') }}"> --}}

    {{-- Snackbar --}}
    <link rel="stylesheet" href="{{ asset('/assets/css//snackbar.min.css') }}">
    <script src="{{ asset('/assets/js/snackbar.min.js') }}"></script>

    {{-- Costume Style --}}
    @yield('c_style')
</head>

<body class="bg-default">
    <!-- Navbar -->
    <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('login') }}">
                <img src="{{ asset('/assets/img/brand/logo1.png') }}">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{ route('login') }}">
                                <img src="{{ asset('/assets/img/brand/logo1.png') }}">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav mr-auto">
                </ul>
                <hr class="d-lg-none" />
                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer class="py-5" id="footer-main">
        <div class="container">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-6">
                    <div class="copyright text-center text-xl-left text-muted">
                        &copy; {{ date('Y') }} <a href="https://www.creative-tim.com" class="font-weight-bold ml-1"
                            target="_blank">Creative Tim</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script src="{{ asset('/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('/assets/js/argon.js?v=1.2.0') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- toastr -->
    {{-- <script src="{{ asset('/assets/js/toastr.min.js') }}"></script> --}}

    {{-- Costume JS --}}
    @yield('c_js')

    <script>
        @if (Session::has('success'))
            Snackbar.show({
                text: "{{ session('success') }}",
                backgroundColor: '#28a745',
                actionTextColor: '#212529',
            })
        @elseif (Session::has('error'))
            Snackbar.show({
                text: "{{ session('error') }}",
                backgroundColor: '#dc3545',
                actionTextColor: '#212529',
            })
        @elseif (Session::has('info'))
            Snackbar.show({
                text: "{{ session('info') }}",
                backgroundColor: '#17a2b8',
                actionTextColor: '#212529',
            })
        @endif ;

        // toggle password
        function seePassword(icon) {
            try {
                var icon = $(`#${icon.id} i`);
                var inputPass = $('input[id="password"]')
                var type = 'password'

                if (icon.attr('class') === 'fas fa-eye') {

                    type = 'text'
                    icon.removeClass().addClass('fas fa-eye-slash')

                } else {
                    icon.removeClass().addClass('fas fa-eye')
                }

                inputPass.map((i, input) => {
                    $(`input[name="${input.name}"]`).attr('type', type)

                })
                return true;
            } catch (error) {
                console.log(error)
                return false;
            }
        }
    </script>
    {{-- <script src="{{ asset('/assets/vendor/webcamjs/webcam.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.js" integrity="sha512-AQMSn1qO6KN85GOfvH6BWJk46LhlvepblftLHzAv1cdIyTWPBKHX+r+NOXVVw6+XQpeW4LJk/GTmoP48FLvblQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
