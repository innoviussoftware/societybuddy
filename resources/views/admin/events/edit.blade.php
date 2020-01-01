@extends('layouts.admin')

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
<section class="content-header">
  <h1>
    {{ $society->name }}
    <small>Event</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.events.index', $society->id) }}">Event</a></li>
    <li><a href="#">Edit</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.events.update', [$society->id, $notice->id]) }}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="event_file" value="{{$notice->event_attachment}}">
        @csrf
        @method('PATCH')

        <div class="box-header">
          <h3 class="box-title">Edit Event</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
            <div class="form-group">
              <label>Building</label>
              <button type="button"   class="btn btn-primary" style="float: right;" id="select_all">Select All</button>
                 <button type="button"  class="btn btn-danger" style="display: none;float: right;" id="remove_all">Remove All</button>
                <select id="parent_filter_select2" class="form-control select2" name="building_id[]" id="building" required data-placeholder="Select a Building" multiple="multiple">                
                @foreach($buildings as $b)
                <?php 
                  $mysqlvalue= explode(",",$notice->building_id);?>
                  <option value="{{ $b->id }}" <?php echo in_array($b->id,$mysqlvalue) ? "selected" : "" ?>>{{ $b->name }}</option>
                @endforeach
              </select>
             
            </div>

            <div class="form-group">
                <label >Type</label>
                <select class="form-control" name="event_type"  required>
                    <option value="">Select Eventtype</option>
                    <option value="Festival" <?php if($notice->event_type=="Festival" ||$notice->event_type=="festival"){echo 'selected';}?>>Festival</option>
                    <option value="AGM" <?php if($notice->event_type=="AGM" ||$notice->event_type=="aGM"){echo 'selected';}?>>AGM</option>
                    <option value="Committee" <?php if($notice->event_type=="Committee" ||$notice->event_type=="committee"){echo 'selected';}?>>Committee</option>
                    <option value="Entertainment" <?php if($notice->event_type=="Entertainment" ||$notice->event_type=="entertainment"){echo 'selected';}?>>Entertainment</option>
                </select>
              </div>
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ $notice->title }}" required>
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" placeholder="Enter Description" name="description" required>{{ $notice->description }}</textarea>
              </div>
             
            </div>
            <div class="col-md-6">
              
            
              <div class="form-group">
                <label >Start Date</label>
                <input type="text" name="startdate" class="form-control datepicker" placeholder="Enter Startdate" value="{{ $notice->event_start_date }}" required id="startdate" autocomplete="off" required="">
              </div>
              <div class="form-group">
                <label>Start Time</label>
                <input type="text" name="starttime" class="form-control timepicker" placeholder="Enter Starttime" value="{{ $notice->event_start_time }}" required autocomplete="off" required="" id="starttime">
                <div class="start_error"></div>
              </div>
              <div class="form-group">
                <label>End Date</label>
                <input type="text" name="enddate" class="form-control datepicker" placeholder="Enter Enddate"  value="{{ $notice->event_end_date }}" required id="enddate" autocomplete="off" required="">
              </div>
              <div class="form-group">
                <label>End Time</label>
                <input type="text" name="endtime" class="form-control timepicker" placeholder="Enter Endtime" value="{{ $notice->event_end_time }}" required autocomplete="off" required="" id="endtime">
                <div class="end_error"></div>
              </div>
              <div class="form-group">
                <label>Attachment</label>
                <input type="file" name="attachment" class="form-control" accept="application/pdf,image/png, image/jpg">
                @if($notice->event_attachment != null)
                  <img src="{{env('APP_URL_STORAGE'). $notice->event_attachment }}" width="150"/>
                @else
                  <?php $img = asset('amenities image.png');?>
                  <img src="{{$img}}" width="150"/>
                @endif
                

              </div>
             
            </div>
          </div>


        </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.events.index', $society->id) }}" class="btn btn-default">Cancel</a>
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

    $("#startdate").datepicker({
        numberOfMonths: 2,
        format: 'yyyy/mm/dd',
        startDate:'+0d',
        
    });

    $("#enddate").datepicker({ 
        numberOfMonths:2,
        format: 'yyyy/mm/dd',
        startDate:'+0d',
        
    });  

    $('.timepicker').timepicker({
      showInputs: false,
    });

  });

    $('#select_all').click(function ()
    {
        $('#parent_filter_select2 > option').prop('selected', 'selected');
        $('#parent_filter_select2').trigger('change');
        $('#remove_all').show();
        $(this).hide();
    });
    
    $('#remove_all').click(function ()
    {
        $('#parent_filter_select2 > option').prop('selected', false);
        $('#parent_filter_select2').trigger('change');
        $('#select_all').show();
        $(this).hide();
    });

    
    $("#enddate").change(function () {
        var startDate = document.getElementById("startdate").value;
        var endDate = document.getElementById("enddate").value;

        if ((Date.parse(startDate) > Date.parse(endDate))) {
            alert("End date should be greater than Start date");
            document.getElementById("enddate").value = "";
        }
    });

});
  let getTime = (m) => {
                 return m.minutes() + m.hours() * 60;
  }

  $("body").on("change","#endtime", function(){

        let timeFrom = $('input[name=starttime]').val().trim(),
            timeTo = $('input[name=endtime]').val().trim();
            timeFrom = moment(timeFrom, 'hh:mm a');
            timeTo = moment(timeTo, 'hh:mm a');
            if(timeFrom.length==0)
            {                            
            }
            else
            {
                            if (getTime(timeFrom) > getTime(timeTo)) {
                               $('.end_error').css('display','block');
                               $('.end_error').css('font-size','13px');
                               $('.end_error').css('color','red');
                               $('.end_error').text('End time should not be greater than start time.');
                               $('.start_error').css('display','none');
                            }
                            else 
                            {
                                $('.end_error').css('display','none');
                                $('.start_error').css('display','none');
                            }
            }
  });

  $("body").on("change","#starttime", function(){

                        let timeFrom =   $('input[name=starttime]').val().trim(),
                            timeTo   =   $('input[name=endtime]').val().trim();
                        timeFrom = moment(timeFrom, 'hh:mm a');
                        timeTo = moment(timeTo, 'hh:mm a');
                        console.log(timeFrom);
                        console.log(timeTo);
                        if(timeTo.length==0)
                        {
                         
                        }
                        else
                        {
                            if (getTime(timeFrom) > getTime(timeTo) ) {
                              
                              $('.start_error').css('display','block');
                              $('.start_error').css('font-size','13px');
                              $('.start_error').css('color','red');
                              $('.start_error').text('Start time should be less than End time.');
                              $('.end_error').css('display','none');
                            }   
                            else 
                            {
                                $('.start_error').css('display','none');
                                $('.end_error').css('display','none');
                                
                            }
                        }
  });

</script>
@endsection
