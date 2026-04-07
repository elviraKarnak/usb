<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <?php wp_head(); ?>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body <?php body_class(); ?>>
   <?php wp_body_open(); ?>
   <div class="site-header-wrap">
      <header>
         <div class="top-header">
            <div class="logo pt-0">
               <?php
               $logo = get_theme_mod('custom_logo');
               $image = wp_get_attachment_image_src($logo, 'full');
               $image_url = $image[0];
               ?>
               <a href="<?php echo get_bloginfo('url'); ?>">
                  <img src="<?php echo $image[0]; ?>" alt="<?php echo get_bloginfo('name'); ?>">
                  <!-- <p class="slogan"><?php echo get_field('logo_text_header', 'option'); ?></p> -->
               </a>
               <div class="toggle-menu" id="toggle-menu">
                  <div></div>
                  <div></div>
                  <div></div>
               </div>

            </div>
            <div class="top-header-right">


               <?php
               $taxonomy = 'pa_color'; // Replace 'your_taxonomy' with the actual taxonomy name
               // Get terms
               $attr_terms = get_terms($taxonomy);

               ?>

               <div class="top-headr-right-bottom">
                  <!-- Filter-Start-->
              
                    
                        <div class="secondary-header ps-xl-5">
                           <div class="secondary-header-wrap">
                              <form class="search-bar main_search_form">
                                 <div class="inpu-txt">
                                    <input type="text"
                                       placeholder="<?php echo get_field('product_search_placeholder_header', 'option'); ?>"
                                       name="search" class="search_text" value="<?php if (isset($_GET['sq'])):
                                          echo ($_GET['sq']);
                                       endif; ?>" />
                                       <input type="hidden" name="shop_link" class="shop_link" value="<?php echo get_field('serch_page','option'); ?>">
                                    <!-- <input type="hidden" name="post_type" value="product" />
                                    <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE; ?>"> -->
                                 </div>
                                 <div class="search-btn">
                                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                                 </div>
                              </form>
                           </div>
                        </div>
                    
                    
                        <div class="top-headr-right-top">
                           <div class="user-language">
                              <?php if (!is_user_logged_in()): ?>
                                 <div class="user-div">
                                    <h4><?php echo get_field('my_account_welcome_text', 'option'); ?></h4>
                                    <a class="my_account_link"
                                       href="<?php echo get_permalink(get_page_by_path('my-account')) ?>"><i
                                          class="icon fa fa-user"></i><?php echo get_field('my_account_text', 'option'); ?></a>
                                 </div>
                              <?php else: ?>
                                 <div class="user-div">
                                    <?php $current_user = wp_get_current_user();

                                    $display_name = $current_user->display_name;
                                    echo '<h4>' . $display_name . '</h4>';
                                    ?>
                                    <a class="my_account_link"
                                       href="<?php echo get_permalink(get_page_by_path('my-account')) ?>"><i
                                          class="icon fa fa-user"></i><?php echo get_field('my_account_text_after_login', 'option'); ?></a>
                                 </div>
                              <?php endif; ?>
                              <div class="language-selector">
                                 <div class="js">
                                    <div class="language-picker js-language-picker"
                                       data-trigger-class="btn btn--subtle">
                                       <?php  dynamic_sidebar('secondary_widget_area'); ?>
                                       <?php //echo do_shortcode('[currency_switcher]'); ?>
											<?php// echo do_shortcode('[gtranslate]');?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                 


                  <!-- Filter-End-->
                  <!-- <div class="search-bar">
                           <form role="search" id="searchform" action="<?php echo home_url(); ?>" method="get">
                            <input type="text" name="s" class="search-field" placeholder="<?php _e('Search…', 'usb'); ?>" required>
                            <button type="submit">search<img src="<?php echo get_template_directory_uri(); ?>/assets/images/feather-search.svg"></button>
                            <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE; ?>">              
                            <input type="hidden" name="post_type" value="product">
                        </form>
                        </div> -->
                  <div class="contact-information">
                     <?php the_field('sales_desk', 'option'); ?>
                  </div>
               </div>
            </div>
         </div>
         <div class="container">
            <div class="row align-items-center">
               <div class="col-lg-12 px-0">
                  <div class="navbar-div">
                     <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="container-fluid">
                           <div class="" id="navbarSupportedContent">
  
                              <?php
                              wp_nav_menu(
                                 array(
                                    'menu_class' => 'navbar-nav me-auto',
                                    'container' => '',
                                    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                     'walker' => new WP_Bootstrap_Navwalker(),
                                    'theme_location' => 'main-menu',
                                 )
                              );
                              ?>
                           </div>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
   </div>


	
	
   <script>
      jQuery(document).ready(function ($) {

         function addCloseButton() {
            var closeButton = $('<button class="close-menu">×</button>');
            closeButton.insertAfter('.navbar-div .navbar');
            closeButton.click(function () {
               $('.navbar-div').removeClass('active');
            });
         }


         $('#toggle-menu').click(function () {
            $('.navbar-div').toggleClass('active');

            if ($('.navbar-div').hasClass('active') && $('.close-menu').length === 0) {
               addCloseButton();
            }
         });
      });
   </script>