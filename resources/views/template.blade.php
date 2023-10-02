<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Favicons -->
    <link type="image/x-icon" href="{{ asset('assets/img/faviconX.png') }}" rel="icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
   <script src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
   <script src="{{ asset('assets/js/respond.min.js') }}"></script>
  <![endif]-->

</head>

<body>

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        <header class="header">
            <nav class="navbar navbar-expand-lg header-nav">
                <div class="navbar-header">
                    <a href="{{ route('login') }}" class="navbar-brand logo">
                        <img src="{{ asset('assets/img/logoX.png') }}" class="img-fluid" alt="Logo">
                    </a>
                </div>
                <div class="main-menu-wrapper">
                    <div class="menu-header">
                        <a href="{{ route('login') }}" class="menu-logo">
                            <img src="{{ asset('assets/img/logoX.png') }}" class="img-fluid" alt="Logo">
                        </a>
                        <a id="menu_close" class="menu-close" href="javascript:void(0);">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
                <ul class="nav header-navbar-rht">
                    @auth
                        <!-- Si l'utilisateur est connecté, vous pouvez afficher un lien vers un autre endroit, par exemple, le tableau de bord -->
                        <li class="nav-item">
                            <a class="nav-link header-login" href="{{ route('accueil') }}">Dashboard</a>
                        </li>
                    @else
                        <!-- Si l'utilisateur n'est pas connecté, affichez le lien de connexion -->
                        <li class="nav-item">
                            <a class="nav-link header-login" href="{{ route('login') }}">Connexion</a>
                        </li>
                    @endauth
                </ul>

            </nav>
        </header>

        @yield('content')

        <footer class="footer">
            <!-- /Footer Top -->

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="container-fluid">

                    <!-- Copyright -->
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="copyright-text">
                                    <p class="mb-0"><a href="templateshub.net">{{ env('APP_NAME') }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Copyright -->

                </div>
            </div>
            <!-- /Footer Bottom -->

        </footer>
        <!-- /Footer -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Slick JS -->
    <script src="{{ asset('assets/js/slick.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

<!-- PGI/  30 Nov 2019 04:11:53 GMT -->

</html>
