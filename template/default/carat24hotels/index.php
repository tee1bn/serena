<?php
$page_title =  "Business hotels in Lagos | Accommodation near by | {$this->name} | hotels in nigeria";

$gitstar_phone = "+234.07062983151";

$page_seo_description = "Find us easily. Call $gitstar_phone for directions. Please always book online and ahead, 
    so we can secure your room. Its now easier to book a hotel in Ijesha - Lagos";

 include 'header.php';?>
            
            <!--  Page Content, class footer-fixed if footer is fixed  -->
            <div id="page-content" class="header-static footer-fixed">
                <!--  Slider  -->
                <div id="flexslider-nav" class="fullpage-wrap home">
                    <ul class="slides">
                        <li itemprop="photo" style="background-image:url(<?=$this_folder;?>/assets/kenny_edited/restaurant.jpg)">
                            <div class="container text center">
                                <h1 class="white flex-animation"><?=$hotel_full_name;?></h1>
                                <h2 class="white flex-animation">Amazing comfort...</h2>
                                <a href="javascript:load_booking_engine()" class="shadow btn-alt small white margin-bottom-null margin-left-null flex-animation">See availability+</a>
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                        <li itemprop="photo" style="background-image:url(<?=$this_folder;?>/assets/kenny_edited/board_rooms.jpg)">
                            <div class="text container">
                                <h1 class="white flex-animation no-opacity">Book with benefits</h1>
                                <h2 class="white flex-animation no-opacity">Receive the lowest rates anywhere, zero booking fee...</h2>
                                <a href="javascript:load_booking_engine()" class="shadow btn-alt small white margin-bottom-null margin-left-null flex-animation">See availability+</a>     
                              </div>
                            <div class="gradient dark"></div>
                        </li>
                    </ul>
                    <div class="container">
                        <div class="slider-controls-container"></div>
                    </div>
                </div>
                <!--  END Slider  -->
                <div id="home-wrap" class="content-section fullpage-wrap">
                    <div class="row margin-leftright-null grey-background">
                        <div class="container text">
                            <!-- Booking Section -->
                            <div id="booking" class="text dark-background">
                              <h3 style="display: inline; color: #f6f6f6;"> See what a difference a stay makes...
                              </h3>
  <a href="javascript:load_booking_engine()" class="shadow btn-alt pull-right small  margin-bottom-null margin-left-null flex-animation">Book now</a>
                            </div>
                            <!-- END Booking Section -->
                        </div>
                    </div>
                    <!-- Section About -->
                    <div class="row margin-leftright-null grey-background">
                        <div class="container">
                            <div class="col-md-12 padding-leftright-null">
                                <div class="text text-center">
                                    <h3 class="big dark">The best <mark>Business</mark> Hotel in Ijesha, Lagos.</h3>
                                    <p class="heading center line margin-bottom-null">
                                        <?=$hotel_description;?>
                                    </p>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <!-- Rooms Carousel -->
                    <div class="row margin-leftright-null" id="rooms">
                        <div class="container text text-center">
                            <h3 class="big title dark margin-bottom-small">Our Rooms</h3>
                            <div class="rooms-carousel text-left">

                                <?php
                                 foreach ($hotel_rooms as  $room):
$star_rate_html ='';
                                    for ($i=0; $i < $room['star_rate']; $i++) { 
                                    $star_rate_html .='<i class="icon ion-ios-star color"></i>';
                                    }
                                    ?>

                                <div class="room">

                                    <div class="col-md-6 padding-leftright-null">
                                        <div class="content">
                                            <?=$star_rate_html;?>
                                              <h3><?=$room['name'];?> 
                                                <a class="pull-right"><?=$currency;?><?=$room['rate'];?>
                                                <span style="font-size: 12px;">/night</span></a>
                                                </h3>

                                        <span class="category"><?=$room['special_feature'];?></span>
                                            <p class="white"><?=$room['brief_description'];?>...
                                                <a href="<?=$this->domain;?>/rooms-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria">read more </a></p>
                                            <a href="javascript:load_booking_engine()" class="btn-alt small color">Book now</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 padding-leftright-null">
                                        <div class="image" itemprop="photo" style="background-image:url(<?=$room['image'];?>)"></div>
                                    </div>
                                </div>
                                
                                <?php endforeach ;?>

                            </div>
                        </div>
                    </div>
                    <!-- END Rooms Carousel -->
                    <!-- Testimonial Carousel -->
                    <div class="row margin-leftright-null">
                        <div class="bg-img overlay" itemprop="photo" style="background-image:url(<?=$this_folder;?>/assets/kenny_edited/restaurant.jpg)">
                            <div class="col-md-12">
                                <div class="text text-center padding-bottom-null">
                                    <h3 class="big white margin-bottom">Our Guests Say</h3>
                                </div>
                            </div>
                            <!-- Testimonials -->
                            <section class="testimonials-carousel col-md-12">

                                <?php foreach ($hotel_testmonials as $testimonial):?>

                                <div class="item col-md-8 col-md-offset-2 padding-leftright-null">
                                    <div class="container text text-center padding-top-null padding-bottom-null">
                                        <p class="heading center grey-light margin-bottom-small">"<?=$testimonial['review'];?>"</p>
                                        <em><?=$testimonial['guest'];?></em>
                                    </div>
                                </div>
                              
                              <?php endforeach ;?>
                            </section>
                            <!-- END Testimonials -->
                        </div>
                    </div>
                    <!-- Testimonial Carousel -->
                    <div class="row margin-leftright-null">
                        <div class="container text text-center padding-bottom-null">
                            <div class="col-md-12 padding-leftright-null">
                                <h3 class="big title dark margin-bottom-small">Our Services</h3>
                                <p class="heading full center margin-bottom-null">What we can give to our guest.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services Box -->
                    <div class="row margin-leftright-null" id="home-services">
                        <div class="container text">
                            <section id="box-items" data-isotope="load-simple">
                                <div class="masonry-items equal three-columns">   


                                <?php foreach ($hotel_services as $service):?>
                                    <div class="one-item">
                                        <div class="image-bg" itemprop="photo" style="background-image:url(<?=$service['image'];?>)"></div>
                                        <div class="preview">
                                            <h4><?=$service['name'];?></h4>
                                        </div>
                                        <div class="content">
                                            <div class="text">
                                                <h3><?=$service['name'];?></h3>
                                                <p><?=substr($service['description'], 0, 200);?>..</p>
                                            </div>
                                            <div class="line"></div>
                                            <a href="<?=$this->domain;?>/facilities-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria" class="link"></a>
                                        </div>
                                    </div>
                                  
                                  <?php endforeach ;?>
                                </div>
                            </section>
                        </div>
                    </div>
  

  <div class="row margin-leftright-null">
                        <div class="container text text-center padding-bottom-null">
                            <div class="col-md-12 padding-leftright-null">
                                <h3 class="big title dark margin-bottom-small">Our Facilities</h3>
                                <p class="heading full center margin-bottom-null">Kindly know you will be charged on usage of our paid facilities, while you enjoy our free services.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Services Box -->
                    <div class="row margin-leftright-null" id="home-services">
                        <div class="container text">
<div class="col-md-4">
        <ul list-style-type="none">
          <li><i class="fa fa-car"></i> Parking</li>
          <li><i class="fa fa-wifi"></i>Free WIFI access </li>
          <li><i class="fa fa-life-buoy"></i> Laundary </li>
          <li><i class="fa fa-circle"></i> Smoking Area </li>
          <li><i class="fa fa-tv"></i> Tv </li>
          <li><i class="fa fa-wheelchair"></i> wheelchair access</li>
       </ul>
      </div>

                             
<div class="col-md-4">
        <ul list-style-type="none">
         


          <li><i class="fa fa-level-up"></i> Elevator </li>
          <li><i class="fa fa-cloud"></i> Air conditioning </li>
          <li><i class="fa fa-group"></i> Courteous Staff </li>
          <li><i class="fa fa-beer"></i> Breakfast Service </li>
          <li><i class="fa fa-tty"></i> In rooms telephone </li>
          <li><i class="fa fa-briefcase"></i> Work area  </li>



       </ul>
      </div>

                             
<div class="col-md-4">
        <ul list-style-type="none">
         

          <li><i class="fa fa-bed"></i> Room service </li>
          <li><i class="fa fa-lock"></i> Security</li>
          <li><i class="fa fa-bolt"></i> Electric Fence</li>
          <li><i class="fa fa-power-off"></i> 24/7 Power supply</li>
          <li><i class="fa fa-cutlery"></i> Restaurant </li>
          <li><i class="fa fa-beer"></i> Bar </li>



       </ul>
      </div>

                             
                        </div>
                    </div>


                    <!-- END Services Box -->
                    <!-- CTA Section -->
                  <!--   <div class="row padding-md margin-leftright-null grey-background">
                        <div class="col-md-12 text-center">
                            <h4 class="big margin-bottom-small black">Get 15% Off Today</h4>
                            <a href="https://themeforest.net/item/dap-creative-multipurpose-html-template/17672552" target="_blank" class="btn-alt small margin-null">Book Now</a>
                        </div>
                    </div> -->
                    <!-- END CTA Section -->
                </div>
            </div>
            <!--  END Page Content, class footer-fixed if footer is fixed  -->
            



            <?php include 'footer.php';?>