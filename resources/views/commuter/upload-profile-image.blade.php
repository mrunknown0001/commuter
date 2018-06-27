@extends('layouts.app')

@section('title') Profile Image Upload @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<!-- <h3 class="text-center">My Profile</h3> -->
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@include('includes.all')
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong><i class="fa fa-user"></i> Profile Image Upload</strong>
				</div>
				<div class="panel-body">
					<form action="{{ route('commuter.profile.image.upload.post') }}" method="POST" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-primary">Upload Image</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection