@extends('layouts.app')
@section('content')
<div class="container m-t-70 m-b-70">
	<div class="row">
		<div class="col-md-12">
			<table id="members">
				<tr>
					<th>No.</th>
					<th>Name</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Message</th>
				</tr>
				@foreach($getQuery as $key => $query)
				<tr>
					<td>{{$key +1}}</td>
					<td>{{$query->name}}</td>
					<td>{{$query->phone}}</td>
					<td>{{$query->email}}</td>
					<td>{{$query->message}}</td>
				</tr>
				@endforeach
			</table>
			{!! $getQuery->links() !!}
		</div>
	</div>
</div>
@endsection