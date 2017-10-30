<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    @guest
                        {{--<li class="nav-item active">--}}
                            {{--<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>--}}
                        {{--</li>--}}
                    @else

                    @endguest

                </ul>

                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                        @else
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event
                                    .preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                            @endguest

                </ul>
            </div>
        </nav>


        @yield('content')

    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
