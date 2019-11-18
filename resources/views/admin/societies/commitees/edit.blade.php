@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Committee</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.commitees.index', $society->id) }}">Committees</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <form action="{{ route('admin.societies.commitees.update', $society->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="box">

        <div class="box-header">
          <h3 class="box-title">Edit Society Committee</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Chairman</label>
                <select class="form-control select2" name="chairman"  data-placeholder="Select a Chairman">
                  @foreach($members as $role)
                    <option value="{{ $role->id }}" <?php echo ($role->id == $society_committee['chairman']) ? "selected" : "" ?>>{{ $role->name." - ".(($role->member) ? $role->member->building->name.'-'.$role->member->flat->name  : "")}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Secretory</label>
                <select class="form-control select2" name="secretory"  data-placeholder="Select a Secretory">
                  <option value="" >Selecte Secretory</option>
                  @foreach($members as $role)
                    <option value="{{ $role->id }}" {{ ($role->id == $society_committee['secretory']) ? "selected" : "" }}>{{ $role->name." - ".(($role->member) ? $role->member->building->name.'-'.$role->member->flat->name  : "") }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Jt. Secretory</label>
                <select class="form-control select2" name="jt_secretory"  data-placeholder="Select a Jt. Chairman">
                  <option value="" >Selecte Jt. Secretory</option>
                  @foreach($members as $role)
                    <option value="{{ $role->id }}"  {{ ($role->id == $society_committee['jt_secretory']) ? "selected" : "" }}>{{ $role->name." - ".(($role->member) ? $role->member->building->name.'-'.$role->member->flat->name  : "") }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Treasurer</label>
                <select class="form-control select2" name="treasurer"  data-placeholder="Select a Treasurer">
                  <option value="" >Selecte Treasurer</option>
                  @foreach($members as $role)
                    <option value="{{ $role->id }}" {{ ($role->id == $society_committee['treasurer']) ? "selected" : "" }} >{{ $role->name." - ".(($role->member) ? $role->member->building->name.'-'.$role->member->flat->name  : "") }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Committees</label>
                <select class="form-control select2" name="commitees[]" multiple="multiple" data-placeholder="Select a Commitee" >
                  <option value="" >Selecte Committees</option>
                  @foreach($members as $role)
                    <option value="{{ $role->id }}" <?php echo in_array($role->id, $society_committee['commitees']) ? "selected" : "" ?>>{{ $role->name ." - ".(($role->member) ? $role->member->building->name.'-'.$role->member->flat->name  : "")}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.commitees.index', $society->id) }}" class="btn btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
@section('custom_js')
<script src="{{ env('APP_URL') }}/admin_assets/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  $(document).ready(function (){
    $('.select2').select2();
  });
</script>
@endsection
