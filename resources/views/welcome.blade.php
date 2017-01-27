<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fantasy Enduro</title>

        <link href="/css/app.css" rel="stylesheet">
    </head>
    <body>
        <div class="landing-bg-image flex-center position-ref full-height">
            <div class="cover"></div><!-- /.cover -->
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Fantasy Enduro
                </div>

                <div class="links">
                    @if (Auth::check())
                        <a href="/athletes">Athletes</a>
                        <a href="/set-lineup">Set Lineup</a>
                        <a href="/upload-race">Leagues</a>
                        <a href="/results">Results</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
