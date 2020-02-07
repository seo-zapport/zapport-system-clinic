@php 
	$i = 0;

	if(Request::is('inventory/medicine/logs/brand/*/generic/*/inputDate/*/expDate/*')){
		$minus = 5;
	}elseif(Request::is('inventory/supply/name/*/brand/*/date-inserted/*') ){
		$minus = 3;
	}else{
		$minus = 1;
	}

	$numsegment = count(request()->breadcrumbs()->segments()) - $minus ;
	$genexist = '';
	$posexist = '';
	$supexist = '';

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
				$arrspecsym = array("-", "_");

				$url = str_replace('/name', '/register', $url);

				if($name === "Department"){
					$url = '/hr/department';
					$posexist = '2';   	
				}

				if($name === "Supply" || $name === "supply" ){
					$name = 'Supply';
				}

				if($name === "Brand" || $name === "Brandname" ){
					$name = 'Brand Name'; 	
					if($supexist == '1'){
						$url = str_replace('/brand', ' ', $url);		
					}else{
						$url = '/inventory/medicine/brandname';
					}
				}

				if($name === "Generic"){
					$url = '/inventory/medicine/generic'; 
					$genexist = '1';
					$name = "Generic Name";
				}

				if($name === "Userroles"){
					$name = 'User Roles'; 	 	
				}

				if($name === "Bodyparts" || $name === "bodyparts" ){
					$name = 'Body parts'; 	 	
				}

				if($name === "Employeesmedical" || $name === "employeesmedical" ){
					$name = 'Employees medical';
					if(auth()->user()->roles[0]->role === "employee"){
						$url = '/dashboard';
					}else{ 	
						$url = str_replace('/employeesmedical', ' ', $url);
					}	
				}

				if($name === "Diseases" || $name === "diseases" ){
					$url = app('url')->previous(); 	 	
				}

				if($name === 'Supply'){
					$supexist = '1';
				}

				if($name === 'Position'){
					$posexist = '1';
				}

				if(auth()->user()->roles[0]->role === "employee"){
					if($name === 'Profile' || $name === auth()->user()->employee->emp_id){
						$url = "/employees/profile/employee/".auth()->user()->employee->emp_id;	
					}
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

			@if($name != "Dashboard" && $name != "Hr" && $name != "Inventory" && $name != "Medical" && $name != "Logs" && $name != "Inputdate" && $name != "Expdate" && $name != "Date-Inserted" && !DateTime::createFromFormat('Y-m-d H:i:s', $name) !== FALSE && $name != "Admin" && $name != "Name")
				 @if($i != $numsegment)	
				 	<li class="breadcrumb-item">
				 		<a href="{{$url}}">{{optional($segment->model())->title?: str_replace($arrspecsym, " ",$name)}} </a>
				 	</li>
				 @else
					<li class="breadcrumb-item">
						<span><strong>{{optional($segment->model())->title?: str_replace($arrspecsym, " ",$name)}}</strong></span>
					</li>
				 @endif
			@endif
			@php $i++; @endphp	
		@endforeach
	</ul>
</nav>