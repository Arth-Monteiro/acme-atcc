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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="d-flex flex-column" style="min-height: 100vh">
    <header class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">

                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
{{--                            {{ Auth::user()->name }}--}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="flex-grow-1 d-flex flex-row" style="border: 1px solid red">
        <nav class="d-flex flex-column p-lg-3 gap-lg-3" style="font-size: 20px; border: 1px solid black; width: 250px;" >
{{--            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>--}}
            <a href="#">Painel</a>
            <a href="#">Pessoas</a>
            <a href="#">Crachás</a>
            <div class="btn-group dropright">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    Torres
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            <a href="#">Torres</a>
            <a href="#">Dashbords</a>
            <a href="#">Sobre Nós</a>
        </nav>

        <main class="py-4 flex-grow-1">
            @yield('content')
        </main>
    </div>

    <footer>
        <div class="text-center pb-2 pt-2">
            <div> Site desenvolvido pelos alunos da turma ECP3AN-PLA da Universidade São Judas Tadeu</div>
            <div> © {{ date('Y') }}. ACME Corp. Todos os Direitos Reservados.</div>
        </div>
    </footer>
</div>
</body>
</html>
