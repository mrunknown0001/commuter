@extends('layouts.app')

@section('title') Request Ride @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong>Request Ride Form</strong>
				</div>
				<div class="panel-body">
	                <form class="form-horizontal" method="POST" action="{{ route('commuter.request.ride.post') }}" autocomplete="off">
	                    {{ csrf_field() }}


	                    <div class="form-group">
	                        <label for="pickup" class="col-md-3 control-label">From</label>

	                        <div class="col-md-9">

	                            <select id="pickup" name="pickup" class="form-control" required>
	                            	<option value="">Select Pickup Location</option>
	                            	@foreach($locations as $loc)
									<option value="{{ $loc->id }}">{{ ucwords($loc->name) }}</option>
	                            	@endforeach
	                            </select>

	                            @if ($errors->has('pickup'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('pickup') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="dropoff" class="col-md-3 control-label">To &nbsp;</label>

	                        <div class="col-md-9">
	                            <select id="dropoff-name" class="form-control" disabled>
	                            	<option value="">Drop Off Location</option>
	                            	@foreach($locations as $loc)
									<option value="{{ $loc->id }}">{{ ucwords($loc->name) }}</option>
	                            	@endforeach
	                            </select>


	                            <input id="dropoff" type="hidden" name="dropoff">
								
	                            @if ($errors->has('dropoff'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('dropoff') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="passenger1" class="col-md-3 control-label">Passenger 1 &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger1" type="text" class="form-control" value="{{ Auth::user()->identification }}" required disabled>
								
								<input type="hidden" name="passenger1" value="{{ Auth::user()->identification }}">

	                            @if ($errors->has('passenger1'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger1') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="passenger2" class="col-md-3 control-label">Passenger 2 &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger2" type="text" class="form-control" name="passenger2" value="">

	                            @if ($errors->has('passenger2'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger2') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>


	                    <div class="form-group">
	                        <label for="passenger3" class="col-md-3 control-label">Passenger 3 &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger3" type="text" class="form-control" name="passenger3" >

	                            @if ($errors->has('passenger3'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger3') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>


	                    <div class="form-group">
	                        <label for="passenger4" class="col-md-3 control-label">Passenger 4 &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger4" type="text" class="form-control" name="passenger4" >

	                            @if ($errors->has('passenger4'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger4') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>


	                    <div class="form-group">
	                        <div class="col-md-6 col-md-offset-3">
	                            <button type="submit" class="btn btn-primary">
	                                Finish &amp; Submit Request
	                            </button>
	                        </div>
	                    </div>
	                </form>
				</div>
			</div>
		</div>
	</div>
	

</div>
<script>
$(document).ready(function(){
    $('#pickup').change(function () {
    	if($('#pickup').val() == 1) { 
	    	$('#dropoff').val(2);
	    	$('#dropoff-name').val(2);
	    }
	    else {
	    	$('#dropoff').val(1);
	    	$('#dropoff-name').val(1);
	    }
    });

    // check the amount of fare
    // $('#passenger2').focusout(function () {
    // 	if($('#passenger2').val().length > 0 && $('#passenger3').val().length < 1 && $('#passenger4').val().length < 1) {
    // 		alert('15 pesos each')
    // 	}
    // 	else if($('#passenger2').val().length > 0 && $('#passenger3').val().length > 0 && $('#passenger4').val().length < 1) {
    // 		alert('10 pesos each')
    // 	}
    // 	else if($('#passenger2').val().length > 0 && $('#passenger3').val().length > 0 && $('#passenger4').val().length > 0) {
    // 		alert('10 pesos each')
    // 	}

    // });


});
</script>
@endsection