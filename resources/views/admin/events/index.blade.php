@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Events
    <small>advanced tables</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Events</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Events List
          </h3>
          <a href="{{ route('admin.societies.events.add',$society->id) }}" class="btn btn-primary pull-right">Add Events+</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


          <table id="areas_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <tr>
              <th>ID</th>
              <th>Type</th>
              <th>Title</th>
              <th>Description</th>
              <th>Event Start</th>
              <th>Event End</th>
              <th>Building</th>              
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
      $(document).ready(function () {
          var doctordatatable = $('#areas_datatable').DataTable({
              responsive: true,
              "processing": true,
              "ajax": "{{ route('admin.societies.arrayEvents',$society->id) }}",
              "language": {
                  "emptyTable": "No Event available"
              },
              "order": [[0, "desc"]],
          });
          doctordatatable.columns([0]).visible(false, false);
      }); // end of document ready
  </script>
  @endsection
