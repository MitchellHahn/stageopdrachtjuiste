


<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

{{--<script scr="https://code.jquery.com/jquery-1.12.4.js"></script>--}}
{{--<script scr="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
{{--<script>--}}
{{--    $( function() {--}}
{{--        $( ".datepicker" ).datepicker();--}}
{{--    });--}}
{{----}}
{{--</script>--}}


    <link href="{{ mix('css/style.css') }}?v=<?php echo time(); ?>" rel="stylesheet">


</head>
<body>
    <header>


        <div class="row align-items-center navbarbox">

            <div class="col-3">
                <div class="row align-items-left">

                <img class="navbar-logo" src="{{ url('images/logos/brouwerslogo.png') }}" />
{{--                <img src="/storage/app/public/uploads/logos/48876.jpg" alt="Logo" style="width:100px;height:50px;">--}}
{{--                <img src="/logos/48876.jpg" width="100" height="50" class="logo" />--}}
{{--                <img src="/storage/app/public/uploads/logos/48876.jpg" width="100" height="50" class="logo" />--}}
{{--                <img src="{{ url('uploads/logos/'.$logo->blogo) }}" width="190" height="190" class="logo " />--}}



{{--                {{ asset('storage/test.png') }}--}}

                </div>
            </div>

            <nav class="col-9 col-md-6 navbar justify-content-center navbar-expand-md" style="position:static">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('', '') }}
                </a>


                <div id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto ">
                        @foreach ($navbars as $navbarItem)
                            <li class="nav-item ">
                                <a class="navbarboxtext " class="nav-link" href="{{ route($navbarItem->route) }}">{{ $navbarItem->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="d-md-none">
                    <button class="hamburger nav-btn" type="button">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </nav>
            <div class="col-3 d-none d-md-block"></div>
        </div>

        {{--impersonation verbinding verbreken--}}
        <div class="pull-right">
            @impersonating($guard = null)
            <a href="{{ route('impersonate.leave') }}">Verbinding verbreken</a>
            @endImpersonating
        </div>
        {{--logout knop--}}
        @auth
{{--            <form action="{{ route('logout') }}" method="post" class="logoutbox">--}}
{{--                <div class="row height15">--}}
{{--                    <div class="col-12">--}}
{{--                        <span class="tablerowcell  d-none d-md-table-cell tablerowcellSupportedContent fontcolorwhite">Ingelogd als <br/>--}}
{{--                            {{ Auth::user()->name.' '.Auth::user()->getLastName() }}--}}
{{--                        </span>--}}
{{----}}
{{----}}
{{----}}
{{--                        <span class="tablerowcell d d-md-table-cell tablerowcellSupportedContent">--}}
{{--                            @csrf--}}
{{--                            <input type="submit" class="logoutbtn " value="Uitloggen" />--}}
{{--                            </span>--}}
{{--                        ingelogd als--}}
{{--                                <div class="pull-right"><i>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
        @endauth
    </header>
    <main>
        @yield('content')
    </main>
    <script defer src="{{ mix('js/main.js') }}"></script>
</body>
</html>
