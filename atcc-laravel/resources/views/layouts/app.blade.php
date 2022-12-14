<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="icon" href="{{ asset('img/favicon.png') }}">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"
                integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
                crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"
                integrity="sha512-51l8tSwY8XyM6zkByW3A0E36xeiwDpSQnvDfjBAzJAO9+O1RrEcOFYAs3yIF3EDRS/QWPqMzrl6t7ZKEJgkCgw=="
                crossorigin="anonymous"
                referrerpolicy="no-referrer"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
                integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
                crossorigin="anonymous"
                referrerpolicy="no-referrer"></script>

        <script src="{{ asset('js/main.js') }}"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
            integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link  href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet"/>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">


        @stack('styles_scripts')
    </head>
    <body>
        <div id="app" class="d-flex flex-column" style="min-height: 100vh">

            <nav class="navbar navbar-expand-md navbar-light shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}" >
                        @if(file_exists(public_path('img/logo-white.png')))
                            <img src="{{ asset('img/logo-white.png') }}" alt="OnPoint Logo" height="20">
                        @else
                            {{config('app.name', 'Laravel')}}
                        @endif
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>



                    <div class="collapse navbar-collapse" id="navbarSupportedContent" >

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('panel_index') }}">{{ __('Painel') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('people_index') }}">{{ __('Pessoas') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('tags_index') }}">{{ __('Tags') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('dashboards_index') }}">{{ __('Gr??ficos') }}</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class='fas fa-user-circle' style="font-size: 28px;"></i>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="navbarDropdown">

                                        <a class="dropdown-item" href="{{ route('users_view_edit', ['id' => Auth::user()->id ]) }}">
                                            <div class="d-flex justify-content-evenly gap-2 pt-2 pb-2 ps-2 pe-2 border-bottom fw-bold">
                                                    <p>{{ Auth::user()->name }}</p>
                                                    @if(in_array($role = Auth::user()->getRole('code'), [ 'super_admin', 'admin', ]))
                                                        <i class="fas fa-solid fa-star" style="color: {{$role === 'super_admin' ? 'blue' : 'gray'}}; font-size: 1.3em;"></i>
                                                    @endif
                                            </div>
                                        </a>


                                        {{-- TODO: CREATE ROUTES--}}
                                        @if(in_array($role = Auth::user()->getRole('code'), [ 'super_admin', 'admin', ]))
                                            @if($role === 'super_admin')
                                                <a class="dropdown-item" href="{{ route('roles_index') }}">{{ __('Pap??is') }}</a>
                                                <a class="dropdown-item" href="{{ route('companies_index') }}">{{ __('Empresas') }}</a>
                                                <a class="dropdown-item" href="{{ route('buildings_index') }}">{{ __('Pr??dios') }}</a>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('users_index') }}">{{ __('Usu??rios') }}</a>
                                        @endif

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Sair') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4 flex-grow-1">
                @yield('content')
            </main>

            <footer>
                <div class="text-center pb-2 pt-2 bg-dark text-white">
                    <div>Trabalho de conclus??o de curso apresentado a Universidade S??o Judas Tadeu como parte dos requisitos para a obten????o do t??tulo de bacharel em Engenharia da Computa????o.</div>
                    <div> ?? {{ date('Y') }}. ACME Corp. Todos os Direitos Reservados.</div>
                </div>
            </footer>
        </div>
    </body>
</html>
