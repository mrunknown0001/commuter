@extends('layouts.admin-layout')

@section('title') Admins @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Admin (Guard)
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> Home</a></li>
        <li class="active">Admin</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          @include('includes.all')

          <form action="{{ route('admin.update.admin.post') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" name="admin_id" value="{{ $admin->id }}">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Firstname</label>
                  <input type="text" name="first_name" id="first_name" value="{{ $admin->first_name }}" class="form-control" placeholder="Enter Firstname" >
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Lastname</label>
                  <input type="text" name="last_name" id="last_name" value="{{ $admin->last_name }}" class="form-control" placeholder="Enter Lastname">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <label>Username</label>
                <input type="text" name="username" id="username" value="{{ $admin->identification }}" class="form-control" placeholder="Enter Username" readonly="">
              </div>
              <div class="col-md-4">
                <label>Mobile Number</label>
                <input type="text" name="mobile_number" id="mobile_number" value="{{ $admin->mobile_number }}" class="form-control" placeholder="Enter Mobile Number">
              </div>
            </div>
            <p></p>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save Admin Details</button>
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