<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title
    @if(Gate::check('isHr'))
        {{ "id=hrNotifTitle" }}
    @elseif(Gate::check('isDoctor'))
        {{ "id=doctorNotifTitle" }}
    @elseif(Gate::allows('isNurse'))
        {{ "id=nurseNotifTitle" }}
    @elseif(Gate::allows('isAdmin'))
        {{ "id=adminNotifTitle" }}
    @endif
    >
        {{ config('app.name', 'Laravel') }} 
        @yield('title')
    </title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
    {{-- @include('layouts.classes') --}}
</head>
<body class="{{ ( ! empty($class) ) ? $class : '' }}">
    <div id="zapWrap" class="sticky-menu">
        @guest
            @yield('content')
        @else
            <div id="adminMainMenu" role="navigation">
                <a href="#zapbody-content" class="sr-only">Skip to main content</a>
                <a href="#zap-toolbar" class="sr-only">Skip to toolbar</a>
                @include('layouts.includes.sidebar')
            </div>
            <div id="zapContent">
                @include('layouts.includes.top')
                <main id="app" class="primary-site" role="main">
                    <div class="wrap">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-12 col-lg-6">
                                    <h2 class="heading-title">@yield('heading-title')</h2>
                                </div>
                                <div class="col-12 col-lg-6">

                                  @if ( !Request::is('dashboard') && !Request::is('employees/profile/employee/*') && !Request::is('password/reset') )
                                    @include('layouts.breadcrumbs')
                                  @endif  

                                </div>                                
                            </div>
                            @if ( request()->is('dashboard*') || request()->is('hr*')  || request()->is('employees*') || request()->is('register') || request()->is('password/reset') || request()->is('media')  || request()->is('posts*')  || request()->is('inventory*')  || request()->is('medical*') || request()->is('category*') || request()->is('admin*') ) 
                                @yield('dash-content')
                            @else
                                <div class="card">
                                    <div class="card-header">@yield('dash-title') <span class="float-right">@yield('back')</span></div>
                                    <div class="card-body">
                                        @yield('dash-content') 
                                    </div> 
                                </div>                            
                            @endif

                        </div>
                    </div>
                </main>
            </div>
        @endguest
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}"></script>
    <script src="{{ asset('/js/tinymce/tinymce.js') }}"></script>
    <script src="{{ asset('/js/tinymce/tinymce.jquery.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js" crossorigin="anonymous"></script>
   @if ( Request::is('hr/employees') || request()->route()->getName() == 'hr.emp.show' || Request::is('inventory/medicine') || Request::is('inventory/medicine/*') || request()->route()->getName() == 'medical.show' || request()->route()->getName() == 'medical.employeeInfo')
    <script src="{{ asset('/js/jquery.printPage.js') }}" type="text/javascript" defer></script>
   @endif      
    @yield('scripts')
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.26.3'><\/script>".replace("HOST", location.hostname));
    //]]>
    </script>
</body>
</html>