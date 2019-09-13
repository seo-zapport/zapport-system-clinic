@extends('layouts.app')
@section('title', '| Roles')
@section('roles', 'active')
@section('dash-title', ucwords($role->role).' role')
@section('dash-content')
@section('back')
<a href="{{ route('dashboard.roles') }}">
	<i class="fas fa-arrow-left"></i>
</a>
@endsection

<table class="table">
	<thead class="thead-dark">
		<th>No.</th>
		<th>User Name</th>
		<th>User Email</th>
	</thead>
	@php
		$i = 1;
	@endphp
	@forelse($role->users as $u)
		<tr>
			<td>{{ $i++ }}</td>
			<td>
				{{ ucwords($u->name) }}
			</td>
			<td>
				{{ $u->email }}
			</td>
		</tr>
	@empty
		<tr>
			<td colspan="3" class="text-center">No Registered User Yet!</td>
		</tr>
	@endforelse

</table>

@endsection