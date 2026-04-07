<?php
add_action('usb_show_price_content', 'show_price_content_cb');
function show_price_content_cb()
{
    global $product;
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = get_woocommerce_currency();
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];
    if ($crncy == 'SEK') {
        $crncy = ' Kr';
    }

    $user = wp_get_current_user();
    $product_id = get_the_ID();


    $productCalculation = [];
    $productResaleCalculation = [];
    $productUserCalculation = [];




        //  qty 1
        $price_option_1_net = get_post_meta(get_the_ID(), '_price_option_1', true);

        if($price_option_1_net){

                $price_option_1 = modify_price_customer_tier_wise($price_option_1_net);
                if ($rate_change > 0) {
                    $price_option_1 = floatval($rate_change) * floatval($price_option_1);
                }
                $price_option_1 = number_format((float) $price_option_1, 2, '.', '');

                $tempArray = [];

                $tempArray['Qty'] = "1";
                $tempArray['price'] = $price_option_1;
                array_push($productCalculation, $tempArray);

                //resale 1
                $resale_price_option_1 = modify_net_price_customer_tier_wise($price_option_1_net);
                if ($rate_change > 0) {
                    $resale_price_option_1 = floatval($rate_change) * floatval($resale_price_option_1);
                }
                $resale_price_option_1 = number_format((float) $resale_price_option_1, 2, '.', '');

                $resaletempArray = [];

                $resaletempArray['Qty'] = "1";
                $resaletempArray['price'] = $resale_price_option_1;
                array_push($productResaleCalculation, $resaletempArray);

        }

                //  qty 25
                
                $price_option_25_net = get_post_meta(get_the_ID(), '_price_option_25', true);

                if($price_option_25_net){

                $price_option_25 = modify_price_customer_tier_wise($price_option_25_net);
                if ($rate_change > 0) {
                    $price_option_25 = floatval($rate_change) * floatval($price_option_25);
                }
                $price_option_25 = number_format((float) $price_option_25, 2, '.', '');

                $tempArray = [];

                $tempArray['Qty'] = "25";
                $tempArray['price'] = $price_option_25;
                array_push($productCalculation, $tempArray);

                //resale 1
                $resale_price_option_25 = modify_net_price_customer_tier_wise($price_option_25_net);
                if ($rate_change > 0) {
                    $resale_price_option_25 = floatval($rate_change) * floatval($resale_price_option_25);
                }
                $resale_price_option_25 = number_format((float) $resale_price_option_25, 2, '.', '');

                $resaletempArray = [];

                $resaletempArray['Qty'] = "25";
                $resaletempArray['price'] = $resale_price_option_25;
                array_push($productResaleCalculation, $resaletempArray);

        }

    //user 50
    $user_price_option_50 = modify_price_customer_search_tier_wise($price_option_50_net);
    if ($rate_change > 0) {
        $user_price_option_50 = floatval($rate_change) * floatval($user_price_option_50);
    }
    $user_price_option_50 = number_format((float) $user_price_option_50, 2, '.', '');

    $resaletempArray = [];

    $usertempArray['Qty'] = "50";
    $usertempArray['price'] = $user_price_option_50;
    array_push($productUserCalculation, $usertempArray);







    //  qty 50
    $price_option_50_net = get_post_meta(get_the_ID(), '_price_option_50', true);
    $price_option_50 = modify_price_customer_tier_wise($price_option_50_net);
    if ($rate_change > 0) {
        $price_option_50 = floatval($rate_change) * floatval($price_option_50);
    }
    $price_option_50 = number_format((float) $price_option_50, 2, '.', '');

    $tempArray = [];

    $tempArray['Qty'] = "50";
    $tempArray['price'] = $price_option_50;
    array_push($productCalculation, $tempArray);

    //resale 50
    $resale_price_option_50 = modify_net_price_customer_tier_wise($price_option_50_net);
    if ($rate_change > 0) {
        $resale_price_option_50 = floatval($rate_change) * floatval($resale_price_option_50);
    }
    $resale_price_option_50 = number_format((float) $resale_price_option_50, 2, '.', '');

    $resaletempArray = [];

    $resaletempArray['Qty'] = "50";
    $resaletempArray['price'] = $resale_price_option_50;
    array_push($productResaleCalculation, $resaletempArray);

    //user 50
    $user_price_option_50 = modify_price_customer_search_tier_wise($price_option_50_net);
    if ($rate_change > 0) {
        $user_price_option_50 = floatval($rate_change) * floatval($user_price_option_50);
    }
    $user_price_option_50 = number_format((float) $user_price_option_50, 2, '.', '');

    $resaletempArray = [];

    $usertempArray['Qty'] = "50";
    $usertempArray['price'] = $user_price_option_50;
    array_push($productUserCalculation, $usertempArray);


    //  qty 100
    $price_option_100_net = get_post_meta(get_the_ID(), '_price_option_100', true);
    $price_option_100 = modify_price_customer_tier_wise($price_option_100_net);
    if ($rate_change > 0) {
        $price_option_100 = floatval($rate_change) * floatval($price_option_100);
    }
    $price_option_100 = number_format((float) $price_option_100, 2, '.', '');

    $tempArray = [];

    $tempArray['Qty'] = "100";
    $tempArray['price'] = $price_option_100;
    array_push($productCalculation, $tempArray);

    //resale 100
    $resale_price_option_100 = modify_net_price_customer_tier_wise($price_option_100_net);
    if ($rate_change > 0) {
        $resale_price_option_100 = floatval($rate_change) * floatval($resale_price_option_100);
    }
    $resale_price_option_100 = number_format((float) $resale_price_option_100, 2, '.', '');

    $resaletempArray = [];

    $resaletempArray['Qty'] = "100";
    $resaletempArray['price'] = $resale_price_option_100;
    array_push($productResaleCalculation, $resaletempArray);

    //user 100
    $user_price_option_100 = modify_price_customer_search_tier_wise($price_option_100_net);
    if ($rate_change > 0) {
        $user_price_option_100 = floatval($rate_change) * floatval($user_price_option_100);
    }
    $user_price_option_100 = number_format((float) $user_price_option_100, 2, '.', '');

    $usertempArray = [];

    $usertempArray['Qty'] = "100";
    $usertempArray['price'] = $user_price_option_100;
    array_push($productUserCalculation, $usertempArray);



    //  qty 250
    $price_option_100 = number_format((float) $price_option_100, 2, '.', '');
    $price_option_250_net = get_post_meta(get_the_ID(), '_price_option_250', true);
    $price_option_250 = modify_price_customer_tier_wise($price_option_250_net);
    if ($rate_change > 0) {
        $price_option_250 = floatval($rate_change) * floatval($price_option_250);
    }
    $price_option_250 = number_format((float) $price_option_250, 2, '.', '');


    $tempArray = [];

    $tempArray['Qty'] = "250";
    $tempArray['price'] = $price_option_250;
    array_push($productCalculation, $tempArray);

    //resale 250
    $resale_price_option_250 = modify_net_price_customer_tier_wise($price_option_250_net);
    if ($rate_change > 0) {
        $resale_price_option_250 = floatval($rate_change) * floatval($resale_price_option_250);
    }
    $resale_price_option_250 = number_format((float) $resale_price_option_250, 2, '.', '');


    $resaletempArray = [];

    $resaletempArray['Qty'] = "250";
    $resaletempArray['price'] = $resale_price_option_250;
    array_push($productResaleCalculation, $resaletempArray);

    //user 250
    $user_price_option_250 = modify_price_customer_search_tier_wise($price_option_250_net);
    if ($rate_change > 0) {
        $user_price_option_250 = floatval($rate_change) * floatval($user_price_option_250);
    }
    $user_price_option_250 = number_format((float) $user_price_option_250, 2, '.', '');


    $usertempArray = [];

    $usertempArray['Qty'] = "250";
    $usertempArray['price'] = $user_price_option_250;
    array_push($productUserCalculation, $usertempArray);


    //  qty 500
    $price_option_500_net = get_post_meta($product_id, '_price_option_500', true);
    $price_option_500 = modify_price_customer_tier_wise($price_option_500_net);
    if ($rate_change > 0) {
        $price_option_500 = floatval($rate_change) * floatval($price_option_500);
    }
    $price_option_500 = number_format((float) $price_option_500, 2, '.', '');

    $tempArray = [];

    $tempArray['Qty'] = "500";
    $tempArray['price'] = $price_option_500;
    array_push($productCalculation, $tempArray);

    //resale 500
    $resale_price_option_500 = modify_net_price_customer_tier_wise($price_option_500_net);
    if ($rate_change > 0) {
        $resale_price_option_500 = floatval($rate_change) * floatval($resale_price_option_500);
    }
    $resale_price_option_500 = number_format((float) $resale_price_option_500, 2, '.', '');

    $resaletempArray = [];

    $resaletempArray['Qty'] = "500";
    $resaletempArray['price'] = $resale_price_option_500;
    array_push($productResaleCalculation, $resaletempArray);


    //user 500
    $user_price_option_500 = modify_price_customer_search_tier_wise($price_option_500_net);
    if ($rate_change > 0) {
        $user_price_option_500 = floatval($rate_change) * floatval($user_price_option_500);
    }
    $user_price_option_500 = number_format((float) $user_price_option_500, 2, '.', '');

    $usertempArray = [];

    $usertempArray['Qty'] = "500";
    $usertempArray['price'] = $user_price_option_500;
    array_push($productUserCalculation, $usertempArray);

    //  qty 1000
    $price_option_1000_net = get_post_meta(get_the_ID(), '_price_option_1000', true);
    $price_option_1000 = modify_price_customer_tier_wise($price_option_1000_net);
    if ($rate_change > 0) {
        $price_option_1000 = floatval($rate_change) * floatval($price_option_1000);
    }
    $price_option_1000 = number_format((float) $price_option_1000, 2, '.', '');

    $tempArray = [];

    $tempArray['Qty'] = "1000";
    $tempArray['price'] = $price_option_1000;
    array_push($productCalculation, $tempArray);

    //resale 1000
    $resale_price_option_1000 = modify_net_price_customer_tier_wise($price_option_1000_net);
    if ($rate_change > 0) {
        $resale_price_option_1000 = floatval($rate_change) * floatval($resale_price_option_1000);
    }
    $resale_price_option_1000 = number_format((float) $resale_price_option_1000, 2, '.', '');

    $resaletempArray = [];

    $resaletempArray['Qty'] = "1000";
    $resaletempArray['price'] = $resale_price_option_1000;
    array_push($productResaleCalculation, $resaletempArray);

    //user 1000
    $user_price_option_1000 = modify_price_customer_search_tier_wise($price_option_1000_net);
    if ($rate_change > 0) {
        $user_price_option_1000 = floatval($rate_change) * floatval($user_price_option_1000);
    }
    $user_price_option_1000 = number_format((float) $user_price_option_1000, 2, '.', '');

    $usertempArray = [];

    $usertempArray['Qty'] = "1000";
    $usertempArray['price'] = $user_price_option_1000;
    array_push($productUserCalculation, $usertempArray);

    //  qty 2500

    $price_option_2500_net = get_post_meta(get_the_ID(), '_price_option_2500', true);
    $price_option_2500 = modify_price_customer_tier_wise($price_option_2500_net);
    if ($rate_change > 0) {
        $price_option_2500 = floatval($rate_change) * floatval($price_option_2500);
    }
    $price_option_2500 = number_format((float) $price_option_2500, 2, '.', '');

    $tempArray = [];

    $tempArray['Qty'] = "1000";
    $tempArray['price'] = $price_option_2500;
    array_push($productCalculation, $tempArray);

    //resale 2500
    $resale_price_option_2500 = modify_net_price_customer_tier_wise($price_option_2500_net);
    if ($rate_change > 0) {
        $resale_price_option_2500 = floatval($rate_change) * floatval($resale_price_option_2500);
    }
    $resale_price_option_2500 = number_format((float) $resale_price_option_2500, 2, '.', '');

    $resaletempArray = [];

    $resaletempArray['Qty'] = "1000";
    $resaletempArray['price'] = $resale_price_option_2500;
    array_push($productResaleCalculation, $resaletempArray);

    //user 2500
    $user_price_option_2500 = modify_price_customer_search_tier_wise($price_option_2500_net);
    if ($rate_change > 0) {
        $user_price_option_2500 = floatval($rate_change) * floatval($user_price_option_2500);
    }
    $user_price_option_2500 = number_format((float) $user_price_option_2500, 2, '.', '');

    $usertempArray = [];

    $usertempArray['Qty'] = "2500";
    $usertempArray['price'] = $user_price_option_2500;
    array_push($productUserCalculation, $usertempArray);

    //  qty 5000

    $price_option_5000_net = get_post_meta(get_the_ID(), '_price_option_5000', true);
    $price_option_5000 = modify_price_customer_tier_wise($price_option_5000_net);
    if ($rate_change > 0) {
        $price_option_5000 = floatval($rate_change) * floatval($price_option_5000);
    }
    $price_option_5000 = number_format((float) $price_option_5000, 2, '.', '');

    $tempArray = [];



    $tempArray['Qty'] = "2500";
    $tempArray['price'] = $price_option_5000;
    array_push($productCalculation, $tempArray);

    //resale 5000
    $resale_price_option_5000 = modify_net_price_customer_tier_wise($price_option_5000_net);
    if ($rate_change > 0) {
        $resale_price_option_5000 = floatval($rate_change) * floatval($resale_price_option_5000);
    }
    $resale_price_option_5000 = number_format((float) $resale_price_option_5000, 2, '.', '');

    $resaletempArray = [];



    $resaletempArray['Qty'] = "2500";
    $resaletempArray['price'] = $resale_price_option_5000;
    array_push($productResaleCalculation, $resaletempArray);

    //user 5000
    $user_price_option_5000 = modify_price_customer_search_tier_wise($price_option_5000_net);
    if ($rate_change > 0) {
        $user_price_option_5000 = floatval($rate_change) * floatval($user_price_option_5000);
    }
    $user_price_option_5000 = number_format((float) $user_price_option_5000, 2, '.', '');

    $usertempArray = [];



    $usertempArray['Qty'] = "2500";
    $usertempArray['price'] = $user_price_option_5000;
    array_push($productUserCalculation, $usertempArray);

    //var_dump($productCalculation);

    function roundUpToTwoDecimals($price)
    {
        return ceil($price * 100) / 100;
    }



    ?>


    <!-- choose product price  start -->
    <?php
    //$product = wc_get_product($product_id);
    $rate_change_cs = get_field('price_fractor', 'option');
    ?>
    <div class="custom_price_cal">
    <h4 class="woocommerce-description-custom"><?php _e('Your net price', 'usb'); ?></h4>
        <div class="single-price-table-wrap">

        <?php if(is_user_logged_in()){?>

             <table class="table">
                
                <thead>
                    <tr>
                        <th><?php _e( 'Quantity', 'usb' ); ?></th>
                        <?php
                        foreach ($productCalculation as $item) {
                            
                            $quantity = $item['Qty'];
                            $price = $item['price'];
                            if ($price > 0) {
                                ?>
                                <th><?php echo $quantity; ?></th>

                            <?php }
                        }?>
                    </tr>
                </thead>
                <tbody>

                    <tr class="table-primary">
                        <td class="td_name"><?php _e( 'Item Price', 'usb' ); ?></td>
                        <?php
                        foreach ($productCalculation as $item) {
                           
                            $quantity = $item['Qty'];
                            $price = $item['price'];
                            if ($price > 0) {
                                ?>
                                <td><?php echo $price?></td>

                            <?php }
                         }?>
                    </tr>
                    <!-- <tr>
                        <td class="td_name">Total Price</td>
                        <?php
                        foreach ($productCalculation as $item) {
                            $quantity = $item['Qty'];
                            $price = $item['price'];
                            if ($price > 0) {
                                ?>
                                <td><?php echo roundUpToTwoDecimals(($price + $price) * $quantity); ?></td>

                            <?php }
                        } ?>
                    </tr> -->
                </tbody>
            </table>

          <?php }else{ ?>  

                <table class="table">
                    
                    <thead>
                        <tr>
                            <th><?php _e( 'Quantity', 'usb' ); ?></th>
                            <?php
                            foreach ($productCalculation as $item) {
                                if($item['Qty'] == '50' || $item['Qty'] == '100' || $item['Qty'] == '250' || $item['Qty'] == '500' ){
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <th><?php echo $quantity; ?></th>

                                <?php }
                            } }?>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="table-primary">
                            <td class="td_name"><?php _e( 'Item Price', 'usb' ); ?></td>
                            <?php
                            foreach ($productCalculation as $item) {
                                if($item['Qty'] == '50' || $item['Qty'] == '100' || $item['Qty'] == '250' || $item['Qty'] == '500' ){
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {

                          $final_price = (float)$price * (float)$rate_change_cs;

                                // Round to nearest 0.50
                                $final_price = round($final_price * 2) / 2;

                                // Format Swedish style
                                $final_price = number_format($final_price, 2, ',', ' ');
                                    ?>
                                    <td><?php echo $final_price ; ?></td>

                                <?php }
                            } }?>
                        </tr>
                        <!-- <tr>
                            <td class="td_name">Total Price</td>
                            <?php
                            foreach ($productCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <td><?php echo roundUpToTwoDecimals(($price + $price) * $quantity); ?></td>

                                <?php }
                            } ?>
                        </tr> -->
                    </tbody>
                </table>

            <?php } ?>
            
        </div>
            <?php if ( get_field('handling_cost_text') ) : ?>
  <p class="note_text">
    <?php echo get_field('handling_cost_text'); ?>
  </p>
<?php else: ?>
  <p>
    <?php echo get_field('price_table_text', 'option'); ?>
  </p>
<?php endif; ?>


    </div>

    <?php if (is_user_logged_in()) {
        if (current_user_can('administrator') && isset($_REQUEST['user_id'])) {

            // echo "<pre>";
            // print_r($productResaleCalculation);
            // echo "</pre>";


            $user_id = $_REQUEST['user_id'];
            $user_level = $_REQUEST['user_level'];
            $user_info = get_userdata($user_id);

            $first_name = get_user_meta($user_id, 'first_name', true);
            $last_name = get_user_meta($user_id, 'last_name', true);
            $company = get_user_meta($user_id, 'company', true);
            $customer_no = get_user_meta($user_id, 'customer_no', true);
            $customer_email = $user_info->user_email;

            $level_price = get_field($user_level, 'option');

        
            // Get billing country code from user meta
            $billing_country_code = get_user_meta( $user_id, 'billing_country', true );

    
            ?>
            <div class="custom_price_cal">
                <table class="table">
                    <h4 class="woocommerce-description-custom"><?php _e('User price', 'usb'); ?></h4>
                    <ul>
                    <?php
                    if ($company) { ?>
                           <li> 
                            <strong><span class="company_id"><?php _e('Company Name:', 'usb'); ?>&nbsp;<?php echo $company; ?></strong></span>
                              </li>
                        <?php } ?>
                      <li> 
                        <strong><span class="customer_name"><?php _e('Customer Name:', 'usb'); ?></strong>
                            <?php echo $first_name . ' ' . $last_name; ?></span><span class="customer_id"> (
                            <?php _e('Customer ID:', 'usb'); ?> &nbsp;           <?php echo $user_id ?>)</span>
                    </li>
                        
                            <?php if ($customer_no) { ?>
                                <li> 
                            <strong> <span class="customer_no"><?php _e('Customer No:', 'usb'); ?>  </strong>&nbsp;               <?php echo $customer_no; ?></span><br>
                               </li>
                            <?php } ?>

                     
                        <li>
                            <strong><span class="customer_email"><?php _e('Customer Email:', 'usb'); ?></strong>&nbsp;
                            <?php echo $customer_email; ?></span>
                        </li>
                        <li> 
                        <strong> <span class="user_level"><?php _e('Customer Tier:', 'usb'); ?></strong>&nbsp;
                                <?php echo $user_level . '=' . $level_price . "%"; ?></span>
                        </li>  

                        <?php if($billing_country_code) {
                        // Get country name from WooCommerce
                        $country_name = WC()->countries->countries[ $billing_country_code ] ?? $billing_country_code;

                        // Get currency code from country (WooCommerce locale map)
                        $locale = WC()->countries->get_country_locale();
                        $currency_code = isset( $locale[ $billing_country_code ]['currency'] ) ? $locale[ $billing_country_code ]['currency'] : get_woocommerce_currency(); // fallback to store currency
                        if($country_name == 'Sverige'){
                            $country_name = 'Sweden';
                        }
                        ?>
                      <li> 
                       <strong> <span class="user_level"><?php _e('Customer Country/Currency:', 'usb'); ?></strong>&nbsp;
                            <?php echo $country_name." ($currency_code)"; ?></span>
                      </li>  
                    
                      <?php } ?>
                    </ul>
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <?php
                            foreach ($productUserCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <th><?php echo $quantity; ?></th>

                                <?php }
                            } ?>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="table-primary">
                            <td class="td_name"><?php _e( 'Item Price', 'usb' ); ?></td>
                            <?php
                            foreach ($productUserCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <td><?php echo $price; ?></td>

                                <?php }
                            } ?>
                        </tr>
                        <!-- <tr>
                            <td class="td_name">Total Price</td>
                            <?php
                            foreach ($productUserCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <td><?php echo roundUpToTwoDecimals(($price + $price) * $quantity); ?></td>

                                <?php }
                            } ?>
                        </tr> -->
                    </tbody>
                </table>
                <?php if ( get_field('handling_cost_text') ) : ?>
  <p class="note_text">
    <?php echo get_field('handling_cost_text'); ?>
  </p>
<?php else: ?>
  <p>
    <?php echo get_field('price_table_text', 'option'); ?>
  </p>
<?php endif; ?>

            </div>
        <?php }
    } ?>


    <?php if (is_user_logged_in()) {
        if (!current_user_can('administrator')) { 
           
            ?>
            <div class="custom_price_cal">
                <table class="table">
                    <h4 class="woocommerce-description-custom"><?php _e('Recommended Resale Price', 'usb'); ?></h4>
                    <thead>
                        <tr>
                            <th>Quantity</th>
                            <?php
                            foreach ($productResaleCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <th><?php echo $quantity; ?></th>

                                <?php }
                            } ?>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="table-primary">
                            <td class="td_name"><?php _e( 'Item Price', 'usb' ); ?></td>
                            <?php
                            foreach ($productResaleCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <td><?php echo $price; ?></td>

                                <?php }
                            } ?>
                        </tr>
                        <!-- <tr>
                            <td class="td_name">Total Price</td>
                            <?php
                            foreach ($productResaleCalculation as $item) {
                                $quantity = $item['Qty'];
                                $price = $item['price'];
                                if ($price > 0) {
                                    ?>
                                    <td><?php echo roundUpToTwoDecimals(($price + $price) * $quantity); ?></td>

                                <?php }
                            } ?>
                        </tr> -->
                    </tbody>
                </table>
                <?php if ( get_field('handling_cost_text') ) : ?>
  <p class="note_text">
    <?php echo get_field('handling_cost_text'); ?>
  </p>
<?php else: ?>
  <p>
    <?php echo get_field('price_table_text', 'option'); ?>
  </p>
<?php endif; ?>

                <div class="col-md-12">
                    <!-- Button trigger modal -->
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#price_calculatuion">
                        Price calculator
                    </button> -->
                </div>
            </div>
        <?php }
    } ?>
<?php
}