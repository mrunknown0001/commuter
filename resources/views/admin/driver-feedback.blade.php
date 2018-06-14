@extends('layouts.admin-layout')

@section('title') Driver Feedbacks @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver Feedbacks Received By <a href="{{ route('admin.view.driver.details', ['id' => $driver->id]) }}">{{ ucwords($driver->first_name . ' ' . $driver->last_name) }}</a>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Drivers</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">


    <div class="row">
        <div class="col-md-12">
          <p><a href="{{ url()->previous() }}" class="">Back</a></p>

          @if(count($driver->feedback) > 0)

            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Feedback Number</th>
                  <th>Commuter</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($driver->feedback as $f)
                <tr>
                  <td>
                    {{ strtoupper($f->feedback_number) }}
                  </td>
                  <td>
                    <a href="{{ route('admin.view.commuter.details', ['id' => $f->commuter->id]) }}">{{ ucwords($f->commuter->first_name . ' ' . $f->commuter->last_name) }}</a>
                  </td>
                  <td>
                    <a href="{{ route('admin.view.feedback.details', ['id' => $f->id, 'feedback_number' => $f->feedback_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          @else
        
            <p class="text-center"><em>No feedback received!</em></p>
          @endif

        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection