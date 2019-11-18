@extends('layouts.admin')

@section('content')
<section class="content-header">
  <h1>
    Commitee
    <small>{{ $society->name }}</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ route('admin.societies.index') }}">Societies</a></li>
    <li><a href="{{ route('admin.societies.edit', $society->id) }}">{{ $society->name }}</a></li>
    <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
    <li><a href="#">Commitee</a></li>
  </ol>
</section>

<section class="content">
  <div class="row">

    <div class="col-xs-12">
      <div class="box">
        @role(['admin','sub_admin'])
        <ul class="nav nav-tabs">
         <li><a href="{{ route('admin.societies.edit', $society->id) }}">Society Details</a></li>
         <li><a href="{{ route('admin.societies.buildings.add', $society->id) }}">Buildings</a></li>
         <li><a href="{{ route('admin.societies.adminusers.index', $society->id) }}">Admin Users</a></li>
         <li><a href="{{ route('admin.societies.members.index', $society->id) }}">Members</a></li>
         <li class="active"><a href="{{ route('admin.societies.commitees.index', $society->id) }}">Members</a></li>
       </ul>
       @endrole

        <div class="box-body">

          <div class="post">
            <div class="row">
                <div class="col-sm-6">
                  <div class="col-sm-3 col-md-3">
                          <h4><b>Chairman: </b></h4>
                      </div>
                      <div class="col-sm-9 col-md-9">
                        @if($chairman)
                        <div class="user-block post">
                           <img class="img-circle img-bordered-sm" src="{{isset($chairman->image)?env('APP_URL_STORAGE').$chairman->image:''}}" alt="" style="margin-right: 2em;width: 110px !important;height: 100px !important;">
                            <div class="box-comment">
                                <div class="comment-text">
                                      <span class="username">
                                        {{isset($chairman->name)?$chairman->name:'-'}}
                                      </span>
                                      <span class="username">
                                        (M) {{isset($chairman->phone)?$chairman->phone:'-'}}
                                      </span>
                                      <span class="username">
                                       {{isset($chairman->member->building->name)?$chairman->member->building->name:'-'}}-{{isset($chairman->member->flat->name)?$chairman->member->flat->name:''}}
                                      </span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="user-block post" style="margin-top:13px;">
                           <a  href="{{ route('admin.societies.commitees.edit', $society->id) }}">Committee is not formed for your society, create committee now</a>
                        </div>
                        @endif
                    </div>
                </div>
                @if($secretory)
                <div class="col-sm-6">
                  <div class="col-sm-3 col-md-3">
                        <h4><b>Secretory: </b></h4>
                    </div>
                    <div class="col-sm-9 col-md-9">
                     
                      <div class="user-block">
                         <img class="img-circle img-bordered-sm" src="{{isset($secretory->image)?env('APP_URL_STORAGE').$secretory->image:''}}" alt="" style="margin-right: 2em;width: 110px !important;height: 100px !important;">

                            <div class="box-comment">
                                <div class="comment-text">
                                      <span class="username">
                                      {{isset($secretory->name)?$secretory->name:'-'}}
                                      </span>
                                      <span class="username">
                                      (M) {{isset($secretory->phone)?$secretory->phone:'-'}}
                                      </span>
                                      <span class="username">
                                       {{isset($secretory->member->building->name)?$secretory->member->building->name:'-'}}-{{isset($secretory->member->flat->name)?$secretory->member->flat->name:''}}
                                      </span>
                                </div>
                            </div>
                      </div>
                      
                    </div>
                </div>
                @endif
            </div>

            <div class="row">
              @if($jt_secretory)
                  <div class="col-sm-6">
                         <div class="col-sm-3 col-md-3">
                          <h4><b>Jt. Secretory: </b></h4>
                        </div>

                        <div class="col-sm-9 col-md-9">
                          
                          <div class="user-block post">
                             <img class="img-circle img-bordered-sm" src="{{isset($jt_secretory->image)?env('APP_URL_STORAGE').$jt_secretory->image:''}}" alt="" style="margin-right: 2em;width: 110px !important;height: 100px !important;">
                              <div class="box-comment">
                                  <div class="comment-text">
                                        <span class="username">
                                          {{isset($jt_secretory->name)?$jt_secretory->name:'-'}}
                                        </span>
                                        <span class="username">
                                          (M) {{isset($jt_secretory->phone)?$jt_secretory->phone:'-'}}
                                        </span>
                                        <span class="username">
                                          {{isset($jt_secretory->member->building->name)?$jt_secretory->member->building->name:'-'}}-{{isset($jt_secretory->member->flat->name)?$jt_secretory->member->flat->name:''}}
                                        </span>
                                  </div>
                              </div>
                          </div>
                       
                        </div>
                  </div>
                     @endif
                  <div class="col-sm-6">
                    @if($treasurer)
                        <div class="col-sm-3 col-md-3">
                        <h4><b>Treasurer: </b></h4>
                        </div>

                          <div class="col-sm-9 col-md-9">
                            
                            <div class="user-block post">
                               <img class="img-circle img-bordered-sm" src="{{isset($treasurer->image)?env('APP_URL_STORAGE').$treasurer->image:''}}" alt="" style="margin-right: 2em;width: 110px !important;height: 100px !important;">
                                <div class="box-comment">
                                    <div class="comment-text">
                                          <span class="username">
                                            {{isset($treasurer->name)?$treasurer->name:'-'}}
                                          </span>
                                          <span class="username">
                                            (M) {{isset($treasurer->phone)?$treasurer->phone:'-'}}
                                          </span>
                                          <span class="username">
                                            {{isset($treasurer->member->building->name)?$treasurer->member->building->name:'-'}}-{{isset($treasurer->member->flat->name)?$treasurer->member->flat->name:''}}
                                          </span>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                         @endif
                  </div>

            </div>




          </div>
          <a class="btn btn-primary" href="{{ route('admin.societies.commitees.edit', $society->id) }}">+ Edit Commitee</a>
          <br>
          <br>
          <table id="societies_datatable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <!-- <th>Building</th> -->
              <th>Flat</th>

              <!-- <th>Action</th> -->
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

  var doctordatatable = $('#societies_datatable').DataTable({
      responsive: true,
      "processing": true,
      "ajax": "{{ route('admin.societies.arrayCommitees', $society->id) }}",
      "language": {
          "emptyTable": "No any Member available"
      },
      "order": [[0, "desc"]],
  });
  doctordatatable.columns([0]).visible(false, false);
});
</script>
@endsection
