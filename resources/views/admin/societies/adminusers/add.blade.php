@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Admin users</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.adminusers.store', $society->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Admin Users</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label >Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}" required>
              </div>
              <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone') }}" required minlength="10" maxlength="10">
              </div>
              <div class="form-group">
                <label >Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password"  required>
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password"  required>
              </div>

              <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image">
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
