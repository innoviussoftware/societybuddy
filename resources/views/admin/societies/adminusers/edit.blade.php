@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Admin users</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.adminusers.update', [$society->id, $user->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Admin Users</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $user->name }}" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" readonly  class="form-control"  value="{{ $user->email }}" required>
              </div>
              <div class="form-group">
                <label>Phone</label>
                <input type="text"  class="form-control"  value="{{ $user->phone }}" required minlength="10" maxlength="10">
              </div>
              <!-- <div class="form-group">
                <label for="exampleInputEmail1">Password</label>
                <input type="text" name="password" class="form-control" placeholder="Enter Password" value="" required>
              </div> -->

              <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image">
              </div>
              <img src="{{ $user->fullimagepath }}" width="150"/>
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.adminusers.index', $society->id) }}" class="btn btn-default">Cancel</a>
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
@section('custom_js')
<script>
$(document).ready(function (){
});
</script>
@endsection
