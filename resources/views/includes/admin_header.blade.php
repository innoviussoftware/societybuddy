<header class="main-header">
  <!-- Logo -->
  <a href="{{ route('admin.dashboard') }}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>S</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>{{ env('APP_NAME') }}</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    @role(['admin','sub_admin'])
    <!-- Sidebar toggle button-->
    <a href="{{ env('APP_URL') }}/admin_assets/#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    @endrole
    @role(['society_admin'])
    <?php $notificationcount=App\SocietySettings::where('society_id',auth()->user()->society_id)->first();
      $module = explode(',', $notificationcount->module_name);
      ?>
    <ul class="nav navbar-nav">
      <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-users" aria-hidden="true"></i> Manage Society
         <span class="caret"></span></a>
         <ul class="dropdown-menu">
           <li><a href="{{ route('admin.societies.edit',auth()->user()->society_id) }}">Manage Society Details</a></li>
           <li><a href="{{ route('admin.societies.buildings.add',auth()->user()->society_id) }}">Manage Building</a></li>
           <li><a href="{{ route('admin.societies.adminusers.index',auth()->user()->society_id) }}">Manage Admins</a></li>
           <li><a href="{{ route('admin.guardes.index') }}">Manage Guards</a></li>
           <li><a href="{{ route('admin.societies.commitees.index',auth()->user()->society_id) }}">Manage Commitee</a></li>
           <li><a href="{{ route('admin.societies.notices.index',auth()->user()->society_id) }}">Manage Notices</a></li>
           <li><a href="{{ route('admin.societies.events.index',auth()->user()->society_id) }}">Manage Events</a></li>
           <li><a href="{{ route('admin.societies.circulars.index',auth()->user()->society_id) }}">Manage Circulars</a></li>
           <?php if(in_array("Maintenance", $module)){?>
           <li><a href="{{ route('admin.societies.maintencepayment.index',auth()->user()->society_id) }}">Manage Maintenance</a></li>
         <?php }?>
         </ul>
      </li>
      
      <li><a href="{{ route('admin.societies.members.index',auth()->user()->society_id) }}"><i class="fa fa-building" aria-hidden="true"></i> Manage Residents</a></li>
      <li><a href="{{ route('admin.societies.serviceprovider.index',auth()->user()->society_id) }}"><i class="fa fa-cogs" aria-hidden="true"></i> Manage Domestic Helpers</a></li>
      
      <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Manage Reports
         <span class="caret"></span></a>
         <ul class="dropdown-menu">
           <li><a href="{{ route('admin.societies.reports.index',auth()->user()->society_id) }}">Current Visitor</a></li>
           <li><a href="{{ route('admin.societies.visitorreports.index',auth()->user()->society_id) }}">Visitor Report</a></li>
           <li><a href="{{ route('admin.societies.tenantreports.index',auth()->user()->society_id) }}">Tenant Directory</a></li>
           <li><a href="{{ route('admin.societies.helpers.index',auth()->user()->society_id) }}">Domestic helper Report</a></li>
         </ul>
      </li>

      <li class="dropdown">
         <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-file-text" aria-hidden="true"></i> More
         <span class="caret"></span></a>
         <ul class="dropdown-menu">
           <li><a href="{{ route('admin.societies.helpdesk.index',auth()->user()->society_id) }}"><i class="fa fa-home" aria-hidden="true"></i> Help desk</a></li>
           <li><a href="{{ route('admin.societies.polls.index',auth()->user()->society_id) }}"><i class="fa fa-cog " aria-hidden="true"></i> Polls</a></li>
           <li><a href="{{ route('admin.societies.amenties.index',auth()->user()->society_id) }}"><i class="fa fa-info-circle" aria-hidden="true"></i> Amenities</a></li>
           <?php if(in_array("Maintenance", $module)){?>
           <li><a href="{{ route('admin.societies.maintence.index',auth()->user()->society_id) }}"><i class="fa fa-cog" aria-hidden="true"></i> Maintenance Settings</a></li>
         <?php }?>
         </ul>
      </li>

    </ul>
    @endrole

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        @role(['society_admin'])
        <?php $notificationcount=App\Notification::where('type',4)->where('isread','=','0')->count();
        $notification=App\Notification::where('type',4)->where('isread','=','0')->with('user')->get();?>
        @if(count($notification) > 0)
                                
        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{$notificationcount}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php if($notificationcount !='0'){?>You have {{$notificationcount}} notifications<?php }?></li>
              <li>
                <ul class="menu">
                  @foreach($notification as $b)
                  <li>
                    <a href="{{ route('admin.member.viewnotification',[auth()->user()->society_id,$b->id]) }}">
                      <i class="fa fa-user"></i> {{isset($b->user->name)?$b->user->name:''}} have registered successfully 
                    </a>
                  </li>
                  @endforeach
                </ul>
              </li>
              <!-- <li class="footer"><a href="{{ route('admin.societies.members.index',auth()->user()->society_id) }}">View all</a></li> -->
            </ul>
        </li>
        
         @else
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{$notificationcount}}</span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">
                  <li>
                    <a href="#">
                      Notification Not Found
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        @endif
        @endrole

        @role(['admin','sub_admin'])
        <?php $referralcount=App\Referral::where('isread','=','0')->count();
        $referral=App\Referral::where('isread','=','0')->with('user')->get();?>
            @if(count($referral) > 0)
                      <li class="dropdown notifications-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">{{$referralcount}}</span>
                          </a>
                          <ul class="dropdown-menu">
                            <li class="header"><?php if($referralcount !='0'){?>You have {{$referralcount}} notifications<?php }?></li>
                            <li>
                              <ul class="menu">
                                @foreach($referral as $r)
                                <li>
                                  <a href="{{ route('admin.referral.viewnotification',$r->id) }}">
                                    {{isset($r->user->name)?$r->user->name:''}} has referral for {{isset($r->society_name)?$r->society_name:''}}.  
                                  </a>
                                </li>
                                @endforeach
                              </ul>
                            </li>
                          </ul>
                      </li>
            @else
                      <li class="dropdown notifications-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">0</span>
                          </a>
                          <ul class="dropdown-menu">
                            <li>
                              <ul class="menu">
                                <li>
                                  <a href="#">
                                    Notification Not Found
                                  </a>
                                </li>
                              </ul>
                            </li>
                          </ul>
                      </li>
            @endif
            @endrole

        <li class="dropdown user user-menu">
          <a href="{{ env('APP_URL') }}/admin_assets/#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ env('APP_URL') }}/admin_assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
            <span class="hidden-xs">{{ auth()->user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{ env('APP_URL') }}/admin_assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

              <p>
                {{ auth()->user()->name }}
                @if(auth()->user()->created_at)
                  <small>Member since {{ date("M j, Y", strtotime(auth()->user()->created_at)) }}</small>
                @endif
              </p>
            </li>
            <!-- Menu Body -->
            <!-- <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </div>
            </li> -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
      </ul>
    </div>
  </nav>
</header>
