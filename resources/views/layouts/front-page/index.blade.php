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
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
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
            img{
				display: block;
				max-width: 100%;
				height: auto;         	
            }
            #hero{
            	background: url('images/bg-hero.jpg') no-repeat;
            	-webkit-background-size: cover;
            	background-size: cover;
				min-height: 750px;
				padding: 100px 0;
				position: relative;
            }
            .overlay{
            	position: relative;
            }
            .overlay:before{
            	content: '';
            	display: block;
				background: rgba(0, 0, 0, 0.65);
				position: absolute;
				width: 100%;
				height: 100%;
				top: 0;
				left: 0;
			}
			.z-index-1{
				position: relative;
				z-index: 1;
			}
			.btn-custom-trans {
			    background-color: transparent;
			    border-color: #fff;
			    color: #fff;
			    padding: 0.75rem 3.5rem;
			    font-size: 1.125rem;
			    line-height: 1.5;
			    border-radius: 0.3rem;
			    transition: all ease-in-out 0.5s;
			}

			.btn-custom-trans a {
			    text-transform: uppercase;
			    color: #fff;
			    line-height: 1.5;
			}

			.btn-custom-trans:hover {
			    background-color: #0acfd4;
			    color: #fff;
			    border-color: #0acfd4;
			}

			.btn-custom-trans:hover a {
			    color: #fff;
			    text-decoration: none;
			}
			#post{
				background-color: #e4e4e4;
			}
			#zp-footer{
				background-color: #01393a !important;
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