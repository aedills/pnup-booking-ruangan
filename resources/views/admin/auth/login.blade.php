<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{$title}}</title>

    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{url('/res/assets/img/favicon.png')}}" rel="icon">
    <link href="{{url('/res/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">
    <link href="{{url('/res/assets/img/favicon.png')}}" rel="shortcut icon" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i'" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    @livewireStyles

    <!-- Data Tables -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>

    <!-- Vendor CSS Files -->
    <link href="{{ url('res/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('res/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('res/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('res/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ url('res/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ url('res/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ url('res/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url('res/assets/css/style.css') }}" rel="stylesheet">

    <!-- J-Query -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="logo d-flex align-items-center w-auto">
                                    <img src="{{url('/res/assets/img/logo.png')}}" alt="">
                                    <span class="d-none d-lg-block">SIRARA</span>
                                </a>
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Masuk Sebagai Admin</h5>
                                        <p class="text-center small">Masukkan username dan password untuk masuk ke akun Anda.</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate action="{{route('auth.doLogin')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa-solid fa-circle-user"></i></span>
                                                <input type="text" name="username" class="form-control" id="yourUsername" required>
                                                <div class="invalid-feedback">Masukkan username Anda.</div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa-solid fa-key"></i></span>
                                                <input type="password" name="password" class="form-control" id="yourPassword" required>
                                                <div class="invalid-feedback">Masukkan password Anda!</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>


    @livewireScripts

    <!-- Vendor JS Files -->
    <script src="{{ url('res/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ url('res/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('res/assets/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ url('res/assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ url('res/assets/vendor/quill/quill.js') }}"></script>
    <script src="{{ url('res/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ url('res/assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ url('res/assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('res/assets/js/main.js') }}"></script>

    <!-- J-Query -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session()->has('success'))
    <script>
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "success",
            title: "{{ session()->get('success') }}",
            showConfirmButton: false,
            timer: 2500
        })
    </script>
    @endif

    @if (session()->has('error'))
    <script>
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: "{{ session()->get('error') }}",
            showConfirmButton: false,
            timer: 2500
        })
    </script>
    @endif

</body>

</html>