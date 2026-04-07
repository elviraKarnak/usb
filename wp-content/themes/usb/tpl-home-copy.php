<?php
/*Template Name: Home Copy Page*/
get_header();
?>

<!-- ======== Slider END ======== -->
<!-- ======== Top Five Section Start ======== -->
      <section class="full top-five-section">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-12 no-padding">
                  <h3 class="section-title"><?php _e( 'Top 5 products', 'usb' );?></h3>
               </div>
            </div>
            <div class="row">
            <div class="category_wraper">
				    <?php
				      $args = array( 'post_type' => 'product','tax_query' => array(array( 'taxonomy' => 'product_visibility','field' => 'name',
				      'terms'    => 'featured', ),), 'order' => 'DESC', 'posts_per_page' => 5, 'suppress_filters'=>0); 
				      $usbpost = get_posts( $args ); 
				      foreach ( $usbpost as $post ) : setup_postdata( $post ); 
				      $usbtopimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'true');
				      //$categories = get_the_terms( $post->ID, 'bitcoinico_cat' );
				    ?>

               <div class="col-sm-2 col-xs-12 no-padding">
                  <div class="top-five-box">
                     <a href="<?php the_permalink(); ?>">
                        <div class="top-five-img"><img src="<?php echo $usbtopimage[0]; ?>">
                      
                            <?php $field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);
                              if(!empty($field_id_value_popular)){ ?>
                                <span class="tag-sky">
                                  <?php _e( 'Populär', 'usb' );?>
                                </span>
                              <?php } ?>
                          
                          
                            <?php $field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);
                              if(!empty($field_id_value_new)){ ?>
                                <span class="tag-red">
                                  <?php _e( 'New', 'usb' );?>
                                </span>
                              <?php } ?>
                         
                        </div>
                        <!-- <h3>Nyheter</h3> -->
                        <h2><?php the_title(); ?></h2>
                       <p> <?php echo substr(get_the_excerpt(), 0,80); ?></p>
                        
                      <?php
                    /*if ( is_user_logged_in() ) { ?>
                     <div class="top-five-btn">
                        <a href="<?php the_permalink(); ?>"><?php _e( 'Order', 'usb' );?></a>
                     </div>
                     <?php } else{ ?>
                        <div class="top-five-btn btn-change">
                        <a href="<?php the_permalink(); ?>"><?php _e( 'Order', 'usb' );?> </a>
                        </div>
                       
                     <?php }*/ ?>
                  </div>
               </div>
              <?php 
                   endforeach; 
                wp_reset_postdata();
              ?>
               
               
            </div>
          </div>
         </div>
      </section>
      <!-- ======== Top Five Section End ======== -->
      <!-- ======== Category Section Start ======== -->
      <section class="full category-section">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-12 no-padding">
                  <h3 class="section-title"><?php _e( 'Top Categories', 'usb' );?></h3>
               </div>
            </div>
            <div class="row">
               <div class="full category-section-inner">

    <?php
      $j=1;
      $product_categories = get_terms( 'product_cat', array(
        'orderby'    => 'name',
        'order'      => 'ASC',
        'hide_empty' => true
    ));

    foreach( $product_categories as $product_cat ) :
     
        $cat_thumb_id = get_woocommerce_term_meta( $product_cat->term_id, 'thumbnail_id', true );
        $shop_catalog_img = wp_get_attachment_image_src( $cat_thumb_id, 'full' );
        $term_link = get_term_link( $product_cat, 'product_cat' );
        ?>

        <div class="col-sm-4 col-xs-12 cat-row-<?php echo $j ; ?>">
               <div class="hover ehover11">
                  <div class="col-sm-6 no-padding">
                     <div class="overlay">
                         <h2><a href="<?php echo $term_link; ?> "><?php echo $product_cat->name; ?></a></h2>
                       <!--  <a href="<?php //echo $term_link; ?>" class="info nullbutton">Click Here </a> -->
                     </div>
                  </div>
                  <div class="col-sm-6 no-padding">
                  <img class="img-responsive" src="<?php echo $shop_catalog_img[0]; ?>" />
                  </div>
               </div>
            </div>
             <?php $j++; ?>
             <?php endforeach; ?>
         </div>

         <!-- new section html add start -->
		<div class="cei-top-product-wraper">
			<div class="cei-top-product-top-sec">
				<div class="col-xs-12 col-sm-8 col-md-8 cat-row-1 cei-top-product-warp">
					<div class="hover ehover11">
						<div class="col-sm-6 no-padding">
							<div class="overlay">
								<h2 class="cei-sku-id">25383</h2>
								<h2 class="cei-product-title">Mässa Event</h2>
							  <!-- <a href="#" class="info nullbutton">Click Here</a> -->
							</div>
						</div>
						<div class="col-sm-6 no-padding">
							<img class="img-responsive" src="https://elvirainfotechcloud.com/usb/wp-content/uploads/2019/02/högtalare_montblanc_vit_2.jpg" alt="">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 cei-top-product-right-sec">
					<div class="col-xs-12 col-sm-12 col-md-12 cat-row-1 cei-top-product-warp">
						<div class="hover ehover11">
							<div class="col-sm-6 no-padding">
								<div class="overlay">
									<h2 class="cei-sku-id">25383</h2>
									<h2 class="cei-product-title">Mässa Event</h2>
								  <!-- <a href="#" class="info nullbutton">Click Here</a> -->
								</div>
							</div>
							<div class="col-sm-6 no-padding">
								<img class="img-responsive" src="https://elvirainfotechcloud.com/usb/wp-content/uploads/2019/02/3i1-Logoband-laddkabel-rund_13629_6.jpg" alt="">
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 cat-row-1 cei-top-product-warp">
						<div class="hover ehover11">
							<div class="col-sm-6 no-padding">
								<div class="overlay">
									<h2 class="cei-sku-id">25383</h2>
									<h2 class="cei-product-title">Mässa Event</h2>
								  <!-- <a href="#" class="info nullbutton">Click Here</a> -->
								</div>
							</div>
							<div class="col-sm-6 no-padding">
								<img class="img-responsive" src="https://elvirainfotechcloud.com/usb/wp-content/uploads/2019/02/3i1-Logoband-laddkabel-rund_13629_6.jpg" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 cat-row-1 cei-top-product-warp">
				<div class="hover ehover11">
					<div class="col-sm-6 no-padding">
						<div class="overlay">
							<h2 class="cei-sku-id">25383</h2>
							<h2 class="cei-product-title">Mässa Event</h2>
						  <!-- <a href="#" class="info nullbutton">Click Here</a> -->
						</div>
					</div>
					<div class="col-sm-6 no-padding">
						<img class="img-responsive" src="https://elvirainfotechcloud.com/usb/wp-content/uploads/2019/02/3i1-Logoband-laddkabel-rund_13629_6.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 cat-row-1 cei-top-product-warp">
				<div class="hover ehover11">
					<div class="col-sm-6 no-padding">
						<div class="overlay">
							<h2 class="cei-sku-id">25383</h2>
							<h2 class="cei-product-title">Mässa Event</h2>
						  <!-- <a href="#" class="info nullbutton">Click Here</a> -->
						</div>
					</div>
					<div class="col-sm-6 no-padding">
						<img class="img-responsive" src="https://elvirainfotechcloud.com/usb/wp-content/uploads/2019/02/3i1-Logoband-laddkabel-rund_13629_6.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 cat-row-1 cei-top-product-warp">
				<div class="hover ehover11">
					<div class="col-sm-6 no-padding">
						<div class="overlay">
							<h2 class="cei-sku-id">25383</h2>
							<h2 class="cei-product-title">Mässa Event</h2>
						  <!-- <a href="#" class="info nullbutton">Click Here</a> -->
						</div>
					</div>
					<div class="col-sm-6 no-padding">
						<img class="img-responsive" src="https://elvirainfotechcloud.com/usb/wp-content/uploads/2019/02/3i1-Logoband-laddkabel-rund_13629_6.jpg" alt="">
					</div>
				</div>
			</div>
		</div>

         <!-- new section html add end -->




            </div>
         </div>

      </section>

      <!-- ======== Category Section End ======== -->
      <!-- ======== Company Promotion Section Start ======== -->
      <section class="full company-promo-section">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-12 no-padding">
                  <h3 class="section-title"><?php _e( 'Top 5 products Promotion', 'usb' );?></h3>
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
