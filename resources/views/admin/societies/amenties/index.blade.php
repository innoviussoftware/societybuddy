@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Amenities
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Amenities</a></li>
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
           <li class="active"><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
           <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
         </ul>
       @endrole
        <div class="box-body">
          <a class="btn btn-primary pull-right" href="{{ route('admin.societies.amenties.add', $society->id) }}">+ Add Amenities</a>
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Images</th>
              <th>Amount</th>
              <th>Status</th>
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
function confirm(url, name) {
    bootbox.confirm({
        title: '',
        message: '<h5><i class="fa fa-remove text-danger"></i>&nbsp;&nbsp;' + name + '</h5>',
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if (result == true) {
                window.location.replace(url);
            }
        }
    });
}


$(document).ready(function(){
  var doctordatatable = $('#societies_datatable').DataTable({
      responsive: true,
      "processing": true,
      "ajax": "{{ route('admin.societies.arrayamenties', $society->id) }}",
      "language": {
          "emptyTable": "No any Amenities available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
</script>
@endsection
