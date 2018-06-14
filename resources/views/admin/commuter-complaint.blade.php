@extends('layouts.admin-layout')

@section('title') Commuter Complaint @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Complaint for <a href="{{ route('admin.view.commuter.details', ['id' => $commuter->id]) }}">{{ ucwords($commuter->first_name . ' ' . $commuter->last_name) }}</a>
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

          @if(count($commuter->complaint) > 0)

            
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Report Number</th>
                  <th>Complainant</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($commuter->complaint as $c)
                <tr>
                  <td>
                    {{ strtoupper($c->report_number) }}
                  </td>
                  <td>
                    {{ ucwords($c->complainant->first_name . ' ' . $c->complainant->last_name) }}
                  </td>
                  <td>
                    <a href="{{ route('admin.driver.report.view', ['id' => $c->id, 'report_number' => $c->report_number]) }}" class="label label-primary"><i class="fa fa-eye"></i> View</a>
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