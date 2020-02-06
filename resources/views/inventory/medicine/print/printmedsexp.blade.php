<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">

</head>
<body>
<div class="print">
	<img src="{{url( '/images/logo.png' )}}" alt="Zapport" style="display:block;margin:auto; width: 200px">
	<div style="margin-top: 20px; margin-bottom: 20px;">
	<p class="text-center" style="line-height:0px;">14/F UNIT 14-G BURGUNDY CORPORATE TOWER</p>
	<p class="text-center" style="line-height:0px;">Sen Gil Puyat Ave., San Lorenzo</p>
	<p class="text-center" style="line-height:0px;">Makati City Philippines</p>
	</div>
</div>
<h2>Medicines Inventory</h2>
@if(app('request')->input('search') != "")
<h3>Search by: <strong class="zp-color-6b">{{ app('request')->input('search') }}</strong></h3>
@endif
@if($typeprint == "viewlogs" || $typeprint == "logsinput")
	@if($medbrand != '')
		<h3>Brand Name: <strong class="zp-color-6b">{{$medbrand}}</strong></h3>
	@endif
	@if($generic != '')
		<h3>Generic Name: <strong class="zp-color-6b">{{$generic}}</strong></h3>
	@endif
@endif


<div class="table-responsive">
	<table id="medTable" class="table table-hover">
	 @php 
	 	$i = 0;
	 	if(@$typeprint == "viewlogs"){ 
	 @endphp
	   	<thead>
	   		<th>Input Date</th>
	   		<th>Date Expire</th>
	   		<th>Remaining Quantity</th>
	   		<th>No. of deducted Meds</th>
	   		<th>No. of Medicines</th>
	   		<th>Input by</th>
	   	</thead>
	   	<tbody>
	   		@forelse ($expired as $log)
	   			<tr class="medTR">
	   				<td>
	   				{{ Carbon\carbon::parse($log->formatted_at)->format('m/d/Y') }}
	   				</td>
	   				<td>
	   				{{ Carbon\carbon::parse($log->expiration_date)->format('m/d/Y') }}</td>
	   				<td>
	   				{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 0)->where('created_at', $log->orig)->count() }}
	   				</td>
	   				<td>
	   					{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }}
	   				</td>
	   				<td>
	   					{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('created_at', $log->orig)->count() }}
	   				</td>
	   				<td>
	   				{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}
	   				</td>
	   			</tr>
	   			@php $i++; @endphp
	   			@empty
	   				<tr>
	   					@if (isset($_GET['expired']) && @$search == null)
	   							<td colspan="6" class="text-center">{{ "No Expired Medicine!" }}</td>
	   						@else
	   							<td colspan="6" class="text-center">{{ "No registered Medicine yet!" }}</td>
	   					@endif
	   				</tr>
	   		@endforelse
	   	</tbody>
	@php } @endphp
	</table>
</div>
<br/>
<div id="medCount">
	<p style="font-family: arial; font-size: 10px; color: #212529; float: left; margin-top: 10px;">Total of Medicines: <span class="font-weight-bold">{{ @$i }}</span></p>
	@if (Auth::user()->employee != null)
		<p style="font-family: arial; font-size: 10px; color: #212529; float: right; margin-top: 30px;">Printed by: <span>{{ Auth::user()->employee->first_name }} {{ Auth::user()->employee->last_name }} {{ Auth::user()->employee->middle_name }}</span></p>
	@endif
</div>
</body>

</script>
</html>