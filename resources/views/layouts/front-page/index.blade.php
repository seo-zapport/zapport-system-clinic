<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('front-title')</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
		<style type="text/css">
			body{
				position: relative;
			}
			section{
				padding:150px 0;
			}

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
		</style>
	</head>
	<body id="page-top" class="zp-front-page" data-spy="scroll" data-target="#mainNav">
		@include('layouts.front-page.menu')
		<div id="app">
			@yield('front-content')
		</div>
		@include('layouts.front-page.footer')
	</body>
</html>