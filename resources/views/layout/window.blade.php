<!DOCTYPE html>
<html lang="{{ $currentLang ?? 'en' }}" dir="{{ $direction ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexGen Forex</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">

    @if (($direction ?? 'ltr') === 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nexgen.css') }}">

    <style>
        .flag-icon {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 2px;
        }

        body.window-layout .header,
        body.window-layout.layout-mode-rtl .header {
            left: 0;
            right: 0;
            width: 100%;
        }

        body.window-layout .header .main-header {
            width: 100%;
        }

        .window-layout .header .header-left {
            width: auto;
            min-width: 252px;
        }

        body.window-layout .page-wrapper,
        body.window-layout.layout-mode-rtl .page-wrapper {
            margin: 0;
            margin-right: 0;
            margin-left: 0;
            padding-top: 65px;
            width: 100%;
        }

        .window-layout .page-wrapper .content {
            padding: 16px;
            width: 100%;
        }

        .window-layout .copyright-footer {
            margin: 0;
        }
    </style>
</head>

<body class="window-layout {{ ($direction ?? 'ltr') === 'rtl' ? 'layout-mode-rtl' : '' }}">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">
        <div class="header">
            <div class="main-header">
                <div class="header-left active">
                    <a href="{{ route('dashboard') }}" class="logo logo-normal">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Img">
                    </a>
                    <a href="{{ route('dashboard') }}" class="logo logo-white">
                        <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
                    </a>
                    <a href="{{ route('dashboard') }}" class="logo-small">
                        <img src="{{ asset('assets/img/logo-small.png') }}" alt="Img">
                    </a>
                    <a href="{{ route('dashboard') }}" class="logo-small-white">
                        <img src="{{ asset('assets/img/logo-small-white.png') }}" alt="Img">
                    </a>
                </div>

                <ul class="nav user-menu">
                    <li class="nav-item dropdown has-arrow flag-nav nav-item-box">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);"
                            role="button">
                            @if (($currentLang ?? 'en') == 'fa')
                                <img src="{{ asset('assets/img/flags/iran-flag.svg') }}" alt="Language"
                                    class="flag-icon">
                            @elseif(($currentLang ?? 'en') == 'ur')
                                <img src="{{ asset('assets/img/flags/pakistan-flag.svg') }}" alt="Language"
                                    class="flag-icon">
                            @else
                                <img src="{{ asset('assets/img/flags/us-flag.svg') }}" alt="Language"
                                    class="flag-icon">
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="javascript:void(0);"
                                class="dropdown-item language-option d-flex align-items-center" data-lang="en">
                                <img src="{{ asset('assets/img/flags/us-flag.svg') }}" alt="English"
                                    class="flag-icon me-2"> English
                            </a>
                            <a href="javascript:void(0);"
                                class="dropdown-item language-option d-flex align-items-center" data-lang="ur">
                                <img src="{{ asset('assets/img/flags/pakistan-flag.svg') }}" alt="Urdu"
                                    class="flag-icon me-2"> Urdu
                            </a>
                            <a href="javascript:void(0);"
                                class="dropdown-item language-option d-flex align-items-center" data-lang="fa">
                                <img src="{{ asset('assets/img/flags/iran-flag.svg') }}" alt="Farsi"
                                    class="flag-icon me-2"> Farsi
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-item-box">
                        <a href="javascript:void(0);" id="btnFullscreen">
                            <i class="ti ti-maximize"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-item-box">
                        <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit()">
                            <i class="ti ti-logout"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content">
                @yield('content')
            </div>

            <div
                class="copyright-footer d-flex align-items-center justify-content-between border-top bg-white gap-3 flex-wrap">
                <p class="fs-13 text-gray-9 mb-0">2014 - 2026 &copy; DreamsPOS. All Right Reserved</p>
                <p>Designed & Developed By <a href="javascript:void(0);" class="link-primary">Dreams</a></p>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-ru-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-uk_countries-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-in-mill.js') }}"></script>
    <script src="{{ asset('assets/js/jvectormap.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const languageOptions = document.querySelectorAll('.language-option');

            languageOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    const lang = this.getAttribute('data-lang');

                    fetch('{{ route('language.switch') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                lang: lang
                            })
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

    @yield('script')
</body>

</html>
