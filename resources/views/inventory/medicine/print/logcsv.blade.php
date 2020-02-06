{{'Medicines Inventory'}}
{{'Brand Name: '}}{{ucwords($medbrand)}}
{{'Generic Name: '}}{{ucwords($generic)}}
{{'Input Date,Date Expire,Remaining Quantity,No. of deducted Medicines,No. of Medicines,Input by'}}	 
@forelse ($availmeds as $log)
	{{ Carbon\carbon::parse($log->formatted_at)->format('m/d/Y') }},{{ Carbon\carbon::parse($log->expiration_date)->format('m/d/Y') }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 0)->where('created_at', $log->orig)->count() }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }},{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('created_at', $log->orig)->count() }},{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}
	@empty
		{{ "No registered Medicine yet!" }}
@endforelse