@extends('layouts.admin-layout')

@section('title') Activity Log @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Activity Log
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-history"></i> Home</a></li>
        <li class="active">Activity Log</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>User</th>
              <th>Action</th>
              <th>Time &amp; Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($logs as $log)
            <tr>
              <td>
              @if($log->admin_id != null)
                {{ ucwords($log->admin->first_name) }}
                {{ ucwords($log->admin->last_name) }}
              @else
                {{ ucwords($log->user->first_name) }}
                {{ ucwords($log->user->last_name) }}
                @if($log->user->user_type == 1)
                  :Commuter
                @else
                  :Driver
                @endif
              @endif
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
            <div class="text-center"> {{ $logs->links() }}</div>
      </div>
    </div>


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection