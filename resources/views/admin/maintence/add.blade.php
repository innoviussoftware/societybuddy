@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    
    <small>Maintence</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.notices.index', $society->id) }}">Maintence</a></li>
    <li><a href="#">Add</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <form action="{{ route('admin.societies.maintence.store', $society->id) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="box-header">
          <h3 class="box-title">Add Maintence</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-6">
              <!-- <div class="form-group">
                <label>Building</label>
                <button type="button"   class="btn btn-primary" style="float: right;" id="select_all">Select All</button>
                 <button type="button"  class="btn btn-danger" style="display: none;float: right;" id="remove_all">Remove All</button>
                  <select id="parent_filter_select2" class="form-control select2" name="building_id[]" id="building" required data-placeholder="Select a Building" multiple="multiple">
                  @foreach($buildings as $b)
                    <option value="{{ $b->id }}" {{ ($b->id == old('building_id')) ? "selected" : "" }} >{{ $b->name }}</option>
                  @endforeach
                </select>
                
              </div> -->
              
              <div class="form-group">
                <label >(A) Maintance Amount</label>
              </div>
              <div class="form-group">
                <input type="text" name="amount" class="form-control" placeholder="Enter Maintance amount" value="{{ old('title') }}" required>
               
              </div>

                <div class="radio">
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios3" value="monthly" class="radiobutton">
                      Monthly 
                    </label>
                    <label>
                      <input type="radio" name="optionsRadios" id="optionsRadios3" value="yearly" class="radiobutton">
                      Yearly 
                    </label>
                </div>

                <div class="form-group">
                    <label>
                      <input type="checkbox" id="sameamount" name="sameamount"> Maintance same for tenants
                    </label>
                </div>
                   
              <div class="form-group"  id="tenantamount">
                <input type="text" name="amounttenant" class="form-control" placeholder="Enter Tenant amount" value="{{ old('title') }}" >
              </div>

              <div class="form-group">
                <label >(B) Cut off date for Payment</label>
              </div>

              <div class="form-group">
                <input type="text" name="monthly" class="form-control monthlydate" placeholder="Enter Monthly" value="{{ old('title') }}" required id="monthlydate" style="width: 200px;display: none;">
              </div>

              <div class="form-group">
                <input type="text" name="yearly" class="form-control yearlydate" placeholder="Enter Yearly" value="{{ old('title') }}" required id="yearlydate" style="width: 200px;display: none;">
              </div>
              <div class="form-group">
                <label >(C) Penalty</label>
              </div>

              <div class="input-group">
                  <span class="input-group-addon">Rs</span>
                  <input type="text" class="form-control" name="penalty" value="" placeholder="Price (days)" style="width: 140px;">
              </div>
              
            </div>
          </div>


        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="{{ route('admin.societies.notices.index', $society->id) }}" class="btn btn-default">Cancel</a>
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
  $('.select2').select2()

  $("body").on('change','#building',function (){
    var id  = $(this).val();
    getFlats(id);
  });

  // $('#startdate').datepicker({
  //     format: "dd",
  //   viewMode: "days", 
  //   minViewMode: "days"

  // })

  $('#yearlydate').datepicker({
      format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
  })

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

    $('#sameamount').click(function ()
    {
        if($('input[name="sameamount"]').is(':checked'))
        {
            $('#tenantamount').hide();
        }
        else
        {
            $('#tenantamount').show();
        }
    });

    $('.radiobutton').click(function ()
    {      
      var radioValue = $("input[name='optionsRadios']:checked").val();
       
        if(radioValue=='monthly')
        {
            $('.monthlydate').show();
            $('.yearlydate').hide();
        }
        if(radioValue=='yearly')
        {
            $('.monthlydate').hide();
            $('.yearlydate').show();
        }
    });

    

</script>
@endsection
