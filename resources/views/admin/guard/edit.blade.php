@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Edit Guard
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.guardes.index') }}">Guardes</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.guardes.update',$guard->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="box-header">
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              @role(['admin','sub_admin'])
              <div class="form-group">
                <label>Society</label>
                  <select class="form-control" name="society" id="society" required>
                  <option disabled selected value="">Select Society</option>
                  @foreach($society as $s)
                    <option value="{{ $s->id }}" {{ ($s->id == $guard->society_id) ? "selected" : "" }} >{{ $s->name }}</option>
                  @endforeach
                </select>
              </div>
              @endrole 
              @role(['society_admin'])
                <input type="hidden"  name="society" value="{{ auth()->user()->society_id }}">
              @endrole
              <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Guard Name" value="{{ $guard->name }}" required>
              </div>
              <div class="form-group">
                <label>Login Pin</label>
                <input type="text" name="pin" class="form-control" placeholder="Enter Guard Login Pin" value="{{ $guard->login_pin }}" required readonly>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Contact No.</label>
                <input type="text" minlength="10" maxlength="10" name="phone" class="form-control" placeholder="Enter Guard Contact No." value="{{ $guard->phone }}" required>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Gender</label><br/>
                <input type="radio"  name="gender" value="male" {{ ($guard->gender == "male") ? "checked" : "" }}> Male<br>
                <input type="radio"  name="gender" value="female" {{ ($guard->gender == "female") ? "checked" : "" }}> Female<br>
              </div>
              <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" class="form-control" name="profile_pic" accept="image/*" >
                <input type="hidden" class="form-control" name="profile_hidden" value="{{ $guard->profile_pic }}">
                <img  src="{{ App\Guard::getProfilePic($guard->profile_pic) }}" width="100">
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
