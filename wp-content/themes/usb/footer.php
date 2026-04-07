<!-- ======== Company Promotion Section End ======== -->
      <footer id="footer" class="full footer color-bg">
         <div class="footer-bottom">
          <?php
          //if ( is_user_logged_in() )
           //{ ?>

            <div class="container">
               <div class="row">
                   <?php if(is_user_logged_in()){?>
                  <div class="col-xs-12 col-sm-6 col-md-3 padding-left0">
                     <div class="module-heading">
                        <h4 class="module-title"><?php echo $usbfootercontact = get_theme_value("usb_footer_contact"); ?></h4>
                     </div>
                     <!-- /.module-heading -->
                     
                     <div class="module-body">
                        <ul class="toggle-footer" style="">
                           <li class="media">
                              <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span> </div>
                              <div class="media-body">
                                 <p><?php echo $usbaddress = get_theme_value("usb_footer_address"); ?></p>
                              </div>
                           </li>
                           
                           
                        </ul>
                     </div>
                     
                     <!-- /.module-body --> 
                  </div>
                  <?php } ?>
                  <!-- /.col -->
                  <div class="col-xs-12 col-sm-6 col-md-3">
                     <?php if(is_user_logged_in()){?>
                     <div class="media toggle-footer">
                              <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                              <div class="media-body">
                                 <p><?php echo $usbcontactone = get_theme_value("usb_footer_phone_number_one"); ?><br>
                                    <?php echo $usbcontacttwo = get_theme_value("usb_footer_phone_number_two"); ?>
                                 </p>
                              </div>
                           </div>
                      <?php } ?>
                     
                  </div>
                  <!-- /.col -->
                  <div class="col-xs-12 col-sm-6 col-md-3">
                     <?php if(is_user_logged_in()){?>
                     <div class="media toggle-footer">
                              <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span> </div>
                              
                              <div class="media-body"> <span><a href="mailto:<?php echo $usbmail = get_theme_value("usb_footer_mail_id");?>"><?php echo $usbmail = get_theme_value("usb_footer_mail_id"); ?></a></span> </div>

                           </div>
                           <?php } ?>
                     <!-- /.module-heading -->
                     
                  </div>
                  <!-- /.col -->
                  <!-- /.col -->
                  <div class="col-xs-12 col-sm-6 col-md-3 right-footer-menu">
                     
                     <div class="media toggle-footer">
                              <?php dynamic_sidebar('sidebar-3');?>
                     </div>
                     <div class="media toggle-footer">
                              <?php dynamic_sidebar('sidebar-4');?>
                     </div>
                     <!-- /.module-heading -->                     
                  </div>
                  <!-- /.col -->
                  
               </div>
            </div>
             <?php // } ?>


         </div>
         
      </footer>
      
      <script>
         jQuery(document).ready(function() {
         jQuery(window).scroll(function () {
             if (jQuery(this).scrollTop() > 100) {
                 jQuery('.scrollup').fadeIn();
         //jQuery(".slidbox").addClass("mtp");
             } else {
                 jQuery('.scrollup').fadeOut();
         //jQuery(".slidbox").removeClass("mtp");
             }
         });
         
         jQuery('.scrollup').click(function () {
             jQuery("html, body").animate({
                 scrollTop: 0
             }, 600);
             return false;
         });
         
         
         });
         
      </script>
      <a href="#" class="scrollup"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
      <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js'></script>
      
       <?php wp_footer(); ?>
   </body>
</html>