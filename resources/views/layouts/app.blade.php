<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'CodeBuilder'))</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="https://codebuilder.us/images/mandala4_75.png">

    <!-- Web Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:700,400,300' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


</head>
<body>
        <script src="{{ asset('/js/enable-push.js') }}" defer></script>
    <div id="app">
        <nav class="navbar fixed-top navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <table style="position: relative; top: 10px; " id="logo_table">
                            <tbody style="background: transparent !important;">
                                <tr>
                                    <td style="width: 60px;">
                                        <img src="https://codebuilder.us/images/mandala4_75.png" style="max-width: 55px;" id="logo_img">
                                    </td>
                                    <td id="logo_txt_td">
                                        <!-- logo -->
                                        <div id="logo" class="logo" style="min-width: 190px !important;">
                                            <h3 style="margin-bottom: 0px;" class="title logo-font object-non-visible animated object-visible fadeIn" data-animation-effect="fadeIn" data-effect-delay="100"><span class="text-default">CodeBuilder</span> Inc.</h3>
                                        </div>
                                        <!-- name-and-slogan -->
                                        <div class="site-slogan">
                                            &nbsp;Administrative Web Panel App
                                        </div>
                                    </td>
                                    <td>
                                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}" style="border: 0px; position: relative; left: 0px; padding-left: 0px; padding-right: 0px;">
                                            <span class="navbar-toggler-icon"></span>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
 
                </div>
 

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

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

        <main class="py-4"  style="margin-top: 66px;">
            @yield('content')
        </main>
    <div style="position: fixed; bottom: 0px; background-color: #f1f1f1; width: 100%; z-index: 1000; text-align: center !important; padding-top: 5px;">
          <div class="row bottom_main_menu">
            <div class="col" style="padding-left: 25px; padding-right: 0px;">
                <a href="#" class="btn" style="color: black;">
                    <i class="fas fa-home"></i>
                </a>
            </div>
            <div class="col" style="padding-left: 0px; padding-right: 0px;">
                <a href="#" class="btn" style="color: black;">
                    <i class="fas fa-list-alt"></i>
                </a>
            </div>
            <div class="col" style="padding-left: 0px; padding-right: 0px;">
                <a href="#" class="btn" style="color: black; border: 1px solid #007c00;border-radius:50%; height: 34px; width: 34px; background-color: #007c00">
                    <i class="fas fa-dollar-sign" style="position: relative;  color: white"></i>
                </a>            
            </div>
            <div class="col" style="padding-left: 0px; padding-right: 0px;">
                <a href="#" class="btn" style="color: black;">
                    <i class="fas fa-clock"></i>
                </a>            
            </div>
            <div class="col" style="padding-left: 0px; padding-right: 15px;">
                <a href="#" class="btn" style="color: black;">
                    <i class="fas fa-user"></i>
                </a>            
            </div>
          </div>
    </div> 
    </div>




    <style>
        .navbar-toggler:focus {
            border: 0px !important;
            outline: 0px dotted;
        }
        .logo-font {
          font-family: "Pacifico", cursive, sans-serif;
          color: #ffffff !important;
        }
        .text-default{
            color: #09afdf !important;
        }
        .navbar-laravel { 
            background-color: #394245;
            padding-bottom: 25px;
        }
        .site-slogan {
            color: #f1f1f1 !important;
            text-shadow: 1px 1px rgba(0, 0, 0, 0.4);
        }
        .site-slogan {
            position: relative;
            top: -3px;
        }
        .site-slogan {
            text-align: left !important;
        }
        .site-slogan {
            text-align: center;
        }
        .site-slogan {
            color: #777777;
            font-size: 11px;
            padding: 3px 0 0;
            font-weight: 300;
            opacity: 1;
            filter: alpha(opacity=100);
            -webkit-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        /*-------------------------------*/
        /*       Hamburger-Cross         */
        /*-------------------------------*/

        .hamburger {
          position:absolute;
          right:25px;
          top: 20px;  
          z-index: 999;
          display: block;
          width: 32px;
          height: 32px;
          margin-left: 15px;
          background: transparent;
          border: none;
        }
        .hamburger:hover,
        .hamburger:focus,
        .hamburger:active {
          outline: none;
        }
        .hamburger.is-closed:before {
          content: '';
          display: block;
          width: 100px;
          font-size: 14px;
          color: #fff;
          line-height: 32px;
          text-align: center;
          opacity: 0;
          -webkit-transform: translate3d(0,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-closed:hover:before {
          opacity: 1;
          display: block;
          -webkit-transform: translate3d(-100px,0,0);
          -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom,
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
          position: absolute;
          left: 0;
          height: 4px;
          width: 100%;
        }
        .hamburger.is-closed .hamb-top,
        .hamburger.is-closed .hamb-middle,
        .hamburger.is-closed .hamb-bottom {
          background-color: #1a1a1a;
        }
        .hamburger.is-closed .hamb-top { 
          top: 5px; 
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-closed .hamb-middle {
          top: 50%;
          margin-top: -2px;
        }
        .hamburger.is-closed .hamb-bottom {
          bottom: 5px;  
          -webkit-transition: all .35s ease-in-out;
        }

        .hamburger.is-closed:hover .hamb-top {
          top: 0;
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-closed:hover .hamb-bottom {
          bottom: 0;
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-middle,
        .hamburger.is-open .hamb-bottom {
          background-color: #1a1a1a;
        }
        .hamburger.is-open .hamb-top,
        .hamburger.is-open .hamb-bottom {
          top: 50%;
          margin-top: -2px;  
        }
        .hamburger.is-open .hamb-top { 
          -webkit-transform: rotate(45deg);
          -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
        }
        .hamburger.is-open .hamb-middle { display: none; }
        .hamburger.is-open .hamb-bottom {
          -webkit-transform: rotate(-45deg);
          -webkit-transition: -webkit-transform .2s cubic-bezier(.73,1,.28,.08);
        }
        .hamburger.is-open:before {
          content: '';
          display: block;
          width: 100px;
          font-size: 14px;
          color: #fff;
          line-height: 32px;
          text-align: center;
          opacity: 0;
          -webkit-transform: translate3d(0,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
        .hamburger.is-open:hover:before {
          opacity: 1;
          display: block;
          -webkit-transform: translate3d(-100px,0,0);
          -webkit-transition: all .35s ease-in-out;
        }
    </style>


</body>
</html>
