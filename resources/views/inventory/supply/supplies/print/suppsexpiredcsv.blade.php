{{'Medicines Inventory'}}
{{'Brand Name: '}}{{ucwords($suppbrand)}}
{{'Supply Name: '}}{{ucwords($supps)}}	
{{'Input by,Input Date,Date Expire,Remaining Quantity,No. of deducted Supply,No. of Supply'}}
	@forelse($expired as $supply)
		{{ ucwords($supply->user->employee->first_name) }},{{ Carbon\carbon::parse($supply->created_at)->format('m/d/Y - h:i:sa') }},{{ ($supply->expiration_date != NULL) ? Carbon\carbon::parse($supply->expiration_date)->format('m/d/Y - h:i:sa') : 'NULL' }},{{ $supply->where('user_id', $supply->user_id)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where('availability', 0)->where('created_at', $supply->created_at)->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)->count() }},{{ $supply->where('user_id', $supply->user_id)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where('availability', 1)->where('created_at', $supply->created_at)->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)->count()}},{{ $supply->where('user_id', $supply->user_id)->where('supbrand_id', $supply->supbrand_id)->where('supgen_id', $supply->supgen_id)->where('created_at', $supply->created_at)->where('expiration_date', ($supply->expiration_date != NULL) ? $supply->expiration_date : NULL)->count() }}
	@empty
		{{'0 Result Found!'}}
	@endforelse