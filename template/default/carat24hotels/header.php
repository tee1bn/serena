<?php
    $gitstar_phone      = "+234 7062983151 ";
    $gitstar_email      = "booking@serenahotelsng.com";
    $hotel_full_name    = "Serena Hotels and Suites";
    $hotel_address_html = '  <span itemprop="streetAddress">  48, Asoge street, </span><br>
                              <span itemprop="addressLocality">  by Okota/Itire bridge, </span> <br>
                                <span itemprop="addressRegion">Ijesha Lagos. </span>';
    $hotel_description  = "$hotel_full_name is situated in a characteristic, quite and lively area. Surrounded by major roads (leading to the murtala international airports, apapa ports in roughly 35mins), the extraordinary beauty of churches, buildings, shops and very close to the police station .  <br><br>
        On entering this charming hotel at Ijesha, you will immediately sense its special intimate atmosphere that makes you feel like being in your own home.  Each detail has been passionately chosen and each room deserves a visit. The special charm and the cosy mood of $hotel_full_name will make you feel an amazing comfort.";




        $hotel_rooms = [
                0  => [
                    'name'              => 'Studio Room',
                    'star_rate'         => '4',
                    'image'             => $this_folder."/assets/kenny_edited/studio_room.jpg",
                    'special_feature'   => 'Single bed, 24" Flat screen Tv, en suite,
                                                   bathroom, mini-fridge.',
                    'rate'              => '7,000',
                    'old_rate'              => '12,000',
                    'brief_description' => 'If you are on good budget and require a sound accommodation to lay your head while enjoying a stress free surroundings that also support work.',
                    ],

                1  => [
                    'name'              => 'Classic Room',
                    'star_rate'         => '4',
                    'image'             => $this_folder."/assets/kenny_edited/classic_room.jpg",
                    'special_feature'   => 'Double Bed, 32" Flat screen Tv, En suite, 
                    bathroom, intercom, free Wifi, table top Fridge.',
                    'rate'              => '8,000',
                    'old_rate'              => '12,000',
                    'brief_description' => 'If you are on good budget and require a sound accommodation to lay your head while enjoying a stress free surroundings that also support work.',
                    ],

               2  => [
                    'name'              => 'Deluxe Room',
                    'star_rate'         => '4',
                    'image'             =>  $this_folder."/assets/kenny_edited/standard_rooms.jpg",
                    'special_feature'   => 'Double Bed, 32" flat screen Tv, en suite, bathroom, intercom,
                                            Table top Fridge, Wifi, Fridge.',
                    'rate'              => '10,000',
                    'old_rate'              => '15,000',
                    'brief_description' => ' This features good work area. when you book this room, you get access to breakfast, free wifi, 24 hours electricity',
                    ],


                 3  => [
                        'name'              => 'Luxury Suite',
                        'star_rate'         => '5',
                        'image'             => $this_folder."/assets/kenny_edited/suite.jpg",
                        'special_feature'   => 'Double bed, sitting room, balccony, 32" flat screen Tv,en suite, bathroom, intercom, free wifi, fridge ,work space, Wifi',
                        'rate'              => '20,000',
                        'old_rate'              => '20,000',
                        'brief_description' => 'When you book this room, you get access to breakfast, free wifi, 24 hours electricity as well as clean bathroom and toilet and Jacuzzi. Perfect for comfort,relaxation and good privacy.'
                                                ],




                        ];

        $currency = '&#8358;';

       
        $hotel_testmonials= [

                        [
                        'review'    => 'My checking process was really smooth. And they made it a less stressful trip for me.',
                        'guest'     => 'Mc Brown'
                        ],
                        [
                        'review'    => 'Smooth checkin process, very great place to stay, courteous and nice staffs.',
                        'guest'     => 'Adeleke mobolaji'
                        ],

                       [
                        'review'    => 'Really love the environment, neatly kept plus quality meals at the restaurant.',
                        'guest'     => 'Jide mobolaji'
                        ],

                       [
                        'review'    => 'The staffs are very courteous and friendly. Neatly kept plus quality meals at the restaurant.',
                        'guest'     => 'Jerry Morgan'
                        ],

                            ];




        $hotel_services = [

                        0 => [
                                'name'   => 'Restaurant & Bar',
                                'description' =>  'you can enjoy a drink while you relax to watch the ongoing Tv show.<br> Our menu is based on using high quality local ingredients along with the best of imported ingredients from around the world. 
                                    Freshly cooked and served meals by our master chef and his team with care and attention.<br>
                                    There is a wide selection to choose from including: Grilled fish, croaker, fish pepper soup, ugha soup, vegetable soup, ogbono, egusi, semo, wheat, garri, rice(fried or jollof with beef, chicken, fish).',

                                'image' => $this_folder."/assets/kenny_edited/restaurant3.jpg"
                            ], 


                        1 => [
                                'name'   => 'Board rooms',
                                'description' =>  'Designed specifically for board meetings, featuring a large table suitable for 12 to 15 board members depending on the sitting arrangement with built in audio visual system to ensure a successful meeting. perfect for executive meetings and board retreats.',

                                'image' => $this_folder."/assets/kenny_edited/board_rooms.jpg"
                            ], 


                        2 => [
                                'name'   => 'Eloquent laundry',
                                'description' =>  'When you\'ve not packed enough apparel to last for the duration of your stay, you can always take advantage of our laundry service. Even if you\'ve never used a hotel laundry service before. You can head off to a meeting or a day of sightseeing and enjoy clean, fresh laundry when you return to your room.',

                                'image' => $this_folder."/assets/edited_images/laundry.jpg"
                            ], 



                        3 => [
                                'name'   => 'Conference Hall',
                                'description' =>  'Our Hall can accommodate up to 50 guest convieniently in Class room seating arrangment. Potential Event planners are welcome to come and see it for maximum satifaction. Kindly send us a mail or call for direct booking.',

                                'image' => $this_folder."/assets/kenny_edited/conference_hall.jpg"
                            ], 



                            ];


 $this_url =  "$this->domain/{$_GET['url']}";

;?>
<!DOCTYPE html>
<html lang="en">
   <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="z1Zl_49djAvNIGaoyoMYBDS6WLI9XiTKzNHdEYBbIQI" />
<meta name="msvalidate.01" content="022EB8F19B5900C36B5764F9A0A955DF" />
        <meta name="description" content="<?=$page_seo_description;?>" />

    <link rel="canonical" href="<?=@$this_url;?>" /> 

        <title> <?=@$page_title;?> </title>
        <script type='text/javascript' src='//platform-api.sharethis.com/js/sharethis.js#property=5b9ba437b698a100116eb550&product=sticky-share-buttons' async='async'></script>


        <!-- gitstar booking engine -->
         <script src="https://hospitality.gitstardigital.com/public/js_booking_engine/middleware.js"></script> 

        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/bootstrap/bootstrap.min.css">
        
        
<link rel="shortcut icon" href="<?=$this_folder;?>/assets/favicon.ico" />

        <!-- Optional theme -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/bootstrap/bootstrap-theme.min.css">

        <!-- Custom css -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/style.css">
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/ionicons.min.css">
        
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/puredesign.css">
        
        <!-- Flexslider -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/flexslider.css">
        
        <!-- Owl -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/owl.carousel.css">
        
        <!-- Magnific Popup -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/magnific-popup.css">
        
        <!-- DateTimepicker -->
        <link rel="stylesheet" href="<?=$this_folder;?>/assets/css/datepicker.css">


    </head>
    <body>
      
      
        <!--  Main Wrap  -->
        <div id="main-wrap" class="full-width">
            <!--  Header & Menu  -->
            <header id="header" class="fixed transparent full-width">
                <div class="container">
                    <nav class="navbar navbar-default white">
                        <!--  Header Logo  -->
                        <div id="logo">
                            <a class="navbar-brand" href="" style="
      background: #fefefe;
    padding-left: 10px;
    padding-right: 10px;">
                               <!--  <img src="assets/img/logo.png" class="normal" alt="logo">
                                <img src="assets/img/logo%402x.png" class="retina" alt="logo">
                                <img src="assets/img/logo_white.png" class="normal white-logo" alt="logo">
                                <img src="assets/img/logo_white%402x.png" class="retina white-logo" alt="logo"> -->
                                <h3 style="font-size:19px;" itemprop="name">Serena Hotels 
                                <small style="position: absolute;  left: 18%;  font-size: 12px;">hotel & suites</small>
                                 </h3>
                            </a>
                        </div>
                        <!--  END Header Logo  -->
                        <!--  Classic menu, responsive menu classic  -->
                        <div id="menu-classic">
                            <div class="menu-holder">
                                <ul>
                                    <li>
                                        <a href="<?=$this->domain;?>" class="">Home</a>
                                     
                                    </li>
                                    <li class="">
                                        <a href="<?=$this->domain;?>/rooms-at-serena-hotels-and-suites-ijesha-lagos-nigeria">Rooms</a>
                                       <!--  <ul class="sub-menu">
                                            <li><a href="rooms.php">rooms</a></li>
                                            
                                        </ul> -->
                                    </li>
                                    <li class="">
                                        <a href="<?=$this->domain;?>/facilities-at-serena-hotels-and-suites-ijesha-lagos-nigeria">Facilities</a>
                                       
                                    </li>
                                    <li>
                                        <a href="<?=$this->domain;?>/gallery-at-serena-hotels-and-suites-ijesha-lagos-nigeria">Gallery</a>
                                    </li>
                                   
                                
                                    <li>
                                        <a href="<?=$this->domain;?>/contact-at-serena-hotels-and-suites-ijesha-lagos-nigeria">Contact</a>
                                    </li>
                                  
                                    <li>
                                        <a href="javascript:load_booking_engine()"><i class="fa fa-sign-in"></i> See availability</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!--  END Classic menu, responsive menu classic  -->
                        <!--  Button for Responsive Menu Classic  -->
                        <div id="menu-responsive-classic">
                            <div class="menu-button">
                                <span class="bar bar-1"></span>
                                <span class="bar bar-2"></span>
                                <span class="bar bar-3"></span>
                            </div>
                        </div>
                        <!--  END Button for Responsive Menu Classic  -->
                    </nav>
                </div>
            </header>
            <!--  END Header & Menu  -->



            