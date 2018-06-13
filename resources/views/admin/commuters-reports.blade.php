@extends('layouts.admin-layout')

@section('title') Commuters Reports @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuters Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-flag"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        @if(count($reports) > 0)
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Report Number</th>
              <th>Commuter</th>
              <th>Time &amp; Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reports as $report)
            <tr>
              <td>
                {{ strtoupper($report->report_number) }}
              </td>
              <td>
                <a href="{{ route('admin.view.commuter.details', ['id' => $report->complainant->id]) }}">{{ ucwords($report->complainant->first_name . ' ' . $report->complainant->last_name) }}</a>
              </td>
              <td>
                {{ date('l, F j, Y g:i:s a', strtotime($report->created_at)) }}
              </td>
              <td>
                @if($report->viewed == 0)
                <span class="badge bg-red">Unread</span>
                @else
                <span class="badge bg-blue">Viewed</span>
                @endif
              </td>
              <td>
                <a href="{{ route('admin.commuter.report.view', ['id' => $report->id, 'report_number' => $report->report_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>


        {{--<p class="text-center"><strong>{{ $reports->count() + $reports->perPage() * ($reports->currentPage() - 1) }} of {{ $reports->total() }} records</strong></p>--}}

            <!-- Page Number render() -->
            <div class="text-center"> {{ $reports->links() }}</div>
        @else
        <p class="text-center"><em>No Commuter Report</em></p>
        @endif
      </div>
    </div>

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection