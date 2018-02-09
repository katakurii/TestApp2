<!DOCTYPE html>
<html lang="en" ng-app="my-app">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ url('/css_template/bootstrap.min.css')}}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sss.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ url('css/style.css')}}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top" style="background: #3c8dbc;">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" style="color: white;">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}" style="color: white;">Login</a></li>
                            <!-- <li><a href="{{ route('register') }}" style="color: white;">Register</a></li> -->
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;background: #3c8dbc;">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu" style="background: #3c8dbc;">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: white;">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="{{ url('/js_template/bootstrap.min.js')}}"></script>
    <script src="{{ asset('app/lib/angular.min.js') }}"></script>
    <script src="{{ asset('app/lib/ng-file-upload.min.js') }}"></script>
    <script src="{{ asset('app/lib/ng-file-upload-all.min.js') }}"></script>
    <script src="{{ asset('app/lib/ng-file-upload-shim.min.js') }}"></script>
    <script src="{{ asset('app/agl.js') }}"></script> 
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('app/paginate.js') }}"></script>
</body>
</html>