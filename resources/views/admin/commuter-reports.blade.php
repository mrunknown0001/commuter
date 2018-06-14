@extends('layouts.admin-layout')

@section('title') Commuter Reports @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuter Reports By <a href="{{ route('admin.view.commuter.details', ['id' => $commuter->id]) }}">{{ ucwords($commuter->first_name . ' ' . $commuter->last_name) }}</a>
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
          <p><a href="{{ url()->previous() }}" class="">Back</a></p>

          @if(count($commuter->report) > 0)

            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Report Number</th>
                  <th>Driver</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($commuter->report as $r)
                <tr>
                  <td>
                    {{ strtoupper($r->report_number) }}
                  </td>
                  <td>
                    {{ ucwords($r->reported->first_name . ' ' . $r->reported->last_name) }}
                  </td>
                  <td>
                    <a href="{{ route('admin.commuter.report.view', ['id' => $r->id, 'report_number' => $r->report_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          @else
        
            <p class="text-center"><em>No Report by this commuter</em></p>
          @endif

        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection