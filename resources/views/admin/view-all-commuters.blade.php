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
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
                <th>ID</th>
              </tr>
            </thead>
            <tbody>
              @foreach($commuters as $commuter)
              <tr>
                <td>
                  {{ strtoupper($commuter->last_name . ', ' . $commuter->first_name) }}
                </td>
                <td>
                  {{ $commuter->identification }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


          {{--<p class="text-center"><strong>{{ $commuters->count() + $commuters->perPage() * ($commuters->currentPage() - 1) }} of {{ $commuters->total() }} records</strong></p>--}}

              <!-- Page Number render() -->
              <div class="text-center"> {{ $commuters->links() }}</div>
        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection