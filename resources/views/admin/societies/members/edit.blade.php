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
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.members.update', [$society->id, $member->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Society Member</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

          @role('society_admin')
            <ul class="nav nav-tabs">
              <li class="active"><a href="{{ route('admin.societies.members.index', $society->id) }}">Details</a></li>
              <li><a href="{{ route('admin.societies.members.vehicles.index', [$society->id, $member->id]) }}">Manage Vehicles</a></li>
              <li><a href="{{ route('admin.societies.members.familymember.index', [$society->id, $member->id]) }}">Manage Family Member</a></li>
           </ul>
         @endrole

          <div class="row">
            <div class="col-md-6">
            <div class="form-group">
              <label>Building</label>
                <select class="form-control" name="building_id" id="building" required>
                <option disabled selected value="">Select Building</option>
                @foreach($buildings as $b)
                  <option value="{{ $b->id }}" {{ ($b->id == $member->building_id) ? "selected" : "" }} >{{ $b->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Flat</label>
                <select class="form-control" name="flat_id" id="flats" required>
                <option disabled  value="">Select Flat</option>
                @foreach($flats as $f)
                  <option value="{{ $f->id }}" {{ ($f->id == $member->flat_id) ? "selected" : "" }}>{{ $f->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Role</label>
              <select class="form-control select2" name="roles[]" multiple="multiple" data-placeholder="Select a State"
                      style="width: 100%;">
                @foreach($roles as $role)
                  <option value="{{ $role->id }}" <?php echo in_array($role->id,$userroles) ? "selected" : "" ?>>{{ $role->display_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $member->user->name }}" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input type="email" readonly  class="form-control"  value="{{ $member->user->email }}" >
            </div>
            <div class="form-group">
              <label>Phone</label>
              <input type="text" readonly  class="form-control"  value="{{ $member->user->phone }}">
            </div>
            <div class="form-group">
              <label>Occupy&nbsp; &nbsp;</label>   
              <select class="form-control" name="occupy" id="Occupy" required>
                <option disabled selected value="">Select Occupy</option>
                <option value="Owner" {{ ($member->occupancy == 'Owner' || $member->occupancy == 'owner') ? "selected" : "" }}>Owner</option>
                <option value="Tenant" {{ ($member->occupancy == 'Tenant' || $member->occupancy == 'tenant') ? "selected" : "" }}>Tenant</option>
              </select>           
            </div>
            <div class="form-group">
              <label>Gender&nbsp; &nbsp;</label>
              <input type="radio" name="gender" value="M" checked="" {{ $member->gender == 'M' ? "checked" : "" }}> Male
              <input type="radio" name="gender"  value="F" {{ $member->gender == 'F' ? "checked" : "" }}> Female
            </div>
            <?php if($member->flatType=='Renting the flat'){?>
              <div class="form-group">
              <label>Verification ID Proof</label>
              <input type="file" class="form-control" name="verification_image" >
              <input type="hidden" name="id_proof" value="{{$member->idproof}}">
            </div>
            <div class="form-group">
              <label>Police Verification&nbsp; &nbsp;</label>
              <input type="radio" name="policeverify" value="Y"  {{ $member->policeverify == 'Y' ? "checked" : "" }}> Yes
              <input type="radio" name="policeverify"  value="N"  {{ $member->policeverify == 'N' ? "checked" : "" }}> No
            </div>
            <div class="form-group">
              <label>Residing Since</label>
              <input type="text" name="since" class="form-control datepicker" placeholder="Enter since"  value="{{ $member->since }}" required autocomplete="off" required="" id="enddate">
            </div>
            <?php } ?>
            <!-- <div class="form-group">
              <label for="exampleInputEmail1">Password</label>
              <input type="text" name="password" class="form-control" placeholder="Enter Password" value="" required>
            </div> -->
            
              <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image" accept="image/*">
              </div>
              
              @if($member->user->image != null)
                  <img src="{{env('APP_URL_STORAGE'). $member->user->image }}" width="150"/>
                @else
                  <?php $img = asset('no-image.png');?>
                  <img src="{{$img}}" width="150"/>
                @endif
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
  $(document).ready(function (){
    $('.select2').select2();

    $("body").on('change','#building',function (){
      var id  = $(this).val();
      getFlats(id);
    });
    $("#enddate").datepicker({ 
        numberOfMonths:2,
        format: 'yyyy/mm/dd',
        //startDate:'+0d',
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
});
</script>
@endsection
