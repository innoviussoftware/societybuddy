@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Settings
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Settings</a></li>
    
  </ol>
</section>
<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        @role(['admin','sub_admin'])
        <ul class="nav nav-tabs">
         <li><a href="{{ route('admin.societies.edit', $society->id) }}">Society Details</a></li>
         <li><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
         <li><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
         <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
         <li class="active"><a href="{{ route('admin.societies.settings.index', $society->id) }}">Settings</a></li>
       </ul>
       @endrole
       
       	@if(isset($societysettings))
       	<form action="{{ route('admin.societies.settings.update',[$society->id, $societysettings->id]) }}" method="post" enctype="multipart/form-data">
       	@csrf
        @method('PATCH')
       	@else
       	<form action="{{ route('admin.societies.settings.store',[$society->id]) }}" method="post" enctype="multipart/form-data">
       		@csrf
       	@endif
        
        @if(isset($societysettings))
        <?php $billing_provider = explode(',', $societysettings->module_name);?>
        <div class="box-body">
         	<div class="form-group">
         		<input type="checkbox" class="minimal" name="module_name[]" value="Maintenance" <?php if(in_array("Maintenance", $billing_provider)){ echo 'checked';}?>>&nbsp&nbsp
                <label>
                  Maintenance
                </label>
        	</div>
        
        
         	<div class="form-group">
         		<input type="checkbox" class="minimal" name="module_name[]" value="Troll" <?php if(in_array("Troll", $billing_provider)){ echo 'checked';}?>>&nbsp&nbsp
                <label>
                  Troll
                </label>
        	</div>
        </div>
        @else
        <div class="box-body">
         	<div class="form-group">
         		<input type="checkbox" class="minimal" name="module_name[]" value="Maintenance">&nbsp&nbsp
                <label>
                  Maintenance
                </label>
        	</div>
        
        
         	<div class="form-group">
         		<input type="checkbox" class="minimal" name="module_name[]" value="Troll">&nbsp&nbsp
                <label>
                  Troll
                </label>
        	</div>
        </div>
         @endif
        @if(isset($societysettings))
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        @else
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        @endif	
        
        </form>
      </div>
    </div>
</section>
@endsection

@section('custom_js')
<script>

</script>

@endsection
