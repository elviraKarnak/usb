	<?php
   $footer_logo= get_field('footer_logo','option');
   $logo_url = get_field('logo_url', 'option');
   $copyright_text = get_field('copyright_text', 'option');

   $facebook_link = get_field('facebook_link', 'option');
   $twitter_link = get_field('twitter_link', 'option');
   $youtube_link = get_field('youtube_link', 'option');
   $instagram_link = get_field('instagram_link', 'option');
   $linkedin_link = get_field('linkedin_link', 'option');
   $pinterest_link = get_field('pinterest_link', 'option');
   $vimeo_link = get_field('vimeo_link', 'option');
   ?>
   <footer>
         <div class="footer-wrapper">
            <div class="container">
               <div class="row">
                  <div class="col-md-3">
                     <div class="footer-widgets">
                        <h3><?php echo get_field('footer_menu_title_1','option'); ?></h3>
                        <?php if (is_user_logged_in()) { ?>
                        <ul>  
                           <!-- <li><a href="<?php echo home_url('/my-account/'); ?>"><?php _e('Dashboard', 'usb' );?></a></li> -->
                           <li><a href="<?php echo wp_logout_url( home_url() ); ?>"><?php _e('Logout', 'usb' );?></a></li>
                        </ul>
                         <?php }else{ ?>  
                        <ul>  
                           <li><a href="<?php echo home_url('/my-account/'); ?>"><?php _e('Login', 'usb' );?></a></li>
                           <!-- <li><a href="<?php echo home_url('/my-account/'); ?>">Register</a></li> -->
                        </ul>
                        <?php } ?>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="footer-widgets">
                        <h3><?php echo get_field('footer_menu_title_2','option'); ?></h3>
                        <ul>
                           <?php wp_nav_menu( array( 'container' => false,'items_wrap' => '%3$s','theme_location' => 'footer1')); ?>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="footer-widgets">
                        <h3><?php echo get_field('footer_menu_title_3','option'); ?></h3>
                        <ul>
                           <?php wp_nav_menu( array( 'container' => false,'items_wrap' => '%3$s','theme_location' => 'footer2')); ?>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="footer-widgets">
                        <h3><?php echo get_field('footer_menu_title_4','option'); ?></h3>
                        <a href="<?php echo $logo_url; ?>"><img src="<?php echo $footer_logo['url']; ?>" alt="footer logo"></a>
                        <div class="social-media">
                           <?php if($facebook_link) { ?>
                           <a href="<?php echo $facebook_link; ?>" target="_blank"><i class="fab fa-facebook"></i></a>
                           <?php } ?>
                           <?php if($twitter_link) { ?>
                           <a href="<?php echo $twitter_link; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                           <?php } ?>
                           <?php if($youtube_link) { ?>
                           <a href="<?php echo $youtube_link; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                           <?php } ?>
                           <?php if($instagram_link) { ?>
                           <a href="<?php echo $instagram_link; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                           <?php } ?>
                           <?php if($linkedin_link) { ?>
                           <a href="<?php echo $linkedin_link; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                           <?php } ?>
                           <?php if($pinterest_link) { ?>
                           <a href="<?php echo $pinterest_link; ?>" target="_blank"><i class="fa-brands fa-pinterest"></i></a>
                           <?php } ?>
                           <?php if($vimeo_link) { ?>
                           <a href="<?php echo $vimeo_link; ?>" target="_blank"><i class="fa-brands fa-vimeo-v"></i></a>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="footer-bottom">
            <div class="footer-bottom-sec">
               <div class="container">
                  <div class="row align-items-center">
                     <div class="col-md-6">
                        <div class="copy-right">
                           <p><?php echo $copyright_text; ?></p>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="footer-nav">
                           <ul>
                              <?php wp_nav_menu( array( 'container' => false,'items_wrap' => '%3$s','theme_location' => 'footer3')); ?>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
    <?php
		wp_footer();
	?>
   </body>
</html>