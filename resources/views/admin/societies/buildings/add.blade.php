@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Society Buildings
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Buildings</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        @role(['admin','sub_admin'])
        <ul class="nav nav-tabs">
         <li ><a href="{{ route('admin.societies.edit', $society->id) }}">Society Details</a></li>
         <li class="active" ><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
         <li><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
         <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
       </ul>
       @endrole

        <form action="{{ route('admin.societies.buildings.store',$society->id) }}" method="post">
        @csrf
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Building Name</label>
                <input type="text" class="form-control" name="name" required>
              </div>
              <label>Add Flats <button class="btn btn-default btn-xs add_flat" type="button">+</button></label>

                <div class="row" id="flats">
                  <!-- <div class="col-md-4">
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button class="btn btn-danger" type="button">-</button>
                      </span>
                    </div>
                  </div> -->
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
      </div>
    </div>


</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Society Building</th>
              <th>Action</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('custom_js')
<script>
$(document).ready(function(){
  $("body").on("click",".add_flat",function(){
    var html = '<div class="col-md-4"> <div class="input-group"><input type="text" name="flats[]" class="form-control" placeholder="Flat no." required><span class="input-group-btn"><button class="btn btn-danger delete_flat" type="button">-</button></span></div></div>';
    $("#flats").append(html);
  });
  $("body").on("click","#flats button.delete_flat",function(){
    $(this).closest(".col-md-4").remove();
  });

  var doctordatatable = $('#societies_datatable').DataTable({
      responsive: true,
      "processing": true,
      "ajax": "{{ route('admin.societies.arrayBuildings', $society->id) }}",
      "language": {
          "emptyTable": "No Society Building available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
</script>
@endsection
