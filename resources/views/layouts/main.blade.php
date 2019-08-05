<!DOCTYPE html>
<html>
<head>
    <title>Сайтсофт</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css">
    @yield('styles')
<body>

<div class="navbar">
    <div class="navbar-inner">
        <a class="brand" href="#">Сайтсофт</a>
        @yield('content_head')

        @if(\Auth::check())
            <ul class="nav pull-right">
                <li><a><b>{{ \Auth::user()->name }}</b></a></li>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Выход</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        @endif
    </div>
</div>

    @yield('content')
    @yield('modal')
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://stackpath.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
    @yield('scripts')

</body>
</html>