<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A fantasy enduro game following the Enduro World Series. Compete against your friends!">

        <title>Fantasy Enduro</title>
        
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
        <link href="/css/app.css" rel="stylesheet">
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-93558705-1', 'auto');
          ga('send', 'pageview');

        </script>
    </head>
    <body class="welcome-page">
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
                        <a href="/leagues">Leagues</a>
                        <a href="/results">Results</a>
                        <a href="/rankings">Rankings</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            </div>
            <footer class="site-footer">
                <div class="content-wrap flex-container">
                    <span class="copywrite">&copy; {{ date("Y") }} Fantasy Enduro</span><!-- /.copywrite -->
                    <a class="terms-and-privacy" href="{{ url('/terms-and-privacy') }}">Terms of Service and Privacy Policy</a>
                </div><!-- /.content-wrap -->
            </footer>
        </div>
    </body>
</html>
