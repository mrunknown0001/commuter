@extends('layouts.admin-layout')

@section('title') View All Commuters @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View All Commuters
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Commuters</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">


    <div class="row">
        <div class="col-md-12">
          @include('includes.all')
          @if(count($commuters) > 0)

          @include('admin.includes.commuter-search')
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>Student Number</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($commuters as $commuter)
              <tr>
                <td>
                  <a href="{{ route('admin.view.commuter.details', ['id' => $commuter->id]) }}">{{ strtoupper($commuter->last_name . ', ' . $commuter->first_name) }}</a>
                </td>
                <td>
                  {{ $commuter->student_number }}
                </td>
                <td>
                  <a href="{{ route('admin.update.commuter', ['id' => $commuter->id]) }}" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> Update</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


          {{--<p class="text-center"><strong>{{ $commuters->count() + $commuters->perPage() * ($commuters->currentPage() - 1) }} of {{ $commuters->total() }} records</strong></p>--}}

              <!-- Page Number render() -->
              <div class="text-center"> {{ $commuters->links() }}</div>
          @else 
          <p class="text-center"><em>No commuters registered</em></p>
          @endif
        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection