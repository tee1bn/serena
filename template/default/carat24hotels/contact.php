

<?php

$page_title =  " Need To Lodge In Best Hotels? | Get  Accommodation Nearby {$this->name} ";


$page_seo_description = "Find us easily. Call {$this->gitstar_phone} for directions. Please always book ahead, 
    so we can secure your room. Early cancellation is FREE! Its now easier to book a hotel in Ikeja - Lagos" ;


 include 'header.php';?>

            <!--  Page Content, class footer-fixed if footer is fixed  -->
            <div id="page-content" class="header-static footer-fixed">
                <!--  Slider  -->
                <div id="flexslider" class="fullpage-wrap small">
                    <ul class="slides">
                        <li style="background-image:url(<?=assets;?>/assets/img/contact.jpg)">
                            <div class="container text text-center">
                                <h1 class="white margin-bottom-small">Contact</h1>
                                <p class="heading white">Our team will be happy to provide more detail about <?=$hotel_full_name;?>. We will call back or send the information you request promptly.</p>
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Contact</li>
                        </ol>
                    </ul>
                </div>
                <!--  END Slider  -->
                <div id="page-wrap" class="content-section fullpage-wrap">
                    <div class="row margin-leftright-null">
                        <div class="container">
                            <!--  Contact Info  -->
                            <div class="col-md-6 padding-leftright-null">
                                <div class="text">
                                    <h3 class="big margin-bottom-small title left">Get in touch </h3>
                                    <p class="heading center grey margin-bottom-null">We look forward to hearing from you. Kindly pay us a visit or reach us via:</p>
                                    <div class="padding-onlytop-md">
                                      
                                        <p>
                                            <span class="contact-info">Address: <br>
                                                <em> <?=$hotel_address_html;?></em>
                                            </span>
                                            <br>
                                            <span class="contact-info">Phone: 
                                                <em>
                                                    <a href="tel:<?=$gitstar_phone;?>"><?=$gitstar_phone;?></a>
                                                </em>
                                            </span>
                                            <br>
                                            <span class="contact-info">Email: 
                                                <a href="mailto://<?=$gitstar_email;?>"><em><?=$gitstar_email;?></em></a>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--  END Contact Info -->
                            <!--  Input Form  -->
                            <div class="col-md-6 padding-leftright-null">
                                <div class="text padding-onlybottom-sm padding-md-top-null">
                                    <form id="contact-form" action="<?=$this->domain?>/home/message" method="post"  class="padding-onlytop-md padding-md-topbottom-null">
                                            <?=$this->csrf_field('contact');?>
                                        <div class="row">


<?php if(Session::hasFlash() == 1) :?>
<div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <?=Session::flash()['message'];?>
                                        </div>

<?php endif ;?>                                            <div class="col-md-12">
                                                <input class="form-field" name="name" id="name" type="text" placeholder="Name">
                                          <?=$this->inputError('name');?>

                                            </div>
                                            <div class="col-md-12">
                                                <input class="form-field" name="email" id="mail" type="text" placeholder="Email">
                                           <?=$this->inputError('email');?>

                                            </div>
                                         
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <textarea class="form-field" name="message" id="message" rows="6" placeholder="Your Message"></textarea>
                                           <?=$this->inputError('message');?>

                                                    <input type="submit" class="btn btn-primary" value="Send Message">
                                                <div class="submit-area padding-onlytop-sm">
                                                    <div id="msg" class="message"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--  END Input Form  -->
                        </div>
                    </div>
                    <div class="row margin-leftright-null">
                        <!--  Map. Settings in assets/js/maps.js  -->
                        <div class="col-md-12 padding-leftright-null map">
                            <div id="map" style="padding: 0px 30px;">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.1333032036073!2d3.3235215144952392!3d6.504804695294705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8e9648100001%3A0x2d4061af88828a67!2sCarat+24+Business+Hotels+%26+Suites!5e0!3m2!1sen!2sng!4v1534528026170" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                        <!--  END Map  -->
                    </div>
                </div>
            </div>
            <!--  END Page Content, class footer-fixed if footer is fixed  -->


 <script>
/*// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: -25.344, lng: 131.036};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}*/
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>
            <?php include 'footer.php'; ?>