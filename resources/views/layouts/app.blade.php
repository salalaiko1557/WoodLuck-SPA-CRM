
<!DOCTYPE html>
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pattaya" rel="stylesheet">
</head>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navigate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">


</head>
<body>
    <div id="app">
        @guest
        <main class="px-0 py-3 ">
            <div class="top-right links">
                    <a href="{{ route('login') }}">Увiйти в систему</a>
                    @yield('content')
            </div>
        </main>
        @else
            @include('layouts.navigate')
        <main class="px-0 py-0">
            @yield('content')
            <role-helper
            :role = "{{ json_encode($role) }}"
            ></role-helper>
            <router-view></router-view>
        </main>
        @endguest
    </div>
</body>
</html>



