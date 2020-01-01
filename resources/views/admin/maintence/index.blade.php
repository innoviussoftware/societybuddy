@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Maintence
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Maintenance</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Maintenance List
          </h3>
          <a href="{{ route('admin.societies.maintence.add',$society->id) }}" class="btn btn-primary pull-right">Add Maintenance+</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


          <table id="areas_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <tr>
              <th>ID</th>
              <th>Building</th>   
              <th>Maintenance Amount</th>
              <th>Tenant Amount</th>
              <th>Payment Mode</th>
              <th>Monthly Date</th>
              <th>Yearly Date</th>
              <th>Penalty</th>
              <th>Action</th>
            </tr>
            </tr>
            </thead>
            <tbody>

            </tbody>

          </table>
        </div>
        <!-- /.box-body -->
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
    function confirm(url, name) {
    bootbox.confirm({
        title: '',
        message: '<h5><i class="fa fa-remove text-danger"></i>&nbsp;&nbsp;' + name + '</h5>',
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Confirm'
            }
        },
        callback: function (result) {
            if (result == true) {
                window.location.replace(url);
            }
        }
    });
}
      $(document).ready(function () {
          var doctordatatable = $('#areas_datatable').DataTable({
              responsive: true,
              "processing": true,
              "ajax": "{{ route('admin.societies.arrayMaintence',$society->id) }}",
              "language": {
                  "emptyTable": "No Maintence available"
              },
              "order": [[0, "desc"]],
          });
          doctordatatable.columns([0]).visible(false, false);
      }); // end of document ready
  </script>
  @endsection
