<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('front-title')</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
	</head>
	<body id="page-top" class="zp-front-page">
		@yield('front-content')
	</body>
</html>