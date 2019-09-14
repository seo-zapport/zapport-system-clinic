@php 
	$i = 0;

	if(Request::is('inventory/medicine/logs/brand/*/generic/*/inputDate/*/expDate/*')){
		$minus = 5;
	}else{
		$minus = 1;
	}

	$numsegment = count(request()->breadcrumbs()->segments()) - $minus ;
	$genexist = '';
	$posexist = '';

@endphp
	
<nav aria-label="breadcrumb">
	<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url( '/dashboard' ) }}">Dashboard</a>
			</li>
		@foreach (request()->breadcrumbs()->segments() as $segment)
			@php 
				$url = $segment->url();
				$name = $segment->name(); 

				if($name === "Department"){
					$url = '/hr/department';
					$posexist = '2';   	
				}

				if($name === "Brand" || $name === "Brandname" ){
					$url = '/inventory/medicine/brandname';
					$name = 'Brand Name'; 	
				}

				if($name === "Generic"){
					$url = '/inventory/medicine/generic'; 
					$genexist = '1';
				}

				if($name === "Userroles"){
					$name = 'User Roles'; 	 	
				}

				if($name === 'Position'){
					$posexist = '1';
				}

				if($posexist == '1'){
					if(strpos($url, '/hr/position/') == true ){
						$url = Request::url();
					}
				}

				if($genexist != '1'){
					if(strpos($url, '/logs/brand/') == true ){
						$url = str_replace('logs/brand', 'brandname', $url);
					}
				}

			@endphp
			@if($name != "Dashboard" && $name != "Hr" && $name != "Inventory" && $name != "Medical" && $name != "Logs" && $name != "Employeesmedical" && $name != "Inputdate"  && $name != "Expdate"  && !DateTime::createFromFormat('Y-m-d H:i:s', $name) !== FALSE)
				 @if($i != $numsegment)	
				 	<li class="breadcrumb-item">
				 		<a href="{{$url}}">{{optional($segment->model())->title?: $name}} </a>
				 	</li>
				 @else
					<li class="breadcrumb-item">
						<span><strong>{{optional($segment->model())->title?: $name}}</strong></span>
					</li>
				 @endif
			@endif
			@php $i++; @endphp	
		@endforeach
	</ul>
</nav>