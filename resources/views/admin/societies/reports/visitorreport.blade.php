@extends('layouts.admin')

@section('content')
<style type="text/css">
  .callout{
    height: 202px;
  }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<section class="content-header">
  <h1>
    Visitor Reports
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="#">Visitor Reports</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">

        @role(['admin','sub_admin'])
        <ul class="nav nav-tabs">
           <li ><a href="{{ route('admin.societies.edit', $society->id) }}">Society Details</a></li>
           <li  ><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
           <li ><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
           <li class="active"><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
        </ul>
       @endrole
       <div class="row">
        <div class="col-sm-12" style="padding-top: 0.5em;margin-left: 0.5em;">
             
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <!-- <div class="col-sm-2">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;" id="building">
                            <option value="">Select Buildings</option>
                            @foreach($buildings as $b)
                            <option value="{{$b->name}}" data-id="{{$b->id}}">{{$b->name}}</option>
                            @endforeach
                          </select>
                        </div> -->

                        <!-- <div class="col-sm-2">
                          <select class="form-control" name="buildings" data-placeholder="Select a Member"
                              style="width: 100%;" id="flats">
                            <option value="">Select Flat</option>
                          </select>
                        </div> -->

                        <!-- <div class="col-sm-2">
                          <select class="form-control" name="guards" data-placeholder="Select a Member"
                              style="width: 100%;" id="guards">
                            <option value="">Select Guards</option>
                            @foreach($guard as $g)
                            <option value="{{$g->id}}">{{$g->name}}</option>
                            @endforeach
                          </select>
                        </div> -->

                        <div class="col-sm-2" style="margin-right: 1em;">
                          <div class="form-group">
                            <input type="text" id="min" name="min" class="form-control datepicker"  placeholder="In Date From:">
                          </div>
                        </div>


                        <div class="col-sm-2">
                         <div class="form-group">
                            <input type="text" id="max" name="max" class="form-control datepicker"  placeholder="In Date To:">
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
               <!--  <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                <button type="reset" class="btn default can-btn reset-btn">Reset</button> -->
        </div>
      </div>
        <div class="box-body">
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Guard Name</th>
              <th>Visitor Name</th>
              <th>Flat</th>
              <th>Member Name</th>
              <th>Status</th>
              <th>In Time</th>
              <th>Out Time</th>
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
   $.fn.dataTable.ext.search.push(
    function (settings, data, dataIndex) {
        var FilterStart = $('#min').val();
        var FilterEnd = $('#max').val();
        var DataTableStart = data[6].trim();
        var DataTableEnd = data[6].trim();
        if (FilterStart == '' || FilterEnd == '') {
            return true;
        }
        if (DataTableStart >= FilterStart && DataTableEnd <= FilterEnd)
        {
            return true;
        }
        else {
            return false;
        }
        
    });

$(document).ready(function(){

      //laod datepicker
      $('.datepicker').datepicker({
          format: 'dd-mm-yyyy',
          startDate: '-3d'
      });


      //load  data

      var conversion_datatable = $('#societies_datatable').DataTable({
          processing: true,
          serverSide: false, 
          ajax: {
            url: "{{ route('admin.societies.visitorreports', $society->id) }}",
            type: 'GET',
          },
          "order": [[0, "desc"]]
      });
      console.log(conversion_datatable.columns([1]));
      conversion_datatable.columns([0]).visible(false, false);

      // var Table  = $('#societies_datatable').DataTable();
      $('#min').change(function (e) {
          conversion_datatable.draw();

      });
      $('#max').change(function (e) {
            conversion_datatable.draw();
      });

});
</script>
<!-- <script>
  $("#startdate").datepicker({
        numberOfMonths: 2,
        format: 'yyyy/mm/dd',
        // startDate:'+0d',
  });

  $("#enddate").datepicker({ 
        numberOfMonths:2,
        format: 'yyyy/mm/dd',
        // startDate:'+0d',
  });  

  $("#enddate").change(function () {
      var startDate = document.getElementById("startdate").value;
      var endDate = document.getElementById("enddate").value;

      if ((Date.parse(startDate) > Date.parse(endDate))) {
          alert("End date should be greater than Start date");
          document.getElementById("enddate").value = "";
      }
  });

$(document).ready(function(){

  $("body").on('change','#building',function (){
      var id = $(this).find(':selected').data('id');
      getFlats(id);
  });

   var conversion_datatable= $('#societies_datatable').DataTable({
          processing: true,
          serverSide: false, 
          ajax: {
              url: "{{ route('admin.societies.visitorreports', $society->id) }}",
              type: 'GET',
          },
         "order": [[0, "desc"]],
        

  });
    conversion_datatable.columns([0]).visible(false, false);

  // var conversion_datatable= $('#societies_datatable').DataTable({
  //         processing: true,
  //         serverSide: true, 
  //         ajax: {
  //             url: "{{ route('admin.societies.visitorreports', $society->id) }}",
  //             type: 'GET',
  //             data: function (d) {
  //               d.startdate = $('.startdate').val();
  //               d.enddate = $('.enddate').val();
  //               d.building_id= $('#building').val();
  //               d.flat_id= $('#flats').val();
  //               d.guard_id= $('#guards').val();
  //             }
  //         },
  //       "order": [[0, "desc"]],
  //       "pagingType": "full_numbers"

  // });
  // // table.columns([0]).visible( false );

  //   $('#btnFiterSubmitSearch').click(function(){    
  //      $('#societies_datatable').DataTable().draw(true);
  //   });
   
  //   $('body').on('click','.reset-btn',function (e) {
  //           $('.startdate').val('')
  //           $('.enddate').val('');
  //           $('#building').val('');
  //           $('#flats').val('');
  //           $('#guards').val('');
  //          conversion_datatable.ajax.reload(null, false);
  //   });

  function getFlats(id){
    $.ajax({
      url:"{{ env('APP_URL') }}/admin/societies/flats/byBuilding/"+id,
      method:"get",
      success:function(e){

        var html = "<option>Select Flat</option>";
        for(var i = 0; i < e.length; i++){
          html += "<option  value='"+e[i].name+"'>"+e[i].name+"</option>";
        }
        $("#flats").html(html);
      }
    });
  }


});
</script> -->

@endsection