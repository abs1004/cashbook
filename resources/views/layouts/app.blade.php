<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<title>{{ config('app.name', 'Laravel') }}</title>--}}
    <title>铁公鸡</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>

    <style>
        body{
            font-family: sans-serif;
        }
        .mt-8{margin-top: 8px;min-height: 35px;}
        .mb-8{margin-bottom: 8px;}
        .text-center{text-align: center;line-height: 50px;height: 50px;}
        .abs-cut-str-3{
            max-width: 3em;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        ul{
            padding: 0 0;
        }
        .li-edit{
            list-style: none;
            margin-top: 10px;
            border-bottom: 1px solid #ddd;
        }
        .abs-cut-str-8{
            max-width: 8em;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .nav-tabs
        {
            text-align: center;
            height: 40px;
            line-height: 40px;
        }
        .main_nav_bottom{
            background: #ddd;
            color: #af3343;
            height: 40px;
        }
        .color-white{
            color:#fff !important;
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed glyphicon glyphicon-user" data-toggle="collapse" data-target="#app-navbar-collapse">
                        {{--<span class="sr-only">Toggle Navigation</span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                        {{--<span class="icon-bar"></span>--}}
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'abs1004') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}" class="btn btn-danger color-white"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

</body>
</html>
