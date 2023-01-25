<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blog Home - Start Bootstrap Template</title>
    {{-- @vite('resources/css/app.css') --}}
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/added_style.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <!--scripts -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div id="app"></div>
        {{-- <x-layouts.header /> --}}
            {{-- {{$slot}} --}}
        {{-- <x-layouts.footer /> --}}


	@vite('resources/js/app.js')
    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
    <!--modals-->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('js/app.js')}}" defer ></script>
    <script>
        $(document).ready(function() {
            $('.switch-tologin-modal').on('click', function() {
                $('#register-modal').modal('hide');
                $('#login-modal').modal('show');
            })
            $('.switch-toregister-modal').on('click', function() {
                $('#login-modal').modal('hide');
                $('#register-modal').modal('show');
            })
        })


    </script>


</body>


</html>
