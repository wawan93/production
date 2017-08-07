<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="/order">Карточки заказов</a></li>
                        <li><a href="/polygraphy-type">Форматы</a></li>
                        <li><a href="/manufacturer">Изготовители</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>var $ = jQuery.noConflict();</script>
    <script type="text/javascript" src="https://mundep.gudkov.ru/static/js/main_gd.js?v8"></script>

    <div style="display: none;">
        <form class="FileUploadForm" enctype="multipart/form-data" method="POST" action="">
            <input id="gdfile_upload_input" type="file" name="fileupload" class="" file_callback="onSuccessUploaded_question_doc" onchange="fileUploader.beginUploadFile.apply(this, []);">
        </form>
    </div>
    <script type="text/javascript">
        (function($) {
            $(document).ready(function(){
                fileUploader.onSuccessUploaded_question_doc = function(data){

                    console.log('Uploaded file');
                    console.log(data);

                    smartAjax('/invoice/save', {
                    	data: JSON.stringify(data),
                        user_id: fileUploader.container.attr('data-user'),
                        order_id: fileUploader.container.attr('data-order'),
                    }, function(msg){

                        location.reload();

                    }, function(msg){
                    	console.log(msg.error_text);
                    });

                };
                fileUploader.initListener();
                fileUploader.setOriginMode('laravel');
            });
        })($ || jQuery);
    </script>
</body>
</html>
