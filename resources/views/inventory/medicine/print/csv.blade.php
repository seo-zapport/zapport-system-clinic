{{'Medicines Inventory'}}
@if($typecsv == "viewlogs")
	{{'Brand Name: '.ucwords($medbrand)}}
	{{'Generic Name: '.ucwords($generic)}}
	{{'Input Date,Date Expire,Remaining Quantity,No. of deducted Medicines,No. of Medicines,Input by'}}	 
		@forelse ($medicine as $log)
		{{ Carbon\carbon::parse($log->formatted_at)->format('m/d/Y') }},{{ Carbon\carbon::parse($log->expiration_date)->format('m/d/Y') }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 0)->where('created_at', $log->orig)->count() }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('created_at', $log->orig)->count() }},{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}
			@empty
				{{ "No registered Medicine yet!" }}
		@endforelse
@elseif($typecsv == "logsinput")
	{{'Brand Name: '.ucwords($medbrand)}}
	{{'Generic Name: '.ucwords($generic)}}
	{{'Date Taken,Name,No. of Medicines,Given By'}}
	@forelse (@$medicine['meds'] as $med)
	{{ $med->Distinct_date->format('m/d/Y - h:i a') }},{{ $med->last_name }} {{ $med->first_name }},{{ $medicine['countMeds']->where('empMeds_id', $med->empMeds_id)->where('patient', $med->patient)->where('distinct_user_id', $med->distinct_user_id)->where('Distinct_date', $med->Distinct_date)->count() }} ,{{ $med->givenLname }} {{ $med->givenFname }}
	@empty
	{{"No Records Yet!"}}
	@endforelse
@else
	@if(app('request')->input('search') != "")  {{ "Filter by: ".app('request')->input('search') }} @endif
	,
	{{'Generic Name,Brand Name,Remaining Quantity'}}
	@if ($medicine != null)
	@forelse ($medicine as $med)
		{{ ucfirst($med->generic->gname) }},{{ ucwords($med->medBrand->bname) }},{{ $med->where('generic_id', $med->generic_id)->where('brand_id', $med->brand_id)->where('availability', 0)->where('expiration_date', '>', NOW())->count() }}
		@empty
			{{ "No registered Medicine yet!" }}
	@endforelse	
	@else
		 {{"No Record Found!"}}
	@endif

@endif 
