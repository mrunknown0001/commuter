@extends('layouts.admin-layout')

@section('title') Commuters Feedbacks @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuters Feedbacks by <a href="{{ route('admin.view.commuter.details', ['id' => $commuter->id]) }}">{{ ucwords($commuter->first_name . ' ' . $commuter->last_name) }}</a>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-comments"></i> Home</a></li>
        <li class="active">Feedbacks</li>
      </ol>
    </section>
        <!-- Main content -->
    <section class="content">

    <div class="row">
      <div class="col-md-12">

          @if(count($commuter->feedback) > 0)

            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Feedback Number</th>
                  <th>Driver</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($commuter->feedback as $f)
                <tr>
                  <td>
                    {{ strtoupper($f->feedback_number) }}
                  </td>
                  <td>
                    {{ ucwords($f->driver->first_name . ' ' . $r->driver->last_name) }}
                  </td>
                  <td>
                    <a href="{{ route('admin.view.feedback.details', ['id' => $f->id, 'feedback_number' => $f->feedback_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          @else
        
            <p class="text-center"><em>No Feedback by this commuter</em></p>
          @endif


      </div>
    </div>

    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection