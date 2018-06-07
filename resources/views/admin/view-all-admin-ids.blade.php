@extends('layouts.admin-layout')

@section('title') View All Admin IDs @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View All Admin IDs
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
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>Used</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ids as $id)
              <tr>
                <td>
                  {{ $id->identification }}
                </td>
                <td>
                  @if($id->used == 0)
                  No
                  @else
                  Yes
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>


          {{--<p class="text-center"><strong>{{ $ids->count() + $ids->perPage() * ($ids->currentPage() - 1) }} of {{ $ids->total() }} records</strong></p>--}}

              <!-- Page Number render() -->
              <div class="text-center"> {{ $ids->links() }}</div>
        </div>
      </div> 



    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection