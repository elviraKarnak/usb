<?php
   /**
    * Variable product add to cart
    *
    * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
    *
    * HOWEVER, on occasion WooCommerce will need to update template files and you
    * (the theme developer) will need to copy the new files to your theme to
    * maintain compatibility. We try to do this as little as possible, but it does
    * happen. When this occurs the version of the template file will be bumped and
    * the readme will list any important changes.
    *
    * @see     https://docs.woocommerce.com/document/template-structure/
    * @author  WooThemes
    * @package WooCommerce/Templates
    * @version 3.0.0
    */
   if (!defined('ABSPATH')) {
       exit;
   }
   global $product;
   global $woocommerce_wpml;

   $cur_lang       = ICL_LANGUAGE_CODE;
   $crncy = get_woocommerce_currency();
   $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];
   if ($crncy == 'SEK') {
     $crncy = ' Kr';
   }

   error_reporting(0);
   $attributes=array();
   $attribute_keys = array_keys($attributes);
   do_action('woocommerce_before_add_to_cart_form');

   if (is_user_logged_in()) {

   if (!defined('ABSPATH')) {
       exit; // Exit if accessed directly
   }
   $has_row    = false;
   $attributes = $product->get_attributes();
   ob_start();
   ?>
  <form action="<?php echo get_site_url(); ?>/cart" class="form-horizontal" method="post" >
     <div class="row standard-product">
        <div class="col-xs-12 col-sm-3 choose-pcs">
           <?php 
              $user = wp_get_current_user();
                 $roles = $user->roles;
                  if($roles[0]=='administrator' || $roles[0]=='sales-user'){
                           ?>
                     <table class="table" data-dd="<?php echo $roles[0];?>">
                        <thead>
                           <tr>
                              <th><span><?php _e( 'Qty', 'usb' );?></span></th>
                              <th></th>
                              <th><?php _e( 'Price incl. options', 'usb' );?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                               $show_stnd_qty = json_decode(get_post_meta(get_the_ID(), '_show_stnd_qty', true),true); 
                               
                              

                              $price_option_1_net = get_post_meta(get_the_ID(), '_price_option_1', true);

                           if( $price_option_1_net){
                              $price_option_1 = modify_price_customer_tier_wise($price_option_1_net);

                           //    echo "rate change".$rate_change;

                              if ( $rate_change > 0 ) {
                                  $price_option_1 = floatval($rate_change) * floatval($price_option_1);
                              }


                               $price_option_1 = number_format((float)$price_option_1, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_1) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('1', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_1;
                                 ?>">1</td>
                              <td><input <?php
                                 if ('1' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="1" class="optionclick price_option_1" name="pcs" value="1" data-value="<?php
                                 echo $price_option_1;
                                 ?>"></td>
                              <td class="show_attr_price price_option_1"><?php
                                 echo $price_option_1;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }}

                              
                    
                              $price_option_25_net = get_post_meta(get_the_ID(), '_price_option_25', true);
                              
                              if( $price_option_25_net){

                              $price_option_25 = modify_price_customer_tier_wise($price_option_25_net);

                           //    echo "rate change".$rate_change;

                              if ( $rate_change > 0 ) {
                                  $price_option_25 = floatval($rate_change) * floatval($price_option_25);
                              }


                               $price_option_25 = number_format((float)$price_option_25, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_25) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('25', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_25;
                                 ?>">25</td>
                              <td><input <?php
                                 if ('25' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="1" class="optionclick price_option_25" name="pcs" value="25" data-value="<?php
                                 echo $price_option_25;
                                 ?>"></td>
                              <td class="show_attr_price price_option_1"><?php
                                 echo $price_option_25;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }}
                           
                              
                             $price_option_50_net = get_post_meta(get_the_ID(), '_price_option_50', true);

                              $price_option_50 = modify_price_customer_tier_wise($price_option_50_net);

                           //    echo "rate change".$rate_change;

                              if ( $rate_change > 0 ) {
                                  $price_option_50 = floatval($rate_change) * floatval($price_option_50);
                              }


                               $price_option_50 = number_format((float)$price_option_50, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_50) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('50', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_50;
                                 ?>">50</td>
                              <td><input <?php
                                 if ('50' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="50" class="optionclick price_option_50" name="pcs" value="50" data-value="<?php
                                 echo $price_option_50;
                                 ?>"></td>
                              <td class="show_attr_price price_option_50"><?php
                                 echo $price_option_50;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              ?>
                           <?php
                              $price_option_100_net = get_post_meta(get_the_ID(), '_price_option_100', true);
                               $price_option_100=modify_price_customer_tier_wise($price_option_100_net);
                              if ( $rate_change > 0 ) {
                                  $price_option_100 = floatval($rate_change) * floatval($price_option_100);
                              }
                              $price_option_100 = number_format((float)$price_option_100, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_100) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('100', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_100;
                                 ?>">100</td>
                              <td><input <?php
                                 if ('100' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="100" class="price_option_100 optionclick" name="pcs" value="100" data-value="<?php
                                 echo $price_option_100;
                                 ?>"></td>
                              <td class="price_option_100 show_attr_price"><?php
                                 echo $price_option_100;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              ?>
                           <?php
                              $price_option_250_net = get_post_meta(get_the_ID(), '_price_option_250', true);
                              $price_option_250=modify_price_customer_tier_wise($price_option_250_net);
                              if ( $rate_change > 0 ) {
                                  $price_option_250 = floatval($rate_change) * floatval($price_option_250);
                              }
                              $price_option_250 = number_format((float)$price_option_250, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_250) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('250', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_250;
                                 ?>">250</td>
                              <td><input <?php
                                 if ('250' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="250" class="price_option_250 optionclick" name="pcs" value="250" data-value="<?php
                                 echo $price_option_250;
                                 ?>"></td>
                              <td class="price_option_250 show_attr_price"><?php
                                 echo $price_option_250;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              ?>
                           <?php
                              $price_option_500_net = get_post_meta(get_the_ID(), '_price_option_500', true);
                              // echo $price_option_500_net;
                              // echo "<br>";
                              $price_option_500=modify_price_customer_tier_wise($price_option_500_net);
                              if ( $rate_change > 0 ) {
                                  $price_option_500 = floatval($rate_change) * floatval($price_option_500);
                              }
                              $price_option_500 = number_format((float)$price_option_500, 2, '.', '');
                              // echo $price_option_500;
                              // echo "<br>";
                              ?>
                           <?php
                              if ($price_option_500) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('500', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_500;
                                 ?>">500</td>
                              <td><input <?php
                                 if ('500' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="500" class="price_option_500 optionclick" name="pcs" value="500" data-value="<?php
                                 echo $price_option_500;
                                 ?>"></td>
                              <td class="price_option_500 show_attr_price"><?php
                                 echo $price_option_500;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              ?>
                           <?php
                              $user = wp_get_current_user();
                              // if ( !in_array( 'customer', (array) $user->roles ) ) {
                                    //The user has the "author" role
                                
                                $price_option_1000_net = get_post_meta(get_the_ID(), '_price_option_1000', true);
                                $price_option_1000=modify_price_customer_tier_wise($price_option_1000_net);
                                if ( $rate_change > 0 ) {
                                    $price_option_1000 = floatval($rate_change) * floatval($price_option_1000);
                                }
                                $price_option_1000 = number_format((float)$price_option_1000, 2, '.', '');
                                ?>
                           <?php
                              if ($price_option_1000) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('1000', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_1000;
                                 ?>">1000</td>
                              <td><input <?php
                                 if ('1000' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="1000" class="price_option_1000 optionclick" name="pcs" value="1000" data-value="<?php
                                 echo $price_option_1000;
                                 ?>"></td>
                              <td class="price_option_1000 show_attr_price"><?php
                                 echo $price_option_1000;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              ?>
                           <?php
                               $price_option_2500_net = get_post_meta(get_the_ID(), '_price_option_2500', true);
                               $price_option_2500=modify_price_customer_tier_wise($price_option_2500_net);
                              if ( $rate_change > 0 ) {
                                  $price_option_2500 = floatval($rate_change) * floatval($price_option_2500);
                              }
                              $price_option_2500 = number_format((float)$price_option_2500, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_2500) {
                              ?>
                           <tr <?php if (!empty($show_stnd_qty) && in_array('2500', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_2500;
                                 ?>">2500</td>
                              <td><input <?php
                                 if ('2500' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="2500" class="price_option_2500 optionclick" name="pcs" value="2500" data-value="<?php
                                 echo $price_option_2500;
                                 ?>"></td>
                              <td class="price_option_2500 show_attr_price"><?php
                                 echo $price_option_2500;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              ?>
                           <?php
                              $price_option_5000_net = get_post_meta(get_the_ID(), '_price_option_5000', true);
                              $price_option_5000=modify_price_customer_tier_wise($price_option_5000_net);
                              if ( $rate_change > 0 ) {
                                  $price_option_5000 = floatval($rate_change) * floatval($price_option_5000);
                              }
                              $price_option_5000 = number_format((float)$price_option_5000, 2, '.', '');
                              ?>
                           <?php
                              if ($price_option_5000) {
                              ?>
                           <tr class="aa" <?php if (!empty($show_stnd_qty) && in_array('5000', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                              <td class="optionprice"  data-value="<?php
                                 echo $price_option_5000;
                                 ?>">5000</td>
                              <td><input <?php
                                 if ('5000' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                                     echo 'checked';
                                 }
                                 ?> type="radio" data-pcs="5000" class="price_option_5000 optionclick" name="pcs" value="5000" data-value="<?php
                                 echo $price_option_5000;
                                 ?>"></td>
                              <td class="price_option_5000 show_attr_price"><?php
                                 echo $price_option_5000;
                                 ?> <?php echo $crncy;?></td>
                           </tr>
                           <?php
                              }
                              // }
                              ?>
                           <tr class="own-quantity-wrap">
                              <td colspan="3">
                                 <label><?php _e( 'Own Quantity', 'usb' );?></label>
                              </td>
                           </tr>
                           <tr class="own-quantity-inner">
                              <td colspan="3">
                                 <input type="text" name="add_custom_quantity"  class="custom_quantity">
                              </td>
                              <td class="quantity_set_own">
                                 <input type="hidden" name="woo_currency" id="woo_currency" value="<?php echo $crncy;?>">
                                 <!-- <input type="radio" name="pcs" data-pcs="" data-chk="other" class="optionclick check_qval" value="" data-value=""> -->
                              </td>
                              <td>
                                 <!-- <label>-- <?php //echo $crncy;?></label> -->
                              </td>
                           </tr>
                        </tbody>
                     </table>
                     <?php 
                   } 
             $show_stnd_qty = json_decode(get_post_meta(get_the_ID(), '_show_stnd_qty', true),true); 
             // print_r($show_stnd_qty);

             if($roles[0]=='customer' ) { 
              ?>
               <table class="table">
                  <thead>
                     <tr>
                        <th><span><?php _e( 'Qty', 'usb' );?></span></th>
                        <th></th>
                        <th><?php _e( 'Price incl. options', 'usb' );?></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                         
                        
                        $price_option_50_net = get_post_meta(get_the_ID(), '_price_option_50', true);
                        $price_option_50=modify_price_customer_tier_wise($price_option_50_net);

                        if ( $rate_change > 0 ) {
                            $price_option_50 = $rate_change * $price_option_50;
                        }
                        $price_option_50 = number_format((float)$price_option_50, 2, '.', '');
                        ?>
                     <?php
                        if ($price_option_50) {
                        ?>
                     <tr <?php if (!empty($show_stnd_qty) && in_array('50', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                        <td class="optionprice"  data-value="<?php
                           echo $price_option_50;
                           ?>">50</td>
                        <td><input <?php
                           if ('50' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                               echo 'checked';
                           }
                           ?> type="radio" data-pcs="50" class="optionclick price_option_50" name="pcs" value="50" data-value="<?php
                           echo $price_option_50;
                           ?>"></td>
                        <td class="show_attr_price price_option_50"><?php
                           echo $price_option_50;
                           ?> <?php echo $crncy;?></td>
                     </tr>
                     <?php
                        }
                        ?>
                     <?php
                        $price_option_100_net = get_post_meta(get_the_ID(), '_price_option_100', true);
                        $price_option_100=modify_price_customer_tier_wise($price_option_100_net);
                        if ( $rate_change > 0 ) {
                            $price_option_100 = floatval($rate_change) * floatval($price_option_100);
                        }
                        $price_option_100 = number_format((float)$price_option_100, 2, '.', '');
                        ?>
                     <?php
                        if ($price_option_100) {
                        ?>
                     <tr <?php if (!empty($show_stnd_qty) && in_array('100', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                        <td class="optionprice"  data-value="<?php
                           echo $price_option_100;
                           ?>">100</td>
                        <td><input <?php
                           if ('100' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                               echo 'checked';
                           }
                           ?> type="radio" data-pcs="100" class="price_option_100 optionclick" name="pcs" value="100" data-value="<?php
                           echo $price_option_100;
                           ?>"></td>
                        <td class="price_option_100 show_attr_price"><?php
                           echo $price_option_100;
                           ?> <?php echo $crncy;?></td>
                     </tr>
                     <?php
                        }
                        ?>
                     <?php
                        $price_option_250_net = get_post_meta(get_the_ID(), '_price_option_250', true);
                        $price_option_250=modify_price_customer_tier_wise($price_option_250_net);
                        if ( $rate_change > 0 ) {
                            $price_option_250 = floatval($rate_change) * floatval($price_option_250);
                        }
                        $price_option_250 = number_format((float)$price_option_250, 2, '.', '');
                        ?>
                     <?php
                        if ($price_option_250) {
                        ?>
                     <tr <?php if (!empty($show_stnd_qty) && in_array('250', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                        <td class="optionprice"  data-value="<?php
                           echo $price_option_250;
                           ?>">250</td>
                        <td><input <?php
                           if ('250' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                               echo 'checked';
                           }
                           ?> type="radio" data-pcs="250" class="price_option_250 optionclick" name="pcs" value="250" data-value="<?php
                           echo $price_option_250;
                           ?>"></td>
                        <td class="price_option_250 show_attr_price"><?php
                           echo $price_option_250;
                           ?> <?php echo $crncy;?></td>
                     </tr>
                     <?php
                        }
                        ?>
                     <?php
                         $price_option_500_net = get_post_meta(get_the_ID(), '_price_option_500', true);
                         $price_option_500=modify_price_customer_tier_wise($price_option_500_net);
                        if ( $rate_change > 0 ) {
                            $price_option_500 = floatval($rate_change) * floatval($price_option_500);
                        }
                        $price_option_500 = number_format((float)$price_option_500, 2, '.', '');
                        ?>
                     <?php
                        if ($price_option_500) {
                        ?>
                     <tr <?php if (!empty($show_stnd_qty) && in_array('500', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                        <td class="optionprice"  data-value="<?php
                           echo $price_option_500;
                           ?>">500</td>
                        <td><input <?php
                           if ('500' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                               echo 'checked';
                           }
                           ?> type="radio" data-pcs="500" class="price_option_500 optionclick" name="pcs" value="500" data-value="<?php
                           echo $price_option_500;
                           ?>"></td>
                        <td class="price_option_500 show_attr_price"><?php
                           echo $price_option_500;
                           ?> <?php echo $crncy;?></td>
                     </tr>
                     <?php
                        }
                        ?>
                     <tr class="own-quantity-wrap">
                        <td>
                           <label><?php _e( 'Own Quantity', 'usb' );?></label>
                        </td>
                     </tr>
                     <tr class="own-quantity-inner">
                        <script type="text/javascript">
                           function minmax(value, min='', max) 
                           {
                               if(parseInt(value) < min || isNaN(parseInt(value))) 
                                   return min; 
                               else if(parseInt(value) > max) 
                                   return max; 
                               else return value;
                           }
                        </script>
                        <td>
                           <input type="text" name="add_custom_quantity" maxlength="5" onkeyup="this.value = minmax(this.value,'' , 500)" class="custom_quantity">
                        </td>
                        <td class="quantity_set_own">
                           <input type="hidden" name="woo_currency" id="woo_currency" value="<?php echo $crncy;?>">
                           <!-- <input type="radio" name="pcs" data-pcs="" data-chk="other" class="optionclick check_qval" value="" data-value=""> -->
                        </td>
                        <td>
                           <!-- <label>-- <?php //echo $crncy;?></label> -->
                        </td>
                     </tr>
                  </tbody>
               </table>
               <?php 
             } 
              ?>
           <?php if ($roles[0]=='customer' && !empty($show_stnd_qty) && !in_array('50', $show_stnd_qty) && !in_array('100', $show_stnd_qty) && !in_array('250', $show_stnd_qty) && !in_array('500', $show_stnd_qty) ) { ?>
           <table class="table">
              <thead>
                 <tr>
                    <th><span><?php _e( 'Qty', 'usb' );?></span></th>
                    <th></th>
                    <th><?php _e( 'Price incl. options', 'usb' );?></th>
                 </tr>
              </thead>
              <tbody>
                 <?php
                    $show_stnd_qty = json_decode(get_post_meta(get_the_ID(), '_show_stnd_qty', true),true);                      
                    ?>
                 <?php
                    $user = wp_get_current_user();
                    if ( !in_array( 'customer', (array) $user->roles ) ) {
                          //The user has the "author" role
                      
                      $price_option_1000_net = get_post_meta(get_the_ID(), '_price_option_1000', true);
                      $price_option_1000=modify_price_customer_tier_wise($price_option_1000_net);
                      if ( $rate_change > 0 ) {
                          $price_option_1000 = floatval($rate_change) * floatval($price_option_1000);
                      }
                      $price_option_1000 = number_format((float)$price_option_1000, 2, '.', '');
                      ?>
                 <?php
                    if ($price_option_1000) {
                    ?>
                 <tr <?php if (!empty($show_stnd_qty) && in_array('1000', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                    <td class="optionprice"  data-value="<?php
                       echo $price_option_1000;
                       ?>">1000</td>
                    <td><input <?php
                       if ('1000' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                           echo 'checked';
                       }
                       ?> type="radio" data-pcs="1000" class="price_option_1000 optionclick" name="pcs" value="1000" data-value="<?php
                       echo $price_option_1000;
                       ?>"></td>
                    <td class="price_option_1000 show_attr_price"><?php
                       echo $price_option_1000;
                       ?> <?php echo $crncy;?></td>
                 </tr>
                 <?php
                    }
                    ?>
                 <?php
                    $price_option_2500_net = get_post_meta(get_the_ID(), '_price_option_2500', true);
                    $price_option_2500=modify_price_customer_tier_wise($price_option_2500_net);
                    if ( $rate_change > 0 ) {
                        $price_option_2500 = floatval($rate_change) * floatval($price_option_2500);
                    }
                    $price_option_2500 = number_format((float)$price_option_2500, 2, '.', '');
                    ?>
                 <?php
                    if ($price_option_2500) {
                    ?>
                 <tr <?php if (!empty($show_stnd_qty) && in_array('2500', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                    <td class="optionprice"  data-value="<?php
                       echo $price_option_2500;
                       ?>">2500</td>
                    <td><input <?php
                       if ('2500' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                           echo 'checked';
                       }
                       ?> type="radio" data-pcs="2500" class="price_option_2500 optionclick" name="pcs" value="2500" data-value="<?php
                       echo $price_option_2500;
                       ?>"></td>
                    <td class="price_option_2500 show_attr_price"><?php
                       echo $price_option_2500;
                       ?> <?php echo $crncy;?></td>
                 </tr>
                 <?php
                    }
                    ?>
                 <?php
                    $price_option_5000_net = get_post_meta(get_the_ID(), '_price_option_5000', true);
                    $price_option_5000=modify_price_customer_tier_wise($price_option_5000_net);
                    if ( $rate_change > 0 ) {
                        $price_option_5000 = floatval($rate_change) * floatval($price_option_5000);
                    }
                    $price_option_5000 = number_format((float)$price_option_5000, 2, '.', '');
                    ?>
                 <?php
                    if ($price_option_5000) {
                    ?>
                 <tr class="aa" <?php if (!empty($show_stnd_qty) && in_array('5000', $show_stnd_qty)) { echo 'style="display:none;"';} ?>>
                    <td class="optionprice"  data-value="<?php
                       echo $price_option_5000;
                       ?>">5000</td>
                    <td><input <?php
                       if ('5000' == get_post_meta(get_the_ID(), '_active_qty', true)) {
                           echo 'checked';
                       }
                       ?> type="radio" data-pcs="5000" class="price_option_5000 optionclick" name="pcs" value="5000" data-value="<?php
                       echo $price_option_5000;
                       ?>"></td>
                    <td class="price_option_5000 show_attr_price"><?php
                       echo $price_option_5000;
                       ?> <?php echo $crncy;?></td>
                 </tr>
                 <?php
                    }
                    }
                    ?>
                 <tr class="own-quantity-wrap">
                    <td>
                       <label><?php _e( 'Own Quantity', 'usb' );?></label>
                    </td>
                 </tr>
                 <tr class="own-quantity-inner">
                    <td>
                       <input type="text" name="add_custom_quantity" class="custom_quantity">
                    </td>
                    <td class="quantity_set_own">
                       <input type="hidden" name="woo_currency" id="woo_currency" value="<?php echo $crncy;?>">
                       <!-- <input type="radio" name="pcs" data-pcs="" data-chk="other" class="optionclick check_qval" value="" data-value=""> -->
                    </td>
                    <td>
                       <!-- <label>-- <?php //echo $crncy;?></label> -->
                    </td>
                 </tr>
              </tbody>
           </table>
           <?php } ?>
        </div>
        <div class="col-xs-12 col-sm-2 custom-config">
           <div class="product_attributes">
              <?php
                 $get_attribute_pr_vl = get_post_meta($product->get_id(),'attribute_pr_vl',true);
                 $get_attribute_vl = get_post_meta($product->get_id(),'attribute_vl',true);
                 
                   $i = 1;
                    foreach ($attributes as $attribute):
                        if (empty($attribute['is_visible']) || ($attribute['is_taxonomy'] && !taxonomy_exists($attribute['name'])))
                            continue;
                        $values  = wc_get_product_terms($product->get_id(), $attribute['name'], array(
                            'fields' => 'names'
                        ));
                        $att_val = apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);
                        $terms   = get_the_terms($product->get_id(), $attribute['name']);
                    
                        if (empty($att_val))
                            continue;
                        $has_row = true;
                    ?>
              <div class="right-sec"><?php
                 _e(wc_attribute_label($attribute['name']),'attributename') ;
                 ?></div>
              <div class="standar-print-position">
                 <!-- <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    <span class="caret"></span></button> -->
                 <select class="printposition<?php echo $i;?>">
                    <option data-tax="<?php echo $attribute['name']; ?>" name="attr_<?php echo $attribute['name']; ?>" data-price50="0" data-price100="0" data-price250="0" data-price500="0" data-price1000="0" data-label="Default" data-price2500="0" data-price5000="0" value="" class="attr_optn"><?php _e( 'Choose', 'usb' );?></option>
                    <?php
                       if ($terms && !is_wp_error($terms)) {
                           foreach ($terms as $term) {
                               $price50_net  = get_term_meta($term->term_id, '_price50', true);
                               $price50=modify_price_customer_tier_wise($price50_net);

                               $price100_net  = get_term_meta($term->term_id, '_price100', true);
                               $price100=modify_price_customer_tier_wise($price100_net);

                               $price250_net  = get_term_meta($term->term_id, '_price250', true);
                               $price250=modify_price_customer_tier_wise($price250_net);

                               $price500_net  = get_term_meta($term->term_id, '_price500', true);
                               $price500=modify_price_customer_tier_wise($price500_net);

                               $price1000_net = get_term_meta($term->term_id, '_price1000', true);
                               $price1000=modify_price_customer_tier_wise($price1000_net);

                               $price2500_net = get_term_meta($term->term_id, '_price2500', true);
                               $price2500=modify_price_customer_tier_wise($price2500_net);

                               $price5000_net = get_term_meta($term->term_id, '_price5000', true);
                               $price5000=modify_price_customer_tier_wise($price5000_net);

                               if ( $rate_change > 0 ) {
                                   $price50   = floatval($rate_change) * floatval($price50);
                                   $price100  = floatval($rate_change) * floatval($price100);
                                   $price250  = floatval($rate_change) * floatval($price250);
                                   $price500  = floatval($rate_change) * floatval($price500);
                                   $price1000 = floatval($rate_change) * floatval($price1000);
                                   $price2500 = floatval($rate_change) * floatval($price2500);
                                   $price5000 = floatval($rate_change) * floatval($price5000);
                               }

                               $price50 = number_format((float)$price50, 2, '.', '');
                               $price100 = number_format((float)$price100, 2, '.', '');
                               $price250 = number_format((float)$price250, 2, '.', '');
                               $price500 = number_format((float)$price500, 2, '.', '');
                               $price2500 = number_format((float)$price2500, 2, '.', '');
                               $price5000 = number_format((float)$price5000, 2, '.', '');
                       
                       
                              // $get_attribute_id = $term->term_id;
                              // $get_attribute_name = $term->name;
                       
                              // $field_name = $get_attribute_name.'_'.$get_attribute_id;
                              // $field_name = str_replace(' ', '', $field_name);
                              // $attribute_vl = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                              // $attribute_pr_vl = (!empty($get_attribute_pr_vl[$field_name])) ? $get_attribute_pr_vl[$field_name] :'';
                       
                              $get_attribute_id = $term->term_id;
                              $get_attribute_name = $term->name;
                       
                              $field_name = $get_attribute_name.'_'.$get_attribute_id;
                              $field_name = str_replace(' ', '', $field_name);
                              $attribute_vl = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                              $attribute_pr_vl = (!empty($get_attribute_pr_vl[$field_name])) ? $get_attribute_pr_vl[$field_name] :'';
                              $attribute_vl_chk = ($attribute_vl=='yes')?'selected':'';
                       
                       
                       
                       ?>
                    <option <?php echo $attribute_vl_chk;?> data-class="printposition<?php echo $i;?>" data-disable="<?php echo $attribute_pr_vl;?>" id="elm<?php echo $term->term_id;?>" data-label="<?php
                       echo trim(preg_replace('/\s*\([^)]*\)/', '', $term->name));
                       ?>" data-article="<?php echo $term->slug;?>" type="radio" data-tax="<?php
                       echo $attribute['name'];
                       ?>" class="attr_optn" name="attr_<?php
                       echo $attribute['name'];
                       ?>" data-price50="<?php
                       echo $price50;
                       ?>" data-price100="<?php
                       echo $price100;
                       ?>" data-price250="<?php
                       echo $price250;
                       ?>" data-price500="<?php
                       echo $price500;
                       ?>" data-price1000="<?php
                       echo $price1000;
                       ?>" data-price2500="<?php
                       echo $price2500;
                       ?>" data-price5000="<?php
                       echo $price5000;
                       ?>" value="<?php
                       echo $term->term_id;
                       ?>"><label for="elm<?php echo $term->term_id;?>" ><?php
                       echo trim(preg_replace('/\s*\([^)]*\)/', '', $term->name));
                       ?></label></option>
                    <?php
                       }
                       }
                       ?>
                 </select>
                 <span class="cus-right-icon<?php echo $i;?>"></span>
              </div>
              <?php
                 $i++;
                  endforeach;
                  ?>
           </div>
        </div>
        <?php
           if ($has_row) {
               echo ob_get_clean();
           } else {
               ob_end_clean();
           }
           ?>


           
        <div class="col-xs-12 col-sm-7 summary">
           <h4><?php _e( 'SUMMARY', 'usb' );?></h4>
           <div class="standar_product_summary">
              <table class="table summary">
                 <thead>
                    <tr>
                       <th><?php _e( 'Art no', 'usb' );?></th>
                       <th><?php _e( 'Product', 'usb' );?></th>
                       <th><?php _e( 'Options', 'usb' );?></th>
                       <th><?php _e( 'Qty', 'usb' );?></th>
                       <th><?php _e( 'Price/pcs', 'usb' );?></th>
                       <th><?php _e( 'Total cost', 'usb' );?></th>
                    </tr>
                 </thead>
                 <tbody>
                    <tr>
                       <td><?php echo $product->get_sku();?></td>
                       <td>
                          <?php
                             echo get_the_title($product->ID);
                             ?>
                       </td>
                       <td></td>
                       <td class="show_qty" data-qty="0">0</td>
                       <td class="show_price_option a1" data-price="0">0 <?php echo $crncy;?></td>
                       <td class="total_price" data-price="0">0 <?php echo $crncy;?></td>
                    </tr>
                    <?php
                       foreach ($attributes as $attribute) {
                       ?>
                    <tr class="<?php
                       echo $attribute['name'];
                       ?>">
                       <td></td>
                       <td><?php
                          echo wc_attribute_label($attribute['name']);
                          ?></td>
                       <td></td>
                       <td class="show_qty" data-qty="0">0</td>
                       <td class="show_price_option attrprice" data-price="0">0 <?php echo $crncy;?></td>
                       <td class="total_price" data-price="0">0 <?php echo $crncy;?></td>
                    </tr>
                    <?php
                       }
                       ?>
                    <tr class="cus-your-price">
                       <td><?php //_e( 'Your Price', 'usb' );?></td>
                    </tr>
                    <tr class="summary-last">
                       <td></td>
                       <td><?php _e( 'Total amount', 'usb' );?></td>
                       <td></td>
                       <td class="totalpcs"><?php _e( 'Qty', 'usb' );?><input type="hidden" class="pcs" name="pcs" id="pcs"> <span>0</span></td>
                       <td class="totalprice"><?php _e( 'Price/pcs', 'usb' );?><input type="hidden" class="price" name="price" id="price"> <span>0 <?php echo $crncy;?></span></td>
                       <td class="totalamount"><?php _e( 'Total order', 'usb' );?><input type="hidden" class="totalamount" name="totalamount" id="totalamount"> <span>0 <?php echo $crncy;?></span></td>
                    </tr>
                    <tr class="cus-sales-price">
                       <td><?php //_e( 'Sales price', 'usb' );?></td>
                    </tr>
                    <!-- <tr class="summary-last" style="display: none;">
                       <td></td>
                       <td><?php //_e( 'Margin', 'usb' );?></td>
                       <td></td>
                       <td class="totalpcs"><span>0</span></td>
                       <td class="pricemargin"><input type="hidden" class="margin_price" name="margin_price" id="margin_price"> <span>0 <?php //echo $crncy;?></span></td>
                       <td class="totalmargin"><input type="hidden" class="margin_amount" name="margin_amount" id="margin_amount"> <span>0 <?php //echo $crncy;?></span></td>
                    </tr> -->
                    <tr class="summary-last summary-last-margin">
                       <td></td>
                       <td><?php _e( 'Margin', 'usb' );?></td>
                       <td></td>
                       <td class="totalpcs"><?php _e( 'Qty', 'usb' );?> <span>0</span></td>
                       <td class="pricemargin"><input type="hidden" class="margin_price" name="margin_price" id="margin_price"><?php _e( 'Price/pcs', 'usb' );?> <span>0 <?php echo $crncy;?></span></td>
                       <td class="totalmargin"><input type="hidden" class="margin_amount" name="margin_amount" id="margin_amount"><?php _e( 'Total order', 'usb' );?> <span>0 <?php echo $crncy;?></span></td>
                    </tr>
                 </tbody>
              </table>
           </div>
           <?php
              global $product;
              $id = $product->id;
              ?>
           <div class="cus-margin">
              <label><?php _e( 'Add your magrin', 'usb' );?></label>
              <input type="number" name="cus_margin" class="cus_margin">
              <div class="cus-margin-btn-warp">
                 <?php //echo do_shortcode('[usb_pdf pdf_name="Export"]');?>
                 <!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo get_the_ID();?>" target="_blank" data-productId="<?php //echo $id;?>"><?php //_e( 'Offer', 'usb' );?></a> -->
                 <!-- <a class="dwnpdf" href='?pdf=<?php //echo get_the_ID();?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en';?>' target='_blank'>
                 <?php //_e( 'Export', 'usb' );?></a> -->
                 <a class="down_pdf_summary marginpdf" href="?marginpdf=<?php echo get_the_ID();?>&lang=<?php echo $_GET['lang']?$_GET['lang']:'en';?>" target="_blank" data-productId="<?php echo $id;?>"><?php _e( 'PDF your margin', 'usb' );?></a>

                 <a class="down_pdf_summary" href="?offerpdf=<?php echo get_the_ID();?>&lang=<?php echo $_GET['lang']?$_GET['lang']:'en';?>" target="_blank" data-productId="<?php echo $id;?>"><?php _e( 'PDF rek prices', 'usb' );?></a>
              </div>
           </div>
        </div>
     </div>
  </form>


  <form class="margin_frm">
    <input type="hidden" value="<?php echo $id;?>" name="pdf">
    <input type="hidden" value="" name="margin_Qty" class="margin_Qty">
    <input type="hidden" value="" name="margin_Price" class="margin_Price">
    <input type="hidden" value="" name="margin_total" class="margin_total">
    <input type="hidden" value="" name="margin_woo_currency" class="margin_woo_currency">
    <input type="hidden" value="" name="margin_percentage" class="margin_percentage">
    <input type="hidden" value="<?php _e( 'Total amount', 'usb' );?>" name="margin_text" class="margin_text">
    <input type="hidden" value="<?php echo ICL_LANGUAGE_CODE;?>" name="lang" class="lang">   
  </form>
  <script>
      jQuery(document).ready(function () {
         jQuery(".down_pdf_summary.marginpdf").click(function (e) {

            e.preventDefault();

            var marginQty = jQuery(".summary-last-margin .totalpcs span").text().trim();
            var marginPrice = jQuery(".summary-last-margin .pricemargin span").text().trim();
            var marginTotal = jQuery(".summary-last-margin .totalmargin span").text().trim();
            var marginWooCurrency = jQuery("#woo_currency").val();
            var marginPercentage = jQuery(".cus_margin").val();

            jQuery(".margin_Qty").val(marginQty);
            jQuery(".margin_Price").val(marginPrice);
            jQuery(".margin_total").val(marginTotal);
            jQuery(".margin_woo_currency").val(marginWooCurrency);
            jQuery(".margin_percentage").val(marginPercentage);

            console.log("marginQty:", marginQty);
            console.log("marginPrice:", marginPrice);
            console.log("marginTotal:", marginTotal);
            console.log("marginWooCurrency:", marginWooCurrency);
            console.log("marginPercentage:", marginPercentage);
            console.log("margin form data:", jQuery(".margin_frm").serialize());

            // Temporary debug: do not submit yet
            return false;

             //jQuery(".margin_frm").submit();
         });

   
               // jQuery(".down_pdf_summary.marginpdf").click(function (e) {
               //    e.preventDefault();

               //    var marginQty = jQuery(".summary-last-margin .totalpcs span").text().trim();
               //    var marginPrice = jQuery(".summary-last-margin .pricemargin span").text().trim();
               //    var marginTotal = jQuery(".summary-last-margin .totalmargin span").text().trim();
               //    var marginWooCurrency = jQuery("#woo_currency").val();
               //    var marginPercentage = jQuery(".cus_margin").val();

               //    console.log("base #price:", jQuery("#price").val());
               //    console.log("base #totalamount:", jQuery("#totalamount").val());
               //    console.log("base margin row html:", jQuery(".summary-last-margin").html());
               //    console.log("summary-last-margin count:", jQuery(".summary-last-margin").length);

               //    jQuery(".margin_Qty").val(marginQty);
               //    jQuery(".margin_Price").val(marginPrice);
               //    jQuery(".margin_total").val(marginTotal);
               //    jQuery(".margin_woo_currency").val(marginWooCurrency);
               //    jQuery(".margin_percentage").val(marginPercentage);

               //    console.log("marginQty:", marginQty);
               //    console.log("marginPrice:", marginPrice);
               //    console.log("marginTotal:", marginTotal);
               //    console.log("marginWooCurrency:", marginWooCurrency);
               //    console.log("marginPercentage:", marginPercentage);
               //    console.log("margin form data:", jQuery(".margin_frm").serialize());

               //    return false;
               // });
            });



  </script>


  <script type="text/javascript">
     jQuery(document).ready(function(){
      
      var margainArray = {'1':  1.01,'2': 1.02,'3': 1.031,'4':  1.041,'5':  1.052,'6':  1.063,'7':  1.075,'8':  1.086,'9':  1.098,'10': 1.111,'11': 1.123,'12': 1.136,'13': 1.149,'14': 1.162,'15': 1.176,'16': 1.19,'17':  1.204,'18': 1.219,'19': 1.234,'20': 1.25,'21':  1.265,'22': 1.282,'23': 1.298,'24': 1.315,'25': 1.333,'26': 1.351,'27': 1.369,'28': 1.388,'29': 1.408,'30': 1.428,'31': 1.449,'32': 1.47,'33':  1.492,'34': 1.515,'35': 1.538,'36': 1.562,'37': 1.587,'38': 1.613,'39': 1.639,'40': 1.666,'41': 1.694,'42': 1.724,'43': 1.754,'44': 1.785,'45': 1.818,'46': 1.852,'47': 1.886,'48': 1.923,'49': 1.96,'50':  2,'51': 2.04,'52':  2.083,'53': 2.127,'54': 2.173,'55': 2.222,'56': 2.272,'57': 2.325,'58': 2.38,'59':  2.439,'60': 2.5,'61': 2.564,'62': 2.631,'63': 2.702,'64': 2.777,'65': 2.857,'66': 2.941,'67': 3.03,'68':  3.125,'69': 3.225,'70': 3.333,'71': 3.448,'72': 3.571,'73': 3.703,'74': 3.846,'75': 4,'76': 4.166,'77': 4.347,'78': 4.545,'79': 4.761,'80': 5,'81': 5.263,'82': 5.555,'83': 5.88,'84':  6.25,'85':  6.666,'86': 7.142,'87': 7.692,'88': 8.333,'89': 9.09,'90':  10,'91':  11.111,'92':  12.5,'93':  14.285,'94':  16.666,'95':  20,'96':  25,'97':  33.333,'98':  50,'99':  100,}; 
     
     
     var crncy = ' <?php echo $crncy;?>';

    jQuery(document).on('keyup','.cus_margin',function(){
      var matgin_val = parseFloat(jQuery(this).val());
      /* margin value of total value */
      // console.log(margainArray[matgin_val]+'marginnnnnn');
      var margin_total_amount = parseFloat(jQuery("#totalamount").val());
      // margin_total_amount = (margin_total_amount+((margin_total_amount*matgin_val)/100));
      margin_total_amount = (margin_total_amount*margainArray[matgin_val]);
      if (isNaN(margin_total_amount)) {margin_total_amount=0;}
      margin_total_amount = Math.round(margin_total_amount.toFixed(2))+'.00';

      jQuery("#margin_amount").val(margin_total_amount);
      jQuery(".totalmargin span").html(margin_total_amount+ crncy);

      /* margin value of Price value */
      var margin_price_amount = parseFloat(jQuery("#price").val());
      // margin_price_amount = (margin_price_amount+((margin_price_amount*matgin_val)/100));
      margin_price_amount = (margin_price_amount*margainArray[matgin_val]);
      if (isNaN(margin_price_amount)) {margin_price_amount=0;}
      console.log('margin_price_amount'+margin_price_amount);
      // margin_price_amount = Math.round(margin_price_amount.toFixed(2))+'.00';
      margin_price_amount = margin_price_amount.toFixed(2);
      jQuery("#margin_price").val(margin_price_amount);
      jQuery(".pricemargin span").html(margin_price_amount+ crncy);
    });

     //  jQuery(document).on('keyup','.cus_margin',function(){
     //    var matgin_val = parseFloat(jQuery(this).val());
     // /* margin value of total value */
     //    var margin_total_amount = parseFloat(jQuery("#totalamount").val());
     //    margin_total_amount = (margin_total_amount+((margin_total_amount*matgin_val)/100));
     //    if (isNaN(margin_total_amount)) {margin_total_amount=0;}
     //    margin_total_amount = margin_total_amount.toFixed(2);
     //    jQuery("#margin_amount").val(margin_total_amount);
     //    jQuery(".totalmargin span").html(margin_total_amount+ crncy);
     
     // /* margin value of Price value */
     // var margin_price_amount = parseFloat(jQuery("#price").val());
     //    margin_price_amount = (margin_price_amount+((margin_price_amount*matgin_val)/100));
     //    if (isNaN(margin_price_amount)) {margin_price_amount=0;}
     //    margin_price_amount = margin_price_amount.toFixed(2);
     //    jQuery("#margin_price").val(margin_price_amount);
     //    jQuery(".pricemargin span").html(margin_price_amount+ crncy);
     
     //  });
      onloadDisableSelectOption();
      attr_optn_calc();
      init_qty_price();
        jQuery(document).on('click', '.optionclick', function() {
            
          init_qty_price();
          disableSelectOption();
          jQuery(".custom_quantity").val('');
          jQuery(".cus_margin").trigger('keyup');
          
          // attrprice();
        });
        jQuery('select').on('change', function() {
          init_qty_price();
          attrprice();
        });
     });
       
     function disableSelectOption() {
      
        var checkedVal = jQuery( ".optionclick:checked" ).val();
     
        jQuery(':not(*[data-disable=""])').each(function(){
          var get_data_disable = jQuery(this).attr('data-disable');
          var get_data_class = jQuery(this).attr('data-class');
          if (parseInt(get_data_disable) > parseInt(checkedVal)) {
     
             jQuery('option[value="'+jQuery(this).attr('value')+'"]').hide();
               
     
             
              if (jQuery('.'+get_data_class).find(':selected').attr('data-disable')) {
                // console.log(+'kkkkkkkkkkkkkkkkkkkkkkkkkk');
                 jQuery('.'+get_data_class+' option:first').prop('selected',true);
              }
             // jQuery('.'+get_data_class+' option:first').prop('selected',true);
             jQuery('.'+get_data_class+'').next('span').hide();
            
           
     
          } else {
            jQuery('option[value="'+jQuery(this).attr('value')+'"]').show();
            
     
          }
        });
     
     }
     
     function onloadDisableSelectOption() {
     
     
      
     
        var checkedVal = jQuery( ".optionclick:checked" ).val();
     
        jQuery(':not(*[data-disable=""])').each(function(){
          var get_data_disable = jQuery(this).attr('data-disable');
          
          
     
          if (parseInt(get_data_disable) > parseInt(checkedVal)) {
            
             jQuery('option[value="'+jQuery(this).attr('value')+'"]').hide();
            
          } else {
             jQuery('option[value="'+jQuery(this).attr('value')+'"]').show();
            
          }
        });
     
     }
     
     function attrprice() {
      
         
           var crncy = ' <?php echo $crncy;?>';
      
            var final50= 0.0;
            var final100= 0.0;
            var final250= 0.0;
            var final500= 0.0;
            var final1000= 0.0;
            var final2500= 0.0;
            var final5000= 0.0;
       
        jQuery(".standar-print-position select").each(function(){
     
             var  f50 =jQuery('option:selected', this).attr('data-price50');
             var  f100 =jQuery('option:selected', this).attr('data-price100');
             var  f250 =jQuery('option:selected', this).attr('data-price250');
             var  f500 =jQuery('option:selected', this).attr('data-price500');
             var  f1000 =jQuery('option:selected', this).attr('data-price1000');
             var  f2500 =jQuery('option:selected', this).attr('data-price2500');
             var  f5000 =jQuery('option:selected', this).attr('data-price5000');
            
             console.log(f50+'==f50====');
             console.log(final50+'==final50====');
            final50= parseFloat(final50) + parseFloat(f50);/*parseFloat(final50 + f50);*/
            final100= parseFloat(final100) + parseFloat(f100);
            final250= parseFloat(final250) + parseFloat(f250);
            final500= parseFloat(final500) + parseFloat(f500);
            final1000= parseFloat(final1000) + parseFloat(f1000);
            final2500= parseFloat(final2500) + parseFloat(f2500);
            final5000= parseFloat(final5000) + parseFloat(f5000);
     
          
        }); 
               
          var price_option_50 = parseFloat(jQuery('.optionclick.price_option_50').attr('data-value'))+ parseFloat(final50);
          jQuery('.show_attr_price.price_option_50').html(formatMoney(price_option_50)+crncy);
     
          // console.log(final50+'======');
     
          var price_option_100 = parseFloat(jQuery('.optionclick.price_option_100').attr('data-value'))+ parseFloat(final100);
          console.log(price_option_100 + 'partha');
          jQuery('.show_attr_price.price_option_100').html(formatMoney(price_option_100)+crncy);
     
          var price_option_250 = parseFloat(jQuery('.optionclick.price_option_250').attr('data-value'))+ parseFloat(final250);
          jQuery('.show_attr_price.price_option_250').html(formatMoney(price_option_250)+crncy);
     
          var price_option_500 = parseFloat(jQuery('.optionclick.price_option_500').attr('data-value'))+ parseFloat(final500);
          jQuery('.show_attr_price.price_option_500').html(formatMoney(price_option_500)+crncy);
     
          var price_option_1000 = parseFloat(jQuery('.optionclick.price_option_1000').attr('data-value'))+ parseFloat(final1000);
          jQuery('.show_attr_price.price_option_1000').html(formatMoney(price_option_1000)+crncy);
     
          var price_option_2500 = parseFloat(jQuery('.optionclick.price_option_2500').attr('data-value'))+ parseFloat(final2500);
          jQuery('.show_attr_price.price_option_2500').html(formatMoney(price_option_2500)+crncy);
     
          var price_option_5000 = parseFloat(jQuery('.optionclick.price_option_5000').attr('data-value'))+ parseFloat(final5000);
          jQuery('.show_attr_price.price_option_5000').html(formatMoney(price_option_5000)+crncy);
     }
     
     function init_qty_price() {
      var crncy = ' <?php echo $crncy;?>';
      var qty = jQuery(".optionclick:checked").val();
      var price = jQuery(".optionclick:checked").attr('data-value');

    
  console.log("checked option count:", jQuery(".optionclick:checked").length);
  console.log("checked qty:", qty);
  console.log("checked price:", price);
  console.log("cus margin current:", jQuery(".cus_margin").val());


      if(jQuery("#woo_currency").val() == ' Kr') {
            var output = price.split('.')[1];
            var rnd = price.split('.')[0];
            if(output <= 25){
                price = (Math.round(price)+'.00');
            }else if(output > 25 && output <= 75){
                price = (rnd + '.50');
            }else if(output > 75){
                price = (Math.round(price)+'.00');
            }else{
                // return ('This is not a number!');
                price;
            }
        } else {
            var floatVal = formatter.format(parseFloat(price));
          price = (Math.round(floatVal * 100) / 100).toFixed(2);
          
        }
      console.log(price+'anissssss');
     
      var get_cus_qty = jQuery('input.custom_quantity').val();
      if(get_cus_qty){
        jQuery(".show_qty").text(get_cus_qty).attr('data-qty',qty);
        qty=parseInt(get_cus_qty);
      } else {
        jQuery(".show_qty").text(qty).attr('data-qty',qty);
      }
      
      jQuery("#pcs").val(qty);
      jQuery(".totalpcs span").html(qty);
      jQuery("table.table tbody tr:first-child td.show_price_option").attr('data-price',price).text(price+crncy);
      var total_price = parseFloat(parseFloat(qty)*parseFloat(price));
      total_price = total_price.toFixed(2);
      console.log(total_price+'anit');
      jQuery("table.table tbody tr:first-child td.total_price").attr('data-price',total_price).text(total_price+crncy);
      // jQuery("#totalamount").val(total_price);
      // jQuery(".totalamount span").text(total_price+ crncy);
      jQuery(".attr_optn:selected").each(function() {
        var tax = jQuery(this).attr('data-tax');
        var cus_qty = jQuery('input.custom_quantity').val();
        if(cus_qty){
          var qty2 = cus_qty;
        }
        else{
          var qty2 = jQuery(".optionclick:checked").val();
        }
        var qty = jQuery(".optionclick:checked").val();
        var price = jQuery(this).attr('data-price'+qty);
     
     
        if (price) {
          jQuery("."+tax+" .show_price_option").attr('data-price',price).text(price+crncy);
          var total_price = parseFloat(parseFloat(qty2)*parseFloat(price));
          total_price = total_price.toFixed(2);
          jQuery("."+tax+" .total_price").attr('data-price',total_price).text(total_price+crncy);
          var all_total = 0;
          var all_price = 0;
          jQuery(".total_price").each(function(){
            all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
          });
          jQuery(".show_price_option").each(function(){
            all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
          });
          all_total = all_total.toFixed(2);
          all_price = all_price.toFixed(2);
          jQuery("#totalamount").val(all_total);
          jQuery(".totalamount span").text(all_total+ crncy);
     
          jQuery(".totalprice #price").val(all_price);
          jQuery(".totalprice span").text(all_price+ crncy);
        }          
      });
     
      var all_total = 0;
      jQuery(".total_price").each(function(){
        all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
      });
      all_total = all_total.toFixed(2);
      jQuery("#totalamount").val(all_total);
      jQuery(".totalamount span").text(all_total+ crncy);
     
      var all_price = 0;
      jQuery(".show_price_option").each(function(){
        all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
      });
      all_price = all_price.toFixed(2);
      jQuery(".totalprice #price").val(all_price);
      jQuery(".totalprice span").text(all_price+ crncy);
     
     }
     function attr_optn_calc() {
      var crncy = ' <?php echo $crncy;?>';
      jQuery(".attr_optn").click(function() {
        var tax = jQuery(this).attr('data-tax');
        var qty = jQuery(".optionclick:checked").val();
        var price = jQuery(this).attr('data-price'+qty);
        if (price) {
          jQuery("."+tax+" .show_price_option").attr('data-price',price).text(price+crncy);
          var total_price = parseFloat(parseFloat(qty)*parseFloat(price));
          total_price = total_price.toFixed(2);
          jQuery("."+tax+" .total_price").attr('data-price',total_price).text(total_price+crncy);
          var all_total = 0;
          jQuery(".total_price").each(function(){
            all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
          });
          jQuery("#totalamount").val(all_total);
          jQuery(".totalamount span").text(all_total+ crncy);
     
          var all_price = 0;
          jQuery(".show_price_option").each(function(){
            all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
          });
          all_price = all_price.toFixed(2);
          jQuery(".totalprice #price").val(all_price);
          jQuery(".totalprice span").text(all_price+ crncy);
        }          
      });
     }
  </script>
    <?php
   }
    ?>
<?php if (!is_user_logged_in()) { ?>
  <!-- <div class="cus-margin">
     <div style="position: relative; float: right;" class="cus-margin-btn-warp">
        <?php //echo do_shortcode('[usb_pdf pdf_name="Export"]');?>
     </div>
  </div> -->
  <div>&nbsp;</div>
<?php } ?>
   <?php
   do_action('woocommerce_after_add_to_cart_form');   
   ?>
<script>
   //Code for Article no and option name in single products 
   jQuery(document).ready(function(){
          jQuery("select.printposition1").change(function(){
           var art_no= jQuery('select.printposition1 option:selected').data('article');
          var art_val= jQuery('select.printposition1 option:selected').data('label');
          var art_tax= jQuery('select.printposition1 option:selected').data('tax');
          if( art_val == 'Default'){
            art_no=null;
            art_val=null;
             jQuery("tr."+art_tax+" td:first-child").html(art_no);
             jQuery("tr."+art_tax+" td:nth-child(3)").html(art_val);  
          }else{
            jQuery("tr."+art_tax+" td:first-child").html(art_no);
            jQuery("tr."+art_tax+" td:nth-child(3)").html(art_val); 
          }
      });
       jQuery("select.printposition2").change(function(){
           var art_no= jQuery('select.printposition2 option:selected').data('article');
           var art_val= jQuery('select.printposition2 option:selected').data('label');
           var art_tax= jQuery('select.printposition2 option:selected').data('tax');
           if( art_val == 'Default'){
             art_no=null;
             art_val=null;
              jQuery("tr."+art_tax+" td:first-child").html(art_no);
              jQuery("tr."+art_tax+" td:nth-child(3)").html(art_val);  
           }else{
             jQuery("tr."+art_tax+" td:first-child").html(art_no);
             jQuery("tr."+art_tax+" td:nth-child(3)").html(art_val); 
           }
       });
       jQuery("select.printposition3").change(function(){
           var art_no= jQuery('select.printposition3 option:selected').data('article');
           var art_val= jQuery('select.printposition3 option:selected').data('label');
           var art_tax= jQuery('select.printposition3 option:selected').data('tax');
           if( art_val == 'Default'){
             art_no=null;
             art_val=null;
              jQuery("tr."+art_tax+" td:first-child").html(art_no);
              jQuery("tr."+art_tax+" td:nth-child(3)").html(art_val);  
           }else{
             jQuery("tr."+art_tax+" td:first-child").html(art_no);
             jQuery("tr."+art_tax+" td:nth-child(3)").html(art_val); 
           }
       });
           
       });
   jQuery(function() {
     jQuery('span.cus-right-icon1').hide();
     jQuery('span.cus-right-icon2').hide();
     jQuery('span.cus-right-icon3').hide();
     jQuery('.printposition1').change(function(){
       var selectval = jQuery('select.printposition1 option:selected').val();
       if(selectval !=''){
       jQuery('span.cus-right-icon1').show();
       
       }
       else{
       jQuery('span.cus-right-icon1').hide();
       }
     });
     jQuery('.printposition2').change(function(){
       var selectval = jQuery('select.printposition2 option:selected').val();
       if(selectval !=''){
       jQuery('span.cus-right-icon2').show();
       }
       else{
       jQuery('span.cus-right-icon2').hide();
       }
     });
     jQuery('.printposition3').change(function(){
       var selectval = jQuery('select.printposition3 option:selected').val();
       var labelcheck = jQuery('select.printposition3 option:selected').data('label');
       if(selectval !=''){
         jQuery('span.cus-right-icon3').show();
       }
     });
   });
   
   jQuery(document).ready(function(){
     jQuery('.check_qval').click(function(){
       //other_price_calc();
     });
    //  jQuery('.custom_quantity').blur(function(){
    //  jQuery('.custom_quantity').mouseout(function(){
     jQuery('.custom_quantity').on('mouseout blur change', function(e) {
         var custom_quantity_val = parseInt(jQuery(this).val());
         var visible_first = jQuery(".optionclick:radio:visible:eq(0)").val();
         if (custom_quantity_val < visible_first) {
             jQuery(this).val(visible_first);
             jQuery(this).trigger('blur');
         }
         jQuery(".cus_margin").trigger('keyup');
     });
     
     
    //  jQuery('.custom_quantity').keyup(function(){
     jQuery('.custom_quantity').blur(function(){
   
   
       //other_price_calc();
       var custom_quantity_val = parseInt(jQuery(this).val());
       // console.log(custom_quantity_val+'anissarkar');
       var first_visible_radio_val = parseInt(jQuery(".optionclick:radio:visible:first").val());
       var last_visible_radio_val = parseInt(jQuery(".optionclick:radio:visible:last").val());
       if (custom_quantity_val < first_visible_radio_val) {
        //   jQuery(this).val(jQuery(".optionclick:radio:visible:eq(0)").val());
        //   console.log('.optionclick:radio:visible'+jQuery(".optionclick:radio:visible:eq(0)").val());
         jQuery(".optionclick:radio:visible:first").trigger('click');
         // jQuery('.show_qty').html(first_visible_radio_val);
       } else if(custom_quantity_val > last_visible_radio_val) {
         jQuery(".optionclick:radio:visible:last").trigger('click');
     
          //var qtya=jQuery(".show_qty").attr('data-qty');
   
         // jQuery('.show_qty').html(last_visible_radio_val);
       } else {
   
         var chk = true;
         jQuery('.show_qty').html(custom_quantity_val);
         jQuery(".optionclick").each(function(){
          var loop_val = parseInt(jQuery(this).val());
          if (chk && loop_val >= custom_quantity_val) {
           if (loop_val == custom_quantity_val) {
             jQuery(this).trigger('click');
           } else {
             jQuery(this).parent().parent().prev().find('.optionclick').trigger('click');
           }
   
   
           
           chk = false;
          }
         });
       }
         if (custom_quantity_val) {
           if (custom_quantity_val < first_visible_radio_val) {
             jQuery('.show_qty').html(first_visible_radio_val);
           } else if(custom_quantity_val > last_visible_radio_val) {
             jQuery('.show_qty').html(last_visible_radio_val);
           } else {
             jQuery('.show_qty').html(custom_quantity_val);
           }        
         } else {
           var checked_visible_radio_val = parseInt(jQuery(".optionclick:radio:visible:checked").val());
           jQuery('.show_qty').html(checked_visible_radio_val);
         }
   
     });
   
     // jQuery( ".custom_quantity" ).keyup(function() {
     //   var min = parseInt(jQuery(".optionclick:radio:visible:first").val());
     //   var minlength = jQuery(this).val();
     //   if (jQuery(this).val() < min && minlength.toString().length > 2) {
     //   jQuery(this).val(min);
     //   jQuery(".custom_quantity").trigger('keyup');
     //   }        
     // });
   
   });
   
   function other_price_calc() {
     var productID = '<?php echo get_the_ID();?>';
     var crncy = ' <?php echo $crncy;?>';
     var curncy = jQuery("#woo_currency").val();
     var qty = jQuery('.custom_quantity').val();
       jQuery.ajax({
           type: "POST",
           data: {action: 'usbown_quantity',qtyval:qty, crncyval:crncy, curncyval:curncy, productid:productID},
           url: ajaxVars.ajaxurl,
           success: function(res){
             var price = res;
   
             jQuery(".show_qty").text(qty).attr('data-qty',qty);
             jQuery("#pcs").val(qty);
             jQuery(".totalpcs span").html(qty);
             jQuery("table.table tbody tr:first-child td.show_price_option").attr('data-price',price).text(price+crncy);
             var total_price = parseFloat(parseFloat(qty)*parseFloat(price));
             total_price = total_price.toFixed(2);
             console.log(total_price);
             jQuery("table.table tbody tr:first-child td.total_price").attr('data-price',total_price).text(total_price+crncy);
             // jQuery("#totalamount").val(total_price);
             // jQuery(".totalamount span").text(total_price+ crncy);
             jQuery(".attr_optn:selected").each(function() {
               var tax = jQuery(this).attr('data-tax');
               var qty = jQuery(".optionclick:checked").val();
               var price = jQuery(this).attr('data-price'+qty);
         
         
               if (price) {
                 jQuery("."+tax+" .show_price_option").attr('data-price',price).text(price+crncy);
                 var total_price = parseFloat(parseFloat(qty)*parseFloat(price));
                 total_price = total_price.toFixed(2);
                 jQuery("."+tax+" .total_price").attr('data-price',total_price).text(total_price+crncy);
                 var all_total = 0;
                 var all_price = 0;
                 jQuery(".total_price").each(function(){
                   all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
                 });
                 jQuery(".show_price_option").each(function(){
                   all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
                 });
                 all_total = all_total.toFixed(2);
                 all_price = all_price.toFixed(2);
                 jQuery("#totalamount").val(all_total);
                 jQuery(".totalamount span").text(all_total+ crncy);
            
                 jQuery(".totalprice #price").val(all_price);
                 jQuery(".totalprice span").text(all_price+ crncy);
               }          
             });
            
             var all_total = 0;
             jQuery(".total_price").each(function(){
               all_total = all_total + parseFloat(jQuery(this).attr('data-price'));
             });
             all_total = all_total.toFixed(2);
             jQuery("#totalamount").val(all_total);
             jQuery(".totalamount span").text(all_total+ crncy);
            
             var all_price = 0;
             jQuery(".show_price_option").each(function(){
               all_price = all_price + parseFloat(jQuery(this).attr('data-price'));
             });
             all_price = all_price.toFixed(2);
             jQuery(".totalprice #price").val(all_price);
             jQuery(".totalprice span").text(all_price+ crncy);
   
           }
         });
   }
   
   
   function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = "") {
     try {
       decimalCount = Math.abs(decimalCount);
       decimalCount = isNaN(decimalCount) ? 2 : decimalCount;
   
       const negativeSign = amount < 0 ? "-" : "";
   
       let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
       let j = (i.length > 3) ? i.length % 3 : 0;
   
       return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
     } catch (e) {
       console.log(e)
     }
   };
   
   jQuery( document ).ready(function() {
    jQuery(".standar-print-position select").each(function(){
                 
   
                  if(jQuery(this).val()!=''){
                    jQuery(this).next('span').show(); 
                    jQuery(this).trigger('change');
                  }
   
              });
              
              /*04-12-2020*/
                /*setInterval(function(){ 
                  jQuery("td.show_attr_price,.show_price_option,.total_price,.totalprice span,.totalamount span").each(function(){
                	var floatVal = Math.round(parseFloat(jQuery(this).text()));
                    
                    	jQuery(this).text(floatVal.toFixed(2)+' '+jQuery("#woo_currency").val());
                    });
                  
                }, 1000);*/
                setInterval(function(){ 
                    if(jQuery("#woo_currency").val() == ' Kr') {
                       jQuery("td.show_attr_price,.show_price_option,.total_price,.totalprice span,.totalamount span").each(function(){
                      var floatVal = calPrice(parseFloat(jQuery(this).text()));
                        
                          jQuery(this).text(floatVal+' '+jQuery("#woo_currency").val());
                        });
                        
                        jQuery(".optionprice").each(function(){
                      var floatVal = calPrice(parseFloat(jQuery(this).attr('data-value')));
                        
                          jQuery(this).attr('data-value',floatVal);
                        });
                         jQuery(".show_price_option").each(function(){
                      var floatVal = calPrice(parseFloat(jQuery(this).attr('data-price')));
                        
                          jQuery(this).attr('data-price',floatVal);
                        });
                        // init_qty_price();
                        // other_price_calc
                    } else {
                        jQuery(".optionprice").each(function(){
                          var floatVal = formatter.format(parseFloat(jQuery(this).attr('data-value')));
                            floatVal = (Math.round(floatVal * 100) / 100).toFixed(2);
                          jQuery(this).attr('data-value',floatVal);
                        });
                         jQuery(".show_price_option").each(function(){
                          var floatVal = formatter.format(parseFloat(jQuery(this).attr('data-price')));
                            floatVal = (Math.round(floatVal * 100) / 100).toFixed(2);
                          jQuery(this).attr('data-price',floatVal);
                        });
                        jQuery("td.show_attr_price").each(function(){
                          var floatVal = formatter.format(parseFloat(jQuery(this).text()));
                            floatVal = (Math.round(floatVal * 100) / 100).toFixed(2);
                          jQuery(this).text(floatVal+' '+jQuery("#woo_currency").val());
                        });
                    }
                  
                }, 1000);


   });

   const formatter = new Intl.NumberFormat('en-US', {
       minimumFractionDigits: 1,      
       maximumFractionDigits: 1,
    });    
   function calPrice($amount){
     
            var value = $amount.toFixed(2);
            var output = value.split('.')[1];
            var rnd = value.split('.')[0];
            if(output <= 25){
                return (Math.round($amount)+'.00');
            }else if(output > 25 && output <= 75){
                return (rnd + '.50');
            }else if(output > 75){
                return (Math.round($amount)+'.00');
            }else{
                // return ('This is not a number!');
                return null;
            }
       
    }
</script>