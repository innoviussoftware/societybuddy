@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Add Guard
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.guardes.index') }}">Guardes</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <form action="{{ route('admin.guardes.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Guard</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              @role(['admin','sub_admin'])
              <div class="form-group">
                <label>Society</label>
                  <select class="form-control" name="society" id="society" required>
                  <option disabled selected value="">Select Society</option>
                  @foreach($society as $s)
                    <option value="{{ $s->id }}" {{ ($s->id == old('society')) ? "selected" : "" }} >{{ $s->name }}</option>
                  @endforeach
                </select>
              </div>
              @endrole
              @role(['society_admin'])
              <input type="hidden"  name="society" value="{{ auth()->user()->society_id }}">

              @endrole

              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Guard Name" value="{{ old('name') }}" required>
              </div>
              <div class="form-group">
                <label>Login Pin</label>
                <input type="text" name="pin" class="form-control" placeholder="Enter Guard Login Pin" value="<?php echo rand(1000,9999); ?>" required readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Contact No.</label>
                <input type="text" minlength="10" maxlength="10" name="phone" class="form-control" placeholder="Enter Guard Contact No." value="{{ old('phone') }}" required>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Gender</label><br/>
                <input type="radio"  name="gender" value="male" checked> Male<br>
                <input type="radio"  name="gender" value="female"> Female<br>
              </div>
              <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" class="form-control" name="profile_pic" accept="image/*" >
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.guardes.index') }}" class="btn btn-default">Cancel</a>
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
  $("body").on('change','#city',function (){
    var id  = $(this).val();
    getArea(id);
  });

  function getArea(id){
    $.ajax({
      url:"{{ env('APP_URL') }}/admin/areas/byCity/"+id,
      method:"get",
      success:function(e){

        var html = "<option>Select Area</option>";
        for(var i = 0; i < e.length; i++){
          html += "<option  value='"+e[i].id+"'>"+e[i].name+"</option>";
        }
        $("#area").html(html);
      }
    });
  }
});
</script>
@endsection
