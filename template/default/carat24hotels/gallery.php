<?php

$page_title =  "For Travelers, business hotels and suites | rates | pictures | reviews {$this->name} | Gallery";

$page_seo_description ="call {$this->gitstar_phone}Spend a night or more at Carat24 business hotels and pay less!  suites | rates | pictures | reviews {$this->name} | Gallery";
 include 'header.php';?>
            
            <!--  Page Content, class footer-fixed if footer is fixed  -->
            <div id="page-content" class="header-static footer-fixed">
                <!--  Slider  -->
                <div id="flexslider" class="fullpage-wrap small">
                    <ul class="slides">
                        <li itemprop="photo" style="background-image:url(<?=assets;?>/assets/kenny_edited/restaurant3.jpg)">
                            <div class="container text text-center">
                                <h1 class="white margin-bottom-small">Gallery</h1>
                                <!-- <p class="heading white">We are proud to show you a glimspe of our pride... isnt it "Amazing comfort"...</p> -->
                            </div>
                            <div class="gradient dark"></div>
                        </li>
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Gallery</li>
                        </ol>
                    </ul>
                </div>
                <!--  END Slider  -->
                <div id="page-wrap" class="content-section fullpage-wrap">
                    <!--  Gallery Section  -->
                    <section id="gallery" data-isotope="load-simple">
                        <div class="gallery-items equal four-columns">
                        
                          
                          <?php

    $dir= __DIR__."/assets/kenny_edited";  
 

    $gallery =  scandir($dir)   ;
    array_shift($gallery);
    array_shift($gallery);
    foreach ($gallery as $picture):
      ?>
                            
                            <div class="one-item">
                                <div class="image-bg" itemprop="photo" style="background-image:url(<?=assets;?>/assets/kenny_edited/<?=$picture;?>)"></div>
                                <div class="content figure">
                                    <i class="icon ion-ios-plus-empty"></i>
                                <a href="<?=assets;?>/assets/kenny_edited/<?=$picture;?>" class="link lightbox"></a>
                                </div>
                            </div>

<?php endforeach ;?>




                        </div>
                    </section>
                    <!--  END Gallery Section  -->
                </div>
            </div>
            <!--  END Page Content, class footer-fixed if footer is fixed  -->
            
            <?php include 'footer.php'; ?>