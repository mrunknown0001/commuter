@extends('layouts.app')

@section('title') Active Ride Request @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">

	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@include('includes.all')

			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Active Ride Request</h3>
					<div class="box-tools pull-right">
						<!-- <span class="label label-primary">Label</span> -->
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<p>Time of Request: {{ date('h:i:s a', strtotime($active_ride->created_at)) }}</p>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<small>Ride Request</small>
				</div>
				<!-- box-footer -->
			</div>
			<!-- /.box -->
		</div>
	</div>
	

</div>
@endsection