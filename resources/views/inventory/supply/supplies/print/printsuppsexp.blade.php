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
<h3>Medical Supplies Inventory</h3>
@if(app('request')->input('search') != "")
<h3>Search by: <strong class="zp-color-6b">{{ app('request')->input('search') }}</strong></h3>
@endif
@if(@$typeprint == "viewlogs" || @$typeprint == "logsinput")
	@if(@$suppbrand != '')
		<h3>Brand Name: <strong class="zp-color-6b">{{$suppbrand}}</strong></h3>
	@endif
	@if($supps != '')
		<h3>Supply Name: <strong class="zp-color-6b">{{$supps}}</strong></h3>
	@endif
@endif

<div class="table-responsive">
	<table id="medTable" class="table table-hover">
		 @php 
		 	$i = 0;
		 @endphp
			 <thead class="thead-dark">
			 	<th>Input by</th>
			 	<th>Input Date</th>
			 	<th>Date Expire</th>
			 	<th>Remaining Quantity</th>
			 	<th>No. of deducted Supply</th>
			 	<th>No. of Supply</th>
			 </thead>
			 <tbody>
			 	@forelse($expired as $supply)
			 		<tr class="{{ ($supply->expiration_date != NULL && $supply->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
			 			<td>
			 				{{ ucwords($supply->user->employee->first_name) }}
			 				<div class="row-actions">
			 					<a href="{{ route('supply.showLogs', ['supgen' => $supply->supgen->slug, 'supbrand' => $supply->supbrand->slug, 'created' => $supply->created_at]) }}" class="show-edit btn btn-link {{ ($supply->expiration_date != NULL && $supply->expiration_date <= NOW()) ? 'bg-danger text-white' : 'text-secondary' }}">
			 						<i class="far fa-eye"></i>View
			 					</a>
			 				</div>
			 			</td>
			 			<td>{{ Carbon\carbon::parse($supply->created_at)->format('M d, Y - h:i:sa') }}</td>
			 			<td class="{{ ($supply->expiration_date == NULL) ? 'text-muted' : '' }}">
			 				{{ ($supply->expiration_date != NULL) ? Carbon\carbon::parse($supply->expiration_date)->format('M d, Y - h:i:sa') : 'NULL' }}
			 			</td>
			 			<td>
			 				{{ 
			 					$supply->where('user_id', $supply->user_id)
			 						   ->where('supbrand_id', $supply->supbrand_id)
			 						   ->where('supgen_id', $supply->supgen_id)
			 						   ->where('availability', 0)
			 						   ->where('created_at', $supply->created_at)
			 						   ->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)
			 						   ->count()
			 				}}
			 			</td>
			 			<td>
			 				{{ 
			 					$supply->where('user_id', $supply->user_id)
			 						   ->where('supbrand_id', $supply->supbrand_id)
			 						   ->where('supgen_id', $supply->supgen_id)
			 						   ->where('availability', 1)
			 						   ->where('created_at', $supply->created_at)
			 						   ->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)
			 						   ->count()
			 				}}
			 			</td>
			 			<td>
			 				{{ 
			 					$supply->where('user_id', $supply->user_id)
			 						   ->where('supbrand_id', $supply->supbrand_id)
			 						   ->where('supgen_id', $supply->supgen_id)
			 						   ->where('created_at', $supply->created_at)
			 						   ->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)
			 						   ->count()
			 				}}
			 			</td>
			 		</tr>
			 	@empty
			 		<tr>
			 			<td colspan="6" class="text-center">0 Result Found!</td>
			 		</tr>
			 	@endforelse
			 </tbody>			
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