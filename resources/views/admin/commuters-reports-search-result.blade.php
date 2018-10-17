@extends('layouts.admin-layout')

@section('title') Commuters Reports Search Result @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuters Reports Search Result: {{ $keyword }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-flag"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-6">
          <form action="{{ route('admin.search.commuter.report') }}" method="get" role="form" autocomplete="off">
            <div class="input-group">
              <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search User">
              <span class="input-group-btn">
                    <button type="submit" id="search-btn" class="btn btn-success"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
          @if(count($users) > 0)
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
                @foreach($users as $user)
                  @if(count($user->report) > 0 && $user->user_type == 1)
                    @foreach($user->report as $r)
                    <tr>
                      <td>
                        {{ strtoupper($r->report_number) }}
                      </td>
                      <td>
                        <a href="{{ route('admin.view.commuter.details', ['id' => $r->complainant->id]) }}">{{ ucwords($r->complainant->first_name . ' ' . $r->complainant->last_name) }}</a>
                      </td>
                      <td>
                        {{ date('l, F j, Y g:i:s a', strtotime($r->created_at)) }}
                      </td>
                      <td>
                        @if($r->viewed == 0)
                        <span class="badge bg-red">Unread</span>
                        @else
                        <span class="badge bg-blue">Viewed</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('admin.commuter.report.view', ['id' => $r->id, 'report_number' => $r->report_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
                        </td>
                      </tr>
                    @endforeach
                  @endif
                @endforeach
              </tbody>
            </table>
              <div class="text-center"> {{ $users->links() }}</div>
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