@extends('layouts.admin')

@section('content')

<section class="content-header">
  <h1>
    Societies
    <!-- <small>advanced tables</small> -->
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Guardes</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Guard List
          </h3>
          <a href="{{ route('admin.guardes.add') }}" class="btn btn-primary pull-right">Add Guard+</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">


          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Image</th>
              <th>Name</th>
              <?php if(!auth()->user()->hasRole('society_admin')){ ?>
              <th>Society</th>
              <?php } ?>
              <th>Contact</th>
              <th>Pin</th>
              <th>Gender</th>

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
          var doctordatatable = $('#societies_datatable').DataTable({
              responsive: true,
              "processing": true,
              "ajax": "{{ route('admin.guardes.array') }}",
              "language": {
                  "emptyTable": "No Guard available"
              },
              "order": [[0, "desc"]],
          });
          doctordatatable.columns([0]).visible(false, false);
      }); // end of document ready
  </script>
  
  @endsection
