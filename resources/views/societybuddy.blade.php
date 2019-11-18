
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Society Buddy" />
	<meta name="robots" content="Society Buddy" />
	<meta name="title" content="Best Building, Society and Apartment Management App in India" />
	<meta name="description" content="Society Buddy is a one-stop building management application designed to provide a hassle-free, user-friendly affordable Building, Society and Apartment Management via Mobile App." />
	<meta name="keywords" content="Apartment Management App in India, Society Management Application, Housing Society Management App Ahmedabad, Building Management App India" />
	<meta property="og:title" content="Society Buddy" />
	<meta property="og:description" content="Society Buddy is now serving and accomplishing phenomenon work to help an apartment society in many ways to have a wonderful life" />
	<meta property="og:image" content="social-image.png" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON -->
	  <link rel="icon" type="images/png" sizes="32x32" href="{{ env('APP_URL') }}/new_front/images/favicon.png">

	
	<!-- PAGE TITLE HERE -->
	<title>Society Buddy - SIMPLIFY YOUR LIVING !!</title>

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
	
	<!-- STYLESHEETS -->
	<link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/new_front/css/plugins1.css">
	<link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/new_front/css/style1.css">
	<link class="skin"  rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/new_front/css/skin-1.css">
	<link  rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/new_front/css/templete.css">
	<link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/new_front/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="{{ env('APP_URL') }}/new_front/css/lobibox.min.css">
	
	<style type="text/css">
		{
		 background: url("{{ env('APP_URL') }}/front_assets/icons/9.png") no-repeat center center;
		}
		.error{ color:red; } 
		.icon-bx-md 
		{
			background-color: #fff !important;
		}
		.featuricon1{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/1.png") no-repeat center center;
		    height: 180px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon2{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/2.png") no-repeat center center;
		    height: 57px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon3{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/3.png") no-repeat center center;
		    height: 57px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon4{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/4.png") no-repeat center center;
		   height: 180px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon5{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/5.png") no-repeat center center;
		    height: 180px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon6{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/6.png") no-repeat center center;
		    height: 57px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon7{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/7.png") no-repeat center center;
		     height: 180px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}

		.featuricon8{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/8.png") no-repeat center center;
		     height: 180px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon9{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/9.png") no-repeat center center;
		    height: 180px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon10{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/10.png") no-repeat center center;
		    height: 57px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
		.featuricon11{
		    background: url("{{ env('APP_URL') }}/front_assets/icons/11.png") no-repeat center center;
		    height: 57px;
		    width: 66px;
		    display: block;
		    margin: 0 auto;
		}
	</style>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js"></script>
</head>
<body id="bg">
<div id="loading-area"></div>
<div class="page-wraper">
	<!-- header -->
    <header class="site-header header header-transparent">
		<!-- main header -->
        <div class="sticky-header main-bar-wraper navbar-expand-lg">
            <div class="main-bar clearfix onepage">
                <div class="container clearfix">
                    <!-- website logo -->
                    <div class="logo-header mostion">
						<a href="{{route('index')}}"><img height="40" src="{{ env('APP_URL') }}/new_front/images/logo.png" alt="SocietyBuddy"></a>
					</div>
                    <!-- nav toggle button -->
                    <button class="navbar-toggler collapsed navicon justify-content-end" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
						<span></span>
						<span></span>
						<span></span>
					</button>
                    <!-- main nav -->
                    <div class="header-nav navbar-collapse collapse navbar myNavba justify-content-end" id="navbarNavDropdown">
						<ul class="nav navbar-nav">
							<li class="active"><a href="#app-banner" class="scroll">Home</a></li>
							<li class=""><a href="#about-us" class="scroll">About</a></li>
							<li class=""><a href="#features" class="scroll">Features</a></li>
							<li class=""><a href="#services" class="scroll">Services</a></li>
							<li class=""><a href="#screenshots" class="scroll">Screenshots</a></li>
							<!-- <li class=""><a href="#pricing" class="scroll">Pricing</a></li> -->
							<!-- <li class=""><a href="#news" class="scroll">Our Team</a></li> -->
							<li class=""><a href="#footer" class="scroll">Contact Us</a></li>
							<li class=""><a href="#mobile-download" class="site-button scroll" ><span class="text-white">Download</span></a></li>
						</ul>
					</div>
                </div>
            </div>
        </div>
        <!-- main header END -->
    </header>
    <!-- header END -->
    <!-- Content -->
    <div class="page-content">
		<!-- Slider -->
        <div class="main-slider style-two app-banner" id="app-banner" >
			<div class="moving-bg"></div>
			<div class="container">
				<div class="row align-items-center full-height">
					<div class="col-md-7 col-lg-8 col-xl-7 dis-tbl align-self-center">
						<div class="dis-tbl-cell">
							<h2 class="text-uppercase">SIMPLIFY YOUR<br> LIVING !!</h2>
							<p>Society Buddy simplifies life for everyone in a gated community, from residents and management committee members to security guards, society managers and even for daily domestic helpers.</p>
							<p><b style="color: #1b8cbe;font-size: 21px;">Modernize .Enhance & .Upgrade to .Secure </b></p>
							<div class="">
								<a target="_blank" href="https://play.google.com/store/apps/details?id=com.societybuddy" class="site-button radius-xl m-r10"><i class="fa fa-play m-r5"></i> Google Play</a>
								<a target="_blank" href="https://apps.apple.com/in/app/society-buddy/id1483762111" class="site-button radius-xl outline"><i class="fa fa-apple m-r5"></i> App Store</a>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-lg-4 col-xl-5 slide-img">
						<img src="{{ env('APP_URL') }}/new_front/images/pic1.png" alt="SocietyBuddy Slider"/>	
					</div>
				</div>
            </div>         
		</div>        
		<!-- Slider END -->
        <!-- About App Info Us -->
		<div class="section-full bg-white content-inner app-about about-us raindrop" id="about-us">
			<div class="container">
				<div class="row equal-wraper">
					<div class="col-lg-6 col-md-5 equal-col dis-tbl m-b30">
						<div class="dis-tbl-cell">
							<img src="{{ env('APP_URL') }}/new_front/images/pic1.jpg" alt="SocietyBuddy App"/>
						</div>
					</div>
					<div class="col-lg-6 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">EASY & SECURE </h1>
								<div class="dlab-separator bg-primary"></div>
								<p>SECURED & EASY SOLUTION FOR YOUR SOCIETY TO MANAGEMENT DAILY NEED FOR ANY GATED COMMUNITY.</p>
							</div>		
							<ul class="list-check primary">
								<li>Value Addition propelling your Brand</li>
								<li>Highest ROI On Your Investment</li>
								<li>Stay Connected Society Buddies</li>								
							</ul>
							<div class="m-t30">
								<a target="_blank" href="https://play.google.com/store/apps/details?id=com.societybuddy" class="site-button radius-xl m-r10"><i class="fa fa-play m-r5"></i> Google Play</a>
								<a target="_blank" href="https://apps.apple.com/in/app/society-buddy/id1483762111" class="site-button radius-xl outline"><i class="fa fa-apple m-r5"></i> App Store</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- About App Info END -->
		<!-- Mobile App -->
		<div class="section-full content-inner-2 bg-img-fix overlay-primary-dark mobile-app " id="mobile-app" style="background-image: url({{ env('APP_URL') }}/new_front/images/background/bg11.jpg);">
			<div class="moving-bg"></div>
			<div class="container">
				<div class="row">
					<div class="col-lg-6 text-white app-content">
						<h2 class="h2 text-uppercase">Best app for Society Management System</h2>
						<p>Society Buddy Building Management System Easier management of building through the Best Mobile App</p>
						<div class="m-b60">
							<a href="{{ env('APP_URL') }}/new_front/brochure/Society Buddy Brochure.pdf" target="_blank" class="site-button radius-xl outline white m-r10"><i class="fa fa-download m-r5"></i> Download Brochure</a>
						</div>
					</div>
					<div class="col-lg-6">
						<img src="{{ env('APP_URL') }}/new_front/images/mobile-app.png" alt="Mobile App"/>
					</div>
				</div>
			</div>
		</div>
		<!-- Mobile App END -->
		<!-- App Features -->
		<div class="section-full bg-white content-inner raindrop" id="features" >
			<div class="container">
				<div class="section-head text-center">
					<h2 class="h2 text-uppercase">Society Buddy FEATURES</h2>
					<div class="dlab-separator bg-primary"></div>
					<!-- <p>There are some good features in this app like easy navigate, read clear, quick search. This app is friendly, bold and unbelievably easy to use.</p> -->
				</div>
				<div class="row equal-wraper">
					<div class="col-lg-4 col-md-6 col-sm-6 equal-col dis-tbl">
						<div class="dis-tbl-cell">
							<div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50">
								<div class="icon-bx-md radius bg-primary"><span class="icon-cell text-white"><i class="featuricon1"></i></span></div>
								<div class="icon-content p-r40">
									<h5 class="dlab-tilte">Visitor Managements</h5>
									<div class="dlab-separator-outer ">
										<div class="dlab-separator bg-primary style-liner"></div>
									</div>
									<p>Ensure your guests feel welcome. With a simple passcode, your
										guests are through to your door instantly. No need for manual register. </p>
								</div>
							</div>
							<div class="icon-bx-wraper bx-style-2 m-b30 p-a20  right m-r50">
								<div class="icon-bx-md radius bg-primary"> <span class="icon-cell text-white"><i class="featuricon7"></i></span> </div>
								<div class="icon-content p-r40">
									<h5 class="dlab-tilte">Payments Managements </h5>
									<div class="dlab-separator-outer ">
										<div class="dlab-separator bg-primary style-liner"></div>
									</div>
									<p>A comprehensive platform on which the society can manage its accounts and residents can track and get reminders to pay their maintenance bills</p>
								</div>
							</div>
							<div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50">
								<div class="icon-bx-md radius bg-primary"> <span class="icon-cell text-white"><i class="featuricon5"></i></span> </div>
								<div class="icon-content p-r40">
									<h5 class="dlab-tilte ">Emergency Alerts </h5>
									<div class="dlab-separator-outer ">
										<div class="dlab-separator bg-primary style-liner"></div>
									</div>
									<p>Trigger an alarm on the guard device when any emergency is there like a fire, stuck in lift etc. Get The Help Instantly. </p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 text-center hidden-sm equal-col dis-tbl d-none d-lg-block">
						<div class="worker dis-tbl-cell"> <img src="{{ env('APP_URL') }}/new_front/images/iphone_big-1.png" alt="Iphone View"> </div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6 equal-col dis-tbl">
						<div class="dis-tbl-cell">
							<div class="icon-bx-wraper bx-style-2 m-b30 p-a20 left m-l50">
								<div class="icon-bx-md radius bg-primary"> <span class="icon-cell text-white"><i class="featuricon9"></i></span> </div>
								<div class="icon-content p-l40">
									<h5 class="dlab-tilte ">Events & Announcements</h5>
									<div class="dlab-separator-outer ">
										<div class="dlab-separator bg-primary style-liner"></div>
									</div>
									<p>No more need to worry about a missed notice from the society office. All notices/circulars are served to your mobile App so you can be prepared with the schedule of your society activities.</p>
								</div>
							</div>
							<div class="icon-bx-wraper bx-style-2 m-b30 p-a20 left m-l50">
								<div class="icon-bx-md radius bg-primary"> <span class="icon-cell text-white"><i class="featuricon4"></i></span> </div>
								<div class="icon-content p-l40">
									<h5 class="dlab-tilte ">Child Security</h5>
									<div class="dlab-separator-outer ">
										<div class="dlab-separator bg-primary style-liner"></div>
									</div>
									<p>Make it easy for security to ask for your permission in case your child is attempting to exit the premises, with or without an escort. </p>
								</div>
							</div>
							<div class="icon-bx-wraper bx-style-2 p-a20 left m-l50">
								<div class="icon-bx-md radius bg-primary"> <span class="icon-cell text-white"><i class="featuricon8"></i></span> </div>
								<div class="icon-content p-l40">
									<h5 class="dlab-tilte ">Amenities Booking</h5>
									<div class="dlab-separator-outer ">
										<div class="dlab-separator bg-primary style-liner"></div>
									</div>
									<p>There’s no need for forms or applications. All residents can see the booking calendar & book amenities using the app.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
		<!-- App Features End -->
		<!-- Stats -->
		<div class="section-full content-inner bg-img-fix overlay-primary-dark text-white" style="background-image: url(images/background/bg21.jpg);">
			<div class="container">	
				<div class="section-head text-black text-center m-t30">
					<h2 class="h2 text-uppercase">About Society Buddy</h2>
					<div class="dlab-separator bg-white"></div>
					<p>India's first exclusive mobile App for gated communities having most edge cutting security features and a robust society management features.</p> 
					<p>Enroll your Society/Apartment Complex today and start using its awesome features.</p>
				</div>
				<!-- <div class="row p-t30 p-b10">
					<div class="col-lg-3 col-md-6 col-sm-6 m-b30">
						<div class="stats text-center">
							<div class="m-b30"><i class="flaticon-file font-45"></i></div>
							<span>Builders	</span> 
							<div class="counter font-45 font-weight-800 m-b5 m-t30">10</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 m-b30">
						<div class="stats text-center">
							<div class="m-b30"><i class="flaticon-team font-45"></i></div>
							<span>Societies</span> 
							<div class="counter font-45 font-weight-800 m-b5 m-t30">25</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 m-b30">
						<div class="stats text-center">
							<div class="m-b30"><i class="flaticon-downloading-from-smartphone font-45"></i></div>
							<span>App Downloads</span> 
							<div class="counter font-45 font-weight-800 m-b5 m-t30">635</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-6 m-b30">
						<div class="stats text-center">
							<div class="m-b30"><i class="flaticon-bar-chart font-45"></i></div>
							<span>Positive Ratings</span> 
							<div class="counter font-45 font-weight-800 m-b5 m-t30">635</div>
						</div>
					</div>
				</div> -->
			</div>
		</div>
		<!-- Stats END -->			
		<!-- App Services -->			
		<div class="section-full bg-white content-inner" id="services" style="background-image: url(images/background/bg33.jpg); background-repeat:no-repeat; background-position:bottom; background-size:100%;">
			<div class="container">
				<div class="section-head text-center">
					<h2 class="h2 text-uppercase">Society Buddy SERVICES</h2>
					<div class="dlab-separator bg-primary"></div>
					<!-- <p>You should check out Rise, our beautifully simple app. Just download it once from the App Store and it will automatically install on all your devices.</p> -->
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="icon-bx-wraper center p-a30 box-fill m-b30" data-tilt>
							<div class="icon-lg text-primary m-b20"> <span class="icon-cell"><i class="flaticon-diamond text-gd"></i></span> </div>
							<div class="icon-content">
								<div class="dlab-separator bg-primary"></div>
								<h4 class="dlab-tilte">Creative Design</h4>
								<p>Easy & Creative design makes it fun to use society buddy app on daily basis. </p>
								
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="icon-bx-wraper center p-a30 box-fill m-b30" data-tilt>
							<div class="icon-lg text-primary m-b20"> <span class="icon-cell"><i class="flaticon-downloading-from-smartphone text-gd"></i></span> </div>
							<div class="icon-content">
								<div class="dlab-separator bg-primary"></div>
								<h4 class="dlab-tilte">Easy Installation </h4>
								<p>It takes only 24 hrs to setup your community on Society Buddy platform.</p>
								
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="icon-bx-wraper center p-a30 box-fill m-b30" data-tilt>
							<div class="icon-lg  text-primary m-b20"> <span class="icon-cell"><i class="flaticon-rocket-ship text-gd"></i></span> </div>
							<div class="icon-content">
								<div class="dlab-separator bg-primary"></div>
								<h4 class="dlab-tilte">Extra Booster </h4>
								<p>Get insights from recorded data and boost society functioning by 2x within short period of time.  </p>
								
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="icon-bx-wraper center p-a30 box-fill m-b30" data-tilt>
							<div class="icon-lg  text-primary m-b20"> <span class="icon-cell"><i class="flaticon-smartphone text-gd"></i></span> </div>
							<div class="icon-content">
								<div class="dlab-separator bg-primary"></div>
								<h4 class="dlab-tilte">Flexible Interface </h4>
								<p>Don’t miss a single thing happening in your community. Everything is on your fingertip within a seconds.</p>
								
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="icon-bx-wraper center p-a30 box-fill m-b30" data-tilt>
							<div class="icon-lg  text-primary m-b20"> <span class="icon-cell"><i class="flaticon-devices text-gd"></i></span> </div>
							<div class="icon-content">
								<div class="dlab-separator bg-primary"></div>
								<h4 class="dlab-tilte">Notification </h4>
								<p>All this data is statistically integrated which is easy for you to use. All your data is safe.</p>
								
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6 col-sm-6">
						<div class="icon-bx-wraper center p-a30 box-fill m-b30" data-tilt>
							<div class="icon-lg  text-primary m-b20"> <span class="icon-cell"><i class="flaticon-chat text-gd"></i></span> </div>
							<div class="icon-content ">
								<div class="dlab-separator bg-primary"></div>
								<h4 class="dlab-tilte">Notification </h4>
								<p>All this data is statistically integrated which is easy for you to use. All your data is safe.</p>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- App Services END -->
		<!-- Download -->
		<div class="section-full bg-img-fix overlay-primary-dark mobile-download" id="mobile-download" style="background-image: url(images/background/bg44.jpg);">
			<div class="moving-bg"></div>
            <div class="container">
				<div class="row">
					<div class="col-lg-12 content-inner text-white text-center">
						<h2 class="text-uppercase m-t0">download Now</h2>
						<p>Download the App Free for Android and iOS</p>
						<div class="m-t40">
							<ul class="app-icon"> 
								<li class="flaticon-android"></li>
								<li class="flaticon-apple"></li>
							</ul>
						</div>
						<div class="m-t40">
							<a target="_blank" href="https://play.google.com/store/apps/details?id=com.societybuddy" class="site-button radius-xl outline white m-r10"><i class="flaticon-google-play m-r5"></i> Google Play</a>
							<a target="_blank" href="https://apps.apple.com/in/app/society-buddy/id1483762111" class="site-button radius-xl outline white "><i class="flaticon-apple m-r5"></i> App Store</a>
						</div>
						
					</div>
				</div>
			</div> 
			<div class="mobile-out">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 text-center">
							<img src="{{ env('APP_URL') }}/new_front/images/mobile-flat.png" alt="App"/>
						</div>
					</div>
				</div> 
			</div> 
		</div>
		<!-- Download END -->
		<!-- App Screenshots -->
		<div class="section-full content-inner bg-white owl-btn-center-lr owl-nav-lr raindrop" id="screenshots">
			<div class="container">
				<!-- Nav tabs -->
				<div class="section-head text-center">
					<h2 class="h2 text-uppercase">App Screenshots</h2>
					<div class="dlab-separator bg-primary"></div>
					<p>MANAGE SOCIETY SMARTLY !</p>
				</div>
				<div class="row ">
				  	<!-- Tab panes -->
			      <div class="col-lg-12 app-gallery ">
							<div class="app-carousel owl-loaded owl-theme owl-carousel">
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/1.jpg" alt="Screenshot 1"/>
								</div>
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/2.jpg" alt="Screenshot 2"/>
								</div>
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/3.jpg" alt="Screenshot 3"/>
								</div>
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/4.jpg" alt="Screenshot 4"/>
								</div>
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/5.jpg" alt="Screenshot 5"/>
								</div>
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/6.jpg" alt="Screenshot 6"/>
								</div>
								<div class="item">
									<img src="{{ env('APP_URL') }}/new_front/images/app/7.jpg" alt="Screenshot 6"/>
								</div>
							</div>
						</div>
				</div>
			</div>
		</div>
		<!-- App Screenshots END -->
		<!-- Play Video -->
		<!-- <div class="section-full overlay-primary-dark content-inner-1 bg-img-fix play-video" style="background-image:url(images/background/bg5.jpg);">
			<div class="container">
				<div class="text-white text-center m-t30">
					<a class="flaticon-play-button font-45 popup-youtube video" href="https://www.youtube.com/watch?v=Zm5Ncgg7XiE">
						<span>Play Video</span>
					</a>
				</div>
			</div>
		</div> -->
		<!-- Play Video END -->
		<!-- Pricing Table -->
		<!-- <div class="section-full content-inner app-gallery bg-white owl-btn-center-lr owl-nav-lr raindrop" id="pricing">
			<div class="container">
				<div class="section-head text-center">
					<h2 class="h2 text-uppercase">PRICING TABLE</h2>
					<div class="dlab-separator bg-primary"></div>
					<p>We have combined our most requested services into terrific packages for you to choose from us. A fully integrated payment system. Pricing subject to volume.</p>
				</div>
				<div class="row">
					<div class="col-sm-6 col-md-6 col-lg-4 m-b30">
						<div class="pricingtable-wrapper">
							<div class="pricingtable-inner text-left ">
								
								<div class="pricingtable-price"> 
									<h4 class="m-t0 m-b5">BASIC</h4>
									<p class="m-b0">Appdent Pricing Table Design.</p>
								</div>
								<ul class="pricingtable-features">
									<li><i class="fa fa-check"></i> Basic profile</li>
									<li><i class="fa fa-check"></i> Communication</li>
									<li><i class="fa fa-check"></i> Gallery</li>
									<li><i class="fa fa-check"></i> Vehicle</li>
									<li><i class="fa fa-check"></i> Event</li>
									<li><i class="fa fa-check"></i> Announcement</li>
									<li><i class="fa fa-check"></i> Staff Availability Check</li>
									<li><i class="fa fa-check"></i> Complaints</li>
									<li><i class="fa fa-check"></i> Voting</li>
									<li><i class="fa fa-check"></i> Emergency/SOS</li>
									<li><i class="fa fa-close"></i> Facility Availability check & Booking</li>
									<li><i class="fa fa-close"></i> Automated Bill and accountings</li>
									<li><i class="fa fa-close"></i> Balance sheet</li>
									<li><i class="fa fa-close"></i> Employee payroll</li>
									<li><i class="fa fa-close"></i> Staff attendance</li>
									<li><i class="fa fa-close"></i> Customized user creation</li>
									<li><i class="fa fa-close"></i> Customized Payment gateway</li>
									<li><i class="fa fa-close"></i> Visitor/Gatekeeper Management</li>
									<li><i class="fa fa-close"></i> Auto visitor verification</li>
									<li><i class="fa fa-close"></i> Video calls</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-4 m-b30">
						<div class="pricingtable-wrapper">
							<div class="pricingtable-inner text-left">
								
								<div class="pricingtable-price"> 
									<h4 class="m-t0 m-b5">PREMIUM</h4>
									
									<p class="m-b0">Appdent Pricing Table Design.</p>
								</div>
								<ul class="pricingtable-features">
									<li><i class="fa fa-check"></i> Basic profile</li>
									<li><i class="fa fa-check"></i> Communication</li>
									<li><i class="fa fa-check"></i> Gallery</li>
									<li><i class="fa fa-check"></i> Vehicle</li>
									<li><i class="fa fa-check"></i> Event</li>
									<li><i class="fa fa-check"></i> Announcement</li>
									<li><i class="fa fa-check"></i> Staff Availability Check</li>
									<li><i class="fa fa-check"></i> Complaints</li>
									<li><i class="fa fa-check"></i> Voting</li>
									<li><i class="fa fa-check"></i> Emergency/SOS</li>
									<li><i class="fa fa-check"></i> Facility Availability check & Booking</li>
									<li><i class="fa fa-check"></i> Automated Bill and accountings</li>
									<li><i class="fa fa-check"></i> Balance sheet</li>
									<li><i class="fa fa-check"></i> Employee payroll</li>
									<li><i class="fa fa-close"></i> Staff attendance</li>
									<li><i class="fa fa-close"></i> Customized user creation</li>
									<li><i class="fa fa-close"></i> Customized Payment gateway</li>
									<li><i class="fa fa-close"></i> Visitor/Gatekeeper Management</li>
									<li><i class="fa fa-close"></i> Auto visitor verification</li>
									<li><i class="fa fa-close"></i> Video calls</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-lg-4">
						<div class="pricingtable-wrapper">
							<div class="pricingtable-inner text-left active">
								
								<div class="pricingtable-price"> 
									<h4 class="m-t0 m-b5">ULTIMATE</h4>
									<p class="m-b0">Appdent Pricing Table Design.</p>
								</div>
								<ul class="pricingtable-features">
									<li><i class="fa fa-check"></i> Basic profile</li>
									<li><i class="fa fa-check"></i> Communication</li>
									<li><i class="fa fa-check"></i> Gallery</li>
									<li><i class="fa fa-check"></i> Vehicle</li>
									<li><i class="fa fa-check"></i> Event</li>
									<li><i class="fa fa-check"></i> Announcement</li>
									<li><i class="fa fa-check"></i> Staff Availability Check</li>
									<li><i class="fa fa-check"></i> Complaints</li>
									<li><i class="fa fa-check"></i> Voting</li>
									<li><i class="fa fa-check"></i> Emergency/SOS</li>
									<li><i class="fa fa-check"></i> Facility Availability check & Booking</li>
									<li><i class="fa fa-check"></i> Automated Bill and accountings</li>
									<li><i class="fa fa-check"></i> Balance sheet</li>
									<li><i class="fa fa-check"></i> Employee payroll</li>
									<li><i class="fa fa-check"></i> Staff attendance</li>
									<li><i class="fa fa-check"></i> Customized user creation</li>
									<li><i class="fa fa-check"></i> Customized Payment gateway</li>
									<li><i class="fa fa-check"></i> Visitor/Gatekeeper Management</li>
									<li><i class="fa fa-check"></i> Auto visitor verification</li>
									<li><i class="fa fa-check"></i> Video calls</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<!-- Pricing Table END -->
		<!-- Testimoniay -->
		<div class="section-full overlay-primary-dark content-inner-1 bg-img-fix" id="testimonial" style="background-image:url(images/background/bg5.jpg);">
			<div class="moving-bg"></div>
			<div class="container">
				<div class="section-head text-white text-center m-t30">
					<h2 class="h2 text-uppercase">Happy Clients</h2>
					<div class="dlab-separator bg-primary"></div>
					<p>We are extremely happy with our results because our clients happy with our app. Here are some of our clients who have expressed their views.</p>
				</div>
				<div class="section-content">
					<div class="testimonial-one owl-loaded owl-theme owl-none owl-carousel owl-dots-white-full">
						<div class="item">
							<div class="testimonial-1 testimonial-bg">
								<div class="testimonial-pic quote-left radius shadow"><img src="{{ env('APP_URL') }}/new_front/images/testimonials/pic1.jpg" width="100" height="100" alt="testimonial"></div>
								<div class="testimonial-text">
									<p>Society Buddy is an Extremely Fast, User Friendly, Efficient and wonderful app which makes Management of the Residential Complex so easy and effortless.</p>
								</div>
								<div class="testimonial-detail"> <strong class="testimonial-name">Vipul Raval</strong> <span class="text-white"></span> </div>
							</div>
						</div>
						
						
						<div class="item">
							<div class="testimonial-1 testimonial-bg">
								<div class="testimonial-pic quote-left radius shadow"><img src="{{ env('APP_URL') }}/new_front/images/testimonials/user.png" width="100" height="100" alt="testimonial"></div>
								<div class="testimonial-text">
									<p>Society Buddy helped us become a Completely Transparent Flat Owners Association. Residents are now expressing their views and come forward Voluntary for Community Initiatives. The cost and effort of Management Committee has also come down.</p>
								</div>
								<div class="testimonial-detail"> <strong class="testimonial-name">Malav Shah </strong> <span class="text-white"></span> </div>
							</div>
						</div>
						<div class="item">
							<div class="testimonial-1 testimonial-bg">
								<div class="testimonial-pic quote-left radius shadow"><img src="{{ env('APP_URL') }}/new_front/images/testimonials/user.png" width="100" height="100" alt="testimonial"></div>
								<div class="testimonial-text">
									<p>It is very good app. It maintains all the details of flat, visitors records, maintenance and many more. It is very useful and user friendly app.</p>
								</div>
								<div class="testimonial-detail"> <strong class="testimonial-name">Nishat Dave </strong> <span class="text-white"></span> </div>
							</div>
						</div>
				
					</div>
				</div>
			</div>
		</div>
		<!-- Testimoniay END -->
		<!-- Our Latest Blog -->
		<!-- <div class="section-full bg-white content-inner-1 dlab-blog-1 owl-btn-center-lr owl-nav-lr raindrop" id="news"> 
			<div class="container">
				<div class="section-head text-center">
					<h2 class="h2 text-uppercase">Our Team</h2>
					<div class="dlab-separator bg-primary"></div>
				</div>
				<div class="section-content">
					<div class="blog-carousel mfp-gallery owl-loaded owl-theme owl-carousel gallery owl-dots-style">
						<div class="item">
							<div class="ow-blog-post date-style-2">
								<div class="ow-post-media dlab-img-effect zoom-slow"> <img style="height:350px;" src="images/team/sachin.jpg" alt="Sachin"> </div>
								<div class="ow-post-info bg-dark-black text-center">
									
									<div class="ow-post-title">
										<h5 class="post-title"> <a href="#" title="Sachin Sehgal">Sachin Sehgal</a> </h5>
									</div>
									<div class="ow-post-text">
										<p>Founder & CEO</p>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="ow-blog-post date-style-2">
								<div class="ow-post-media dlab-img-effect zoom-slow"> <img style="height:350px;" src="images/team/mehul.jpg" alt="Mehul"> </div>
								<div class="ow-post-info bg-dark-black text-center">
									
									<div class="ow-post-title">
										<h5 class="post-title"> <a href="#" title="Mehul Patel">Mehul Patel</a> </h5>
									</div>
									<div class="ow-post-text">
										<p>Founder & CTO</p>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="ow-blog-post date-style-2">
								<div class="ow-post-media dlab-img-effect zoom-slow"> <img style="height:350px;" src="images/team/asif.jpg" alt="Asif"> </div>
								<div class="ow-post-info bg-dark-black text-center">
									
									<div class="ow-post-title">
										<h5 class="post-title"> <a href="#" title="Asif Hingora">Asif Hingora</a> </h5>
									</div>
									<div class="ow-post-text">
										<p>Tech. Head</p>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="ow-blog-post date-style-2">
								<div class="ow-post-media dlab-img-effect zoom-slow"> <img style="height:350px;" src="images/team/ankit.jpg" alt="Ankit"> </div>
								<div class="ow-post-info bg-dark-black text-center">
									
									<div class="ow-post-title">
										<h5 class="post-title"> <a href="#" title="Ankit Hingora">Ankit Rana</a> </h5>
									</div>
									<div class="ow-post-text">
										<p>Android Developer</p>
									</div>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="ow-blog-post date-style-2">
								<div class="ow-post-media dlab-img-effect zoom-slow"> <img style="height:350px;" src="images/team/ajit.jpg" alt="Ajit"> </div>
								<div class="ow-post-info bg-dark-black text-center">
									
									<div class="ow-post-title">
										<h5 class="post-title"> <a href="#" title="Ajit">Ajit Maurya</a> </h5>
									</div>
									<div class="ow-post-text">
										<p>Android Developer</p>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div> -->
		<!-- Our Latest Blog END -->
	</div>
	<!-- Footer -->
    <footer class="site-footer trans-footer bg-img-fix bg-img-fix" id="footer" style="background-image:url({{ env('APP_URL') }}/new_front/images/background/bg7.jpg); background-size:cover; background-position:bottom; ">
		<div class="moving-bg"></div>
        <div class="footer-top">
            <div class="container">
                <div class="row">
                		<div class="col-lg-12 text-center m-b10">
                				 <h2 class="text-white font-weight-300">Contact With Us</h2>
                    </div>
                		<div class="col-lg-6 text-center m-b30" style="padding-top: 30px;">
                				<h4 class="text-white"><i class="fa fa-phone"></i> +91 99986 43562</h4>
                				<h4 class="text-white"><i class="fa fa-phone"></i> +91 99789 09750</h4>
                				<h4 class="text-white"><i class="fa fa-phone"></i> +91 82004 65248</h4>
                				<h4 class="text-white"><i class="fa fa-envelope"></i>  societybuddy@gmail.com</h4>
                				
                				<h5 class="text-white"><i class="fa fa-home"></i> 
                				 911 ,Pratiksha Complex Mahalaxmi Five Road, <br>Paldi,  Ahmedabad,<Br> Gujarat - 380007, India</h5>
                				
                    </div>
                    <div class="col-lg-6 text-center m-b30">
						<div class="max-w600 m-auto m-t30 subscribe-form">
							<div class="alert alert-success" id="success" style="display: none;">
								<p id="successtext" style="text-align: center;font-size: 1em;;padding: 0.5em 0.5em;font-weight: bold;"></p>
							</div>
							<div class="alert alert-error" id="error" style="display: none;background-color: red;">
								<p id="errortext" style="text-align: center;font-size: 1em;;padding: 0.5em 0.5em;font-weight: bold;"></p>
							</div>
							<form id="contact_us" role="search"  method="post">
								{{ csrf_field() }}
								<div class="input-group" style="margin-bottom: 20px;">
									<input required="" maxlength="20" name="name" class="form-control text-capitalize" placeholder="Name" type="text"/>
								</div>
								<div class="input-group" style="margin-bottom: 20px;">
									<input required="" id="mobile" maxlength="13" name="mobile" class="form-control" placeholder="Mobile Number" type="text"/>
								</div>
								<div class="input-group" style="margin-bottom: 20px;">
									<input required="" maxlength="50" name="email" class="form-control" placeholder="Email Address" type="email"/>
								</div>
								<div class="input-group" style="margin-bottom: 20px;">
									<textarea required=""  maxlength="200" name="message" class="form-control" placeholder="Message" type="text" id="message"/></textarea>
								</div> 
								<div class="input-group" style="margin-bottom: 20px;">
									<input type="submit" id="send_form" class="site-button radius-xl" value="Submit" class="form-control" style="color: #ffff;width: 160px;" size="50">
									
								</div>
								
							</form>
							<div class="input-group" id='loader' style='display: none;'>
  <img src="{{ env('APP_URL') }}/new_front/reload.gif" width='32px' height='32px'>
</div>

						</div>
                    </div>
                    

                </div>
            </div>
        </div>
        <!-- footer bottom part -->
        <div class="footer-bottom text-center">
            <div class="container p-tb10">
				
                <div class="row">
                    <div class="col-lg-12 col-sm-12"> 
						<div class="widget-link "> 
							<ul>
								<li><a href="{{route('index')}}">Home</a></li> 
								<li><a href="{{route('privacypolicy')}}">Privacy Policy</a></li> 
							</ul>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 m-t20">
						<ul class="list-inline">
							<li><a target="_blank" href="https://www.facebook.com/societybuddy/" class="site-button circle-sm"><i class="fa fa-facebook"></i></a></li>
							<li><a target="_blank" href="#" class="site-button circle-sm"><i class="fa fa-linkedin"></i></a></li>
							<li><a target="_blank" href="https://www.instagram.com/societybuddy/" class="site-button circle-sm"><i class="fa fa-instagram"></i></a></li>
							<li><a target="_blank" href="https://twitter.com/societybuddy_in" class="site-button circle-sm"><i class="fa fa-twitter"></i></a></li>
						</ul>
					</div>
				</div>
            </div>
        </div>
    </footer>
    <!-- Footer END-->
    <!-- scroll top button -->
    <button class="scroltop fa fa-chevron-up" ></button>
</div>
<!-- JavaScript  files ========================================= -->
<script data-cfasync="false" src="{{ env('APP_URL') }}/new_front/js/email-decode.min.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/jquery.min.js"></script><!-- JQUERY.MIN JS -->
<script  src="{{ env('APP_URL') }}/new_front/js/jquery-ui.min.js"></script><!-- JQUERY.MIN JS -->
<script src="{{ env('APP_URL') }}/new_front/js/bootstrap.min.js"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ env('APP_URL') }}/new_front/js/bootstrap-select.min.js"></script><!-- FORM JS -->
<script src="{{ env('APP_URL') }}/new_front/js/jquery.bootstrap-touchspin.js"></script><!-- FORM JS -->
<script src="{{ env('APP_URL') }}/new_front/js/magnific-popup.js"></script><!-- MAGNIFIC-POPUP JS -->
<script src="{{ env('APP_URL') }}/new_front/js/waypoints-min.js"></script><!-- WAYPOINTS JS -->
<script src="{{ env('APP_URL') }}/new_front/js/counterup.min.js"></script><!-- COUNTERUP JS -->
<script src="{{ env('APP_URL') }}/new_front/js/imagesloaded.js"></script><!-- MASONRY  -->
<script src="{{ env('APP_URL') }}/new_front/js/masonry-3.1.4.js"></script><!-- MASONRY  -->
<script src="{{ env('APP_URL') }}/new_front/js/masonry.filter.js"></script><!-- MASONRY  -->
<script src="{{ env('APP_URL') }}/new_front/js/owl.carousel.js"></script><!-- OWL  SLIDER  -->
<script src="{{ env('APP_URL') }}/new_front/js/dz.carousel.js"></script><!-- SORTCODE FUCTIONS  -->
<script src="{{ env('APP_URL') }}/new_front/js/custom.js"></script><!-- CUSTOM FUCTIONS  -->
<!-- SORTCODE FUCTIONS -->
<script  src="{{ env('APP_URL') }}/new_front/js/tilt.jquery.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/raindrops.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/templete.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/particles.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.owl-carousel').carousel({
      interval: 1200
    })
  });
</script>
<script src="{{ env('APP_URL') }}/new_front/js/lobibox.min.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/notifications.min.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/notification-custom-script.js"></script>

<script type="text/javascript">

 $("#mobile").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
         // Allow: Ctrl+A, Command+A
        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
         // Allow: home, end, left, right, down, up
        (e.keyCode >= 35 && e.keyCode <= 40)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
</script>


<!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142423220-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-142423220-1');
</script> -->

<script async src="https://www.googletagmanager.com/gtag/js?id=G-Y298L7XSFF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Y298L7XSFF');
</script>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5d9d8dcedb28311764d7fdf7/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

<script type="text/javascript">
	$.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

	

$('#contact_us').submit(function (e) {

        e.preventDefault(); //**** to prevent normal form submission and page reload

		var details = '<?php echo URL::to('save-form'); ?>';

		var name = $("input[name=name]").val();

        var mobile = $("input[name=mobile]").val();

        var email = $("input[name=email]").val();

        var message = $("#message").val();

            $.ajax({
                type : 'POST',
                url : details,
                data : {
                    "_token": "{{ csrf_token() }}",
       			name:name, mobile:mobile, email:email,message:message,
                },
                beforeSend: function(){
					    // Show image container
					    $("#loader").show();
   				},
                success: function(result){
                    
                    //  alert(result.status);
                    // var jsonConvertedData = JSON.stringify(result); 
                    // var obj = JSON.parse(result);
                    // console.log(obj);
                   
                    if(result.status==true)
                    {
                    
                    	$('#success').show();
                    	$('#successtext').text(result.msg);
                    	$('#error').hide();
                    }
                    else
                    {
                    	$('#error').show();
                    	$('#errortext').text(result.msg);
                    	$('#success').hide();
                    }
                    
                },
                complete:function(data){
					    // Hide image container
					    $("#loader").hide();
   				},
                error: function (xhr, ajaxOptions, thrownError) {
                    

                }
            });
});

</script>

</body>

</html>
