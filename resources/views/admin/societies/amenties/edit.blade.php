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
    <li><a href="{{ route('admin.societies.amenties.index', $society->id) }}">Amenities</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.amenties.update', [$society->id, $user->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Amenities</h3>
        </div>
        <input type="hidden" name="oldimages" value="{{$user->images}}">
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">

              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $user->name}}" required>
              </div>

              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" placeholder="Enter Description" required="required" name="description">{{ $user->description}}</textarea>
              </div>

              <div class="form-group">
                <label>Amount</label>
                <input type="text" name="amount" class="form-control" placeholder="Enter Amount" value="{{ $user->amount}}">
              </div>

              <div class="form-group">
                <label>Notes</label>
                <textarea class="form-control" placeholder="Enter Notes" name="notes">{{ $user->notes}}</textarea>
              </div>

              <div class="form-group">
                <label>Images</label>
                <input type="file" class="form-control" name="image[]" multiple="multiple">
              </div>

              <div class="form-group">
                <?php 
                $reports_file = explode(' | ', $user->images);
                if($reports_file != null){
                 foreach ($reports_file as $reports) {
                  $url=env('APP_URL_STORAGE').'/'.$reports;?>
                      <div class="" style="display: inline-block;"><a class="example-image-link" href="{{$url}}" data-lightbox="example-1"><img src="{{$url}}"  width="50px" height="50px"></a></div>
                <?php }}else{$img = asset('amenities image.png');?>
                    <div class="" style="display: inline-block;"><a class="example-image-link" href="{{$img}}" data-lightbox="example-1"><img src="{{$img}}"  width="50px" height="50px"></a></div>
                <?php }?>      
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
});
</script>
@endsection
