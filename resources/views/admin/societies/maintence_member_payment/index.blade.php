@extends('layouts.admin')

@section('content')
<style type="text/css">
      .payment_building{
        border-radius: 50%;        
        padding: 1em 1em;
        border: 1px solid #00c0ef;
        text-align: center;
        margin-bottom: 1.5em;
        cursor: pointer;
      }
      .memberlist{
        padding: 1em 1em;
        border: 1px solid #3c8dbc;
        text-align: center;
        margin-bottom: 1.5em;
        cursor: pointer;
      }
</style>

<section class="content-header">
  <h1>
    Maintenance
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Maintenance Payment</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        <div class="box-body">
          <input type="hidden" name="society_id" value="{{$society->id}}" id="society_id">
         
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3></h3>
                    <p>Total Pending :</p>
                  </div>
                  <div class="inner">
                    <h3></h3>
                    <p></p>
                  </div>
              </div>
            </div>

            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                  <div class="inner">
                    <h3></h3>
                    <p>Total Collected :</p>
                  </div>
                  <div class="inner">
                    <h3></h3>
                    <p></p>
                  </div>
              </div>
            </div>

          </div>
            
          
            <div class="row">
              @foreach($buildings as $b)
              <div class="col-xs-1">
                <div class="payment_building viewmember" id="{{isset($b->id)?$b->id:''}}">
                  <span><a href="#">{{isset($b->name)?$b->name:''}}</a></span>
                </div>
              </div>
               @endforeach
            </div>
          <!--   <div class="memberlistdetails">
            </div> -->
            
            <table id="societies_datatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Building No</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
            </table>
        </div>

      </div>
      
    </div>
</section>

@endsection

@section('custom_js')
<script>
$(document).ready(function(){
   

  $("body").on("click",".viewmember",function(){
    var society_id=$('#society_id').val();
    var buildings_id=$(this).attr('id'); 
    getMembers(buildings_id,society_id);
  });

  $(".datepicker").datepicker({
        numberOfMonths: 2,
        format: 'yyyy/mm/dd',
        //startDate:'+0d',
  });

  $("body").on("click",".optradio",function(){
    var val=$(this).val();
    if(val=='Cheque' )
    {
      $('#ChequeNo').show();
       $('#WireNo').hide();
    }
    else if(val=='Wire')
    {
      $('#WireNo').show();
      $('#ChequeNo').hide(); 
    }
    else
    {
      $('#ChequeNo').hide(); 
      $('#WireNo').hide();
    }
  });

 

  function getMembers(id,society_id){
    $.ajax({
      url:"{{ env('APP_URL') }}/admin/societies/members/byBuilding/"+id+"/"+society_id,
      method:"get",
      success:function(e){
        var html = '';
        for(var i = 0; i < e.length; i++){
          html += '<div class="col-xs-2"><div class="memberlist" id="paymentform" data-toggle="modal" data-target="#modal-default"  data-id="'+e[i].id+'"><div><span><b>'+e[i].building.name+'-'+e[i].flat.name+'</b></span></div><div><span><b>'+e[i].user.name+'</b></span></div></div></div></div>';
        }
        $(".memberlistdetails").html(html);
      }
    });
  }

});
</script>
@endsection
