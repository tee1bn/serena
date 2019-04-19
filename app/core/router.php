
<?php 


$router =[

''=>'home',
'home'=>'home',
'index-2.html'=>'home',




#guest routers

'rooms-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria' =>'RoomsController',
'facilities-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria' =>'FacilitiesController',
'gallery-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria' =>'GalleryController',
'contact-at-carat-24-hotels-and-suites-ijesha-lagos-nigeria' =>'ContactController',



#for new serena
'rooms-at-serena-hotels-and-suites-ijesha-lagos-nigeria' =>'RoomsController',
'facilities-at-serena-hotels-and-suites-ijesha-lagos-nigeria' =>'FacilitiesController',
'gallery-at-serena-hotels-and-suites-ijesha-lagos-nigeria' =>'GalleryController',
'contact-at-serena-hotels-and-suites-ijesha-lagos-nigeria' =>'ContactController',







#routers for users
'register' 					=> 'RegisterController',
'login' 					=> 'LoginController',
'forgot-password'			=>'ForgotPasswordController',





];

