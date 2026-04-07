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
/*  if ($crncy == 'SEK') {
    $crncy = ' Kr';
  }*/
   $rate_change    = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];
    error_reporting(0);
   $attributes=array();
   $attribute_keys = array_keys($attributes);
   do_action('woocommerce_before_add_to_cart_form');
   ?>
<?php
   if (is_user_logged_in()) {
   ?>
<?php
   if (!defined('ABSPATH')) {
       exit; // Exit if accessed directly
   }
   $has_row    = false;
   $attributes = $product->get_attributes();
   ob_start();
   ?>
    <form action="<?php echo get_site_url();?>/cart" class="form-horizontal" method="post" >
       <input type="hidden" name="woo_currency" id="woo_currency" value="<?php echo $crncy;?>">
       <div class="row standard-product">
          <div class="col-xs-12 col-sm-4 custom-usb">
             <div class="product_attributes">
                <?php
                /*get attribute price for USB product*/
                $usb_quantity = get_terms( 'usb_quantity', array(
                    'hide_empty' => 0,
                ) );
                if ( ! empty( $usb_quantity ) && ! is_wp_error( $usb_quantity ) ){
                  $usb_quantity_arr = array();
                    foreach ( $usb_quantity as $usb_qty ) {
                      $usb_quantity_arr[] = $usb_qty->term_id;
                    }
                }
                /*get attribute price for USB product*/
                // $get_attribute_pr_vl = get_post_meta($product->get_id(),'attribute_pr_vl_usb',true);
                  $get_attribute_vl = get_post_meta($product->get_id(),'attribute_vl_2',true);
                  $i = 1;
                   foreach ($attributes as $attribute):
                       if (empty($attribute['is_visible']) || ($attribute['is_taxonomy'] && !taxonomy_exists($attribute['name'])))
                           continue;
                       $values  = wc_get_product_terms($product->get_id(), $attribute['name'], array(
                           'fields' => 'names'
                       ));
                       $att_val = apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);
                       $terms   = get_the_terms($product->get_id(), $attribute['name']);
                       //  print "<pre>";
                       // print_r($attribute['name']);
                       // print "</pre>";
                       if (empty($att_val))
                           continue;
                       $has_row = true;
                   ?>
                <!-- <div class="col">
                   <div class="att_label"><?php //echo wc_attribute_label( $attribute['name'] ); 
                      ?></div>
                   <div class="att_value"><?php //echo $att_val; 
                      ?></div>
                   </div> -->
                   <div class="right-sec"><?php echo wc_attribute_label($attribute['name']);?></div>
                <div class="cei-custom-usb-cal">
                   <select class="usb-dropdown usb_product<?php echo $i;?>">
				              <option data-tax="<?php echo $attribute['name']; ?>" name="radio_<?php echo $attribute['name']; ?>" data-price50="0" data-price100="0" data-price250="0" data-price500="0" data-price1000="0" data-price2500="0" data-price5000="0" class="attr_optn" value="0"><?php _e( 'Choose', 'usb' ); ?></option>
                      <?php
                         if ($terms && !is_wp_error($terms)) {
                             foreach ($terms as $term) {
                                $price50   = get_term_meta($term->term_id, '_price50', true);
                                $price50   = str_replace(",",".",$price50);
                                $price50 = (!empty($price50)) ? $price50 : '0.0';

                                $price100  = get_term_meta($term->term_id, '_price100', true);
                                $price100   = str_replace(",",".",$price100);
                                $price100 = (!empty($price100)) ? $price100 : '0.0';

                                $price250  = get_term_meta($term->term_id, '_price250', true);
                                $price250   = str_replace(",",".",$price250);
                                $price250 = (!empty($price250)) ? $price250 : '0.0';

                                $price500  = get_term_meta($term->term_id, '_price500', true);
                                $price500   = str_replace(",",".",$price500);
                                $price500 = (!empty($price500)) ? $price500 : '0.0';

                                $price1000 = get_term_meta($term->term_id, '_price1000', true);
                                $price1000   = str_replace(",",".",$price1000);
                                $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

                                $price2500 = get_term_meta($term->term_id, '_price2500', true);
                                $price2500   = str_replace(",",".",$price2500);
                                $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

                                $price5000 = get_term_meta($term->term_id, '_price5000', true);
                                $price5000   = str_replace(",",".",$price5000);
                                $price5000 = (!empty($price5000)) ? $price5000 : '0.0';
                                $usb_ocm_tlc = array();
                                foreach ($usb_quantity_arr as $usb_value) {
                                  $usb_ocm_tlc[$usb_value][] = $usb_value;
                                  $usb_ocm_tlc[$usb_value][] = $price50;
                                  $usb_ocm_tlc[$usb_value][] = $price100;
                                  $usb_ocm_tlc[$usb_value][] = $price250;
                                  $usb_ocm_tlc[$usb_value][] = $price500;
                                  $usb_ocm_tlc[$usb_value][] = $price1000;
                                  $usb_ocm_tlc[$usb_value][] = $price2500;
                                  $usb_ocm_tlc[$usb_value][] = $price5000;
                                }
                                $usb_oem_mlc = $usb_original = $usb_ocm_tlc;
                                // $usb_ocm_tlc = json_decode(get_term_meta($term->term_id,'_usb_ocm_tlc',true),true);
                                // $usb_ocm_tlc = array_map('array_filter', $usb_ocm_tlc);
                                $usb_ocm_tlc = json_encode(array_filter($usb_ocm_tlc));
                                if (!empty($usb_ocm_tlc)) {
                                  $usb_ocm_tlc = $usb_ocm_tlc;
                                } else {
                                  $usb_ocm_tlc = "";
                                }

                                // $usb_oem_mlc = json_decode(get_term_meta($term->term_id,'_usb_oem_mlc',true),true); 
                                // $usb_oem_mlc = array_map('array_filter', $usb_oem_mlc);
                                $usb_oem_mlc = json_encode(array_filter($usb_oem_mlc));
                                if (!empty($usb_oem_mlc)) {
                                  $usb_oem_mlc = $usb_oem_mlc;
                                } else {
                                  $usb_oem_mlc = "";
                                }

                                // $usb_original = json_decode(get_term_meta($term->term_id,'_usb_original',true),true); 
                                // $usb_original = array_map('array_filter', $usb_original);
                                $usb_original = json_encode(array_filter($usb_original));
                                if (!empty($usb_original)) {
                                  $usb_original = $usb_original;
                                } else {
                                  $usb_original = "";
                                }

                                  $get_attribute_id = $term->term_id;
                                  $get_attribute_name = $term->name;
                                  $field_name = $get_attribute_name.'_'.$get_attribute_id; 
                                  $field_name = str_replace(' ', '', $field_name);
                                 
                                 
                                  //echo attribute_vl_2[2Färger(191)_326]
                                


                                 $attribute_vl_2 = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                                  
                                 
                                 $attribute_vl_chk2 = ($attribute_vl_2=='yes')?'selected':'';
                         ?>
                        <option <?php echo $attribute_vl_chk2;?> id="elm<?php echo $term->term_id;?>" type="radio" data-tax="<?php echo $attribute['name'];
                         ?>" class="attr_optn" name="radio_<?php echo $attribute['name'];?>" data-usb_ocm_tlc='<?php echo $usb_ocm_tlc;?>' data-usb_oem_mlc='<?php echo $usb_oem_mlc;?>' data-usb_original='<?php echo $usb_original;?>' value="<?php echo $term->term_id; ?>" for="elm<?php echo $term->term_id;?>"><?php echo trim(preg_replace('/\s*\([^)]*\)/', '', $term->name)); ?></option>
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
             <!-- <div class="cus-margin">
                <label><?php //_e( 'Margin', 'usb' ); ?></label>
               <input type="number" name="cus_margin" class="cus_margin" min="0" value="0">
             </div> -->
             <!-- <p><?php// _e( 'Set 0 for default price*', 'usb' ); ?></p> -->
          </div>
          <div class="col-xs-12 col-sm-8 custom-usb">
            <?php
              $show_oem_value = get_post_meta(get_the_ID(), '_show_oem', true);
              if($show_oem_value == 'yes') {
            ?>
           <div class="custom-usb-table-sec custom-usb-table-oem-tlc">
              <h3 class="custom-usb-table-title"><?php _e( 'OEM TLC', 'usb' ); ?> <a href="#divOEMTLC" id="btnOEMTLC"> <?php _e( 'Read more', 'usb' ); ?></a></h3>
              <div class="pop-info-box" >
              <div id="divOEMTLC" style="display:none">
                <?php
                  $info_oemtlc = get_post_meta(get_the_ID(), '_info_oemtlc', true);
                  $theme_oemtlc_info_en = get_theme_value("product_oem_tlc_info_en");
                  $theme_oemtlc_info_sw = get_theme_value("product_oem_tlc_info_sw");

                  if(!empty($info_oemtlc)){
                ?>
                <p><?php echo $info_oemtlc;?></p>
              <?php } else if(!empty($theme_oemtlc_info_en) && $cur_lang == 'en'){ ?>
                <p><?php echo $theme_oemtlc_info_en;?></p>
             <?php }else if(!empty($theme_oemtlc_info_sw) && $cur_lang == 'sv'){ ?>
                <p><?php echo $theme_oemtlc_info_sw;?></p>
             <?php }else{
              //
             }
             ?>
              </div>
              </div>
              <?php

                $usb_ocm_tlc = json_decode(get_post_meta(get_the_ID(),'_usb_ocm_tlc',true),true); 
                $usb_ocm_tlc = array_map('array_filter', $usb_ocm_tlc);
                $usb_ocm_tlc = array_filter($usb_ocm_tlc);
                $show_tlc_qty = json_decode(get_post_meta(get_the_ID(),'_show_tlc_qty',true),true); 
              ?>
              <table class="table custom-usb-table" data-val='<?php echo json_encode($usb_ocm_tlc); ?>'>
                <thead>
                  <tr>
                    <th scope="col"><?php _e( 'Quantity', 'usb' );?></th>
                    
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '50', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '100', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '250', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '500', 'usb' ); ?></th>
                    <?php
                    $user = wp_get_current_user();
                    if ( !in_array( 'customer', (array) $user->roles ) ) {
                    ?>
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '1000', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '2500', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '5000', 'usb' ); ?></th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                            
              
                            
                            foreach ($usb_ocm_tlc as $key => $value) {
                                // print_r($value);
                                ?>
                                <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                                    <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                                        <?php 
                                        $category = get_term_by('id', $key,'usb_quantity');
                                        echo $category->name;

                                        ?>
                                    </td>
                                    <?php 
                                    $qty1 = $value[1]; 
                                    if ( $rate_change > 0 ) {
                                      $qty1 = $qty1*$rate_change;
                                      $qty1 = number_format((float)$qty1, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty1;?>
                                    </td>
                                    <?php 
                                    $qty2 = $value[2]; 
                                    if ( $rate_change > 0 ) {
                                      $qty2 = $qty2*$rate_change;
                                      $qty2 = number_format((float)$qty2, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty2; ?>
                                    </td>
                                    <?php 
                                    $qty3 = $value[3]; 
                                    if ( $rate_change > 0 ) {
                                      $qty3 = $qty3*$rate_change;
                                      $qty3 = number_format((float)$qty3, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty3; ?>
                                    </td>
                                    <?php 
                                    $qty4 = $value[4]; 
                                    if ( $rate_change > 0 ) {
                                      $qty4 = $qty4*$rate_change;
                                      $qty4 = number_format((float)$qty4, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty4; ?>
                                    </td>

                                    <?php 

                                    if ( !in_array( 'customer', (array) $user->roles ) ) {
                                    $qty5 = $value[5]; 
                                    if ( $rate_change > 0 ) {
                                      $qty5 = $qty5*$rate_change;
                                      $qty5 = number_format((float)$qty5, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty5; ?>               
                                    </td>
                                    <?php 
                                    $qty6 = $value[6]; 
                                    if ( $rate_change > 0 ) {
                                      $qty6 = $qty6*$rate_change;
                                      $qty6 = number_format((float)$qty6, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty6; ?>            
                                    </td>    
                                    <?php 
                                    $qty7 = $value[7]; 
                                    if ( $rate_change > 0 ) {
                                      $qty7 = $qty7*$rate_change;
                                      $qty7 = number_format((float)$qty7, 2, '.', '');
                                    }
                                    ?>
                                    <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) { echo 'style="display:none;"';} ?>>
                                        <?php echo $qty7; ?>            
                                    </td>
                                    <?php } ?> 
                                </tr>
                                <?php
                            }
                        ?>
                </tbody>
              </table>
            </div>
            <?php
              }
              $show_mlc_value = get_post_meta(get_the_ID(), '_show_mlc', true);
              if($show_mlc_value == 'yes') {
            ?>
            <div class="custom-usb-table-sec custom-usb-table-oem-mlc">
              <h3 class="custom-usb-table-title"><?php _e( 'OEM MLC', 'usb' );?> <a href="#divOEMMLC" id="btnOEMMLC"> <?php _e( 'Read more', 'usb' );?></a></h3>
              <div class="pop-info-box" >
              <div id="divOEMMLC" style="display:none">
                <?php
                    $info_oemmlc = get_post_meta(get_the_ID(), '_info_oemmlc', true);
                    $theme_oemmlc_info_en = get_theme_value("product_oem_mlc_info_en");
                    $theme_oemmlc_info_sw = get_theme_value("product_oem_mlc_info_sw");
                  if(!empty($info_oemmlc)){
                ?>
                <p><?php echo $info_oemmlc;?></p>
                <?php }else if(!empty($theme_oemmlc_info_en) && $cur_lang == 'en'){ ?>
                  <p><?php echo $theme_oemmlc_info_en;?></p>
                <?php }else if(!empty($theme_oemmlc_info_sw) && $cur_lang == 'sv'){?>
                  <p><?php echo $theme_oemmlc_info_sw;?></p>
                <?php } else{
                  //
                }?>
              </div>
              </div>
              <?php
                $usb_oem_mlc = json_decode(get_post_meta(get_the_ID(),'_usb_oem_mlc',true),true); 
                $usb_oem_mlc = array_map('array_filter', $usb_oem_mlc);
                $usb_oem_mlc = array_filter($usb_oem_mlc);
                $show_mlc_qty = json_decode(get_post_meta(get_the_ID(),'_show_mlc_qty',true),true);
              ?>
              <table class="table custom-usb-table" data-val='<?php echo json_encode($usb_oem_mlc); ?>' >
                <thead>
                  <tr>
                    <th scope="col"><?php _e( 'Quantity', 'usb' );?></th>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '50', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '100', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '250', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '500', 'usb' ); ?></th>
                    <?php
                    $user = wp_get_current_user();
                    if ( !in_array( 'customer', (array) $user->roles ) ) {
                    ?>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '1000', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '2500', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>><?php _e( '5000', 'usb' ); ?></th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php
                          
               
                            if($usb_oem_mlc){
                                foreach ($usb_oem_mlc as $key => $value) {
                                    ?>
                                    <tr class="oem_mlc_qnty_size" data-class="<?php echo str_replace(' ', '', $value[0]); ?>">
                                        <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                                            <?php 
                                        $category = get_term_by('id', $key,'usb_quantity');
                                        echo $category->name;

                                        ?>
                                        </td>
                                        <?php 
                                        $qty1 = $value[1]; 
                                        if ( $rate_change > 0 ) {
                                          $qty1 = $qty1*$rate_change;
                                          $qty1 = number_format((float)$qty1, 2, '.', '');
                                        }
                                        ?>
                                        <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty1; ?>
                                        </td>
                                        <?php 
                                        $qty2 = $value[2]; 
                                        if ( $rate_change > 0 ) {
                                          $qty2 = $qty2*$rate_change;
                                          $qty2 = number_format((float)$qty2, 2, '.', '');
                                        }
                                        ?>
                                        <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty2; ?>
                                        </td>
                                        <?php 
                                        $qty3 = $value[3]; 
                                        if ( $rate_change > 0 ) {
                                          $qty3 = $qty3*$rate_change;
                                          $qty3 = number_format((float)$qty3, 2, '.', '');
                                        }
                                        ?>
                                        <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty3; ?>
                                        </td>
                                        <?php 
                                        $qty4 = $value[4]; 
                                        if ( $rate_change > 0 ) {
                                          $qty4 = $qty4*$rate_change;
                                          $qty4 = number_format((float)$qty4, 2, '.', '');
                                        }
                                        ?>
                                        <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty4; ?>
                                        </td>
                                        <?php 
                                        if ( !in_array( 'customer', (array) $user->roles ) ) {
                                        $qty5 = $value[5]; 
                                        if ( $rate_change > 0 ) {
                                          $qty5 = $qty5*$rate_change;
                                          $qty5 = number_format((float)$qty5, 2, '.', '');
                                        }
                                        ?>
                                        <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty5; ?>                  
                                        </td>
                                        <?php 
                                        $qty6 = $value[6]; 
                                        if ( $rate_change > 0 ) {
                                          $qty6 = $qty6*$rate_change;
                                          $qty6 = number_format((float)$qty6, 2, '.', '');
                                        }
                                        ?>
                                        <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty6; ?>                 
                                        </td> 
                                        <?php 
                                        $qty7 = $value[7]; 
                                        if ( $rate_change > 0 ) {
                                          $qty7 = $qty7*$rate_change;
                                          $qty7 = number_format((float)$qty7, 2, '.', '');
                                        }
                                        ?>   
                                        <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) { echo 'style="display:none;"';} ?>>
                                            <?php echo $qty7; ?>           
                                        </td> 
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                </tbody>
              </table>
            </div>
            <?php }
            $original_value = get_post_meta(get_the_ID(), '_original', true);
            if($original_value == 'yes') {
            ?>

            <div class="custom-usb-table-sec custom-usb-table-original">
              <h3 class="custom-usb-table-title"><?php _e( 'Original', 'usb' );?> <a href="#divOriginal" id="btnOriginal"> <?php _e( 'Read more', 'usb' );?></a></h3>
              <div class="pop-info-box" >
              <div id="divOriginal" style="display:none">
                <?php 
                  $info_original = get_post_meta(get_the_ID(), '_info_original', true);
                  $theme_original_info_en = get_theme_value("product_original_info_en");
                  $theme_original_info_sw = get_theme_value("product_original_info_sw");
                  if(!empty($info_original)){?>
                    <p><?php echo $info_original;?></p>
                  <?php }else if(!empty($theme_original_info_en) && $cur_lang == 'en'){ ?>
                    <p><?php echo $theme_original_info_en;?></p>
                  <?php }else if(!empty($theme_original_info_sw) && $cur_lang == 'sv'){ ?>
                    <p><?php echo $theme_original_info_sw;?></p>
                  <?php } else{
                    //
                  }?>
              </div>
              </div>
              <?php
                $usb_original = json_decode(get_post_meta(get_the_ID(),'_usb_original',true),true); 
                $usb_original = array_map('array_filter', $usb_original);
                $usb_original = array_filter($usb_original);
                $show_original_qty = json_decode(get_post_meta(get_the_ID(),'_show_original_qty',true),true);
              ?>
              <table class="table custom-usb-table" data-val='<?php echo json_encode($usb_original); ?>'>
                <thead>
                  <tr>
                    <th scope="col"><?php _e( 'Quantity', 'usb' );?></th>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('50', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '50', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('100', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '100', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('250', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '250', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('500', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '500', 'usb' ); ?></th>
                    <?php
                    $user = wp_get_current_user();
                    if ( !in_array( 'customer', (array) $user->roles ) ) {
                    ?>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('1000', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '1000', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('2500', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '2500', 'usb' ); ?></th>
                    <th scope="col" <?php if (!empty($show_original_qty) && in_array('5000', $show_original_qty)) { echo 'style="display:none;"';} ?>><?php _e( '5000', 'usb' ); ?></th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $usb_original = json_decode(get_post_meta(get_the_ID(),'_usb_original',true),true); 
                  $usb_original = array_map('array_filter', $usb_original);
                  $usb_original = array_filter($usb_original);
                  ?>
                  <?php
                      if($usb_original){
                          foreach ($usb_original as $key => $value) {
                              // print_r($value);
                              ?>
                              <tr class="original_qnty_size" data-class="<?php echo str_replace(' ', '', $value[0]); ?>">
                                  <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                                      <?php 
                                        $category = get_term_by('id', $key,'usb_quantity');
                                        echo $category->name;

                                        ?>
                                  </td>
                                  <?php 
                                  $qty1 = $value[1]; 
                                  if ( $rate_change > 0 ) {
                                    $qty1 = $qty1*$rate_change;
                                    $qty1 = number_format((float)$qty1, 2, '.', '');
                                  }
                                  ?>
                                  <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_original_qty) && in_array('50', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty1; ?>
                                  </td>
                                  
                                  <?php 
                                  $qty2 = $value[2]; 
                                  if ( $rate_change > 0 ) {
                                    $qty2 = $qty2*$rate_change;
                                    $qty2 = number_format((float)$qty2, 2, '.', '');
                                  }
                                  ?>
                                  <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_original_qty) && in_array('100', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty2; ?>
                                  </td>
                                  
                                  <?php 
                                  $qty3 = $value[3]; 
                                  if ( $rate_change > 0 ) {
                                    $qty3 = $qty3*$rate_change;
                                    $qty3 = number_format((float)$qty3, 2, '.', '');
                                  }
                                  ?>
                                  <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_original_qty) && in_array('250', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty3; ?>
                                  </td>
                                  
                                  <?php 
                                  $qty4 = $value[4]; 
                                  if ( $rate_change > 0 ) {
                                    $qty4 = $qty4*$rate_change;
                                    $qty4 = number_format((float)$qty4, 2, '.', '');
                                  }
                                  ?>                                  
                                  <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_original_qty) && in_array('500', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty4; ?>
                                  </td>
                                  
                                  <?php 
                                  if ( !in_array( 'customer', (array) $user->roles ) ) {
                                  $qty5 = $value[5]; 
                                  if ( $rate_change > 0 ) {
                                    $qty5 = $qty5*$rate_change;
                                    $qty5 = number_format((float)$qty5, 2, '.', '');
                                  }
                                  ?> 
                                  <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_original_qty) && in_array('1000', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty5; ?>                    
                                  </td>
                                  
                                  <?php 
                                  $qty6 = $value[6]; 
                                  if ( $rate_change > 0 ) {
                                    $qty6 = $qty6*$rate_change;
                                    $qty6 = number_format((float)$qty6, 2, '.', '');
                                  }
                                  ?>
                                  <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_original_qty) && in_array('2500', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty6; ?>                    
                                  </td>   
                                  
                                  <?php 
                                  $qty7 = $value[7]; 
                                  if ( $rate_change > 0 ) {
                                    $qty7 = $qty7*$rate_change;
                                    $qty7 = number_format((float)$qty7, 2, '.', '');
                                  }
                                  ?>
                                  <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_original_qty) && in_array('5000', $show_original_qty)) { echo 'style="display:none;"';} ?>>
                                      <?php echo $qty7; ?>
                                  </td> 
                                  <?php } ?>
                              </tr>
                              <?php
                          }
                      }
                  ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
            <!-- <div class="cus-usb-offer">
              <a href="#">Offer</a>
            </div> -->
            <div class="cus-usb-offer">
              <style type="text/css">
                .standard-product .custom-usb .cus-usb-offer a {margin: 5px;}
              </style>
              <?php //echo do_shortcode('[usb_pdf pdf_name="Export"]');?>
              <!-- <a class="dwnpdf" href='?pdf=<?php //echo get_the_ID();?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en';?>' target='_blank'>
                      <?php //_e( 'Export', 'usb' );?></a> -->

              <a class="usb_down_pdf_summary22" href='?usbofferpdf=<?php echo get_the_ID();?>&lang=<?php echo $_GET['lang']?$_GET['lang']:'en';?>' target="_blank" data-productId="<?php echo get_the_ID();?>"><?php _e( 'Product Price Quote', 'usb' );?></a>
              <!-- <a href="#">Offer</a> -->
            </div>
          </div>
          <?php
             if ($has_row) {
                 echo ob_get_clean();
             } else {
                 ob_end_clean();
             }
             ?>
 </div>

 
    </form>
    <input type="hidden" name="cus-product-id" id="cus_product_id" value="<?php echo get_the_ID();?>">

<?php
   }
   ?>
<script type="text/javascript">
  var arr2 = [];
  jQuery(document).ready(function(){   

    /*fancybox*/
    jQuery("#btnOEMTLC").fancybox();
    jQuery("#btnOEMMLC").fancybox();
    jQuery("#btnOriginal").fancybox();
    /*fancybox*/
	
	/* On Change Radio Button Margin field will Clear */
	jQuery( ".usb-dropdown option" ).change(function() {

	  jQuery('.cus_margin').val('0');
	});

    var woo_currency = jQuery("#woo_currency").val();
    jQuery('.usb-dropdown').change(function(){
       
   
   
        
      data_usb_ocm_tlc();
    });

    //anit code here 

     jQuery( document ).ready(function() {


    jQuery('span.cus-right-icon1').hide();
    jQuery('span.cus-right-icon2').hide();
    jQuery('span.cus-right-icon3').hide();
    jQuery('span.cus-right-icon4').hide();
    


     var selectval1 = jQuery('select.usb_product1 option:selected').val();
     var selectval2 = jQuery('select.usb_product2 option:selected').val();
     var selectval3 = jQuery('select.usb_product3 option:selected').val();
     var selectval4 = jQuery('select.usb_product4 option:selected').val();
     
    if(selectval1 !=0){
    jQuery('span.cus-right-icon1').show();
    
    }
    else{
    jQuery('span.cus-right-icon1').hide();
    }

    if(selectval2 !=0){
    jQuery('span.cus-right-icon2').show();
    
    }
    else{
    jQuery('span.cus-right-icon2').hide();
    }

    if(selectval3 !=0){
    jQuery('span.cus-right-icon3').show();
    
    }
    else{
    jQuery('span.cus-right-icon3').hide();
    }

     if(selectval4 !=0){
    jQuery('span.cus-right-icon4').show();
    
    }
    else{
    jQuery('span.cus-right-icon4').hide();
    }

    //data_usb_ocm_tlc();
    
    });

    // jQuery(".cus_margin").keyup(function(){
    jQuery(".cus_margin").on('keyup change', function (){
  
      var data_usb_ocm_tlc = {};
      jQuery(".usb-dropdown option:selected").each(function() {
       
        radio_checked = 'yes';
        var data_tax = jQuery(this).attr('data-tax');
        var data_val = jQuery(this).val();
        
        data_usb_ocm_tlc[data_val] = data_tax;
      });
        var cus_product_id = jQuery("#cus_product_id").val();
        var cus_margin = jQuery(".cus_margin").val();
        if(isNaN(cus_margin)) { var cus_margin_val = 0; } else { var cus_margin_val = cus_margin; }
        console.log(cus_margin_val);
        if (cus_margin) {
          if(jQuery(".custom-usb-table-oem-tlc").length) { 
            
              jQuery.ajax({
                 type: "POST",
                 data: {action: 'margin_usb_ocm_tlc',info:data_usb_ocm_tlc,tablename:'usb_ocm_tlc',cus_product_id:cus_product_id,cus_margin:cus_margin_val,woo_currency:woo_currency},
                 url: '<?php echo admin_url('admin-ajax.php');?>',
                 success: function(msg){
                   jQuery(".custom-usb-table-oem-tlc table tbody").html(msg);
                 }
              });
            
            
          }

        if(jQuery(".custom-usb-table-oem-mlc").length) {    
          jQuery.ajax({
             type: "POST",
             data: {action: 'margin_usb_oem_mlc',info:data_usb_ocm_tlc,tablename:'usb_oem_mlc',cus_product_id:cus_product_id,cus_margin:cus_margin_val,woo_currency:woo_currency},
             url: '<?php echo admin_url('admin-ajax.php');?>',
             success: function(msg){
               // console.log(msg);
               jQuery(".custom-usb-table-oem-mlc table tbody").html(msg);
             }
          });
        }

        if(jQuery(".custom-usb-table-original").length) {    
          jQuery.ajax({
             type: "POST",
             data: {action: 'margin_usb_original',info:data_usb_ocm_tlc,tablename:'usb_original',cus_product_id:cus_product_id,cus_margin:cus_margin_val,woo_currency:woo_currency},
             url: '<?php echo admin_url('admin-ajax.php');?>',
             success: function(msg){
               // console.log(msg);
               jQuery(".custom-usb-table-original table tbody").html(msg);
             }
          });
        }


        }
      

    });

  });



  function data_usb_ocm_tlc() {
    var woo_currency = jQuery("#woo_currency").val();
    var data_usb_ocm_tlc = {};
    jQuery(".usb-dropdown option:selected").each(function() {

      var data_tax = jQuery(this).attr('data-tax');
      var data_val = jQuery(this).val();
     
      data_usb_ocm_tlc[data_val] = data_tax;
    });
    var cus_product_id = jQuery("#cus_product_id").val();
    if(jQuery(".custom-usb-table-oem-tlc").length) {    
      jQuery.ajax({
         type: "POST",
         data: {action: 'data_usb_ocm_tlc',info:data_usb_ocm_tlc,tablename:'usb_ocm_tlc',cus_product_id:cus_product_id,woo_currency:woo_currency},
         url: '<?php echo admin_url('admin-ajax.php');?>',
         success: function(msg){
           // console.log(msg);
           jQuery(".custom-usb-table-oem-tlc table tbody").html(msg);
         }
      });
    }

    if(jQuery(".custom-usb-table-oem-mlc").length) {    
      jQuery.ajax({
         type: "POST",
         data: {action: 'data_usb_oem_mlc',info:data_usb_ocm_tlc,tablename:'usb_oem_mlc',cus_product_id:cus_product_id,woo_currency:woo_currency},
         url: '<?php echo admin_url('admin-ajax.php');?>',
         success: function(msg){
           // console.log(msg);
           jQuery(".custom-usb-table-oem-mlc table tbody").html(msg);
         }
      });
    }

    if(jQuery(".custom-usb-table-original").length) {    
      jQuery.ajax({
         type: "POST",
         data: {action: 'data_usb_original',info:data_usb_ocm_tlc,tablename:'usb_original',cus_product_id:cus_product_id,woo_currency:woo_currency},
         url: '<?php echo admin_url('admin-ajax.php');?>',
         success: function(msg){
           // console.log(msg);
           jQuery(".custom-usb-table-original table tbody").html(msg);
         }
      });
    }

  }
jQuery(function() {
  jQuery('span.cus-right-icon1').hide();
  jQuery('span.cus-right-icon2').hide();
  jQuery('span.cus-right-icon3').hide();
  jQuery('.usb_product1').change(function(){
    var selectval = jQuery('select.usb_product1 option:selected').val();
    if(selectval !=0){
    jQuery('span.cus-right-icon1').show();
    }
    else{
    jQuery('span.cus-right-icon1').hide();
    }
  });
  jQuery('.usb_product2').change(function(){
    var selectval = jQuery('select.usb_product2 option:selected').val();
    if(selectval !=0){
    jQuery('span.cus-right-icon2').show();
    }
    else{
    jQuery('span.cus-right-icon2').hide();
    }
  });
  jQuery('.usb_product3').change(function(){
    var selectval = jQuery('select.usb_product3 option:selected').val();
    var labelcheck = jQuery('select.usb_product3 option:selected').data('label');
    if(selectval !=0){
      jQuery('span.cus-right-icon3').show();
    }else{
       jQuery('span.cus-right-icon3').hide();
    }
  });
   jQuery('.usb_product4').change(function(){
    var selectval = jQuery('select.usb_product4 option:selected').val();
    var labelcheck = jQuery('select.usb_product4 option:selected').data('label');
    if(selectval !=0){
      jQuery('span.cus-right-icon4').show();
    }else{
       jQuery('span.cus-right-icon4').hide();
    }
  });
  
  /*04-12-2020*/
    /*setInterval(function(){ 
    	jQuery(".custom-usb-table .qty1,.custom-usb-table .qty2,.custom-usb-table .qty3,.custom-usb-table .qty4,.custom-usb-table .qty5,.custom-usb-table .qty6,.custom-usb-table .qty7").each(function(){
    		var floatVal = Math.round(parseFloat(jQuery(this).text()));
    		jQuery(this).text(floatVal.toFixed(2));
    	});
    }, 1000);*/
});

</script>
<?php
do_action('woocommerce_after_add_to_cart_form');

