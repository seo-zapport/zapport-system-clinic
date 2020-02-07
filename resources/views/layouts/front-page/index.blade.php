<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('front-title')</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/slick.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/slick-theme.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/front.css') }}">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
	</head>
	<body id="page-top" class="zp-front-page" data-spy="scroll" data-target="#mainNav" data-postmodal="@yield('modalStatus')">
		
		@include('layouts.front-page.menu')
		<div id="app">
			@yield('front-content')
		</div>
		@include('layouts.front-page.footer')
	</body>
</html>