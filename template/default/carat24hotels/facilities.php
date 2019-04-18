

<?php

$page_title =  "2019 Election, Booking secure hotels in nigeria | {$this->name} |hotels facilities";


$page_seo_description ="When you stay with us, you get free access to our restaurant, bar, wifi , breakfast with a little extra, you can 
    use our boardroom and laundry. Remember to book online $gitstar_phone";


 include 'header.php';?>            
            <!--  Page Content, class footer-fixed if footer is fixed  -->
            <div id="page-content" class="header-static footer-fixed">
                <!--  Slider  -->
                <div id="flexslider" class="fullpage-wrap small">
                    <ul class="slides">
                        <li itemprop="photo" style="background-image:url(<?=assets;?>/assets/kenny_edited/suite.jpg)">
                            <div class="container text text-center">
                                <h1 class="white margin-bottom-small">Facilities</h1>
                                <!-- <p class="heading white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde veniam aperiam rerum quis atque, illum.</p> -->
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Facilities</li>
                        </ol>
                    </ul>
                </div>
                <!--  END Slider  -->
                <div id="page-wrap" class="content-section fullpage-wrap">
                    <!-- Section About -->
                    <!-- <div class="row margin-leftright-null">
                        <div class="container">
                            <div class="col-md-12 padding-leftright-null">
                                <div class="text text-center">
                                    <p class="heading line full center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam, odit quam dolores incidunt architecto debitis repellendus atque asperiores, est aut deleniti nesciunt tenetur. Omnis ullam, iusto voluptatibus neque quaerat amet accusantium suscipit voluptas quod impedit.</p>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
 -->
                  

                    <!-- Services section -->
                    <div class="row margin-leftright-null grey-background" id="home-square">
                        <div class="container text">

                           


<section id="news" class="page">
                                <div class="news-items equal one-columns" style="position: relative; height: 969px;">
                                    <!--  Single News  -->
<?php 

    $i= 3;
    
   foreach ($hotel_services as $facility):
?>
                                       

                                    <div class="single-news one-item horizontal-news" style="position: absolute; left: 0px; top: 0px;">
                                        <article>
                                            <div class="col-md-6 padding-leftright-null">
                                                <div class="image" style="background-image:url(<?=$facility['image'];?>)"></div>
                                            </div>
                                            <div class="col-md-6 padding-leftright-null">
                                                <div class="content">
                                                    <h3><?=$facility['name'];?></h3>
                                                    <p><?=$facility['description'];?></p>
                                                </div>
                                            </div>

                                        </article>
                                    </div>

                                    <?php    $i++; endforeach ;?>  
                            <!-- Section with same height -->
                            
                                </div>
                            </section>



                        </div>
                    </div>
                    <!-- END Services section -->
                </div>
            </div>
            <!--  END Page Content, class footer-fixed if footer is fixed  -->
            


            <?php include 'footer.php'; ?>