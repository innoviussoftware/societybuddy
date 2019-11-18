@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Domestic Helpers</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.serviceprovider.index', $society->id) }}">DomesticHelpers</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.serviceprovider.update',  [$society->id, $Services->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Domestic Helpers</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

              	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Photo: </label>

                  <div class="col-sm-10">
                    
                    <input type="hidden" class="form-control" name="profile_hidden" value="{{ $Services->photos }}">
                    <div style="padding-bottom:  1em;">
                	<img  src="{{env('APP_URL_STORAGE').$Services->photos}}" width="100">
                	</div>
                	<input type="file" class="form-control" name="image" accept="image/*">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Type: </label>

                  <div class="col-sm-10">
                    <select class="form-control" name="type" id="type" required data-placeholder="Select a type">
                    	<option >Select a type</option>
	                    @foreach($types as $type)
		                  <option value="{{ $type->id }}" {{ ($type->id == $Services->type_id) ? "selected" : "" }}>{{ $type->name }}</option>
		                @endforeach
                	</select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Member: </label>

                  <div class="col-sm-10">
                    <select class="form-control select2" name="members[]" multiple="multiple" data-placeholder="Select a Member"
                        style="width: 100%;">
	                  @foreach($member as $m)
	                  <?php 
	                  $mysqlvalue= explode(",",$Services->member_id);?>
	                  <option value="{{ $m->user->id }}" <?php echo in_array($m->user->id,$mysqlvalue) ? "selected" : "" ?>>{{ $m->user->name }} , {{ $m->building->name }}-{{ $m->flat->name }}</option>
	                  @endforeach
                	</select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Name: </label>

                  <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{$Services->name}}" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Pin: </label>

                  <div class="col-sm-10">
                    <input type="text" name="pin" class="form-control" placeholder="Enter Pin" value="{{$Services->pin}}" required readonly="">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Mobile: </label>

                  <div class="col-sm-10">
                    <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{$Services->mobile}}" required minlength="10" maxlength="10">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Gender: </label>
                  <div class="col-sm-10">
                    <input type="radio" name="gender"  value="M" checked="" 
                		{{$Services->gender == 'M' ? "checked" : "" }}> Male
                	<input type="radio" name="gender" value="F" {{ $Services->gender  == 'F' ? "checked" : "" }}> Female
                  </div>
                </div>
                <?php $ext = pathinfo($Services->document, PATHINFO_EXTENSION);?>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Document: </label>

                  <div class="col-sm-10">
                    <input type="file" class="form-control" name="document">
                  </div>
                  <input type="hidden" class="form-control" name="document_hidden" value="{{ $Services->document }}">
                </div>
                @if($ext=='jpeg' || $ext=='jpg'||$ext=='png'||$ext=='bmp')
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <a class='example-image-link' href="{{env('APP_URL_STORAGE').$Services->document}}" data-lightbox='example-1'><img width='50' class='example-image' src="{{env('APP_URL_STORAGE').$Services->document}}" alt='image-1' /></a>
                  </div>
                </div>
                @elseif($ext=='pdf')
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <a href="{{env('APP_URL_STORAGE').$Services->document}}" download><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>
                  </div>
                </div>
                @else
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label"></label>
                  <div class="col-sm-10">
                    <a href="{{env('APP_URL_STORAGE').$Services->document}}" download><i class='fa fa-file-pdf-o' aria-hidden='true'></i></a>
                  </div>
                </div>
                @endif
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Status: </label>
                  <div class="col-sm-10">
                    <input type="radio" name="Status"  value="1" checked="" 
                		{{ $Services->status == '1' ? "checked" : "" }}> Active
                	<input type="radio" name="Status" value="0" {{ $Services->status == '0' ? "checked" : "" }}> Inactive
                  </div>
                </div>
              
              
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.serviceprovider.index', $society->id) }}" class="btn btn-default">Cancel</a>
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