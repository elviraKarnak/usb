<?php
/**
 * Template Name: Home page
 * Description: Page template full width.
 *
 */
get_header();
?>
<div class="sec-wrapper pb-0">

   <?php
   $home_page_banner = get_field('home_page_banner');
   $mission_content = get_field('mission_content');
   $mission_link = get_field('mission_link');
   $mission_title = get_field('mission_title');
   $service_loop = get_field('service_loop');
   $service_loop2 = get_field('service_loop2');
   $ride = get_field('ride');
   $ride_title = $ride['title'];
   $ride_image = $ride['image'];
   $ride_link = $ride['link'];
   $stay_connected = get_field('stay_connected');
   $stay_title = $stay_connected['title'];
   $stay_image = $stay_connected['image'];
   $stay_link = $stay_connected['link'];
   $stay_content = $stay_connected['content'];
   $content_sec = get_field('content_sec');
   $content1 = $content_sec['content'];
   $content_link = $content_sec['button'];
   $banner_slider = get_field('banner_slider');
   ?>
   <?php if ($banner_slider) { ?>
      <div class="banner-slider ">
         <?php foreach ($banner_slider as $row_slider) {
            $slider_image = $row_slider['image'];
            if ($slider_image) { ?>
               <div class="banner-slider-row">
                  <?php echo wp_get_attachment_image($slider_image, 'full') ?>
               </div>
            <?php }
            ;
         } ?>
      </div>
   <?php } ?>
   <?php if ($home_page_banner): ?>
      <section class="banner">
         <div class="bannnr-texts">
            <img class="img-fluid" src="<?php echo $home_page_banner['url']; ?>"
               alt="<?php echo $home_page_banner['alt']; ?>">
         </div>
      </section>
   <?php endif; ?>

   <?php if ($mission_content): ?>
      <section class="misson-sec space-mr ">
         <div class="misson-div py-0">
            <?php echo $mission_content; ?>
            <?php if ($mission_title && $mission_link): ?>
               <a class="black-btn" href="<?php echo $mission_link; ?>"><?php echo $mission_title; ?></a>
            <?php endif; ?>
         </div>
      </section>
   <?php endif; ?>
</div>

<?php if ($ride_title || $ride_link || $ride_image) { ?>
   <section class="ride-section text-center py-5" style="background-image:url('<?php echo $ride_image ?>')">
      <div class="container">
         <?php if ($ride_title) { ?>
            <h2><strong><?php echo $ride_title ?></strong></h2>
         <?php } ?>
         <?php

         if ($ride_link):
            $ride_url = $ride_link['url'];
            $ride_link_title = $ride_link['title'];
            $ride_link_target = $ride_link['target'] ? $ride_link['target'] : '_self';
            ?>
            <div class="btn-sc">
               <a class="white-btn" href="<?php echo esc_url($ride_link_url); ?>"
                  target="<?php echo esc_attr($ride_link_target); ?>"><?php echo esc_html($ride_link_title); ?></a>
            </div>
         <?php endif; ?>

      </div>

   </section>
<?php } ?>
<div class="sec-wrapper pb-0">
   <?php if ($service_loop): ?>
      <section class="service-sec">
         <?php
         $i = 1;
         foreach ($service_loop as $service_part):
            $service_type = $service_part['service_type'];
            if ($service_type == 'no-image') {
               $main_class = "more-nform-row";
            } else {
               $main_class = "service-content-row";
            }
            $service_title = $service_part['service_title'];
            $service_video = $service_part['service_video'];
            $service_content = $service_part['service_content'];
            $service_image = $service_part['service_image'];
            $button_link = $service_part['button'];


            if ($button_link):
               $button_link_url = $button_link['url'];
               $button_link_title = $button_link['title'];
               $button_link_target = $button_link['target'] ? $button_link['target'] : '_self';
            endif;

            ?>
            <div class="<?php echo $main_class; ?>">
               <?php if ($service_type != 'no-image'): ?>
                  <?php if ($i % 2 == 1): ?>
                     <div class="service-content-left">
                        <div class="service-text-div">
                           <h5><?php echo $service_title; ?></h5>
                           <?php echo $service_content; ?>
                           <?php

                           if ($button_link):

                              ?>
                              <a class="read-more" href="<?php echo esc_url($button_link_url); ?>"
                                 target="<?php echo esc_attr($button_link_target); ?>"><?php echo esc_html($button_link_title); ?></a>
                           <?php endif; ?>
                        </div>
                     </div>
                     <div class="service-content-right">
                        <?php if ($service_type == 'image'): ?>
                           <?php

                           if ($button_link):

                              ?>
                              <a href="<?php echo esc_url($button_link_url); ?>" target="<?php echo esc_attr($button_link_target); ?>">
                              <?php endif; ?>
                              <img class="img-fluid" src="<?php echo $service_image['url']; ?>"
                                 alt="<?php echo $service_image['alt']; ?>">
                              <?php

                              if ($button_link):

                                 ?>
                              </a>
                           <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($service_type == 'video'):
                           echo $service_video;
                        endif;
                        ?>

                     </div>
                  <?php else: ?>

                     <div class="service-content-left">
                        <?php if ($service_type == 'image'): ?>
                           <?php

                           if ($button_link):

                              ?>
                              <a href="<?php echo esc_url($button_link_url); ?>" target="<?php echo esc_attr($button_link_target); ?>">
                              <?php endif; ?>
                              <img class="img-fluid" src="<?php echo $service_image['url']; ?>"
                                 alt="<?php echo $service_image['alt']; ?>">
                              <?php

                              if ($button_link):

                                 ?>
                              </a>
                           <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($service_type == 'video'):
                           echo $service_video;
                        endif;
                        ?>
                     </div>
                     <div class="service-content-right">
                        <div class="service-text-div">
                           <h5><?php echo $service_title; ?></h5>
                           <?php echo $service_content; ?>
                           <?php

                           if ($button_link):

                              ?>
                              <a class="read-more" href="<?php echo esc_url($button_link_url); ?>"
                                 target="<?php echo esc_attr($button_link_target); ?>"><?php echo esc_html($button_link_title); ?></a>
                           <?php endif; ?>
                        </div>

                     </div>
                  <?php endif; ?>
               <?php else: ?>
                  <div class="container">
                     <div class="row">
                        <div class="col-md-12">
                           <h3><?php echo $service_title; ?></h3>
                           <?php echo $service_content; ?>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            </div>
            <?php $i++;
         endforeach; ?>
      </section>
   </div>
<?php endif; ?>
<?php if ($stay_title || $stay_link || $stay_image) { ?>
   <section class="stay-connected space-pd">
      <div class="container">
         <div class="row align-items-center">
            <div class=" <?php if ($stay_image) { ?>col-md-6<?php } ?>">
               <?php if ($stay_title) { ?>
                  <h2><strong><?php echo $stay_title ?></strong></h2>
               <?php } ?>
               <?php if ($stay_content) { ?>
                  <div class="my-4"><?php echo $stay_content ?></div>
               <?php } ?>
               <?php

               if ($stay_link):
                  $stay_url = $stay_link['url'];
                  $stay_link_title = $stay_link['title'];
                  $stay_link_target = $stay_link['target'] ? $stay_link['target'] : '_self';
                  ?>
                  <div class="btn-sc ">
                     <a class="black-btn block-btn" href="<?php echo esc_url($stay_link_url); ?>"
                        target="<?php echo esc_attr($stay_link_target); ?>"><?php echo esc_html($stay_link_title); ?></a>
                  </div>
               <?php endif; ?>
            </div>
            <?php if ($stay_image) { ?>
               <div class="col-md-6 text-end mt-md-0 mt-4">

                  <?php echo wp_get_attachment_image($stay_image, 'full') ?>


               </div>
            <?php } ?>

         </div>
      </div>
   </section>
<?php } ?>
<?php if ($service_loop2): ?>
   <div class="sec-wrapper pb-0">
      <section class="service-sec">
         <?php
         $j = 1; // Start a counter for odd/even row logic
         foreach ($service_loop2 as $service_part2):
            $service_type2 = $service_part2['service_type'];

            // Determine the main class based on service type
            $main_class2 = ($service_type2 == 'no-image') ? "more-nform-row" : "service-content-row";

            // Get the service details
            $service_title2 = $service_part2['service_title'];
            $service_video2 = $service_part2['service_video'];
            $service_content2 = $service_part2['service_content'];
            $service_image2 = $service_part2['service_image'];
            ?>

            <div class="<?php echo $main_class2; ?>">

               <?php if ($service_type2 != 'no-image'): ?>
                  <!-- Odd Row (j % 2 == 1) -->
                  <?php if ($j % 2 == 1): ?>
                     <div class="service-content-left">
                        <div class="service-text-div">
                           <h5><?php echo esc_html($service_title2); ?></h5>
                           <?php echo $service_content2; ?>
                        </div>
                     </div>
                     <div class="service-content-right">
                        <?php if ($service_type2 == 'image'): ?>
                           <img class="img-fluid" src="<?php echo esc_url($service_image2['url']); ?>"
                              alt="<?php echo esc_attr($service_image2['alt']); ?>">
                        <?php endif; ?>

                        <?php if ($service_type2 == 'video'): ?>
                           <?php echo $service_video2; ?>
                        <?php endif; ?>
                     </div>
                  <?php else: ?>
                     <!-- Even Row -->
                     <div class="service-content-left">
                        <?php if ($service_type2 == 'image'): ?>
                           <img class="img-fluid" src="<?php echo esc_url($service_image2['url']); ?>"
                              alt="<?php echo $service_image2['alt']; ?>">
                        <?php endif; ?>

                        <?php if ($service_type2 == 'video'): ?>
                           <?php echo $service_video2; ?>
                        <?php endif; ?>
                     </div>
                     <div class="service-content-right">
                        <div class="service-text-div">
                           <h5><?php echo $service_title2; ?></h5>
                           <?php echo $service_content2; ?>
                        </div>
                     </div>
                  <?php endif; ?>
               <?php else: ?>

                  <div class="container">
                     <div class="row">
                        <div class="col-md-12">
                           <h3><?php echo $service_title2; ?></h3>
                           <?php echo $service_content2; ?>
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            </div>

            <?php $j++; endforeach; ?>
      </section>
   </div>
<?php endif; ?>

<?php if ($content1 || $content_link) { ?>
   <section class="content-section text-center space-mr ">
      <div class="container">
         <?php if ($content1) { ?>
            <?php echo $content1 ?>
         <?php } ?>
         <?php

         if ($content_link):
            $content_url = $ride_link['url'];
            $content_link_title = $content_link['title'];
            $content_link_target = $content_link['target'] ? $content_link['target'] : '_self';
            ?>
            <div class="btn-sc mt-5">
               <a class="black-btn block-btn mx-auto" href="<?php echo esc_url($content_link_url); ?>"
                  target="<?php echo esc_attr($content_link_target); ?>"><?php echo esc_html($content_link_title); ?></a>
            </div>
         <?php endif; ?>

      </div>

   </section>
<?php } ?>


<?php get_footer(); ?>