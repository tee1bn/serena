
            <!--  Footer. Class fixed for fixed footer  -->
            <footer class="fixed full-width">
                <div class="container">
                    <div class="row no-margin pre-footer">
                        <div  itemprop="address" itemscope itemtype="http://schema.org/PostalAddress" class=" col-md-4 padding-leftright-null">
                            <h6 class="heading white">Address </h6>
                         <address  class="grey-light">
                            <i class="fa fa-map-marker"></i> 
                          <?=$hotel_address_html;?>
                            </address>
                            <p class="grey-light">   
                            <i class="fa fa-envelope"></i>  
                            <a href="mailto://<?=$gitstar_email;?>">
                                <?=$gitstar_email;?>
                            </a>
                            <br>
                            <i class="fa fa-phone"></i> 
                            Reservations: <br> <span itemprop="telephone"><a href="tel:<?=$gitstar_phone;?>"> <?=$gitstar_phone;?> </a></span></p>
                       
                        </div>


                        <!-- Social -->
                        <div class=" col-md-4 padding-leftright-null">
                            <h6 class="heading white">Connect with us</h6>
                            <p class="grey-light">Social media channels</p>
                            <ul class="social">
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                        <!-- END Social -->
                        <!-- Newsletter -->
                        <div class="col-md-4 padding-leftright-null">
                            <h6 class="heading white">Newsletter sign up</h6>
                            <p class="grey-light">Sign up for special offers</p>
                            <div id="newsletter-form">
                                <form class="search-form">
                                    <div class="form-input">
                                        <input type="text" placeholder="Your email ID">
                                        <span class="form-button">
                                            Sign up
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END Newsletter -->
                    </div>
                </div>



                <!-- Copyright -->
                        <div class="row">
                    <div class="container">
                            <div class="col-xs-12 " style="color: white; 
     position: relative;
    bottom: 10px;">
                              
                     &copy; <?=date("Y");?> All rights reserved

                                <a style="float: right;" href="http://gitstardigital.com/" target="_blank">Developed & managed by Gitstar digital</a>
                            </div>
                        </div>
                    </div>
                    <br>
                <!-- END Copyright -->
            </footer>
            <!--  END Footer. Class fixed for fixed footer  -->
        </div>
        <!--  Main Wrap  -->
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?=$this_folder;?>/assets/js/jquery.min.js"></script>
        <!-- All js library -->
        <script src="<?=$this_folder;?>/assets/js/bootstrap/bootstrap.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/datepicker.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/jquery.flexslider-min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/owl.carousel.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/isotope.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/jquery.magnific-popup.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/jquery.scrollTo.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/smooth.scroll.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/jquery.appear.js"></script>
        <script src="<?=$this_folder;?>/assets/js/jquery.countTo.js"></script>
        <script src="<?=$this_folder;?>/assets/js/jquery.scrolly.js"></script>
        <script src="<?=$this_folder;?>/assets/js/plugins-scroll.js"></script>
        <script src="<?=$this_folder;?>/assets/js/imagesloaded.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/pace.min.js"></script>
        <script src="<?=$this_folder;?>/assets/js/main.js"></script>

          <!--drift-->
  <script>
"use strict";

!function() {
  var t = window.driftt = window.drift = window.driftt || [];
  if (!t.init) {
    if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
    t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
    t.factory = function(e) {
      return function() {
        var n = Array.prototype.slice.call(arguments);
        return n.unshift(e), t.push(n), t;
      };
    }, t.methods.forEach(function(e) {
      t[e] = t.factory(e);
    }), t.load = function(t) {
      var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
      o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
      var i = document.getElementsByTagName("script")[0];
      i.parentNode.insertBefore(o, i);
    };
  }
}();
drift.SNIPPET_VERSION = '0.3.1';
drift.load('ryn92xris6a6');
</script>
      
    </body>

<?php include 'schema.org.php';?>

</html>