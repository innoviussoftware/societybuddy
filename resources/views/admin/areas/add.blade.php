@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Add Area
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.areas.index') }}">Areas</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-6 col-xs-12">
      <div class="box">
        <form action="{{ route('admin.areas.store') }}" method="post">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Area</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <label for="exampleInputEmail1">City</label>
              <select class="form-control" name="city">
              <option disabled selected>Select City</option>
              @foreach($cities as $c)
                <option value="{{ $c->id }}" {{ ($c->id == old('city')) ? "selected" : "" }} >{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Area">
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.areas.index') }}" class="btn btn-default">Cancel</a>
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
