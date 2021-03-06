@extends('layouts.admin-layout')

@section('title') Drivers @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Driver
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Home</a></li>
        <li class="active">Driver</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          @include('includes.all')

          <form action="{{ route('admin.update.driver.post') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="driver_id" value="{{ $driver->id }}">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="first_name" id="first_name" value="{{ $driver->first_name }}" class="form-control" placeholder="Enter Firstname" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" name="last_name" id="last_name" value="{{ $driver->last_name }}" class="form-control" placeholder="Enter Lastname" required="">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" name="username" id="username" value="{{ $driver->username }}" class="form-control" placeholder="Enter Username" required >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Mobile Number</label>
                  <input type="text" name="mobile_number" id="mobile_number" value="{{ $driver->mobile_number }}" class="form-control" placeholder="Enter Mobile Number" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Operator</label>
                  <input type="text" name="operator" id="operator" value="{{ $driver->driver_info->operator_name }}" class="form-control" placeholder="Enter Operator Name" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Body Number</label>
                  <input type="text" name="body_number" id="body_number" value="{{ $driver->driver_info->body_number }}" class="form-control" placeholder="Enter Body Number of Vehicle" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Plate Number</label>
                  <input type="text" name="plate_number" id="plate_number" value="{{ $driver->driver_info->plate_number }}" class="form-control" placeholder="Enter Plate Number" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>License</label>
                  <input type="text" name="license_number" id="license_number" value="{{ $driver->driver_info->license }}" class="form-control" placeholder="Enter License Number" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Save Driver Info</button>
                </div>
              </div>
            </div>
            

          </form>
<!--           <video id="video" width="400" height="400" autoplay></video>
          <button id="snap">Snap Photo</button>
          <canvas id="canvas" width="400" height="400"></canvas> -->

        </div>
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
<script>
  // Grab elements, create settings, etc.
  var video = document.getElementById('video');

  // Get access to the camera!
  if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
      // Not adding `{ audio: true }` since we only want video now
      navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
          video.src = window.URL.createObjectURL(stream);
          video.play();
      });
  }

  /* Legacy code below: getUserMedia 
  else if(navigator.getUserMedia) { // Standard
      navigator.getUserMedia({ video: true }, function(stream) {
          video.src = stream;
          video.play();
      }, errBack);
  } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
      navigator.webkitGetUserMedia({ video: true }, function(stream){
          video.src = window.webkitURL.createObjectURL(stream);
          video.play();
      }, errBack);
  } else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
      navigator.mozGetUserMedia({ video: true }, function(stream){
          video.src = window.URL.createObjectURL(stream);
          video.play();
      }, errBack);
  }
  */


  // Elements for taking the snapshot
  var canvas = document.getElementById('canvas');
  var context = canvas.getContext('2d');
  var video = document.getElementById('video');

  // Trigger photo take
  document.getElementById("snap").addEventListener("click", function() {
    context.drawImage(video, 0, 0, 400, 400);

  });
</script>
@endsection