{{'Medicines Inventory'}}
@if($typecsv == "logs")
	{{'Brand Name: '}}{{ucwords($medbrand)}}
	{{'Generic Name: '}}{{ucwords($generic)}}
		{{'Input Date,Date Expire,Remaining Quantity,No. of deducted Medicines,No. of Medicines,Input by'}}	 
		@foreach($medicine as $log)
		{{ Carbon\carbon::parse($log->formatted_at)->format('m/d/yy') }},{{ Carbon\carbon::parse($log->expiration_date)->format('m/d/yy') }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 0)->where('created_at', $log->orig)->count() }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('created_at', $log->orig)->count() }},{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}
		@endforeach
@elseif($typecsv == "logsinput")
	{{'Brand Name: '}}{{ucwords($medbrand)}}
	{{'Generic Name: '}}{{ucwords($generic)}}
		{{'Date Taken,Name,No. of Medicines,Given By'}}
	@foreach ($medicine['meds'] as $med)
		{{ $med->Distinct_date->format('m/d/yy - h:i a') }},{{ $med->last_name }} {{ $med->first_name }},{{ $medicine['countMeds']->where('empMeds_id', $med->empMeds_id)->where('patient', $med->patient)->where('distinct_user_id', $med->distinct_user_id)->where('Distinct_date', $med->Distinct_date)->count() }} ,{{ $med->givenLname }} {{ $med->givenFname }}
	@endforeach
@else
	{{'List Medicines'}}
	{{'Generic Name,Brand Name,Remaining Quantity'}}	
	@foreach($medicine as $med)
	{{ ucfirst($med->generic->gname) }},{{ ucwords($med->medBrand->bname) }},{{ $med->where('generic_id', $med->generic_id)->where('brand_id', $med->brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}
	@endforeach
@endif 
