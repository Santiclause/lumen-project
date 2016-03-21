<!DOCTYPE html>
<html>
    <head>
        <title>Notes - @yield('title')</title>
        <link href="/css/global.css" rel="stylesheet" type="text/css" />
@section('scripts')
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="/js/global.js"></script>
@show
    </head>
    <body>
        <div id="main-header" class="container">
            <div id="header">
                Fancy app header
            </div>
            <div id="login-header">
                <a href="/login" class="button">Login</a>
                <span id="logout" class="button">Logout</span>
            </div>
        </div>
        <div id="main-content" class="container">
@yield('content')
        </div>
    </body>
</html>