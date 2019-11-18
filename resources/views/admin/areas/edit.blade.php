@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Edit Area
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.areas.index') }}">Areas</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-md-6 col-xs-12">
      <div class="box">
        <form action="{{ route('admin.areas.update',$area->id) }}" method="post">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Area</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">City</label>
            <select class="form-control" name="city">
              @foreach($cities as $c)
              <option value="{{ $c->id }}" {{ ($c->id == $area->city->id) ? "selected" : "" }} >{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $area->name }}" placeholder="Enter Area">
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
