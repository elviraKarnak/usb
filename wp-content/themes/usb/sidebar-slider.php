<section class="slider-section">
         <div class="container">
            <div class="row">
               <div class="col-xs-12 col-sm-12 no-padding">
                  <div class="owl-carousel owl-theme">
                     <?php
                        $args = array( 'post_type' => 'sliders', 'orderby'=> 'menu_order', 'order' => 'DESC',  'posts_per_page' => -1,'suppress_filters'=>0 );
                        $usbslider = get_posts( $args );
                        foreach ( $usbslider as $post ) : setup_postdata( $post );
                        $slidersimage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'full');
                        $slider_text = get_post_meta(get_the_ID(),'sider_text',true);
                        $slider_button = get_post_meta(get_the_ID(),'slider_button',true);
                        
                     ?>
                     <a href="<?php echo $slider_button;?>">
                        <div class="item slider-btn">
                           <img src="<?php echo strip_tags($slidersimage[0]); ?>" />
                           <?php if (!empty($slider_text)) {?>
                           <div class="button_text"><?php echo $slider_text;?></div>
                           <?php }?>
                       </div>
                    </a>
                    
                     <?php 
                     
                        $i++;
                        endforeach; 
                        wp_reset_postdata();
                     ?>
                  </div>
               </div>
            </div>
         </div>
</section>