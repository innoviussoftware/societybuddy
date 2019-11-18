@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Members
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Members</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">

          @role('society_admin')
            <ul class="nav nav-tabs">
              <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Details</a></li>

              <li class="active"><a href="{{ route('admin.societies.members.vehicles.index', [$society->id, $member->id]) }}">Manage Vehicles</a></li>

              <li><a href="{{ route('admin.societies.members.familymember.index', [$society->id, $member->id]) }}">Manage Family Member</a></li>
           </ul>
         @endrole


         <br>
          <a class="btn btn-primary" href="{{ route('admin.societies.members.vehicles.add', [$society->id,$member->id]) }}">+ Add Member's vehicles</a>
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Type</th>
              <th>Number</th>
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
      "ajax": "{{ route('admin.arrayMembersVehicles', $member->user_id) }}",
      "language": {
          "emptyTable": "No any vehicles available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
</script>
@endsection
