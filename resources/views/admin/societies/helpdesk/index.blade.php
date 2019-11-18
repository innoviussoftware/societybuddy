@extends('layouts.admin')

@section('content')
<style type="text/css">
  .callout{
    height: 202px;
  }
</style>

<section class="content-header">
  <h1>
    Help Desk
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Help Desk</a></li>
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
          <?php $help=App\Helpdesk::where('society_id',$society->id)->count();
          if($help=='0'){?>
          <a class="btn btn-primary" href="{{ route('admin.societies.helpdesk.add', $society->id) }}" style="float: right;">+ Add New</a>
        <?php }?>
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Name2</th>
              <th>Phone</th>
              <th>Fire</th>
              <th>Police Station</th>
              <th>Police Number</th>
              <th>Hostipal Name</th>
              <th>Hostipal Number</th>
              <th>Ambulance Number</th>
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
      "ajax": "{{ route('admin.societies.helpdesk', $society->id) }}",
      "language": {
          "emptyTable": "No any help desk available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
</script>

@endsection