@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Amenities</small>
    
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Amenities</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.amenties.store', $society->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Amenities</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" required>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" placeholder="Enter Description" required="required" name="description"></textarea>
              </div>

              <div class="form-group">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control" placeholder="Enter Amount" value="{{ old('amount') }}">
              </div>

              <div class="form-group">
                <label>Notes</label>
                <textarea class="form-control" placeholder="Enter Notes" name="notes"></textarea>
              </div>

              <div class="form-group">
                <label>Images</label>
                <input type="file" class="form-control" name="image[]" multiple>
              </div>

            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.amenties.index', $society->id) }}" class="btn btn-default">Cancel</a>
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
