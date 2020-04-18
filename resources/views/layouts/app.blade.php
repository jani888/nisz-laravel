<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script   src="https://code.jquery.com/jquery-3.5.0.min.js"   integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="   crossorigin="anonymous"></script>

        <!-- fullCalendar -->
        <script src='https://unpkg.com/@fullcalendar/core@4.4.0/locales/hu.js'></script>
        <script src="https://unpkg.com/@fullcalendar/core@4.4.0/main.min.js"></script>
        <script src="https://unpkg.com/@fullcalendar/interaction@4.4.0/main.js"></script>
        <script src="https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.js"></script>
        <script src="https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/core@4.4.0/main.min.css">
        <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/timegrid@4.4.0/main.min.css">
        <link rel="stylesheet" href="https://unpkg.com/@fullcalendar/daygrid@4.4.0/main.min.css">

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <!-- Styles -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item mx-2"><a href="/todo"> <i class="fa fa-list"></i> Teendők</a></li>
                            <li class="nav-item mx-2"><a href="/schedule"> <i class="fa fa-calendar"></i> Időbeosztás</a></li>
                            <li class="nav-item mx-2"><a href="/chat"> <i class="fa fa-inbox"></i> Üzenetek</a></li>
                            <li class="nav-item mx-2"><a href="/invite"> <i class="fa fa-paper-plane"></i> Meghívás</a></li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                @yield('content')
            </main>

            <footer class="site-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-6 col-xs-12">
                            <span>
                                Made with <i class="fas fa-heart text-danger pulse"></i> Open Source
                            </span>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            #StayAtHome #VigyazzunkEgymasra
                        </div>
                    </div>
                </div>
            </footer>

            <style>
                .site-footer
                {
                    background-color:#26272b;
                    padding:45px 0 20px;
                    font-size:15px;
                    line-height:24px;
                    color:#737373;
                }
            </style>
        </div>
    </body>
</html>
