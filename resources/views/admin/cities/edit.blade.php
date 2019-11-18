@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Edit City
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.cities.index') }}">Cities</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-md-6 col-xs-12">
      <div class="box">
        <form action="{{ route('admin.cities.update',$city->id) }}" method="post">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit City</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <label>Name</label>
            <input maxlength="32" type="text" name="name" class="form-control" value="{{ $city->name }}" placeholder="Enter city" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
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
