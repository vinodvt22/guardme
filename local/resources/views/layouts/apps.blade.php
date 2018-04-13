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
    <link href="{{ asset('css/apps.css') }}" rel="stylesheet">
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
                        &nbsp;
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
    <script src="{{ asset('js/apps.js') }}"></script>
    <script>
        (function () {
            $('.nav-stacked .brand-nav a').first().trigger('click')
            var _token = $('meta[name="csrf-token"]').attr('content');
            $('.msg_btn').on('click', function (e) {
                e.preventDefault();
                var text = $(this).closest('.message_input').find('.msg_txt').val(),
                    reader_id = $('.brand-nav.active a').data('id');
                var self = $(this);
                if (text == "") {
                    $('.msg_txt').closest('.form-group').addClass('has-error');
                    return false;
                }
            console.log(123);
                $.ajax({
                    url: '/messages/send/{{\Auth::user()->id}}',
                    method: 'POST',
                    data: {
                        _token: _token,
                        message: text,
                        reader: reader_id
                    },
                    success: function (data) {
                        $('.msg_txt').val('');
                        var $msg_area = self.closest('.message_input').closest('#tab' + reader_id).find('.messages_area').last().clone();
                        $msg_area.insertAfter(self.closest('.message_input').closest('#tab' + reader_id).find('.messages_area').last());
                        var $msg = self.closest('.message_input').closest('#tab' + reader_id).find('.messages_area').last();
                        $msg.find('.sender,.reader').removeClass('sender reader pull-left')
                            .addClass('reader').addClass('pull-right').html('<p>' + text + '</p>');
                    },
                    error: function (data) {
                        $('.msg_txt').closest('.form-group').addClass('has-error');
                    }
                })
            });


//            $('.user_msg_count').animate({top: -10}, 300, "easeOutCubic", function(){
//                $('.user_msg_count').animate({top: 0}, 300, "easeOutCubic");
//            });
//            $('.user_msg_count').show().animate({ top: 10 }, {duration: 1000, easing: 'easeOutBounce'});

            $('.brand-nav').on('click', function () {
                var id = $(this).find('a').data('id');
                $(this).find('.user_msg_count').remove();
                setTimeout(function () {
//                    $('.all_messages').scrollTop($('#tab' + id + ' .all_messages')[0].scrollHeight);
                }, 1);
                $.ajax({
                    url: '/messages/see/{{\Auth::user()->id}}',
                    method: "POST",
                    data: {
                        _token: _token,
                        sender: id
                    },
                    success: function (data) {

                    }
                })
            });


            $('textarea').focus(function () {
                var $row = $(this).closest('.has-error');
                $row.removeClass('has-error');
            });
        })();
    </script>
</body>
</html>
