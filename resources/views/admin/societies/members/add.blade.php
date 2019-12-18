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
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.members.store', $society->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Society Member</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Building</label>
                  <select class="form-control" name="building_id" id="building" required>
                  <option disabled selected value="">Select Building</option>
                  @foreach($buildings as $b)
                    <option value="{{ $b->id }}" >{{ $b->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Flat</label>
                  <select class="form-control" name="flat_id" id="flats" required>
                  <option disabled selected value="">Select Flat</option>
                </select>
              </div>
              <div class="form-group">
                <label>Role</label>
                <select class="form-control select2" name="roles[]" multiple="multiple" data-placeholder="Select a State"
                        style="width: 100%;">
                  @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label >Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}">
              </div>
              <div class="form-group">
                <label>Phone</label>
                <input type="text" minlength="10" maxlength="10" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone') }}" required>
              </div>
              <div class="form-group">
                <label>Gender</label>
                <input type="radio" name="gender"  value="M" checked="" {{ old('gender') == 'M' ? "checked" : "" }}> Male
                <input type="radio" name="gender" value="F" {{ old('gender') == 'F' ? "checked" : "" }}> Female
              </div>
              <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image" accept="image/*">
              </div>
             
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.members.index', $society->id) }}" class="btn btn-default">Cancel</a>
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
