@extends('layouts.admin-layout')

@section('title') Commuter Search Result @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuter Search: {{ count($commuters) }} Related Result For "{{ $term }}"
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

          @include('admin.includes.commuter-search')
          @if(count($commuters) > 0)

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
                  <a href="{{ route('admin.view.commuter.details', ['id' => $commuter->id]) }}">{{ strtoupper($commuter->last_name . ', ' . $commuter->first_name) }}</a>
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
          @else 
          <p class="text-center">No Related Search Result For: "<strong>{{ $term }}</strong>"</p>
          @endif
        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection