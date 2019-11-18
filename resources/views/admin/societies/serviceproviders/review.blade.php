@extends('layouts.admin')

@section('content')
<?php 
if(isset($helpers))
{
    $stars = DB::table('reveiws')
             ->where('reveiws.helper_id',isset($helpers->id)?$helpers->id:'')
             ->avg('ratings');
}
?>
<section class="content">
<div class="col-md-12">
          <!-- Box Comment -->

          <div class="box box-widget">
              <div class="box-header with-border">
                <div class="row">
                    <div class="col-md-1">
                      <div class="user-block">
                        <?php if(isset($helpers->photos)){?>
                          <img class="img-circle" src="{{ env('APP_URL_STORAGE').$helpers->photos}}" alt="User Image" style="width: 130px !important;height: 100px !important;">
                        <?php }else{?>  
                          <img class="img-circle" src="{{asset('no-image.png')}}" alt="User Image" style="width: 130px !important;height: 100px !important;">
                        <?php }?>
                      </div>
                    </div>

                    <div class="col-md-10">
                        <div class="user-block" style="padding: 0.2em 1.5em;">
                          <span class="username"><a>{{isset($helpers->name)?$helpers->name:''}}</a></span>
                          <span class="username"><a>{{isset($helpers->mobile)?$helpers->mobile:''}}</a></span>
                          <span class="username">
                              @while($stars>0)
                                @if($stars >0.5)
                                    <i class="fa fa-star"></i>
                                @else
                                    <i class="fa fa-star-half"></i>
                                @endif
                                @php $stars--; @endphp
                              @endwhile
                          </span>
                         
                        </div>
                    </div>
                  </div>
              </div>
            
            <div class="box-footer box-comments">
                <div class="box-comment">
                  <h4>Members</h4>
                </div>
                <div class="row">
                  @foreach($username as $u)
                  <div class="col-md-2">
                    <div class="btn btn-app" style="width: 150px;height: auto;">
                        <p style="text-align: left;font-weight: bold;">{{isset($u->user->name)?$u->user->name:''}}</p>
                        <p style="text-align: left;font-weight: bold;">{{isset($u->building->name)?$u->building->name:''}}-{{isset($u->flat->name)?$u->flat->name:''}}</p>
                    </div>
                  </div>
                  @endforeach
                  
                </div>
                
            </div>



            <div class="box-footer box-comments">
                <div class="box-comment">
                  <h4>Reviews</h4>
                </div>
                <div class="row">
                    <div class="col-md-1">
                      <?php if(isset($u->user->image)){?>
                        <img class="img-circle" src="{{ env('APP_URL_STORAGE').$u->user->image}}" alt="User Image" style="width: 100px !important;height: 50px !important;">
                        <?php }else{?>  
                        <img class="img-circle" src="{{asset('no-image.png')}}" alt="User Image" style="width: 100px !important;height: 50px !important;">
                        <?php }?>
                    </div>

                    <div class="col-md-2">
                        <div class="comment-text">
                             <p style="text-align: left;font-weight: bold;">{{isset($u->user->name)?$u->user->name:''}}</p>
                              <p style="text-align: left;font-weight: bold;">{{isset($u->building->name)?$u->building->name:''}}-{{isset($u->flat->name)?$u->flat->name:''}}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        
                        <div class="comment-text">
                          It is a long established fact that a reader will be distracted
                          by the readable content of a page when looking at its layout.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="comment-text">
                              
                        </div>
                    </div>
                </div>

            </div>


          </div>
        </div>
      </section>
@endsection