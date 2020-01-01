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
        <form action="{{ route('admin.societies.polls.update',  [$society->id, $building->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        @method('PATCH')
<div class="box-header">
          <h3 class="box-title">Edit Polls</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Question: </label>

                  <div class="col-sm-10">
                    <textarea class="form-control" name="question" required="" placeholder="Question">{{$building->question}}</textarea>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Option 1: </label>

                  <div class="col-sm-10">
                    <input type="text" name="option1" class="form-control" required="" placeholder="Option 1" value="{{$building->a1}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Option 2: </label>

                  <div class="col-sm-10">
                    <input type="text" name="option2" class="form-control" required="" placeholder="Option 2" value="{{$building->a2}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Option 3: </label>

                  <div class="col-sm-10">
                    <input type="text" name="option3" class="form-control option3" placeholder="Option 3" value="{{$building->a3}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Option 4: </label>

                  <div class="col-sm-10">
                    <input type="text" name="option4" class="form-control option4" placeholder="Option 4" value="{{$building->a4}}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Expire On: </label>

                  <div class="col-sm-10">
                    <input type="text" name="expire" class="form-control" id="datepicker" placeholder="Enter Datetime" value="{{$building->expires_on}}" required="">
                  </div>
                </div>


                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Status: </label>
                  <div class="col-sm-10">
                    <input type="radio" name="Status"  value="1" checked="" 
                    {{ $building->active == '1' ? "checked" : "" }} required> Active
                  <input type="radio" name="Status" value="0" {{ $building->active == '0' ? "checked" : "" }} required> Inactive
                  </div>
                </div>
              
              
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('admin.societies.polls.index', $society->id) }}" class="btn btn-default">Cancel</a>
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
  
   $('#datepicker').datetimepicker({

    
      startDate: now,
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

$(document).ready(function (){
      $("body").on('change','.option4',function (){

          var id  = $(this).val();
          var option3=$('.option3').val();
          if(id != '')
          {
            
              if(option3 == '')
              {              
                  $('.option3').attr("required", true);
              }
              else
              {
                 $('.option3').removeAttr("required");
              }
          }
          else
          {        
              $('.option3').removeAttr("required");
          }

      });
});
</script>
@endsection