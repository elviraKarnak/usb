<!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <head>
      
      <meta charset="utf-8">
      <meta name="format-detection" content="telephone=no"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta charset="UTF-8">
      
      
      <?php wp_head(); ?>
      <script>
      var ajaxVars = {ajaxurl:"<?php echo admin_url( 'admin-ajax.php' );?>"};

          </script>
      </script>
   </head>
     <body <?php body_class(); ?>>
      <header class="header-style-1">
         <!-- ======== TOP MENU ======== -->
         <div class="top-bar animate-dropdown">
            <div class="container no-padding">
               <div class="header-top-inner">


                 <?php
                      if ( is_user_logged_in() ) { ?>
                      <div class="email-phone-sec">
                          <span class="navbar-text usb-address">
                              <?php _e('CTWO Products AB, Ridbanegatan 4, 213 77 Malmoe','address'); ?>
                            </span>
                           <span class="navbar-text phone-no">
                              <?php $headerphone = get_theme_value("usb_header_phone_number"); ?>
                              <a href="tel:<?php echo $headerphone; ?>"><i class="icon fa fa-phone"></i><?php _e( 'Phone', 'usb' );?> <?php echo $headerphone; ?></a>
                            </span>

                            <span class="navbar-text email-address">
                              <?php $emailaddress= get_theme_value("usb_header_email_address"); ?>
                              <a href="mailto:<?php echo $emailaddress; ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i><?php _e( 'EMAIL:', 'usb' );?> <?php echo $emailaddress; ?></a>
                            </span>

                            
                        </div>
                            <?php } ?>


                  <div class="cnt-account">
                     <ul class="list-unstyled">

                        
                     
                      <?php
                      $languages = icl_get_languages('skip_missing=0');
                     
                      foreach($languages as $l){
                        $lang_cls = ($l['code'] == ICL_LANGUAGE_CODE)?'current_lang' : '';
                      ?>
                      <a class="ei-lang <?php echo $lang_cls?>" href="<?php echo $l['url'];?>" title="<?php echo $l['native_name'];?>" class="glink nturl notranslate"><img src="<?php echo $l['country_flag_url'];?>" height="16" width="16" alt="<?php echo $l['native_name'];?>" /></a>
                      <?php
                      }
                      ?>


                        <!-- <li><a href="#"><span><img src="<?php //bloginfo('template_directory');?>/images/se.svg" /></span>
                           <span><img src="<?php //bloginfo('template_directory');?>/images/gb.svg" /></span> Språk</a></li> -->
     <!-- GTranslate: https://gtranslate.io/ -->
     <!-- <a href="#" onclick="doGTranslate('sv|sv');return false;" title="Swedish" class="glink nturl notranslate"><img src="//elvirainfotechcloud.com/usb/wp-content/plugins/gtranslate/flags/16/sv.png" height="16" width="16" alt="Swedish" /></a>
     
    <a href="#" onclick="doGTranslate('sv|en');return false;" title="English" class="glink nturl notranslate"><img src="//elvirainfotechcloud.com/usb/wp-content/plugins/gtranslate/flags/16/en.png" height="16" width="16" alt="English" /></a> --><!-- Språk --><?php _e( 'Language', 'usb' );?>
<style type="text/css">
#goog-gt-tt {display:none !important;}
.goog-te-banner-frame {display:none !important;}
.goog-te-menu-value:hover {text-decoration:none !important;}
.goog-text-highlight {background-color:transparent !important;box-shadow:none !important;}
body {top:0 !important;}
#google_translate_element2 {display:none!important;}
</style>

<div id="google_translate_element2"></div>
<script type="text/javascript">
function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'sv',autoDisplay: false}, 'google_translate_element2');}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


<script type="text/javascript">
function GTranslateGetCurrentLang() {var keyValue = document['cookie'].match('(^|;) ?googtrans=([^;]*)(;|$)');return keyValue ? keyValue[2].split('/')[2] : null;}
function GTranslateFireEvent(element,event){try{if(document.createEventObject){var evt=document.createEventObject();element.fireEvent('on'+event,evt)}else{var evt=document.createEvent('HTMLEvents');evt.initEvent(event,true,true);element.dispatchEvent(evt)}}catch(e){}}
function doGTranslate(lang_pair){if(lang_pair.value)lang_pair=lang_pair.value;if(lang_pair=='')return;var lang=lang_pair.split('|')[1];if(GTranslateGetCurrentLang() == null && lang == lang_pair.split('|')[0])return;var teCombo;var sel=document.getElementsByTagName('select');for(var i=0;i<sel.length;i++)if(/goog-te-combo/.test(sel[i].className)){teCombo=sel[i];break;}if(document.getElementById('google_translate_element2')==null||document.getElementById('google_translate_element2').innerHTML.length==0||teCombo.length==0||teCombo.innerHTML.length==0){setTimeout(function(){doGTranslate(lang_pair)},500)}else{teCombo.value=lang;GTranslateFireEvent(teCombo,'change');GTranslateFireEvent(teCombo,'change')}}
</script>
      
                        <li><a href="<?php echo get_permalink( get_page_by_path('my-account'))?>"><i class="icon fa fa-user"></i><?php _e( 'My account', 'usb' );?></a></li>
                        <!-- <li><a href="<?php //echo get_permalink( get_page_by_path('wishlist'))?>"><i class="icon fa fa-heart"></i><?php //_e( 'Wishlist', 'usb' );?></a></li> -->
                        
                        <!-- <li><a href="<?php //echo get_permalink( get_page_by_path('cart'))?>"><i class="icon fa fa-shopping-cart"></i><?php //_e( 'Min vagn', 'usb' );?></a></li> -->
                     </ul>
                  </div>
                  <div class="clearfix"></div>
               </div>
            </div>
         </div>
         <!-- ======== TOP MENU : END ======== -->
         
         <!-- ============= NAVBAR ================ -->
         <div class="header-nav animate-dropdown">
            <div class="no-padding container">
               <div class="yamm navbar navbar-default" role="navigation">
                  <div class="navbar-header">
                     <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only"><?php _e( 'Toggle navigation', 'usb' );?></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-2 logo-holder">
                     <!-- ======== LOGO ======== -->
                     
                     <div class="logo"> 
                        <?php $usblogo = get_theme_value("usb_header_logo"); ?>
                        <?php if(!empty($usblogo)) {?>
                        <a href="<?php echo home_url('/');?>"><img src="<?php echo $usblogo;?>" alt="" /></a>
                        <?php  } else {?>
                        <a href="<?php echo home_url('/');?>"> <img src="<?php bloginfo('template_url')?>/images/logo.png" alt=""> </a>
                        <?php }?>
                     </div>
                     <!-- ======== LOGO : END ======== --> 
                     <?php if(ICL_LANGUAGE_CODE == 'en') { ?>
                      <div class="news-tab">
                       <a href="<?php echo get_theme_value("usb_header_menu_link");?>"><?php _e( get_theme_value("usb_header_menu_text"), 'usb' ); ?></a>
                     </div>
                     <?php } else {?>
                     <div class="news-tab">
                       <a href="<?php echo get_theme_value("usb_header_menu_link_sv");?>"><?php _e( get_theme_value("usb_header_menu_text_sv"), 'usb' ); ?></a>
                     </div>
                     <?php } ?>
                  </div>
                  <div class="nav-bg-class col-xs-12 col-sm-12 col-md-7">
                     <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse" style="height: 0px;">
                        <div class="nav-outer">
                           <?php  $header = array(
                        'theme_location'  => '',
                        'menu'            => 'Headermenu',
                        'container'       => '',
                        'container_class' => '',
                        'container_id'    => '',
                        'menu_class'      => 'nav navbar-nav full-width',
                        'menu_id'         => '',
                        'echo'            => true,
                        'fallback_cb'     => 'wp_page_menu',
                        'before'          => '',
                        'after'           => '',
                        'link_before'     => '',
                        'link_after'      => '',
                        'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                        'depth'           => 0,
                        'walker'          => ''
                      );

                      wp_nav_menu( $header );?>
                     

                       
                          <!--  <div class="clearfix"></div> -->
                        </div>
                     </div>
                  </div>
                  <div class="col-xs-12 col-sm-12 col-md-3 top-search-holder">
                     <!-- =========== SEARCH AREA ======== -->
                     <div class="search-area">

                        <form role="search" id="searchform" action="<?php echo home_url(); ?>" method="get">
                      <input type="text" name="s" class="search-field" placeholder="<?php _e( 'Search…', 'usb' );?>">
                      <input type="submit" value="" class="search-button">              
                      <input type="hidden" name="lang" value="<?php echo ICL_LANGUAGE_CODE;?>">              
                      <input type="hidden" name="post_type" value="product">
                        </form>
                        <!-- <form>
                           <div class="control-group">
                              <input class="search-field" placeholder="Sök…">
                              <a class="search-button" href="#"></a> 
                           </div>
                        </form> -->
                        <?php if( current_user_can('administrator') ) { ?>
                        <div class="control-group">
                              <div class="admin-info">
                              <span>Info</span>
                              <div class="admin-menu"><?php wp_nav_menu( array('menu' => 'adminmenu',) );?></div>
                            </div>
                              
                        </div>
                      <?php } ?>
                     </div>
                     <!-- ===== SEARCH AREA : END ============ --> 
                  </div>
               </div>
            </div>
         </div>
         <!-- ======== Navbar END ======== --> 
      </header>
      <?php if (is_front_page() ){ 
      include_once('sidebar-slider.php'); 
       }
      ?>