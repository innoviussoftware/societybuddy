@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Members</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
    <li><a href="{{ route('admin.societies.members.edit', [$society->id, $member->id]) }}">{{ $member->name }}</a></li>
    <li><a href="{{ route('admin.societies.members.vehicles.index', [$society->id, $member->id]) }}">Vehicles</a></li>
    <li><a href="#">Edit Vehicle</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.members.vehicles.update', $vehicle->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Member's Vehicle</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Type</label>
                  <select class="form-control" name="type" required>
                  <option disabled selected value="">Select Type</option>
                  <option value="Two Wheeler" {{ ($vehicle->type == 'Two Wheeler') ? "selected" : "" }}>Two Wheeler</option>
                  <option value="Four Wheeler" {{ ($vehicle->type == 'Four Wheeler') ? "selected" : "" }}>Four Wheeler</option>
                </select>
              </div>

              <div class="form-group">
                <label>Number</label>
                <input type="text" name="number" class="form-control" placeholder="Enter Number" value="{{ $vehicle->number }}" required>
              </div>
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
<script src="{{ env('APP_URL') }}/admin_assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
$(document).ready(function (){
});
</script>
@endsection
