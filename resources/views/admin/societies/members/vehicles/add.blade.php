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
    <li><a href="{{ route('admin.societies.members.edit',[$society->id, $member->id] ) }}">{{ $member->user->name }}</a></li>
    <li><a href="#">Add Vehicle</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.members.vehicles.store', $member->id) }}" method="post">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Member's vehicles</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Type</label>
                  <select class="form-control" name="type" required>
                  <option disabled selected value="">Select Type</option>
                  <option value="Two Wheeler">Two Wheeler</option>
                  <option value="Four Wheeler">Four Wheeler</option>
                </select>
              </div>
              <div class="form-group">
                <label >Vehicle's Number</label>
                <input type="text" maxlength="32" name="number" class="form-control" placeholder="Enter Vehicle Number" value="{{ old('number') }}" required>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.members.edit', [$society->id, $member->id]) }}" class="btn btn-default">Cancel</a>
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
