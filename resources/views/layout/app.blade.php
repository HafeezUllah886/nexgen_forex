<!DOCTYPE html>
<html lang="{{ $currentLang ?? 'en' }}" dir="{{ $direction ?? 'ltr' }}">

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
    @if (($direction ?? 'ltr') === 'rtl')
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.rtl.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    @endif

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">

    <!-- animation CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/tabler-icons/tabler-icons.min.css') }}">

    <!-- Map CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.5.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nexgen.css') }}">

    <style>
        .flag-icon {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 2px;
        }
    </style>

</head>

<body class="{{ ($direction ?? 'ltr') === 'rtl' ? 'layout-mode-rtl' : '' }}">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <div class="header">
            <div class="main-header">

                <!-- Logo -->
                <div class="header-left active">
                    <a href="index.html" class="logo logo-normal">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="Img">
                    </a>
                    <a href="index.html" class="logo logo-white">
                        <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Img">
                    </a>
                    <a href="index.html" class="logo-small">
                        <img src="{{ asset('assets/img/logo-small.png') }}" alt="Img">
                    </a>
                    <a href="index.html" class="logo-small-white">
                        <img src="{{ asset('assets/img/logo-small-white.png') }}" alt="Img">
                    </a>
                </div>
                <!-- /Logo -->

                <a id="mobile_btn" class="mobile_btn" href="#sidebar">
                    <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>

                <!-- Header Menu -->
                <ul class="nav user-menu">

                    <!-- Search -->
                    <li class="nav-item nav-searchinputs">
                        <div class="top-nav-search">
                            <a href="javascript:void(0);" class="responsive-search">
                                <i class="fa fa-search"></i>
                            </a>
                            <form action="#" class="dropdown">
                                <div class="searchinputs input-group dropdown-toggle" id="dropdownMenuClickable"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside">
                                    <input type="text" placeholder="Search">
                                    <div class="search-addon">
                                        <span><i class="ti ti-search"></i></span>
                                    </div>
                                    <span class="input-group-text">
                                        <kbd class="d-flex align-items-center"><img
                                                src="{{ asset('assets/img/icons/command.svg') }}" alt="img"
                                                class="me-1">K</kbd>
                                    </span>
                                </div>
                                <div class="dropdown-menu search-dropdown" aria-labelledby="dropdownMenuClickable">
                                    <div class="search-info">
                                        <h6><span><i data-feather="search" class="feather-16"></i></span>Recent Searches
                                        </h6>
                                        <ul class="search-tags">
                                            <li><a href="javascript:void(0);">Products</a></li>
                                            <li><a href="javascript:void(0);">Sales</a></li>
                                            <li><a href="javascript:void(0);">Applications</a></li>
                                        </ul>
                                    </div>
                                    <div class="search-info">
                                        <h6><span><i data-feather="help-circle" class="feather-16"></i></span>Help
                                        </h6>
                                        <p>How to Change Product Volume from 0 to 200 on Inventory management</p>
                                        <p>Change Product Name</p>
                                    </div>
                                    <div class="search-info">
                                        <h6><span><i data-feather="user" class="feather-16"></i></span>Customers</h6>
                                        <ul class="customers">
                                            <li><a href="javascript:void(0);">Aron Varu<img
                                                        src="{{ asset('assets/img/profiles/avator1.jpg') }}"
                                                        alt="Img" class="img-fluid"></a></li>
                                            <li><a href="javascript:void(0);">Jonita<img
                                                        src="{{ asset('assets/img/profiles/avatar-01.jpg') }}"
                                                        alt="Img" class="img-fluid"></a></li>
                                            <li><a href="javascript:void(0);">Aaron<img
                                                        src="{{ asset('assets/img/profiles/avatar-10.jpg') }}"
                                                        alt="Img" class="img-fluid"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <!-- /Search -->



                    <!-- Flag -->
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
                                    class="flag-icon me-2"> اردو
                            </a>
                            <a href="javascript:void(0);"
                                class="dropdown-item language-option d-flex align-items-center" data-lang="fa">
                                <img src="{{ asset('assets/img/flags/iran-flag.svg') }}" alt="Farsi"
                                    class="flag-icon me-2"> فارسی
                            </a>
                        </div>
                    </li>
                    <!-- /Flag -->

                    <li class="nav-item nav-item-box">
                        <a href="javascript:void(0);" id="btnFullscreen">
                            <i class="ti ti-maximize"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        @include('layout.sidebar')
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
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('assets/js/jquery.slimscroll.min.js') }}"></script>

    <!-- Datatable JS -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Chart JS -->
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/chart-data.js') }}"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Map JS -->
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-ru-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-uk_countries-mill.js') }}"></script>
    <script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-in-mill.js') }}"></script>
    <script src="{{ asset('assets/js/jvectormap.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script>
        function logout() {
            document.getElementById('logout-form').submit();
        }

        // Language switcher functionality
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
                                // Update direction
                                document.documentElement.setAttribute('dir', data.direction);
                                document.documentElement.setAttribute('lang', lang);

                                // Reload page to apply changes
                                location.reload();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>


</html>
