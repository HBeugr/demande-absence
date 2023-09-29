<!DOCTYPE html>
<html lang="fr">

<head>
    @include('admin.layouts.header')
</head>

<body>
    <div class="main-wrapper">

        <!-- Header -->
        <div class="header">
            @include('admin.partials.header')
        </div>
        <!-- /Header -->

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            @include('admin.partials.sidebar')
        </div>
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            @yield('content')
        </div>
        <!-- /Page Wrapper -->

    </div>
    @include('admin.layouts.footer')

</body>

</html>
