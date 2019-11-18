@extends('layouts.admin')

@section('content')
<style type="text/css">
  .callout{
    height: 202px;
  }
</style>

<section class="content-header">
  <h1>
    Domestic Helpers
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Domestic Helpers</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">

        @role(['admin','sub_admin'])
        <ul class="nav nav-tabs">
           <li ><a href="{{ route('admin.societies.edit', $society->id) }}">Society Details</a></li>
           <li  ><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
           <li ><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
           <li class="active"><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
        </ul>
       @endrole

        <div class="box-body">
          <a class="btn btn-primary" href="{{ route('admin.societies.serviceprovider.add', $society->id) }}" style="float: right;">+ Add New</a>
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Photos</th>
              <th>Name</th>
              <th>Type</th>
              <th>Member Name</th>
              <th>Rating</th>
              <th>Join Date</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
</section>
@endsection

@section('custom_js')
<script>
$(document).ready(function(){

  var doctordatatable = $('#societies_datatable').DataTable({
      responsive: true,
      "processing": true,
      "ajax": "{{ route('admin.societies.arrayserviceprovider', $society->id) }}",
      "language": {
          "emptyTable": "No any domestic helpers available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
</script>

@endsection