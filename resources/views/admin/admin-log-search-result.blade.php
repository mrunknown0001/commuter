@extends('layouts.admin-layout')

@section('title') Admin Log Search Result @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin Log Search Result: {{ $keyword }}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-history"></i> Home</a></li>
        <li class="active">Admin Log</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

        <div class="row">
          <div class="col-md-5">
              <form action="{{ route('admin.search.admin.logs') }}" method="get" role="form" autocomplete="off">
                <div class="input-group">
                  <input type="text" name="keyword" class="form-control" placeholder="Search Admin" required>
                  <span class="input-group-btn">
                        <button type="submit" id="search-btn" class="btn btn-success"><i class="fa fa-search"></i>
                        </button>
                      </span>
                </div>
              </form>
          </div>
          <div class="col-md-3">
            <a href="#" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> Print Activity</a>
          </div>
        </div>

    <div class="row">
      <div class="col-md-12">
        @if(count($admins) > 0)
        <table class="table table-hover">
          <thead>
            <tr>
              <th>User</th>
              <th>Action</th>
              <th>Time &amp; Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $log)
            <tr>
              <td>
                {{ ucwords($log->first_name) }}
                {{ ucwords($log->last_name) }}
              </td>
              <td>
                {{ $log->action_performed }}
              </td>
              <td>
                {{ date('l, F j, Y g:i:s a', strtotime($log->performed_on)) }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>


        {{--<p class="text-center"><strong>{{ $logs->count() + $logs->perPage() * ($logs->currentPage() - 1) }} of {{ $logs->total() }} records</strong></p>--}}

            <!-- Page Number render() -->
            <div class="text-center"> {{ $admins->links() }}</div>
        @else
        <p class="text-center"><em>No Admin Logs in search result {{ $keyword }}</em></p>
        @endif
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection