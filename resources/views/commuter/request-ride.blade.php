@extends('layouts.app')

@section('title') Request Ride @endsection

@section('content')
	
@include('commuter.includes.navbar2')

<div class="container-fluid">
		
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<strong>Request Ride Form</strong>
				</div>
				<div class="panel-body">
	                <form class="form-horizontal" method="POST" action="{{ route('commuter.request.ride.post') }}" autocomplete="off">
	                    {{ csrf_field() }}

						<input type="hidden" name="commuter" value="{{ Auth::user()->id }}">
						
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
							<label for="type" class="col-md-3 control-label">Select Type</label>
							<div class="col-md-9">
								<select name="type" id="type" class="form-control" required>
									<option value="1">Solo</option>
									<option value="2">Mix</option>
									<option value="3">Group</option>
								</select>								
							</div>

						</div>

	                    <div class="form-group">
	                        <label for="passenger1_name" class="col-md-3 control-label">Passenger 1 Name &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger1_name" type="text" class="form-control" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" required disabled>
								
								<input type="hidden" name="passenger1_name" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">

	                            @if ($errors->has('passenger1_name'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger1_name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="passenger1_id" class="col-md-3 control-label">Passenger 1 ID &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger1_id" type="text" class="form-control" value="{{ Auth::user()->student_number }}" required disabled>
								
								<input type="hidden" name="passenger1_id" value="{{ Auth::user()->id }}">

	                            @if ($errors->has('passenger1_id'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger1_id') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="passenger2_name" class="col-md-3 control-label">Passenger 2 Name &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger2_name" type="text" class="form-control" name="passenger2_name" value="">

	                            @if ($errors->has('passenger2_name'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger2_name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>	


	                    <div class="form-group">
	                        <label for="passenger2_id" class="col-md-3 control-label">Passenger 2 ID &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger2_id" type="text" class="form-control" name="passenger2_id" value="">

	                            @if ($errors->has('passenger2_id'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger2_id') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="passenger3_name" class="col-md-3 control-label">Passenger 3 Name &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger3_name" type="text" class="form-control" name="passenger3_name" >

	                            @if ($errors->has('passenger3_name'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger3_name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>


	                    <div class="form-group">
	                        <label for="passenger3_id" class="col-md-3 control-label">Passenger 3 ID &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger3_id" type="text" class="form-control" name="passenger3_id" >

	                            @if ($errors->has('passenger3_id'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger3_id') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>

	                    <div class="form-group">
	                        <label for="passenger4_name" class="col-md-3 control-label">Passenger 4 Name &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger4_name" type="text" class="form-control" name="passenger4_name" >

	                            @if ($errors->has('passenger4_name'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger4_name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>


	                    <div class="form-group">
	                        <label for="passenger4_id" class="col-md-3 control-label">Passenger 4 ID &nbsp;</label>

	                        <div class="col-md-9">
	                            <input id="passenger4_id" type="text" class="form-control" name="passenger4_id" >

	                            @if ($errors->has('passenger4_id'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('passenger4_id') }}</strong>
	                                </span>
	                            @endif
	                        </div>
	                    </div>


	                    <div class="form-group">
	                        <div class="col-md-6 col-md-offset-3">
	                            <button type="submit" class="btn btn-primary">
	                                Finalized &amp; Submit Request
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