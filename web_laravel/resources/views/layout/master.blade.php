<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href=" {{ asset('images/favicon.ico') }}">


    <!-- App css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app-creative.min.css') }}" rel="stylesheet" type="text/css" id="light-style"/>
    @stack('css')
</head>

<body
    data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
<!-- Begin page -->
@include('layout.sidebar')
<div class="wrapper">
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    @include('layout.header')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{ $title }}</h4>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="message">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="col-12">
                        @yield('content');
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.footer')
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->

<!-- /Right-bar -->

<!-- bundle -->
<script src="{{ asset('js/vendor.min.js') }}"></script>
<script src="{{ asset('js/app.min.js') }}"></script>
@stack('js')

<!-- end demo js-->
</body>
</html>
