{{'Medicines Inventory'}}
@if(@$suppbrand != '')
	Brand Name: {{ucwords($suppbrand)}}
@endif
@if($supps != '')
	Supply Name: {{ucwords($supps)}}
@endif
@if($typeprint == "viewlogs")
	{{'Input by,Input Date,Date Expire,Remaining Quantity,No. of deducted Supply,No. of Supply'}}
	@forelse($supplies as $supply)
		{{ ucwords($supply->user->employee->first_name) }},{{ Carbon\carbon::parse($supply->created_at)->format('m/d/Y - h:i:sa') }},{{ ($supply->expiration_date != NULL) ? Carbon\carbon::parse($supply->expiration_date)->format('m/d/Y - h:i:sa') : 'NULL' }},{{ $supply->where('user_id', $supply->user_id)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where('availability', 0)->where('created_at', $supply->created_at)->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)->count() }},{{ $supply->where('user_id', $supply->user_id)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where('availability', 1)->where('created_at', $supply->created_at)->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)->count()}},{{ $supply->where('user_id', $supply->user_id)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where('created_at', $supply->created_at)->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)->count() }}
	@empty
		{{'0 Result Found!'}}
	@endforelse
@elseif($typeprint == "logsinput")
		{{'Date Taken,Name,No. of Supply,Given by'}}	
		@forelse($supplies as $row)
			{{ Carbon\carbon::parse($row->date_given)->format('m/d/Y - h:i:sa') }},{{ ucwords($row->requested_Fname) }} {{ ucwords($row->requested_Lname) }},{{ $row->sup_avail }},{{ ucwords($row->givenBy_Fname) }} {{ ucwords($row->givenBy_Lname) }}
		@empty
		{{'0 Result Found!'}}
		@endforelse
@else
	@if(app('request')->input('search') != "")  {{ "Filter by: ".app('request')->input('search') }} @endif
	,
	{{'Supply Name,Supply Brand Name,Remaining Quantity'}}
	@if ($supplies->count() > 0)
	@foreach ($supplies as $supply)
		{{ strtoupper($supply->supgen->name) }},{{ strtoupper($supply->supbrand->name) }},{{$supply->where('availability', 0)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where(function($expdate){$expdate->where('expiration_date', '>', NOW())->orWhereNull('expiration_date');})->count() }}
	@endforeach
	@else
		{{ "No Registered Supplies!" }}
	@endif
@endif 
