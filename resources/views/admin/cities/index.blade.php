@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Cities
    <small>advanced tables</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Cities</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Cities List
          </h3>
          <a href="{{ route('admin.cities.add') }}" class="btn btn-primary pull-right">Add City+</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


          <table id="cities_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>City</th>
              <th>Created At</th>
              <th>Action</th>
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
      $(document).ready(function () {
          var doctordatatable = $('#cities_datatable').DataTable({
              responsive: true,
              "processing": true,
              "ajax": "{{ route('admin.cities.array') }}",
              "language": {
                  "emptyTable": "No city available"
              },
              "order": [[0, "desc"]],
          });
          doctordatatable.columns([0]).visible(false, false);
      }); // end of document ready
  </script>
  @endsection
