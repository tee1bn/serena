

<?php

$page_title =  "Taking Jamb? Best rates for hotels in lagos | Hotel Rooms | {$this->name} | hotels in nigeria";

$page_seo_description ="Featuring free WiFi, breakfast, work area  Carat 24 Hotels and Suites offers accommodation in Ijesha.";

 include 'header.php';?>            
            <!--  Page Content, class footer-fixed if footer is fixed  -->
            <div id="page-content" class="header-static footer-fixed">
                <!--  Slider  -->
                <div id="flexslider" class="fullpage-wrap small">
                    <ul class="slides">
                        <li style="background-image:url(<?=assets;?>/assets/edited_images/bed.jpg)">
                            <div class="container text text-center">
                                <h1 class="white margin-bottom-small">Rooms</h1>
                                <!-- <p class="heading white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde veniam aperiam rerum quis atque, illum.</p> -->
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Rooms</li>
                        </ol>
                    </ul>
                </div>
                <!--  END Slider  -->
                <div id="page-wrap" class="content-section fullpage-wrap">
                    <!-- Section About -->
                    <div class="row margin-leftright-null">
                        <div class="container">
                            <div class="col-md-12 padding-leftright-null">
                                <div class="text text-center">
                                    <p class="heading center line margin-bottom-null">Featuring 34 rooms (Classic rooms, Standard rooms and  Suites), custom-made for business travel and perfect for relaxing leisure guests. Elegantly 
combining style and comfort with generous space to work and relax.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Section About -->
                    <!-- Section Rooms -->
                    <div class="row margin-leftright-null" id="rooms">
                        <div class="container text padding-top-null">
                           
                            <!-- Single Room -->


                                <?php
                                 foreach ($hotel_rooms as  $room):
$star_rate_html ='';
                                    for ($i=0; $i < $room['star_rate']; $i++) { 
                                    $star_rate_html .='<i class="icon ion-ios-star color"></i>';
                                    }

                                    ?>


                         <div itemprop="containsPlace" itemscope itemtype="http://schema.org/HotelRoom" class="room light col-md-12 padding-leftright-null margin-bottom">
                                <div class="col-md-6 padding-leftright-null">
                                    <div class="content">
                                        <span itemprop="starRating" itemscope itemtype="http://schema.org/Rating">
                                <meta itemprop="ratingValue" content="<?=$room['star_rate'];?>">
                                       <?=$star_rate_html;?>
                                        </span>
                                   <h3><?=$room['name'];?> <a class="pull-right">
                                    <?=$currency;?><?=$room['rate'];?>
                                    <span style="font-size: 12px;">/night</span></a></h3>

                                        <span class="category"><?=$room['special_feature'];?></span>
                                        <p itemprop="description"><?=substr($room['brief_description'], 0 ,700);?>
                                        <!-- ...<a href="#">read more</a> -->
                                            
                                        </p>
                                        <a href="javascript:load_booking_engine();" class="btn-alt active small">Book now </a>
                                    </div>
                                </div>
                                <div class="col-md-6 padding-leftright-null">
                                    <div itemprop="photo" class="image" style="background-image:url(<?=$room['image'];?>)">
                                        
                                    </div>
                                </div>
                            </div>


<?php endforeach ;?>



                            
                        </div>
                    </div>
                    <!-- END Section Rooms -->
                </div>
            </div>
            <!--  END Page Content, class footer-fixed if footer is fixed  -->
            <?php include 'footer.php';?>