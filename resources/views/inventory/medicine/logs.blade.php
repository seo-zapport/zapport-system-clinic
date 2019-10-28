@extends('layouts.app')
@section('title', '| Medicines | '.ucwords($generic->gname) . " | " . ucwords($medbrand->bname))
@section('medicine', 'active')
{{-- @section('dash-title', ucwords($generic->gname)) --}}
@section('heading-title')
	<i class="fas fa-pills text-secondary"></i> {{ ucwords($generic->gname) }}
@endsection
@section('dash-content')
@section('back')
<a href="{{ route('medicine') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection
<div class="mb-4">
	<h1 class="zp-text">Brand Name: <strong class="zp-color-6b">{{ ucwords($medbrand->bname) }}</strong></h1>
	<h3 class="zp-text zp-text-16">Generic Name: {{ ucwords($generic->gname) }}</h3>
</div>
<form method="get">
	<div class="form-row">
		<div class="form-group col-md-4 mb-0">
			<select name="search" id="search" class="form-control">
				<option selected disabled='true'>Filter Date</option>
				@if (isset($_GET['expired']) && @$search == null)
					@forelse ($logs as $log2)
						<option {{ (@$search == $log2->formatted_at) ? 'selected' : '' }} value="{{ $log2->formatted_at }}">{{ Carbon\carbon::parse($log2->formatted_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@elseif (!empty(@$search) && isset($_GET['expired']))
					@forelse ($logsearch as $log2)
						<option {{ (@$search == $log2->formatted_at) ? 'selected' : '' }} value="{{ $log2->formatted_at }}">{{ Carbon\carbon::parse($log2->formatted_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@else
					@forelse ($loglist->unique('formatted_at') as $log2)
						<option {{ (@$search == $log2->formatted_at) ? 'selected' : '' }} value="{{ $log2->formatted_at }}">{{ Carbon\carbon::parse($log2->formatted_at)->format('M d, Y') }}</option>
						@empty
							<option>No Records!</option>
					@endforelse
				@endif
			</select>
		</div>
		<div class="form-group col-md-2 d-inline-flex mb-0">
			<button type="submit" class="btn btn-success mr-2">Search</button>
			<a href="{{ route('medicine.log', ['medbrand' => $medbrand->bname, 'generic' => $generic->gname]) }}" class="btn btn-info text-white">Clear</a>
		</div>
		<div class="form-check col-12 col-md-4 mb-0">
			<input type="checkbox" class="form-check-input" {{ (isset($_GET['expired'])) ? 'checked' : '' }} id="exampleCheck1" name="expired" onclick="this.form.submit()">
			<label class="form-check-label" for="exampleCheck1">Filter Expired Medicines</label>
		</div>		

		<div class="form-check col-12 col-md-2 mb-0">
			<div class="text-right">
				<!--- PRINT --->

				<button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">PRINT <span class="caret"></span>
				</button>
				@php 
					$fileName = 'inventory_medicine';
				@endphp
				<ul class="dropdown-menu">

					<li class="nav-item-btn"><a href="#" onclick="clicked()"><i class="fas fa-print text-secondary"></i>PRINT</a></li>
					<li class="nav-item-btn"><a href="{{ asset('storage/uploaded/print/'.@$fileName.'.csv')}}" download="{{ @$fileName.'.csv'}}" target="_blank"><i class="fas fa-file-csv text-secondary"></i>CSV</a></li>
				</ul>
			</div>
		</div>
	</div>

</form>
<br>
<div class="card">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead class="thead-dark">
					<th>No.</th>
					<th>Input Date</th>
					<th>Date Expire</th>
					<th>Remaining Quantity</th>
					<th>No. of deducted Meds</th>
					<th>No. of Medicines</th>
					<th>Input by</th>
					<th>Action</th>
				</thead>
				<tbody>
					@php
						$i = 1;
					@endphp
					@forelse ($logs as $log)
						<tr>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							{{ $i }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							{{ Carbon\carbon::parse($log->formatted_at)->format('M d, Y') }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							{{ Carbon\carbon::parse($log->expiration_date)->format('M d, Y') }}</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 0)->where('created_at', $log->orig)->count() }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
								{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('availability', 1)->count() }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
								{{ $log->where('brand_id', $log->brand_id)->where('generic_id', $log->generic_id)->where('expiration_date', $log->expiration_date)->where('created_at', $log->orig)->count() }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							{{ ucwords($log->user->employee->last_name) }} {{ ucwords($log->user->employee->first_name) }}
							</td>
							<td class="{{ ($log->expiration_date <= NOW()) ? 'bg-danger text-white' : '' }}">
							<a href="{{ route('medicine.show', ['medbrand' => $log->bname, 'generic' => $log->gname, 'inputDate' => $log->orig, 'expDate' => 
							$log->expiration_date]) }}" class="show-edit btn btn-link text-secondary"><i class="far fa-eye"></i>View</a>
							</td>
						</tr>
					@php
						$i++;
					@endphp
						@empty
							<tr>
								@if (isset($_GET['expired']) && @$search == null)
									<td colspan="8" class="text-center">{{ "No Expired Medicine!" }}</td>
									@else
										<td colspan="8" class="text-center">{{ "No registered Medicine yet!" }}</td>
								@endif
							</tr>
					@endforelse
				</tbody>
			</table>			
		</div>
	</div>
</div>

{{ $logs->links() }}

<div id="printable" class="d-none">
	{!! @$printtable !!}
	<br/>
<div id="medCount"></div>
</div>

<script type="application/javascript">

	function clicked(){
	
		var iframe = document.getElementById('printable');
		var htmlToPrint = '' +
			'<style type="text/css">' +
			'table {'+
			'border-collapse: collapse;'+ 
			'border-spacing: 0;'+ 
			'width: 100%;'+ 
			'border-bottom: 1px solid #dee2e6;'+ 
			'border-top: 1px solid #dee2e6;'+
			'};'+
			'th{'+
			'padding: 8px;'+ 
			'border-bottom: 1px solid #dee2e6;'+ 
			'text-align: left;'+ 
			'font-size: 13px;'+ 
			'font-family: arial; color: #212529;'+
			'}'+
			'tbody tr td{'+
			'text-align: left;'+ 
			'padding: 8px;'+ 
			'border-top: 1px solid #dee2e6;'+
			'border-bottom: 1px solid #dee2e6;'+ 
			'font-family: arial;'+ 
			'font-size: 10px;'+ 
			'color: #212529;'+ 
			'}'+
			'tr td:last-child {'+
			'width: 20%;'+
			'text-align: center;'+ 
			'}'+
			'</style>';
		var WinPrint = window.open('', '', 'left=0,top=0,width=1600,height=1800,toolbar=0,scrollbars=0,status=0');
			WinPrint.document.write(htmlToPrint);
			WinPrint.document.write(iframe.innerHTML);
			WinPrint.document.close();
			WinPrint.focus();
			WinPrint.print();
			WinPrint.close();
	}

	          
	jQuery(document).ready(function($){
		//$('a.printPagebtn').printPage();
	});

</script>

@endsection