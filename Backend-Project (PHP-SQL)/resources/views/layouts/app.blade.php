<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <title>Shostatskyi's Project </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
     
    <link href="asset/css/mystyles.css" rel="stylesheet">
    <link href="asset/css/bootstrap.min.css" rel="stylesheet" />
    <link href="asset/css/navbar-fixed-side.css" rel="stylesheet" />
     
    <style>
    .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 70%;
      margin: auto;
  }
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    
</head>

<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/home') }}">
                   <b class='tb_header'>Мой проект</b>
                </a>
            </div>
            
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}"><span class="glyphicon glyphicon-home"
                         aria-hidden="true"></span> Главная</a></li>
                    <li><a href="{{ url('/ask') }}"> <span class="glyphicon glyphicon-question-sign"
                         aria-hidden="true"></span> Задать вопрос</a></li>
                         
                     @if (Auth::user())
                     
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                         role="button" aria-haspopup="true" aria-expanded="false">
                         <span class="glyphicon glyphicon-list-alt"
                         aria-hidden="true"></span> Админ <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">Вопросы </li>
                            <li><a href="questionUnaMgt"> Неотвеченные вопросы</a></li>
                            <li><a href="questionAnsMgt"> Отвеченные вопросы </a></li>
                            <li><a href="questionsCenosred"> Заблокированные вопросы </a></li>
                            <li><a href="questionAll"> Все вопросы </a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Админы</li>
                            <li><a href="adminMgt">Управление админами</a></li>
                            <li><a href="addAdmin">Добавить админа </a></li>
                            <li><a href="adminMonitor">Действия админа </a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Категории </li>
                            <li><a href="tagMgt"> Управление категориями </a></li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-header">Запрещенные слова </li>
                            <li><a href="censor"> Запрещенные слова </a></li>
                        </ul>
                     </li> 
                     
                     @endif
                     
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                    @if (Auth::guest())
                    
                        <li><a href="{{ url('/login') }}">Вход</a></li>
                        <!-- <li><a href="{{ url('/register') }}">Register</a></li> -->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Выход </a></li>
                            </ul>
                        </li>
                        
                    @endif
                    
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="asset/js/modals.js"></script>
         
</body>

</html>
