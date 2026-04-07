<?php get_header(); ?>
<?php //include_once('sidebar-slider.php'); ?>

<!-- ======== Slider END ======== -->
<!-- ======== Top Five Section Start ======== -->
      <section class="full top-five-section">
         <div class="container">
            <div class="row">
             <div class="cei-top-product-wraper">
                <div class="cei-top-product-top-sec">
                 
                    <div class="col-xs-12 col-sm-8 col-md-8 cat-row-1 cei-top-product-warp" style="display: none;">

                      <?php
                      $args = array( 'post_type' => 'product', 'order' => 'ASC', 'posts_per_page' => 1,'meta_key' => '_front_page_big', 'meta_value' => 'yes'); 
                      $usbpost = get_posts( $args ); 
                      foreach ( $usbpost as $post ) : setup_postdata( $post ); 
                      $usbtopimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'true');
                      $product = wc_get_product( $post->ID );
                      $post_excerpt =  substr($post->post_excerpt, 0, 60);
                      ?>
                      <a href=" <?php echo get_permalink( $post->ID ); ?>">

                      <div class="hover ehover11">
                        <div class="col-sm-6 no-padding">
                          <div class="overlay">
                            <h2 class="cei-product-title"><?php the_title(); ?></h2>
                            <p><?php echo $post_excerpt;?></p>
                          </div>
                        </div>
                        <div class="col-sm-6 no-padding">
                          <img class="img-responsive" src="<?php echo $usbtopimage[0]; ?>" alt="">
                        </div>
                      </div>
                      </a>

                    <?php endforeach; 
                      wp_reset_postdata();
                     ?>

                    </div>
                   

                  <div class="col-xs-12 col-sm-4 col-md-4 cei-top-product-right-sec" style="display: none;">
                    <?php
                    $args = array( 'post_type' => 'product', 'order' => 'ASC', 'posts_per_page' => 1,'meta_key' => '_front_page_small', 'meta_value' => 'yes','offset' => 1 ); 
                    $usbpost = get_posts( $args ); 
                    foreach ( $usbpost as $post ) : setup_postdata( $post ); 
                    $usbtopimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'true');
                    $product = wc_get_product( $post->ID );
                    ?>
                     <a href=" <?php echo get_permalink( $post->ID ); ?>">
                    <div class="col-xs-12 col-sm-12 col-md-12 cat-row-1 cei-top-product-warp">
                      <div class="hover ehover11">
                        <div class="col-sm-12 no-padding">
                          <img class="img-responsive" src="<?php echo $usbtopimage[0]; ?>" alt="">
                        </div>
                        <div class="col-sm-12 no-padding">
                          <div class="overlay">
                            <h2 class="cei-product-title"><?php the_title(); ?></h2>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                    <?php 
                      endforeach;
                      wp_reset_postdata();
                    ?>
                    
                  </div>
                </div>
                <div class="cei-bottom-product-wrap">
                 <?php
                  $args = array( 'post_type' => 'product', 'order' => 'ASC', 'posts_per_page' => 3,'meta_key' => '_front_page_small', 'meta_value' => 'yes','offset' => 2 ); 
                  $usbpost = get_posts( $args ); 
                  foreach ( $usbpost as $post ) : setup_postdata( $post ); 
                  $usbtopimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'true');
                  $product = wc_get_product( $post->ID );
                  ?>
                   
                  <div class="col-xs-12 col-sm-4 col-md-4 cat-row-1 cei-top-product-warp">
                    <a href=" <?php echo get_permalink( $post->ID ); ?>">
                      <div class="hover ehover11">
                        <div class="col-sm-12 no-padding">
                          <img class="img-responsive" src="<?php echo $usbtopimage[0]; ?>" alt="">
                        </div>
                        <div class="col-sm-12 no-padding">
                          <div class="overlay">
                            <h2 class="cei-product-title"><?php the_title(); ?></h2>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  
                    <?php 
                      endforeach;
                      wp_reset_postdata();
                    ?>
                  </div>
              </div>

            </div>
         </div> 
      </section>
     
      <!-- ======== Category Section End ======== -->
      <!-- ======== Company Promotion Section Start ======== -->
      <section class="full company-promo-section">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-12 no-padding">
                <?php $top_product_pro = get_theme_value("top5product_promotion");?>
                <?php if(!empty($top_product_pro)){?>
                  <h3 class="section-title"><?php _e( $top_product_pro, 'usb' );?></h3>
                <?php } ?>
               </div>
               <div class="company-promo-inner">
                  <div class="col-sm-4 col-xs-12 ad-img text-center">
                    <!--  <img src="<?php bloginfo('template_directory');?>/images/ad-img-left.jpg" /> -->
                    <?php $usb_promo_img_one = get_theme_value("usb_Promotion_imageone"); ?>
                     <?php if(!empty($usb_promo_img_one))
                        { ?>
                     <img src="<?php echo $usb_promo_img_one; ?>" alt="" />
                     <?php } else { ?>
                     <img src="<?php bloginfo('template_url')?>/images/ad-img-left.jpg" />
                     <?php } ?>
                     <div class="add-btn"><a href="<?php echo  $usb_left_button_link = get_theme_value("usb_left_button_link"); ?>" class=""><?php echo $usb_left_button_txt = get_theme_value("usb_left_button_text"); ?></a></div>
                  </div>
                  <div class="col-sm-4 col-xs-12 ad-img text-center">
                     <!-- <img src="<?php bloginfo('template_directory');?>/images/ad-img-right.jpg" /> -->
                     <?php $usb_promo_img_two = get_theme_value("usb_Promotion_imagetwo"); ?>
                     <?php if(!empty($usb_promo_img_two))
                        { ?>
                     <img src="<?php echo $usb_promo_img_two; ?>" alt="" />
                     <?php } else { ?>
                     <img src="<?php bloginfo('template_url')?>/images/ad-img-right.jpg" />
                     <?php } ?>
                     <div class="add-btn"><a href="<?php echo $usb_right_button_link = get_theme_value("usb_right_button_link"); ?>" class=""><?php echo $usb_right_button_txt = get_theme_value("usb_right_button_text"); ?></a></div>
                  </div>
                  <div class="col-sm-4 col-xs-12 padding-right0 text-center">
                  <?php $usb_video_embeded_code = get_theme_value("usb_video_embeded_code"); ?>
                  <?php if(!empty($usb_video_embeded_code)) {?>
                  <?php echo $usb_video_embeded_code ;  ?>
                  <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
<?php get_footer(); ?>