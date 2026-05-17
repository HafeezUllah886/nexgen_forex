<!DOCTYPE html>
<html lang="{{ session('locale', 'en') }}" dir="{{ session('direction', 'ltr') }}">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Dreams POS is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
    <meta name="keywords"
        content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>NexGen Forex</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">

    <!-- Bootstrap CSS - RTL or LTR based on direction -->
    @if(session('direction') === 'rtl')
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    @else
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    @endif

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

</head>

<body class="account-page bg-white{{ session('direction') === 'rtl' ? ' layout-mode-rtl' : '' }}">

    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper login-new">
                <div class="row w-100">
                    <div class="col-lg-5 mx-auto">
                        <div class="login-content user-login">
                            <div class="login-logo">
                                <img src="{{ asset('assets/img/logo.svg') }}" alt="img">
                                <a href="index.html" class="login-logo logo-white">
                                    <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
                                </a>
                            </div>

                            <!-- Language Selector -->
                            <div class="language-selector mb-3">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary dropdown-toggle w-100 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if(session('locale') == 'fa')
                                            <img src="{{ asset('assets/img/flags/iran-flag.svg') }}" alt="Farsi" class="me-2 flag-icon"> فارسی
                                        @elseif(session('locale') == 'ur')
                                            <img src="{{ asset('assets/img/flags/pakistan-flag.svg') }}" alt="Urdu" class="me-2 flag-icon"> اردو
                                        @else
                                            <img src="{{ asset('assets/img/flags/us-flag.svg') }}" alt="English" class="me-2 flag-icon"> English
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li>
                                            <a class="dropdown-item language-option d-flex align-items-center" href="javascript:void(0);" data-lang="en">
                                                <img src="{{ asset('assets/img/flags/us-flag.svg') }}" alt="English" class="me-2 flag-icon"> English
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item language-option d-flex align-items-center" href="javascript:void(0);" data-lang="ur">
                                                <img src="{{ asset('assets/img/flags/pakistan-flag.svg') }}" alt="Urdu" class="me-2 flag-icon"> اردو
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item language-option d-flex align-items-center" href="javascript:void(0);" data-lang="fa">
                                                <img src="{{ asset('assets/img/flags/iran-flag.svg') }}" alt="Farsi" class="me-2 flag-icon"> فارسی
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <style>
                                .flag-icon {
                                    width: 24px;
                                    height: 16px;
                                    object-fit: cover;
                                    border-radius: 2px;
                                }
                            </style>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="card">
                                    <div class="card-body p-5">
                                        <div class="login-userheading">
                                            <h3>{{ __('auth.sign_in') }}</h3>
                                            <h4>{{ __('auth.access_panel') }}</h4>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('auth.username') }} <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="username" value="{{ old('username') }}" class="form-control border-end-0" required>
                                                <span class="input-group-text border-start-0">
                                                    <i class="ti ti-user"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">{{ __('auth.password') }} <span class="text-danger">*</span></label>
                                            <div class="pass-group">
                                                <input type="password" name="password" class="pass-input form-control" required>
                                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                                            </div>
                                        </div>

                                        <div class="form-login">
                                            <button type="submit" class="btn btn-primary w-100">{{ __('auth.login') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                            <p>Copyright &copy; 2026 NextGen Forex</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <!-- Language Switcher -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageOptions = document.querySelectorAll('.language-option');

            languageOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lang = this.getAttribute('data-lang');

                    fetch('{{ route("language.switch") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ lang: lang })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.documentElement.setAttribute('dir', data.direction);
                            document.documentElement.setAttribute('lang', lang);
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

</body>

</html>