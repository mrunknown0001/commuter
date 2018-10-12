@extends('layouts.admin-layout')

@section('title') Driver Report Details @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Report Details
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-flag"></i> Home</a></li>
        <li class="active">Report</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

 
    <div class="row">
      <div class="col-md-12">
        <p><a href="{{ route('admin.drivers.reports') }}">Back to Driver Reports</a></p>
        <p>Ride Number: <strong><a href="{{ route('admin.ride.details', ['id' => $report->ride->id, 'ride_number' => $report->ride->ride_number]) }}">{{ strtoupper($report->ride->ride_number) }}</a></strong></p>
        <p>Complainant: <strong><a href="{{ route('admin.view.driver.details', ['id' => $report->complainant->id]) }}">{{ ucwords($report->complainant->first_name . ' ' . $report->complainant->last_name) }}</a></strong></p>
        <p>Reported Commuter: <strong><a href="{{ route('admin.view.commuter.details', ['id' => $report->reported->id]) }}"> {{ ucwords($report->reported->first_name . ' ' . $report->reported->last_name) }}</a></strong></p>

        <p><button class="btn btn-success" onclick="openWin()"><i class="fa fa-print"></i></button></p>

        <div class="box box-danger">
          <div class="box-header with-border">
            <strong>Content</strong>
          </div>
          <div class="box-body">
            <p>{{ $report->content }}</p>
          </div>
          <div class="box-footer">
            <small>Content</small>
          </div>
        </div>
      </div>
    </div


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->

  <input type="hidden" name="rideNumber" id="rideNumber" value="{{ strtoupper($report->ride->ride_number) }}">
  <input type="hidden" name="complainant" id="complainant" value="{{ ucwords($report->complainant->first_name . ' ' . $report->complainant->last_name) }}">
  <input type="hidden" name="commuter" id="commuter" value="{{ ucwords($report->reported->first_name . ' ' . $report->reported->last_name) }}">
  <input type="hidden" name="date" id="date" value="{{ date('l, F j, Y g:i:s a', strtotime($report->ride->created_at)) }}">
  <input type="hidden" name="content" id="content" value="{{ $report->content }}">

<script type="text/javascript">
  function openWin()
  {
    var rideNumber = document.getElementById('rideNumber').value;
    var complainant = document.getElementById('complainant').value;
    var commuter = document.getElementById('commuter').value;
    var dateTime = document.getElementById('date').value;
    var content = document.getElementById('content').value;

    var myWindow=window.open('','','width=800,height=900');
    myWindow.document.write("<html>");
    myWindow.document.write("<head>");
    myWindow.document.write("</head>");
    myWindow.document.write("<body>");
    myWindow.document.write("<h2>Driver Report</h2>");
    myWindow.document.write("<p>Ride Number: ");
    myWindow.document.write(rideNumber);
    myWindow.document.write("</p>");
    myWindow.document.write("<p>Complainant: ");
    myWindow.document.write(complainant);
    myWindow.document.write("</p>");
    myWindow.document.write("<p>Reported Commuter: ");
    myWindow.document.write(commuter);
    myWindow.document.write("</p>");
    myWindow.document.write("<p>Date: ");
    myWindow.document.write(dateTime);
    myWindow.document.write("</p>");
    myWindow.document.write("<p>Report Content:</p>");
    myWindow.document.write("<p>");
    myWindow.document.write(content);
    myWindow.document.write("</p>");
    myWindow.document.write("</body>");
    myWindow.document.write("</html>");
    myWindow.document.close();
    myWindow.focus();
    myWindow.print();
    myWindow.close();
    
  }
</script>
@endsection