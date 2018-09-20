@extends('layouts.admin-layout')

@section('title') Locations @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Location
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-map-marker"></i> Home</a></li>
        <li class="active">Locations</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
          @include('includes.all')
      <div class="row">
        <div class="col-md-6">
          
          <form action="{{ route('admin.update.location.post') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="location_id" value="{{ $location->id }}">
            <div class="form-group">
              <label for="location">Enter Location Name</label>
              <input type="text" name="location" id="location" class="form-control" value="{{ $location->name }}" placeholder="Enter Location Name" required="">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-success">Update Location</button>
            </div>
          </form>

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