@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Help Desk</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.helpdesk.index', $society->id) }}">Help Desk</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.helpdesk.update', [$society->id, $building->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
       @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Help Desk</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

            	<div class="box-comment">
                  <h4><b>Society</b></h4>
                </div>

              	<div class="form-group">
                  <div class="col-sm-6">
                    <input type="text" name="sname1" class="form-control" placeholder="Enter Name" value="{{ $building->societyName1 }}" required>
                  </div>

                  <div class="col-sm-6">
                   <input type="text" name="sno1" class="form-control" placeholder="Enter Number" value="{{ $building->societyPhone1 }}" required minlength="10" maxlength="10" >
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="text" name="sname2" class="form-control" placeholder="Enter Name" value="{{ $building->societyName2 }}">
                  </div>

                  <div class="col-sm-6">
                   <input type="text" name="sno2" class="form-control" placeholder="Enter Number" value="{{ $building->societyPhone2 }}" minlength="10" maxlength="10" >
                  </div>
                </div>

                <div class="box-comment">
                  <h4><b>Police Station</b></h4>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                   <input type="text" name="policename" class="form-control" placeholder="Enter Name" value="{{ $building->police }}" required>
                  </div>
                

                
                  <div class="col-sm-6">
                   <input type="text" name="policenumber" class="form-control" placeholder="Enter Number" value="{{ $building->policenumber }}" required minlength="10" maxlength="10" >
                  </div>
                </div>

                <div class="box-comment">
                  <h4><b>Fire</b></h4>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                   <input type="text" name="firenumber" class="form-control" placeholder="Enter Number" value="{{ $building->fire }}" required minlength="10" maxlength="10" >
                  </div>
                </div>

                <div class="box-comment">
                  <h4><b>Hostipal</b></h4>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                   <input type="text" name="hostipalname" class="form-control" placeholder="Enter Name" value="{{ $building->hostipalName }}" required>
                </div>

                <div class="col-sm-6">
                   <input type="text" name="hostipalno" class="form-control" placeholder="Enter Number" value="{{ $building->hostipalPhone }}" required minlength="10" maxlength="10" >
                  </div>
                </div>

                <div class="box-comment">
                  <h4><b>Ambulance</b></h4>
                </div>

                <div class="form-group">
                  <div class="col-sm-6">
                   <input type="text" name="ambulanceno" class="form-control" placeholder="Ambulance Number" value="{{ $building->ambulance }}" required minlength="10" maxlength="10" >
                  </div>
                </div>

              
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.helpdesk.index', $society->id) }}" class="btn btn-default">Cancel</a>
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
  $('.select2').select2()

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
});
</script>
@endsection