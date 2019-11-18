@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Member Import
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-6 col-xs-12">
      <div class="box">
        <form action="{{ route('admin.guard.importdata') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Import Member</h3>
        </div>

        <input  type="hidden" name="society_id" class="form-control" value="{{ (request()->route('id')) ? request()->route('id') : 6 }}">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <label>Upload File</label>
            <input  type="file" name="file_import" class="form-control" placeholder="Enter File">
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.index') }}" class="btn btn-default">Cancel</a>
        </div>
      </form>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endsection
