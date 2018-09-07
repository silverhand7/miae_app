<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | MIAE APP</title>


    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet"/>

    <!-- Animation library for notifications   -->
    <link href="{{ asset('css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('css/paper-dashboard.css')}}" rel="stylesheet"/>
    
    <!-- datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!--  Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet"/>

</head>
<body>
    <div class="wrapper">
        @guest
            <!-- form login -->
            @yield('login')

            <!-- content forget password & register -->
            <br><br><br><br>
            @yield('content')
        @else
            @include('layouts.sidebar')

            <div class="main-panel">
            
                @include('layouts.navbar')
                <div class="content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                @include('layouts.footer')
            </div>
        @endguest

        
        
  
    </div>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    

    @stack('scripts')

    <!--  Charts Plugin -->
    <script src="{{asset('js/chartist.min.js')}}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{asset('js/bootstrap-notify.js')}}"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="{{asset('js/paper-dashboard.js')}}"></script>  

    @include('layouts.notification')

    

</body>
</html>
