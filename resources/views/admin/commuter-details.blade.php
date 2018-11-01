@extends('layouts.admin-layout')

@section('title') Commuter Details @endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Commuter Details
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
          <p><a href="{{ route('admin.view.all.commuters') }}" class="">Go to Commuters</a></p>
          <p>
            @if($commuter->active == 1)
            <span class="badge bg-green">Active</span>
            @else
            <span class="badge bg-red">Blocked</span>
            @endif
          </p>
          <p>Name: <strong>{{ ucwords($commuter->first_name . ' ' . $commuter->last_name) }}</strong></p>
          <p>Identification: <strong>{{ $commuter->identification }}</strong></p>
          <p>Mobile Number: <strong>{{ $commuter->mobile_number }}</strong></p>
          <hr>
          <p>Feedback Made: <strong><a href="{{ route('admin.view.commuter.feedback', ['id' => $commuter->id]) }}">{{ count($commuter->comment) }}</a></strong></p>
          
          <hr>

          <hr>
          @if($commuter->active == 1)
          <p><a href="javascript:void(0)" class="badge bg-red" data-toggle="modal" data-target="#block">Block Commuter</a></p>
          @else
          <p><a href="javascript:void(0)" class="badge bg-green" data-toggle="modal" data-target="#unblock">Unblock Commuter</a></p>
          @endif
          {{-- start of modals --}}
          <div class="modal fade modal-danger" tabindex="-1" id="block" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Block Commuter</h4>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('admin.block.user') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $commuter->id }}">
                        <p>Are you sure you want to block this commuter?</p>
                        <p><button class="btn btn-danger">Block Commuter</button></p>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <small>Block commuter</small>
                    </div>
                </div>

            </div>
        </div>


          <div class="modal fade modal-success" tabindex="-1" id="unblock" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Unblock Commuter</h4>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('admin.unblock.user') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $commuter->id }}">
                        <p>Are you sure you want to block this commuter?</p>
                        <p><button class="btn btn-success">Unblock Commuter</button></p>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <small>Unblock commuter</small>
                    </div>
                </div>

            </div>
        </div>
          {{-- end of modals --}}

        </div>
      </div> 


    </section>
    <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection