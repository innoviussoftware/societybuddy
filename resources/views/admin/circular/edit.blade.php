@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Circular</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.circulars.index', $society->id) }}">Circular</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.circulars.update', [$society->id, $notice->id]) }}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="circularfile" value="{{$notice->pdffile}}">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Circular</h3>
        </div>
        <!-- /.box-header -->

        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
            <div class="form-group">
              <label>Building</label>
               <button type="button"   class="btn btn-primary" style="float: right;" id="select_all">Select All</button>
                 <button type="button"  class="btn btn-danger" style="display: none;float: right;" id="remove_all">Remove All</button>
                <select id="parent_filter_select2" class="form-control select2" name="building_id[]" id="building" required multiple="" data-placeholder="Select a Building">
                @foreach($buildings as $b)
                  <?php 
                  $mysqlvalue= explode(",",$notice->building_id);?>
                  <option value="{{ $b->id }}" <?php echo in_array($b->id,$mysqlvalue) ? "selected" : "" ?>>{{ $b->name }}</option>
                @endforeach
              </select>
              
            </div>

            <div class="form-group">
                <label >Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Name" value="{{$notice->title}}" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" name="description" placeholder="Enter Description" required="">{{$notice->description}}</textarea>
              </div>
              
              <div class="form-group">
                <label>Pdf</label>
                <input type="file" class="form-control" name="pdf" accept="application/pdf,image/png, image/jpg">
              </div>
             
            
            </div>
          </div>


        </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.circulars.index', $society->id) }}" class="btn btn-default">Cancel</a>
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

  });
    $('#select_all').click(function ()
    {
        //   alert('aaa');
        $('#parent_filter_select2 > option').prop('selected', 'selected');
        $('#parent_filter_select2').trigger('change');
        $('#remove_all').show();
        $(this).hide();
    });
    
    $('#remove_all').click(function ()
    {
        //   alert('aaa');
        $('#parent_filter_select2 > option').prop('selected', false);
        $('#parent_filter_select2').trigger('change');
        $('#select_all').show();
        $(this).hide();
    });

});
</script>
@endsection
