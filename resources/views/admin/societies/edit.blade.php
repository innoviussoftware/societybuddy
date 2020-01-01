@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Edit Society
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        @role(['admin','sub_admin'])
          <ul class="nav nav-tabs">
           <li class="active"  ><a href="{{ route('admin.societies.edit', $society->id) }}">Society Details</a></li>
           <li><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
           <li><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
           <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
           <li><a href="{{ route('admin.societies.settings.index', $society->id) }}">Settings</a></li>
         </ul>
       @endrole

        <form action="{{ route('admin.societies.update',$society->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <!-- <h3 class="box-title">Edit Society</h3> -->
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
                    <option value="{{ $c->id }}" {{ ($c->id == $society->area->city->id) ? "selected" : "" }} >{{ $c->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Area <span class="text-danger">*</span></label>
                  <select class="form-control" name="area" id="area" required>
                    <option disabled selected value="">Select Area</option>
                    @foreach($areas as $c)
                    <option value="{{ $c->id }}" {{ ($c->id == $society->area_id) ? "selected" : "" }} >{{ $c->name }}</option>
                    @endforeach

                  </select>
              </div>
              <div class="form-group">
                <label>Address <span class="text-danger">*</span></label>
                <textarea class="form-control" name="address" required>{{ $society->address }}</textarea>
              </div>
              <div class="form-group">
                <label>Logo</label>
                <input type="file" class="form-control" name="logo">
              </div>
              <img src="{{ $society->fulllogopath }}" width="150"/>

              <div class="form-group">
                <label>Document</label>
                <input type="file" class="form-control" name="document">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Enter Society Name" value="{{ $society->name }}" required>
              </div>
              <div class="form-group">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="Enter Society Email" value="{{ $society->email }}" required>
              </div>
              <div class="form-group">
                <label>Contact No. <span class="text-danger">*</span></label>
                <input type="text" name="contact" class="form-control" placeholder="Enter Society Contact No." value="{{ $society->contact }}" required minlength="10" maxlength="10">
              </div>

              <div class="form-group">
                <label>Latitude <span class="text-danger">*</span></label>
                <input type="text" name="lat" class="form-control" placeholder="Enter Latitude." value="{{ $society->lat }}" >
              </div>

              <div class="form-group">
                <label>Longitude <span class="text-danger">*</span></label>
                <input type="text" name="lng" class="form-control" placeholder="Enter Longitude." value="{{ $society->lng }}" >
              </div>


            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
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
