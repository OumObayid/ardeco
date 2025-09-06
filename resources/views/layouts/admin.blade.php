<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css">
    <!-- pour sweetAlert -->
    <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.23.0/dist/sweetalert2.all.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.23.0/dist/sweetalert2.min.css
" rel="stylesheet">
    <script src="{{ asset('js/confirm.js') }}"></script>
     <!-- fin pour sweetAlert -->
    <style>
        :root {
            --color-bg-main: #121212;
            --color-bg-secondary: #1e1e1e;
            --color-bg-card: #262626;
            --color-navbar: #000;

            --color-text-main: #f1f1f1;
            --color-text-muted: #bbb;
            --color-accent: #e3c34e;
            --color-accent-hover: #ddac38ff;

            --font-main: 'Segoe UI', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #343a40;
            color: #fff;
            transition: transform 0.3s ease;
        }

        /* Sidebar links */
        .sidebar a {
            display: block;
            color: #c2c7d0;
            padding: 12px 20px;
            text-decoration: none;
        }
         .sidebar a.nav-link.active{
             background-color: var(--color-accent) !important;
         }

        .sidebar a:hover,
        .sidebar .active {
            background: #495057;
            color: #fff;
        }

        /* Contenu principal */
        .content-wrapper {
            flex: 1;
            padding: 5px 20px;
        }

        /* Hamburger mobile */
        .btn-toggle {
            display: none;
            cursor: pointer;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .btn-toggle {
                display: block;
                z-index: 9900;

            }

            /* Sidebar au-dessus du contenu */
            .sidebar {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                transform: translateX(-100%);
                z-index: 1050;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content-wrapper {
                width: 100%;
            }

            /* Overlay pour améliorer l'effet */
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }

            .overlay.show {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="positiion-relative">

    <!-- Overlay mobile -->
    <div class="overlay"></div>



    <!-- Sidebar -->
    <div class="sidebar">

        @include('partials.sidebar')
    </div>

    <!-- Contenu -->
    <div class="content-wrapper">
        @include('partials.navbar')
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.btn-toggle').on('click', function () {
                $('.sidebar').toggleClass('show');
                $('.overlay').toggleClass('show');
            });

            $('.overlay').on('click', function () {
                $('.sidebar').removeClass('show');
                $(this).removeClass('show');
            });
        });
    </script>
</body>

</html>