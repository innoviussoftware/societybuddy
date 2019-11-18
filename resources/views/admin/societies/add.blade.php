@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Add Society
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Society</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>City <span class="text-danger">*</span></label>
                  <select class="form-control" name="city" id="city" required>
                  <option disabled selected value="">Select City</option>
                  @foreach($cities as $c)
                    <option value="{{ $c->id }}" {{ ($c->id == old('city')) ? "selected" : "" }} >{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Area <span class="text-danger">*</span></label>
                  <select class="form-control" name="area" id="area" required>
                    <option disabled selected value="">Select Area</option>
                    @if($areas)
                      @foreach($areas as $a)
                      <option value="{{ $a->id }}" {{ (old('area') == $a->id) ? "selected" : "" }}>{{ $a->name }}</option>

                      @endforeach
                    @endif
                  </select>
              </div>
              <div class="form-group">
                <label>Address <span class="text-danger">*</span></label>
                <textarea class="form-control" name="address" required>{{ old('address') }}</textarea>
              </div>
              <div class="form-group">
                <label>Logo</label>
                <input type="file" class="form-control" name="logo">
              </div>
              <div class="form-group">
                <label>Document</label>
                <input type="file" class="form-control" name="document">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Enter Society Name" value="{{ old('name') }}" required>
              </div>
              <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="Enter Society Email" value="{{ old('email') }}" required>
              </div>
              <div class="form-group">
                <label>Contact No. <span class="text-danger">*</span></label>
                <input type="text" minlength="8" maxlength="12" name="contact" class="form-control" placeholder="Enter Society Contact No." value="{{ old('contact') }}" required minlength="10" maxlength="10">
              </div>


            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.index') }}" class="btn btn-default">Cancel</a>
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
