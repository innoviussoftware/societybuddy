@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Edit Building
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">


        <form action="{{ route('admin.societies.buildings.update',[$society->id, $building->id]) }}" method="post">
        @csrf
        @method("PATCH")
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Building Name</label>
                <input type="text" class="form-control" name="name" required value="{{ $building->name }}">
              </div>
              <label>Add Flats <button class="btn btn-default btn-xs add_flat" type="button">+</button></label>

                <div class="row" id="flats">
                  @foreach($building->flats as $f)
                  <div class="col-md-4" >
                    <div class="input-group">
                      <input type="text" class="form-control" placeholder="Flat No." name="flats[]" value="{{ $f->name }}">
                      <span class="input-group-btn">
                        <button class="btn btn-danger delete_flat" type="button">-</button>
                      </span>
                    </div>
                  </div>
                  @endforeach
                </div>
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
    </div>


</section>
@endsection

@section('custom_js')
<script>
$(document).ready(function(){
  $("body").on("click",".add_flat",function(){
    var html = '<div class="col-md-4"> <div class="input-group"><input type="text" name="flats[]" class="form-control" placeholder="Flat no." required><span class="input-group-btn"><button class="btn btn-danger delete_flat" type="button">-</button></span></div></div>';
    $("#flats").append(html);
  });
  $("body").on("click","#flats button.delete_flat",function(){
    $(this).closest(".col-md-4").remove();
  });
});
</script>
@endsection
