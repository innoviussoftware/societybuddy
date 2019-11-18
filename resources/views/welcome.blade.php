@extends('layouts.front')

@section('content')
<style type="text/css">
.somefeatures-text p {
    padding: 0;
}
    .somepowerful-panel p {
    font-size: 14px;
    color: #4a4a4a;
    line-height: 22px;
    
}
.somepowerful-panel {
    text-align: center;
}
.somefeatures {
    padding: 0 0px 85px;
    margin: 0 auto;
    max-width: 290px;
}
.somepowerful-panel h2 {
    font-size: 26px;
    line-height: 30px;
    color: #0c2e60;
    font-weight: bold;
    padding: 0 0 10px;
    font-family: "Poppins", sans-serif;
}
.somepowerful-panel p {
    padding: 0 0 20px;
}
.somefeatures-img {
    width: 100px;
    height: 100px;
    border-radius: 100%;
    background: #fff;
    box-shadow: 0 0 20px rgba(38,38,106,0.2);
    margin: 0 auto;
    padding: 20px 0;
}
.somefeatures-text {
    padding: 22px 0 0;
}
.somefeatures-text h3 {
    font-size: 16px;
    line-height: 20px;
    font-weight: 500;
    color: #0c2e60;
    text-transform: uppercase;
    padding: 0 0 12px;
}
.somepowerful-section
{
    background: #fff;
    padding: 75px 0 0;
}
.featuricon1{
    background: url("{{ env('APP_URL') }}/front_assets/icons/1.png") no-repeat center center;
    height: 57px;
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
    height: 57px;
    width: 66px;
    display: block;
    margin: 0 auto;
}
.featuricon5{
    background: url("{{ env('APP_URL') }}/front_assets/icons/5.png") no-repeat center center;
    height: 57px;
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
    height: 57px;
    width: 66px;
    display: block;
    margin: 0 auto;
}

.featuricon8{
    background: url("{{ env('APP_URL') }}/front_assets/icons/8.png") no-repeat center center;
    height: 57px;
    width: 66px;
    display: block;
    margin: 0 auto;
}
.featuricon9{
    background: url("{{ env('APP_URL') }}/front_assets/icons/9.png") no-repeat center center;
    height: 57px;
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
<section class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-xl-6 ">
                    <div class="banner_text">
                        <div class="banner_text_iner">
                            <h5>Every child yearns to learn</h5>
                            <h1>Welcome To Society Buddy</h1>
                            <p>Replenish seasons may male hath fruit beast were seas saw you arrie said man beast whales
                                his void unto last session for bite. Set have great you'll male grass yielding yielding
                                man</p>
                            <!-- <a href="#" class="btn_1">View Course </a> -->
                            <a href="#" class="btn_2">Get Started </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <section class="feature_part" >
     <div class="somepowerful-section" style="">
            <div class="container">
                <div class="somepowerful-panel">
                    <h2 style="font-size: 35px !important;">Some of Society Buddy Features</h2>
                    <p>Society Buddy app is a complete package of innovative features for hassle-free township management</p>
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon1"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Visitor Management</h3>
                                    <p>Ensure your guests feel welcome. With a simple passcode, your guests are through to your door instantly. No need for the register.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon2"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Daily Staff Management</h3>
                                    <p>Receive notiﬁcations when your domestic staff enter the  community, record attendance and ﬁnd best-rated help in the area.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon3"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Delivery Management</h3>
                                    <p>Verify entry of every delivery executive and, if needed, instruct them to leave the package at the gate and pick it up at your convenience.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon4"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Child Security</h3>
                                    <p>Make it easy for security to ask for your permission in case your child  is attempting to exit the premises, with or without an escort. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon5"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Emergency Alert</h3>
                                    <p>Trigger an alarm on the guard device when any emergency will be  come like a ﬁre, stuck in lift etc. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon6"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Overstay Alert</h3>
                                    <p>Automatically trigger an alarm on the guard device if delivery  executives/cabs stay on the premises beyond a certain duration. </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon7"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Payments Management</h3>
                                    <p>A comprehensive platform on which the society can manage its accounts and residents can pay their maintenance bills.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon8"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Amenities Booking</h3>
                                    <p>There’s no need for forms or applications. All residents can book amenities and admit their guests on the app. </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon9"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Complaint Management</h3>
                                    <p>Report grievances to the facility manager in a click; be notiﬁed as soon as a resolution has been found.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon10"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Check Monthly Attendance</h3>
                                    <p>Wouldn’t it be nice if you had a daily record of your staff’s attendance? The numbers are always just a click away on society buddy.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="somefeatures">
                                <div class="somefeatures-img"> <i class="featuricon11"></i> </div>
                                <div class="somefeatures-text">
                                    <h3>Buy Sell Bulletin Board </h3>
                                    <p>Make it easy for you to sell your unwanted items quickly, straight from your phone. Find veriﬁed sellers in your neighbourhood and get to discover great deals.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
 </section>

    <!-- feature_part start-->
   <!--  <section class="feature_part" style="padding-bottom: 2em;">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xl-3 align-self-center">
                    <div class="single_feature_text ">
                        <h2>Awesome <br> Feature</h2>
                        <p>Set have great you male grass yielding an yielding first their you're
                            have called the abundantly fruit were man </p>
                        <a href="#" class="btn_1">Read More</a>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon"><i class="ti-layers"></i></span>
                            <h4>Better Future</h4>
                            <p>Set have great you male grasses yielding yielding first their to
                                called deep abundantly Set have great you male</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part">
                            <span class="single_feature_icon"><i class="ti-new-window"></i></span>
                            <h4>Qualified Trainers</h4>
                            <p>Set have great you male grasses yielding yielding first their to called
                                deep abundantly Set have great you male</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="single_feature">
                        <div class="single_feature_part single_feature_part_2">
                            <span class="single_service_icon style_icon"><i class="ti-light-bulb"></i></span>
                            <h4>Job Oppurtunity</h4>
                            <p>Set have great you male grasses yielding yielding first their to called deep
                                abundantly Set have great you male</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- upcoming_event part start-->

    <!-- learning part start-->
    <!-- <section class="learning_part">
        <div class="container">
            <div class="row align-items-sm-center align-items-lg-stretch">
                <div class="col-md-7 col-lg-7">
                    <div class="learning_img">
                        <img src="{{ env('APP_URL') }}/front_assets/img/learning_img.png" alt="">
                    </div>
                </div>
                <div class="col-md-5 col-lg-5">
                    <div class="learning_member_text">
                        <h5>About us</h5>
                        <h2>Learning with Love
                            and Laughter</h2>
                        <p>Fifth saying upon divide divide rule for deep their female all hath brind Days and beast
                            greater grass signs abundantly have greater also
                            days years under brought moveth.</p>
                        <ul>
                            <li><span class="ti-pencil-alt"></span>Him lights given i heaven second yielding seas
                                gathered wear</li>
                            <li><span class="ti-ruler-pencil"></span>Fly female them whales fly them day deep given
                                night.</li>
                        </ul>
                        <a href="#" class="btn_1">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- learning part end-->

    <!-- member_counter counter start -->
   <!--  <section class="member_counter">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">1024</span>
                        <h4>All Teachers</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">960</span>
                        <h4> All Students</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">1020</span>
                        <h4>Online Students</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single_member_counter">
                        <span class="counter">820</span>
                        <h4>Ofline Students</h4>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- member_counter counter end -->

    <!--::review_part start::-->
  <!--   <section class="special_cource padding_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>popular courses</p>
                        <h2>Special Courses</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="single_special_cource">
                        <img src="{{ env('APP_URL') }}/front_assets/img/special_cource_1.png" class="special_img" alt="">
                        <div class="special_cource_text">
                            <a href="course-details.html" class="btn_4">Web Development</a>
                            <h4>$130.00</h4>
                            <a href="course-details.html"><h3>Web Development</h3></a>
                            <p>Which whose darkness saying were life unto fish wherein all fish of together called</p>
                            <div class="author_info">
                                <div class="author_img">
                                    <img src="{{ env('APP_URL') }}/front_assets/img/author/author_1.png" alt="">
                                    <div class="author_info_text">
                                        <p>Conduct by:</p>
                                        <h5><a href="#">James Well</a></h5>
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <div class="rating">
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/star.svg" alt=""></a>
                                    </div>
                                    <p>3.8 Ratings</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_special_cource">
                        <img src="{{ env('APP_URL') }}/front_assets/img/special_cource_2.png" class="special_img" alt="">
                        <div class="special_cource_text">
                            <a href="course-details.html" class="btn_4">design</a>
                            <h4>$160.00</h4>
                            <a href="course-details.html"> <h3>Web UX/UI Design </h3></a>
                            <p>Which whose darkness saying were life unto fish wherein all fish of together called</p>
                            <div class="author_info">
                                <div class="author_img">
                                    <img src="{{ env('APP_URL') }}/front_assets/img/author/author_2.png" alt="">
                                    <div class="author_info_text">
                                        <p>Conduct by:</p>
                                        <h5><a href="#">James Well</a></h5>
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <div class="rating">
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/star.svg" alt=""></a>
                                    </div>
                                    <p>3.8 Ratings</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_special_cource">
                        <img src="{{ env('APP_URL') }}/front_assets/img/special_cource_3.png" class="special_img" alt="">
                        <div class="special_cource_text">
                            <a href="course-details.html" class="btn_4">Wordpress</a>
                            <h4>$140.00</h4>
                            <a href="course-details.html">  <h3>Wordpress Development</h3> </a> 
                            <p>Which whose darkness saying were life unto fish wherein all fish of together called</p>
                            <div class="author_info">
                                <div class="author_img">
                                    <img src="{{ env('APP_URL') }}/front_assets/img/author/author_3.png" alt="">
                                    <div class="author_info_text">
                                        <p>Conduct by:</p>
                                        <h5><a href="#">James Well</a></h5>
                                    </div>
                                </div>
                                <div class="author_rating">
                                    <div class="rating">
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/color_star.svg" alt=""></a>
                                        <a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/icon/star.svg" alt=""></a>
                                    </div>
                                    <p>3.8 Ratings</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!--::blog_part end::-->

    <!-- learning part start-->
  <!--   <section class="advance_feature learning_part">
        <div class="container">
            <div class="row align-items-sm-center align-items-xl-stretch">
                <div class="col-md-6 col-lg-6">
                    <div class="learning_member_text">
                        <h5>Advance feature</h5>
                        <h2>Our Advance Educator
                            Learning System</h2>
                        <p>Fifth saying upon divide divide rule for deep their female all hath brind mid Days
                            and beast greater grass signs abundantly have greater also use over face earth
                            days years under brought moveth she star</p>
                        <div class="row">
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="learning_member_text_iner">
                                    <span class="ti-pencil-alt"></span>
                                    <h4>Learn Anywhere</h4>
                                    <p>There earth face earth behold she star so made void two given and also our</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="learning_member_text_iner">
                                    <span class="ti-stamp"></span>
                                    <h4>Expert Teacher</h4>
                                    <p>There earth face earth behold she star so made void two given and also our</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="learning_img">
                        <img src="{{ env('APP_URL') }}/front_assets/img/advance_feature_img.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- learning part end-->

    <!--::review_part start::-->
    <section class="testimonial_part">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <h2 style="font-size: 35px !important;">What customers love about us</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="textimonial_iner owl-carousel">
                        <div class="testimonial_slider">
                            <div class="row">
                                <div class="col-lg-8 col-xl-4 col-sm-8 align-self-center">
                                    <div class="testimonial_slider_text">
                                        <p>Behold place was a multiply creeping creature his domin to thiren open void
                                            hath herb divided divide creepeth living shall i call beginning
                                            third sea itself set</p>
                                        <h4>Michel Hashale</h4>
                                        <h5> Sr. Web designer</h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_1.png" alt="#">
                                    </div>
                                </div>
                                <div class="col-xl-4 d-none d-xl-block">
                                    <div class="testimonial_slider_text">
                                        <p>Behold place was a multiply creeping creature his domin to thiren open void
                                            hath herb divided divide creepeth living shall i call beginning
                                            third sea itself set</p>
                                        <h4>Michel Hashale</h4>
                                        <h5> Sr. Web designer</h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 d-none d-xl-block">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_1.png" alt="#">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial_slider">
                            <div class="row">
                                <div class="col-lg-8 col-xl-4 col-sm-8 align-self-center">
                                    <div class="testimonial_slider_text">
                                        <p>Behold place was a multiply creeping creature his domin to thiren open void
                                            hath herb divided divide creepeth living shall i call beginning
                                            third sea itself set</p>
                                        <h4>Michel Hashale</h4>
                                        <h5> Sr. Web designer</h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_2.png" alt="#">
                                    </div>
                                </div>
                                <div class="col-xl-4 d-none d-xl-block">
                                    <div class="testimonial_slider_text">
                                        <p>Behold place was a multiply creeping creature his domin to thiren open void
                                            hath herb divided divide creepeth living shall i call beginning
                                            third sea itself set</p>
                                        <h4>Michel Hashale</h4>
                                        <h5> Sr. Web designer</h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 d-none d-xl-block">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_1.png" alt="#">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="testimonial_slider">
                            <div class="row">
                                <div class="col-lg-8 col-xl-4 col-sm-8 align-self-center">
                                    <div class="testimonial_slider_text">
                                        <p>Behold place was a multiply creeping creature his domin to thiren open void
                                            hath herb divided divide creepeth living shall i call beginning
                                            third sea itself set</p>
                                        <h4>Michel Hashale</h4>
                                        <h5> Sr. Web designer</h5>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_3.png" alt="#">
                                    </div>
                                </div>
                                <div class="col-xl-4 d-none d-xl-block">
                                    <div class="testimonial_slider_text">
                                        <p>Behold place was a multiply creeping creature his domin to thiren open void
                                            hath herb divided divide creepeth living shall i call beginning
                                            third sea itself set</p>
                                        <h4>Michel Hashale</h4>
                                        <h5> Sr. Web designer</h5>
                                    </div>
                                </div>
                                <div class="col-xl-2 d-none d-xl-block">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_1.png" alt="#">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="textimonial_iner owl-carousel">
                        <div class="testimonial_slider">
                            <div class="row">
                               
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_1.png" alt="#">
                                    </div>
                                </div>
                                
                                <div class="col-xl-2 d-none d-xl-block">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_1.png" alt="#">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_2.png" alt="#">
                                    </div>
                                </div>

                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_2.png" alt="#">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-2 col-sm-4">
                                    <div class="testimonial_slider_img">
                                        <img src="{{ env('APP_URL') }}/front_assets/img/testimonial_img_2.png" alt="#">
                                    </div>
                                </div>
                            </div>
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--::blog_part end::-->

    <!--::blog_part start::-->
    <section class="blog_part section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section_tittle text-center">
                        <p>Our Blog</p>
                        <h2>Students Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="single-home-blog">
                        <div class="card">
                            <img src="{{ env('APP_URL') }}/front_assets/img/blog/blog_1.png" class="card-img-top" alt="blog">
                            <div class="card-body">
                                <a href="#" class="btn_4">Design</a>
                                <a href="blog.html">
                                    <h5 class="card-title">Dry beginning sea over tree</h5>
                                </a>
                                <p>Which whose darkness saying were life unto fish wherein all fish of together called</p>
                                <ul>
                                    <li> <span class="ti-comments"></span>2 Comments</li>
                                    <li> <span class="ti-heart"></span>2k Like</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="single-home-blog">
                        <div class="card">
                            <img src="{{ env('APP_URL') }}/front_assets/img/blog/blog_2.png" class="card-img-top" alt="blog">
                            <div class="card-body">
                                <a href="#" class="btn_4">Developing</a>
                                <a href="blog.html">
                                    <h5 class="card-title">All beginning air two likeness</h5>
                                </a>
                                <p>Which whose darkness saying were life unto fish wherein all fish of together called</p>
                                <ul>
                                    <li> <span class="ti-comments"></span>2 Comments</li>
                                    <li> <span class="ti-heart"></span>2k Like</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 col-xl-4">
                    <div class="single-home-blog">
                        <div class="card">
                            <img src="{{ env('APP_URL') }}/front_assets/img/blog/blog_3.png" class="card-img-top" alt="blog">
                            <div class="card-body">
                                <a href="#" class="btn_4">Design</a>
                                <a href="blog.html">
                                    <h5 class="card-title">Form day seasons sea hand</h5>
                                </a>
                                <p>Which whose darkness saying were life unto fish wherein all fish of together called</p>
                                <ul>
                                    <li> <span class="ti-comments"></span>2 Comments</li>
                                    <li> <span class="ti-heart"></span>2k Like</li>
                                </ul>
                            </div>
                        </div>
                    </div>


        
    </section>
    <section class="blog_part section_padding" style="    background: linear-gradient(to right, rgb(27,140,190) 0%, rgb(249,164,49) 31%, rgb(27,140,190) 100%);">
              
<h2 style="text-align: center;padding-bottom: 0.5em;">Society Buddy Mobile Application</h2>
<p style="text-align: center;padding-bottom: 1em;color:#ffff;">A complete automated and innovative mobile app to manage day-to-day society activities effortlessly</p>
                <div class="poster-main" id="carousel" data-setting='{
                            "width":640,
                            "height":480,
                            "posterWidth":300,
                            "posterHeight":480,
                            "scale":0.8,
                            "speed":1000,
                            "autoPlay":true,
                            "delay":3000,
                            "verticalAlign":"middle"
                            }' style="    max-width: 100%;
    margin: auto;"> 
                   <div class="poster-btn poster-prev-btn" style="width: 170px;height: 500px;z-index: 2;"></div> 
                   <ul class="poster-list"> 
                    <li class="poster-item"><a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/43.png" alt="" width="100%" /></a></li> 
                    <li class="poster-item"><a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/37.png" alt="" width="100%" /></a></li> 
                    <li class="poster-item"><a href="#"><img src="{{ env('APP_URL') }}/front_assets/img/44.png" alt="" width="100%" /></a></li> 
                   
                   </ul> 
                   <div class="poster-btn poster-next-btn"></div> 
                  </div> 
    </section>

    <section class="blog_part section_padding form-bg" style="padding: 3% 0%;
    background: #f4f2e5;">
    <h3 style="text-align: center;">Experience the Society Buddy difference!</h3>
        <p class="sub-heading" style="text-align: center;">Set up a demo for the entire community</p>
    <div class="container">

            <div class="row">

                <div class="col-xl-8 offset-xl-2 py-5">

                   
                    <form id="contact-form" method="post" action="#" role="form" class="wpcf7-form">
{{ csrf_field() }}
                        <div class="messages"></div>

                        <div class="controls">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                       
                                        <input id="form_name" type="text" name="name" class="form-control" placeholder="Name *" required="required" data-error="Firstname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        
                                        <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Contact *" required="required" data-error="Lastname is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        
                                        <input id="form_email" type="email" name="email" class="form-control" placeholder="Email *" required="required" data-error="Valid email is required.">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        
                                        <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Name of the Society *">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        
                                        <input id="form_phone" type="tel" name="city" class="form-control" placeholder="City *">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        
                                        <input id="form_phone" type="tel" name="message" class="form-control" placeholder="Message *">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-md-12 text-center">
                                    <!-- <input type="submit" class="btn btn-success btn-send" value="Send message"> -->
                                    <button type="submit" class="btn btn-success btn-send">SEND</button>
                                </div>
                            </div>
                            
                        </div>

                    </form>

                </div>

            </div> 

        </div> 
</section>
        
 <script>
    $("#contact-form").submit(function(event) {

        event.preventDefault();
        
        var name = $("input[name=name]").val(); // The CSRF token
        var surname = $("input[name=surname]").val();
        var email = $("input[name=email]").val();
        var phone = $("input[name=phone]").val();
        var city = $("input[name=city]").val();
        var message = $("input[name=message]").val();

        $.ajax({
           type:'POST',
           url:'/contact',
           dataType: 'json',
           data:{_token: token, name:name, surname:surname, email:email, phone:phone, message:bodyMessage,city:city},
           success:function(data){
              alert(data.success);
           }
        });
    });
</script>
   

@endsection