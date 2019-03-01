@extends('layouts.admin-layout')

@section('title') Statistics @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Statistics
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bar-chart"></i> Home</a></li>
        <li class="active">Statistics</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">

        <canvas id="myChart" width="400" height="400"></canvas>



      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
<script>
  const monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  var d = new Date();

  var x = new Date();
  x.setDate(1);
  x.setMonth(x.getMonth()-1);

  var y = new Date();
  y.setDate(1);
  y.setMonth(y.getMonth()-2);


  var ctx = document.getElementById("myChart").getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: [monthNames[y.getMonth()], monthNames[x.getMonth()], monthNames[d.getMonth()],],
          datasets: [{
              label: 'Monthly Usage',
              data: [{{ $previous_two_month }}, {{ $previous_month }}, {{ $current }}],
              backgroundColor: [
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
              ],
              borderColor: [
                  'rgba(75, 192, 192, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(75, 192, 192, 1)',
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
  });
</script>
@endsection