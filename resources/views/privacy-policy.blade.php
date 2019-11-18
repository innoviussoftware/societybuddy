
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
	<title>Society Buddy </title>

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
						<a href="{{route('index')}}"><img height="40" src="{{ env('APP_URL') }}/new_front/images/logo.png" alt="Fincasys"></a>
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
							<li class="active"><a href="{{route('index')}}" class="scroll">Home</a></li>
							<li class=""><a href="{{route('index')}}/#about-us" class="scroll">About</a></li>
							<li class=""><a href="{{route('index')}}/#features" class="scroll">Features</a></li>
							<li class=""><a href="{{route('index')}}/#services" class="scroll">Services</a></li>
							<li class=""><a href="{{route('index')}}/#screenshots" class="scroll">Screenshots</a></li>
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
		     
		
		<div class="section-full bg-white content-inner app-about about-us raindrop" id="about-us">
			<div class="container">

				<div class="row equal-wraper">
					
					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase"></h1>
								<div class="dlab-separator bg-primary" style="display: none;"></div>
							</div>	
							<p></p>	
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Privacy Policy of Society Buddy/Innovius Software Solutions LLP</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>We are fully aware of the responsibility on our shoulders. The protection and privacy of the information you and your visitors share with us is our highest priority. Through this Privacy Policy, it is our endeavour to always keep you up-to-date with the types of information you will share with us by using our services and how this information will be used.</p>	
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Introduction</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>We are happy to have you here, at http://www.societybuddy.in/ (“Website”). Please note that we provide our services through our website and mobile application, SocietyBuddy (“App”) (Collectively the “Platform”). If You wish to continue using our Platform, you agree to provide us with such information as detailed here and also agree to the terms of this Privacy Policy.</p>	

							<p>This Privacy Policy has been drafted by Us in accordance with the Information Technology Act, 2000 and the Information Technology (Reasonable security practices and procedures and sensitive personal data or information) Rules, 2011. This Privacy Policy is subject to the Terms of Use and constitute a valid and legally binding agreement between You and Us. The Platform and any services thereon are being provided to You as a service on a revocable, limited, non-exclusive, and non-transferable license.</p>	

							<p>For Us to provide You the Services, it is essential for us to collect some basic information about you. Accordingly, you consent to the collection, storage and use of the information that you disclose on our App in accordance with this Privacy Policy. If we decide to change our Privacy Policy, we will try our best to keep you informed, so that you always know the information we collect, how we use it, and the purposes of the same.</p>	

							<p>If you do not agree with this Policy or our Terms of use, please do not continue to use or access our Platforms or any part thereof.</p>
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">The information we collect</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>We collect information from you when you register on our platform, filling out any form. When registering on our platform, fill out any form, as appropriate, you may be asked to enter your: name, e-mail address, residential address, mailing address or phone number and such other data that your society/community may have chosen to record.</p>	

							<p>We are not being responsible for the accuracy or correctness of any such information. You undertake to indemnify Us for any losses that we may suffer due to any claim raised against Us with respect to any data and/or information that is provided by You to Us which are not attributable to negligence, fraud or misrepresentation on Our part.</p>	

							<p>During the registration process, you may decide to not provide such information to Us. In case you choose to decline to submit information on the App, we may not be able to provide certain services to You. Any information provided by You will not be considered as sensitive and confidential if it is freely available and/or accessible in the public domain.</p>	

							<p>You also understand that this service is an extension of the services offered by the Association / Societies (being our Direct Customer) of the Premises, whether registered or unregistered, and accordingly, the data mentioned in point 1st point above, will also be shared with them, as a part our Services, we share the Information with them for recording and security purposes, however, we take no guarantee of the way the information shall or will be used by them.</p>
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Use of Information</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p><u><b>Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the service requested.</u></b></p>	

							<p>Any of the information we collect from you may be used in one of the following ways:</p>	

							<ul class="list-inline">
								<li><i class="fa fa-check"></i> To personalize your experience - your information helps us to better respond to your individual needs.</li>
								<li><i class="fa fa-check"></i> To improve our website/platform - we continually strive to improve our platform offerings based on the information and feedback we receive from you.</li>
								<li><i class="fa fa-check"></i> To improve customer service - your information helps us to more effectively respond to your customer service requests and support needs.</li>
								<li><i class="fa fa-check"></i> To send periodic emails - the email address you provide shall be used to provide periodic updates to you that are related to Society Buddy and its affiliates, partners and nothing else. If at any time you would like to stop receiving future emails, you can email support@societybuddy.in requesting the un-subscription and your email address shall be removed from the distribution list.</li>
							</ul>
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Do we use cookies?</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>On Our Website, we use data collection devices such as “cookies” on certain pages to help analyze our web page flow, measure promotional effectiveness, and promote trust and safety. “Cookies” are small files placed on your hard drive that assist Us in providing our services. We offer certain features that are only available through the use of a “cookie”. you are always free to decline our cookies if Your browser permits, although in that case you may not be able to use certain features on the Platforms. Additionally, you may encounter “cookies” or other similar devices on certain pages of the Website that are placed by third parties. We do not control the use of cookies by third parties.</p>	
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Do we disclose any information to outside parties?</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, Apps, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect ours or others rights, property, or safety. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.</p>	

							<p>Your Information will be shared with another business entity should We (or our assets) plan to merge with, or be acquired by another business entity, or re-organization, amalgamation, restructuring of business. Should such a transaction occur, the new business entity will follow this Privacy Policy.</p>	

							<p><u><b>Your Information will be shared with another business entity should We (or our assets) plan to merge with, or be acquired by another business entity, or re-organization, amalgamation, restructuring of business. Should such a transaction occur, the new business entity will follow this Privacy Policy.</u></b></p>	
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Your Consent</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>By using our site, you consent to this privacy policy.</p>	
						</div>
					</div>

					<div class="col-lg-12 col-md-7 equal-col dis-tbl">
						<div class="dis-tbl-cell p-l40">
							<div class="section-head inner-haed ">
								<h1 class="h2 text-uppercase">Changes to our Privacy Policy</h1>
								<div class="dlab-separator bg-primary"></div>
							</div>	
							<p>If we decide to change our privacy policy, we will post those changes on this page, and/or send an email notifying you of any changes.</p>	
						</div>
					</div>


				</div>
			</div>
		</div>
	
		
		
	
	
	</div>
	<!-- Footer -->
      <footer class="site-footer trans-footer bg-img-fix bg-img-fix" id="footer" style="background-image:url({{ env('APP_URL') }}/new_front/images/background/bg7.jpg); background-size:cover; background-position:bottom; ">
		<div class="moving-bg"></div>
        
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
							<li><a target="_blank" href="#" class="site-button circle-sm"><i class="fa fa-instagram"></i></a></li>
							<li><a target="_blank" href="#" class="site-button circle-sm"><i class="fa fa-twitter"></i></a></li>
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

<script src="{{ env('APP_URL') }}/new_front/js/lobibox.min.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/notifications.min.js"></script>
<script src="{{ env('APP_URL') }}/new_front/js/notification-custom-script.js"></script>


<!--End of Tawk.to Script-->
</body>

</html>
