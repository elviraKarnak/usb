<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  Automattic
 * @package WooCommerce/Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
global $product;

$short_description = apply_filters( 'woocommerce_short_description', $post->post_excerpt );

// if ( ! $short_description ) {
// 	return;
// }

?>
<div class="woocommerce-description-custom "><?php _e( 'Product Details', 'usb' ); ?></div>
<div class="woocommerce-product-details__short-description">
	<?php //echo $short_description; // WPCS: XSS ok. ?>
	<?php echo wp_safe_utf8_fix($short_description);?>
</div>



<?php  

 global $woocommerce_wpml;

  $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = get_woocommerce_currency();
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];
    if ($crncy == 'SEK') {
        $crncy = ' Kr';
    }


$price_500 = get_post_meta(get_the_ID(), '_price_option_500', true);

$price_500 = modify_price_customer_tier_wise($price_500);

$rate_change = get_field('price_fractor', 'option');

//var_dump($rate_change);

if(is_user_logged_in()){
 $rate_change = 0;   
}

    if ( $rate_change > 0 ) {
        $price_500 = floatval($rate_change) * floatval($price_500);
        }
    
 if (!empty($price_500)) {
        $price_num = number_format((float)$price_500, 2, ',', ' ');

        $int_part = '';
        $decimal_part = '';

        list($int_part, $decimal_part) = explode(',', $price_num);
        //echo '<p class="custom-price-range">' .__('From').$price_num .get_woocommerce_currency_symbol(). '</p>';
        echo '<p class="custom-price-range"><span class="from_span">'. __('FROM', 'usb').'</span><span  class="price_span">' . $int_part . ',<sup class="decimal-part">' . $decimal_part . '</sup> '. get_woocommerce_currency_symbol(). '</span></p>';
    }

                  $usb_original = json_decode(get_post_meta(get_the_ID(),'_usb_ocm_tlc',true),true); 
                  if(!empty($usb_original) && is_array($usb_original)):
                  $usb_original = array_map('array_filter', $usb_original);
                  $usb_original = array_filter($usb_original);
                  ?>
                  <?php
                      if($usb_original){
                          foreach ($usb_original as $key => $value) {

                            if($key == '152'){ ?>
                                  
                                  <?php 
                                  if ( !in_array( 'customer', (array) $user->roles ) ) {
                                  $qty5 = $value[4]; 
                                  if ( $rate_change > 0 ) {
                                    $qty5 = $qty5*$rate_change;
                                    $qty5 = number_format((float)$qty5, 2, '.', '');
                                  }
                                
                                if (!empty($qty5)) {

                                $price_num = number_format((float)$qty5, 2, ',', ' ');

                                $int_part = '';
                                $decimal_part = '';

                                list($int_part, $decimal_part) = explode(',', $price_num);
                                    //echo '<p class="custom-price-range">' .__('From').$price_num .get_woocommerce_currency_symbol(). '</p>';
                                    echo '<p class="custom-price-range"><span class="from_span">'. __('FROM', 'usb').'</span><span  class="price_span">' . $int_part . ',<sup class="decimal-part">' . $decimal_part . '</sup> '. get_woocommerce_currency_symbol(). '</span></p>';
                                }

                                
                                  
                            
                                   } ?>
                              
                              <?php
                          }}
                      }
                    endif;
                  ?>
      
            
