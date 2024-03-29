<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="A mountain bike fantasy enduro game following the Enduro World Series (EWS). Select your team each race weekend and compete against your friends!">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <!-- Styles -->
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    <link href="/css/emojionearea.min.css" rel="stylesheet">
    <!-- Scripts -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-93558705-1', 'auto');
      ga('send', 'pageview');

    </script>
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
<body class="page-{{(Route::current() ? str_slug(Route::current()->getPath(), '-') : '')}}">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container nav-container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="hamburger">
                        <span class="line"></span>
                        <span class="line"></span>
                        <span class="line"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <img class="logo" src="{{asset('img/fantasy-enduro-logo.png')}}" alt="Fantasy Enduro Logo" />
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav menu-items">
                        <!-- Authentication Links -->
                        @if (Auth::check())
                            <li><a href="{{ url('/athletes') }}">Athletes</a></li>
                            <li><a href="{{ url('/set-lineup') }}">Set Lineup</a></li>
                            <li><a href="{{ url('/leagues') }}">Leagues</a></li>
                            <li><a href="{{ url('/results') }}">Results</a></li>
                            <li><a href="{{ url('/rankings') }}">Rankings</a></li>
                            <li><a href="{{ url('/how-to-play') }}">How To Play</a></li>
                        @endif
                    </ul>
                    <ul class="nav navbar-nav user-settings">
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                            <li><a href="{{ url('/how-to-play') }}">How To Play</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <div class="li-image" style="background-image: url({{ url('/uploads/avatar',Auth::user()->avatar) }})">
                                    </div>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/profile-settings') }}">
                                            <i class="fa fa-cog" aria-hidden="true"></i>
                                                Profile Settings
                                        </a>   
                                    </li>
                                    <li>
                                        <a href="{{ url('/user') }}/{{ Auth::user()->name }}">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                                My Team
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer class="site-footer">
            <div class="content-wrap flex-container">
                <span class="copywrite">&copy; {{ date("Y") }} Fantasy Enduro</span><!-- /.copywrite -->
                <div class="terms-contact">
                    <a href="{{ url('/terms-and-privacy') }}">Terms of Service and Privacy Policy</a> <span>|</span> <a href="{{ url('/contact') }}">Contact</a>
                </div><!-- /.terms-contact -->
            </div><!-- /.content-wrap -->
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
</body>
</html>
