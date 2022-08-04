<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Daftar Buku</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('asset') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('asset') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ asset('asset') }}/index3.html" class="navbar-brand">
                    <img src="{{ asset('asset') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Perpustakaan </span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                    <!-- SEARCH FORM -->
                    <form class="form-inline ml-0 ml-md-3" action="{{ route('home') }}">
                        <div class="input-group input-group-sm">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                aria-label="Search" name="search_query">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Perpustakaan <small>Example 3.0</small></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <div class="btn-group float-sm-right">
                                <button type="button" class="btn btn-default">Ketegori / Lokasi Buku</button>
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu" style="">
                                    @foreach ($booklocations as $booklocation)
                                        <form action="{{ route('home') }}">
                                            <input type="hidden" name="search_query" value="{{ $booklocation->id }}">
                                            <button class="dropdown-item" type="submit">{{ $booklocation->name}}</button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container">
                    <div class="row">
                        @foreach ($books as $book)
                            <!-- /.col-md-2 -->
                            <div class="col-lg-2">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <img src="{{ $book->takeImage }}" class="img-fluid" width="100%">
                                    </div>
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $book->title }}</h6>

                                        <p class="card-text"><i>{{ $book->author }} ({{ $book->publish_year }}); Lokasi
                                                : {{ $book->booklocation->name }}</i></p>
                                        <a href="#" class="btn btn-sm btn-primary">Tersedia</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-md-2 -->
                        @endforeach
                        {{ $books->links() }}
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                SIM Perpustakaan
                <strong>Copyright &copy; 2022-{{ date('Y') }} <a
                        href="https://ikhsanheriyawan2404.github.io">Ikhsan Heriyawan</a>.</strong> All rights
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-{{ date('Y') }} <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('asset') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('asset') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('asset') }}/dist/js/adminlte.min.js"></script>
</body>

</html>
