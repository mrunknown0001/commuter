@extends('layouts.admin-layout')

@section('title') View All Admins @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View All Admins (Guard)
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Admins</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
        <div class="col-md-12">
          @if(count($admins) > 0)
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th class="text-center">ID</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($admins as $admin)
              <tr>
                <td>
                  {{ strtoupper($admin->last_name . ', ' . $admin->first_name) }}
                </td>
                <td class="text-center">
                  {{ $admin->identification }}
                </td>
                <td class="text-center">
                  <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Update</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


          {{--<p class="text-center"><strong>{{ $admins->count() + $admins->perPage() * ($admins->currentPage() - 1) }} of {{ $admins->total() }} records</strong></p>--}}

              <!-- Page Number render() -->
              <div class="text-center"> {{ $admins->links() }}</div>
          @else
          <p class="text-center"><em>No Registered Admins</em></p>
          @endif
        </div>
      </div> 



    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection