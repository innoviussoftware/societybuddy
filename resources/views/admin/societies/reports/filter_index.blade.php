@extends('layouts.admin')

@section('content')
<style type="text/css">
  .callout{
    height: 202px;
  }
</style>

<section class="content-header">
  <h1>
    Reports
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Reports</a></li>
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
       <div class="row">
        <div class="col-sm-5" style="padding-top: 0.5em;margin-left: 0.5em;">
             <form action="{{ route('admin.societies.serviceprovider.store', $society->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
              @csrf
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <div class="col-sm-4">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;" id="building">
                            <option value="">Select Buildings</option>
                            @foreach($buildings as $b)
                            <option value="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-sm-4">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;" id="flats">
                            <option value="">Select Flat</option>
                          </select>
                        </div>

                        <div class="col-sm-4">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;">
                            <option value="">Select Guards</option>
                            @foreach($guard as $g)
                            <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                          </select>
                        </div>

                      </div>
                    </div>
                  </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.societies.serviceprovider.index', $society->id) }}" class="btn btn-default">Cancel</a>
             </form>
        </div>
        <div class="col-sm-5" style="padding-top: 0.5em;margin-left: 0.5em;">
             <form action="{{ route('admin.societies.serviceprovider.store', $society->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
              @csrf
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <div class="col-sm-4">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;">
                            <option value="">Start Date</option>
                          </select>
                        </div>

                        <div class="col-sm-4">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;">
                            <option value="">End Date</option>
                          </select>
                        </div>


                      </div>
                    </div>
                  </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('admin.societies.serviceprovider.index', $society->id) }}" class="btn btn-default">Cancel</a>
             </form>
        </div>
      </div>
        <div class="box-body">
         <!--  <a class="btn btn-primary" href="{{ route('admin.societies.serviceprovider.add', $society->id) }}" style="float: right;">+ Add New</a> -->
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Visitor Name</th>
              <th>Flat</th>
              <th>Member Name</th>
              <th>In Time</th>
              <th>Out Time</th>
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

  $("body").on('change','#building',function (){
    var id  = $(this).val();
    getFlats(id);
  });

  function getFlats(id){
    $.ajax({
      url:"{{ env('APP_URL') }}/admin/societies/flats/byBuilding/"+id,
      method:"get",
      success:function(e){

        var html = "<option>Select Flat</option>";
        for(var i = 0; i < e.length; i++){
          html += "<option  value='"+e[i].id+"'>"+e[i].name+"</option>";
        }
        $("#flats").html(html);
      }
    });
  }

  var doctordatatable = $('#societies_datatable').DataTable({
      responsive: true,
      "processing": true,
      "ajax": "{{ route('admin.societies.filterReports', $society->id) }}",
      "language": {
          "emptyTable": "No any currentvisitor available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
$(document).ready(function (){
  $('.select2').select2()



  
});
</script>

@endsection