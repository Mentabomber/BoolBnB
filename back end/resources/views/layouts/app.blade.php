<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/ui-library/index.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.2.0//SearchBox.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/ui-library/icons-css/poi.css') }}" />

    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/maps/maps-web.min.js'></script>
    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.23.0/services/services-web.min.js'></script>
    <script src='https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.2.0//SearchBox-web.js'></script>


    <script type="text/javascript" src="{{ asset('assets/js/foldable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/languages.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/tail-selector.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/validators.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/dom-helpers.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/formatters.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/info-hint.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/mobile-or-tablet.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/results-manager.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/search-marker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/search-markers-manager.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/search-results-parser.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/side-panel.js') }}"></script>
</head>

<body>
    <div id="app">

        <header class="header">
            <div class="container-fluid" style="background-color: white; color:black">
                <div class="row d-flex align-items-center justify-content-everly" style="line-height: 100px">
                    <div class="col-5" id="title"><h2>BoolBnB</h2></div>
                    <a class="col-3 text-center navbar-header" href="{{ url('http://localhost:5174/') }}">{{ __('Home') }}</a>
                    @guest
                        <div class="col-1 gap-3 d-flex justify-content-between" style="position: relative; left: 90px;">
                            <a class="navbar-header" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @if (Route::has('register'))
                                <a class="navbar-header" href="{{ route('register') }}">{{ __('Signup') }}</a>
                            @endif
                        </div>
                    @else

                    <div class="dropdown col-2" style="line-height: 35px;">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <a href="#" class="navbar-header nome">{{ Auth::user()->name }}</a>
                        </button>
                        <ul class="dropdown-menu" style="font-size:1.2rem;">
                            <li><a class="dropdown-item" href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profilo') }}</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                            </li>
                            <li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                    @endguest
                </div>
            </div>
        </header>

        <main class="">
            @yield('content')
        </main>

        <footer>
            <div class="container-fluid text-align-center" style="height: 250px; padding-top: 1.5rem;">
                <div class="row text-center" style="margin-bottom: 1rem;">
                    <div class="col-12" id="title"><h2>BoolBnB</h2></div>
                </div>
                <div class="row text-center d-flex justify-content-between text-center" id="name">
                    <div class="col-2">
                        <div class="name">Alessandro Belfiore</div>
                        <div class="profile-links">
                            <div><a href="https://www.linkedin.com/in/alessandro-belfiore-695a5328a/">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                            <div><a href="https://github.com/Alecpu92">GitHub <i class="fa-brands fa-github"></i></a></div>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="name">Daniele Corrado</div>
                        <div class="profile-links">
                            <div><a href="https://www.linkedin.com/in/daniele-corrado-7217b628a/">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                            <div><a href="https://github.com/DanieleCorrado">GitHub <i class="fa-brands fa-github"></i></a></div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="name">Fabio Di Giacomo Pepe</div>
                        <div class="profile-links">
                            <div><a href="https://www.linkedin.com/in/fabio-di-giacomo-pepe">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                            <div><a href="https://github.com/fabiodigiacomopepe">GitHub <i class="fa-brands fa-github"></i></a></div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="name">Tilen Simcic</div>
                        <div class="profile-links">
                            <div><a href="https://www.linkedin.com/in/tilen-simcic-043419265/">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                            <div><a href="https://github.com/Mentabomber">GitHub <i class="fa-brands fa-github"></i></a></div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="name">Antonino Troìa</div>
                        <div class="profile-links">
                            <div><a href="https://www.linkedin.com/in/antonino-troia-140884207">LinkedIn <i class="fa-brands fa-linkedin"></i> </a></div>
                            <div><a href="https://github.com/Ninotro">GitHub <i class="fa-brands fa-github"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>

<style>
body {
    background-color: #dfdedf;
}

main {
    padding-bottom: 3rem;
}

.navbar-header {
    font-size: 1.5rem;
}

.nome {
    font-weight: bold;
}

.header {
    border-bottom: 4px solid black;
}

.container-fluid {
    height: 95px;
    color: white;
    background-color: #0D233D;
    text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4);
    font-size: 20px;
}

.row {
    width: 90%;
    margin: 0 auto;
    font-weight: bold;
}

h2 {
    color: #15ba8f;
    font-size: 50px;
}

a {
    text-decoration: none;
    color: inherit;
    font-size: 18px;
}

i {
    margin-left: 10px;
    font-size: 30px;
}

a:hover {
    color: #15ba8f;
}

.name,
.profile-links {
    font-size: 1rem;
}

a, i {
    font-size: 0.85rem;
}
</style>

</html>

<style>
    body {
        background-color: #dfdedf;
    }
</style>