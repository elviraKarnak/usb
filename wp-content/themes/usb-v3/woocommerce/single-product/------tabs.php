<?php

/**

 * Single Product tabs
 *

 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.

 *

 * HOWEVER, on occasion WooCommerce will need to update template files and you

 * (the theme developer) will need to copy the new files to your theme to

 * maintain compatibility. We try to do this as little as possible, but it does

 * happen. When this occurs the version of the template file will be bumped and

 * the readme will list any important changes.

 *

 * @see 	https://docs.woocommerce.com/document/template-structure/

 * @author  WooThemes

 * @package WooCommerce/Templates

 * @version 2.4.0

 */



if (!defined('ABSPATH')) {

  exit;

}



/**

 * Filter tabs and allow third parties to add their own.

 *

 * Each tab is an array containing title, callback and priority.

 * @see woocommerce_default_product_tabs()

 */

global $post;

global $product;

$product_data_chk = get_post_meta($post->ID, '_product_data_chk', true);

$product_acccessories_chk = get_post_meta($post->ID, '_product_acccessories_chk', true);

$product_download_chk = get_post_meta($post->ID, '_product_download_chk', true);

$product_reference_chk = get_post_meta($post->ID, '_product_reference_chk', true);

$product_image_chk = get_post_meta($post->ID, '_product_image_chk', true);

?>



<div class="accordion accordion-flush single-page-description-accordion" id="producttabcontent">


<div class="accordion-item">
    <h2 class="accordion-header" id="flush-heading5">
      <button class="accordion-button" type="button" data-bs-toggle="collapse"
        data-bs-target="#flush-collapse5" aria-expanded="false"
        aria-controls="flush-collapse5">
        USG
      </button>
    </h2>
    <div id="flush-collapse5" class="accordion-collapse collapse show"
      aria-labelledby="flush-heading5" data-bs-parent="#producttabcontent">
      <div class="accordion-body">
        <div class="pdp-grey-box product-compliance-icons-container">
          <!-- <div class="pdp-grey-header">
      ESG Footprint
    </div> -->

          <div class="uxIconWrapper">
            <?php
            
            // Get the footprint options from the options page
            $logo_terms = get_the_terms($product->get_id(), 'product-logo');
            $esgSea = get_post_meta($product->get_id(), 'esg_footprint_product', true);
            $esgAir = get_post_meta($product->get_id(), 'esg_footprint_product_air', true);

            if ($logo_terms && !is_wp_error($logo_terms)) {

              $esgData_1 = '';
              $esgData_2 = '';
              $esgData_dflt = '';


              // Loop through the footprints in the options page
              foreach ($logo_terms as $footprint) {
                $logo_image_url = get_field('logo_image', 'product-logo_' . $footprint->term_id);
                if ($logo_image_url) {

                  $logo_image_url = $logo_image_url['url'];
                }
                //print_r($logo_image_url);
                $logo_link_url = get_field('logo_url', 'product-logo_' . $footprint->term_id);
                $logoType = get_field('type_product_logo_attr', 'product-logo_' . $footprint->term_id);

                if (!empty($logo_image_url) && ($logoType == 'esg') && (!empty($esgSea) || !empty($esgAir))) {
                  if ($footprint->slug == 'esg-footprint') {
                    $esgData_1 .= '<div id="divCO2Icon" class="CO2Icon" style="cursor: pointer; background-image: url(' . $logo_image_url . '); background-size: cover; background-position: center;">';
                    $esgData_1 .= '<span  class="co2_value">' . $esgSea . 'KG</span>';
                    $esgData_1 .= '</div>';
                  } else if ($footprint->slug == 'esg-air') {
                    $esgData_2 .= '<div id="divCO2Icon" class="CO2Icon" style="cursor: pointer; background-image: url(' . $logo_image_url . '); background-size: cover; background-position: center;">';
                    $esgData_2 .= '<span  class="co2_value">' . $esgAir . 'KG</span>';
                    $esgData_3 .= '</div>';
                  }


                } else if ($logo_image_url) {
                  // Get the image URL and logo URL
                  // Display each logo in a list item
                  $esgData_dflt .= '<li>';
                  if ($logo_link_url) {
                    $esgData .= '<a href="' . $logo_link_url . '" target="_blank">';
                  }
                  $esgData_dflt .= '<img src="' . $logo_image_url . '" alt="Product Logo">';
                  if ($logo_link_url) {
                    $esgData_dflt .= '</a>';
                  }
                  $esgData_dflt .= '</li>';
                }
              }


              echo '<ul class="product-footprint-logos">';
              if (!empty($esgSea) || !empty($esgAir)) {
                echo "<li>";
                echo "<div class='esg-wrap d-flex'>";
                echo $esgData_1 . $esgData_2;
                echo "</div>";
                echo "</li>";
              }

              echo $esgData_dflt;
              echo '</ul>';

            }
            ?>

          </div>
          <!--	
    <div class="uxIconWrapper">
      <div class="first-row">

        <div id="divCO2Icon" class="CO2Icon" style="cursor: pointer;">
          <span  class="co2-value"><?php echo get_post_meta($product->get_id(), 'esg_footprint_product', true) ?></span>
        </div>

        
      </div>
      <a href="https://www.amfori.org/" id="ctl00_ctl00_ctl00_SiteContent_SiteContent_SiteContent_uxSingleProductInfo_uxCompliance_aBSCIIcon" class="bscci-icon" target="_blank">
        <img id="ctl00_ctl00_ctl00_SiteContent_SiteContent_SiteContent_uxSingleProductInfo_uxCompliance_uxBSCIIcon" title="The producing factory of this product is BSCI audited." src="https://elvirainfotech.live/usb/wp-content/uploads/2024/05/BSCI.png" style="border-width:0px;"></a>
      
      <div class="bscci-icon-wrapper">
        
        
      </div>
      <div id="divRCS" class="RCSIcon" style="cursor: pointer;">
        <img id="ctl00_ctl00_ctl00_SiteContent_SiteContent_SiteContent_uxSingleProductInfo_uxCompliance_uxRCS" title="This product is RCS (Recycled Claim Standard) certified" src="https://elvirainfotech.live/usb/wp-content/uploads/2024/05/RCS.png" style="border-width:0px;">
      </div>
      <div id="divRCSClaim" class="RCSClaimIcon" style="cursor: pointer;">                
        <a href="https://textileexchange.org/recycled-claim-global-recycled-standard/" id="ctl00_ctl00_ctl00_SiteContent_SiteContent_SiteContent_uxSingleProductInfo_uxCompliance_aRCSClaim" target="_blank">
          <img id="ctl00_ctl00_ctl00_SiteContent_SiteContent_SiteContent_uxSingleProductInfo_uxCompliance_uxRCSClaim" title="This product is RCS Blended certified" src="https://elvirainfotech.live/usb/wp-content/uploads/2024/05/RCS-Blended.png" style="border-width:0px;">                
        </a>
      </div>
      
    </div>-->
        </div>
      </div>
    </div>
  </div>



  <?php if ($product_data_chk == 'yes') { ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">



          <?php if ($product_data_chk == 'yes') { ?>


            <?php echo get_field('tab_title_1', 'option'); ?></a></li>



          <?php } ?>


        </button>
      </h2>

      <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
        data-bs-parent="#producttabcontent">
        <div class="accordion-body">
          <?php if ($product_data_chk == 'yes') { ?>

            <div id="productdata" class="product-data">

              <?php

              global $post;

              $specification_array = array('co2_data_source', 'brand', 'main_colour', 'pms_main_colour', 'net_item_weight_gr', 'packaging_type', 'outer_carton_size_cm', 'quantity_per_carton_outer', 'product_category', 'intracode', 'batteries_included', 'battery_type', 'sleeve_option', 'social_audited_factory', 'factory', 'rcs_claim', 'material', 'total_co2_kg', 'product_size_cm', 'gross_weight_item_gr', 'product_box_size_cm', 'quantity_in_box_inner', 'tare_weight_outer_carton_kg', 'product_subcategory', 'country_of_origin', 'number_of_batteries', 'battery_weight_gr', 'powerbank_capacity_mah', 'weee_registration');

              $ID = $post->ID;


              //  $productdata_content = get_post_meta( $ID, $key = 'productdata_content', $single = true);
          
              // echo $productdata_content;
          
              //echo apply_filters('the_content', $productdata_content);
              // Example array of ACF fields and their labels
          
              $co2_eq = get_field('co2-eq_sp', 'option');
              $blank_mark_for_co2_emissions = get_field('blank_mark_for_co2-emissions', 'option');
              $brand_name = get_field('brand_name_sp', 'option');
              $wireless_charging = get_field('wireless_charging_sp', 'option');
              $capacity_month = get_field('capacity_month_sp', 'option');
              $inkl_batterier = get_field('inkl_batterier', 'option');
              $number_of_batteries = get_field('number_of_batteries_sp', 'option');
              $battery_type = get_field('battery_type_sp', 'option');
              $batterier_iec_kod = get_field('batterier_iec-kod_sp', 'option');
              $vikt_batterier = get_field('vikt_batterier_sp', 'option');
              $usb_output = get_field('usb_output_sp', 'option');
              $fast_charging = get_field('fast_charging_sp', 'option');
              $magnetic_wireless_charging = get_field('magnetic_wireless_charging_sp', 'option');
              $charging_capacity_for_laptops = get_field('charging_capacity_for_laptops_sp', 'option');
              $simultaneous_loading_of_number_of_units = get_field('simultaneous_loading_of_number_of_units_sp', 'option');
              $wireless_charging_input = get_field('wireless_charging_input_sp', 'option');
              $continuous_charging = get_field('continuous_charging_sp', 'option');
              $approved_as_hand_luggage = get_field('approved_as_hand_luggage_sp', 'option');
              $charging_indicator = get_field('charging_indicator_sp', 'option');
              $product_category = get_field('product_category', 'option');
              $subcategory = get_field('subcategory_sp', 'option');
              $material = get_field('material_sp', 'option');
              $secondary_material = get_field('secondary_material_sp', 'option');
              $recycled_content = get_field('recycled_content_sp', 'option');
              $wide_product = get_field('wide_product_sp', 'option');
              $product_length = get_field('product_length_sp', 'option');
              $elevated_product = get_field('elevated_product_sp', 'option');
              $net_weight_of_the_product = get_field('net_weight_of_the_product_sp', 'option');
              $product_gross_weight = get_field('product_gross_weight_sp', 'option');
              $packaging = get_field('packaging_sp', 'option');
              $quantity_inner_box = get_field('quantity_inner_box_sp', 'option');
              $product_box_length = get_field('product_box_length_sp', 'option');
              $wide_product_box = get_field('wide_product_box_sp', 'option');
              $hojd_produktlada = get_field('hojd_produktlada_sp', 'option');
              $pms_color = get_field('pms_color_sp', 'option');
              $intrastat_code = get_field('intrastat_code_sp','option');
              $dangerous_goods_class = get_field('dangerous_goods_class_sp','option');
              $ean_country_of_origin = get_field('ean_country_of_origin_sp','option');

              $acf_fields = array(
                'co2-eq' => $co2_eq,
                'blank_mark_for_co2-emissions' => $blank_mark_for_co2_emissions,
                '_brand_name' => $brand_name,
                'wireless_charging' => $wireless_charging,
                '_capacity_month' => $capacity_month,
                'inkl_batterier' => $inkl_batterier,
                'number_of_batteries' => $number_of_batteries,
                'battery_type' => $battery_type,
                'batterier_iec-kod' => $batterier_iec_kod,
                'vikt_batterier' => $vikt_batterier,
                'usb_output' => $usb_output,
                'fast_charging' => $fast_charging,
                '_magnetic_wireless_charging' => $magnetic_wireless_charging,
                'charging_capacity_for_laptops' => $charging_capacity_for_laptops,
                'simultaneous_loading_of_number_of_units' => $simultaneous_loading_of_number_of_units,
                'wireless_charging_input' => $wireless_charging_input,
                'continuous_charging' => $continuous_charging,
                'approved_as_hand_luggage' => $approved_as_hand_luggage,
                'charging_indicator' => $charging_indicator,
                'product_category' => $product_category,
                'subcategory' => $subcategory,
                'material' => $material,
                'secondary_material' => $secondary_material,
                'recycled_content' => $recycled_content,
                'wide_product' => $wide_product,
                '_product_length' => $product_length,
                'elevated_product' => $elevated_product,
                'net_weight_of_the_product' => $net_weight_of_the_product,
                'product_gross_weight' => $product_gross_weight,
                '_packaging' => $packaging,
                '_quantity_inner_box' => $quantity_inner_box,
                '_product_box_length' => $product_box_length,
                'wide_product_box' => $wide_product_box,
                'hojd_produktlada' => $hojd_produktlada,
                '_pms_color' => $pms_color,
                'intrastat_code' => $intrastat_code,
                'dangerous_goods_class' => $dangerous_goods_class,
                'ean_country_of_origin' => $ean_country_of_origin,
              );

              // $acf_fields = array(
              //     'co2-eq' => 'CO2-eq',
              //     'blank_mark_for_co2-emissions' => 'Blank mark for CO2-emissions',
              //     '_brand_name' => 'Brand name',
              //     'wireless_charging' => 'Wireless charging',
              //     '_capacity_month' => 'Capacity (month)',
              //     'inkl_batterier' => 'Inkl. batterier',
              //     'number_of_batteries' => 'Number of batteries',
              //     'battery_type' => 'Battery type',
              //     'batterier_iec-kod' => 'Batterier IEC-kod',
              //     'vikt_batterier' => 'Vikt batterier',
              //     'usb_output' => 'USB output',
              //     'fast_charging' => 'Fast charging',
              //     '_magnetic_wireless_charging' => 'Magnetic wireless charging',
              //     'charging_capacity_for_laptops' => 'Charging capacity for laptops',
              //     'simultaneous_loading_of_number_of_units' => 'Simultaneous loading of number of units',
              //     'wireless_charging_input' => 'Wireless charging (input)',
              //     'continuous_charging' => 'Continuous charging',
              //     'approved_as_hand_luggage' => 'Approved as hand luggage',
              //     'charging_indicator' => 'Charging indicator',
              //     'product_category' => 'Product category',
              //     'subcategory' => 'Subcategory',
              //     'material' => 'Material',
              //     'secondary_material' => 'Secondary material',
              //     'recycled_content' => 'Recycled content',
              //     'wide_product' => 'Wide product',
              //     '_product_length' => 'Product length',
              //     'elevated_product' => 'Elevated product',
              //     'net_weight_of_the_product' => 'Net weight of the product',
              //     'product_gross_weight' => 'Product gross weight',
              //     '_packaging' => 'Packaging',
              //     '_quantity_inner_box' => 'Quantity (inner box)',
              //     '_product_box_length' => 'Product box length',
              //     'wide_product_box' => 'Wide product box',
              //     'hojd_produktlada' => 'Raised product box',
              //     '_pms_color' => 'PMS color',
              // );
          
              echo '<div class="full_width_tepl" style="width:100%;">';
              // Start the table
              echo '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">';

              // Split the array into two columns
              $fields_per_column = ceil(count($acf_fields) / 2);
              $field_chunks = array_chunk($acf_fields, $fields_per_column, true);

              // Display the two columns
              echo '<tr>';
              // foreach ($field_chunks as $column) {
              //   echo '<td style="vertical-align: top;">';
              //   echo '<table style="width: 100%;">';
              //   foreach ($column as $field_name => $label) {
              //     $value = get_field($field_name); // Retrieve ACF field value
              //     $value_display = !empty($value) ? $value : 'N/A'; // Placeholder if empty
              //     echo '<tr>';
              //     echo '<td style="font-weight: bold;">';
              //     _e($label, 'usb-tab');
              //     echo '</td>';
              //     echo '<td>' . esc_html($value_display) . '</td>';
              //     echo '</tr>';
              //   }
              //   echo '</table>';
              //   echo '</td>';
              // }
              // echo '</tr>';

              // // End the table
              // echo '</table>';
              // echo '</div>';
              foreach ($field_chunks as $column) {
                echo '<td style="vertical-align: top;">';
                echo '<table style="width: 100%;">';
                foreach ($column as $field_name => $label) {
                    $value = get_field($field_name); // Retrieve ACF field value
                    $value_display = !empty($value) ? $value : 'N/A'; // Placeholder if empty

                    // Add units based on field name
                    if (!empty($value)) {
                        switch ($field_name) {
                            case 'recycled_content':
                                $value_display .= ' %';
                                break;
                            case 'wide_product':
                            case '_product_length':
                                $value_display .= ' mm';
                                break;
                            case 'product_gross_weight':
                                $value_display .= ' gram';
                                break;
                            case '_quantity_inner_box':
                                $value_display .= ' pcs';
                                break;
                            case '_product_box_length':
                            case 'wide_product_box':
                                $value_display .= ' cm';
                                break;
                        }
                    }

                    if(!empty($value_display) && $value_display != 'N/A'){
                    echo '<tr>';
                    echo '<td style="font-weight: bold;">';
                    _e($label, 'usb-tab');
                    echo '</td>';
                    echo '<td>' . esc_html($value_display) . '</td>';
                    echo '</tr>';
                    }
                }
                echo '</table>';
                echo '</td>';
            }
            echo '</tr>';

            // End the table
            echo '</table>';
            echo '</div>';
              ?>

            </div>

          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if ($product_acccessories_chk == 'yes') { ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
          <?php if ($product_acccessories_chk == 'yes') { ?>

            <?php echo get_field('tab_title_3', 'option'); ?>

          <?php } ?>
        </button>
      </h2>
      <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
        data-bs-parent="#producttabcontent">
        <div class="accordion-body">
          <?php if ($product_acccessories_chk == 'yes') { ?>

            <div id="accessories1" class="acces-data">

              <?php

              global $product;
              $id = $product->id;
              $product = new WC_Product($id);
              $upsells = $product->get_upsells();
              $meta_query = WC()->query->get_meta_query();
              $args = array(
                'post_type' => 'product',
                'ignore_sticky_posts' => 1,
                'no_found_rows' => 1,
                'posts_per_page' => $posts_per_page,
                'orderby' => $orderby,
                'post__in' => $upsells,
                'post__not_in' => array($id),
                'meta_query' => $meta_query
              );

              $products = new WP_Query($args);
              if ($products->have_posts()) {
                // Iterate over the each product
                while ($products->have_posts()) {

                  $products->the_post();
                  $accessoriesimage = wp_get_attachment_image_src(get_post_thumbnail_id($p_query->ID), 'thumbnail');

                  ?>


                  <div class="col-sm-3 col-xs-6">
                    <div class="accessories-product">
                      <a href="<?php the_permalink(); ?>">
                        <div class="accessories-product-img"><img src="<?php echo $accessoriesimage[0]; ?>"></div>
                        <h2><?php echo get_the_title($post->ID); ?></h2>
                      </a>
                    </div>
                  </div>
                  <?php
                }
              }
              wp_reset_query();
              ?>

            </div>

          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if ($product_download_chk == 'yes') { ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
          <?php if ($product_download_chk == 'yes') { ?>

            <?php echo get_field('tab_title_4', 'option'); ?>

          <?php } ?>
        </button>
      </h2>
      <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree"
        data-bs-parent="#producttabcontent">
        <div class="accordion-body">
          <?php if ($product_download_chk == 'yes') { ?>
            <div id="download1" class="download-data">
              <?php
              global $post;
              $ID = $post->ID;
              $download = get_post_meta($ID, $key = 'download', $single = true);
              // echo $download;
              echo apply_filters('the_content', $download);
              ?>

              <?php
              global $post, $product;
              if ($product->is_type('standard')) {
                ?>
                <div class="cus-margin-btn-warp">
                  <?php //echo do_shortcode('[usb_pdf pdf_name="Export"]'); ?>
                  <!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo get_the_ID(); ?>" target="_blank" data-productId="<?php //echo $id; ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->
                  <a class="dwnpdf"
                    href='?pdf=<?php echo get_the_ID(); ?>&lang=<?php echo $_GET['lang'] ? $_GET['lang'] : 'en'; ?>'
                    target='_blank'>
                    <?php _e('Product PDF', 'usb'); ?></a>
                  <?php if (is_user_logged_in()) { ?>
                    <!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo get_the_ID(); ?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en'; ?>" target="_blank" data-productId="<?php //echo $id; ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->
                  <?php } ?>
                </div>
                <?php
              } else if ($product->is_type('usb')) {
                ?>

                  <div class="cus-usb-offer">
                    <style type="text/css">
                      .standard-product .custom-usb .cus-usb-offer a {
                        margin: 5px;
                      }
                    </style>
                  <?php //echo do_shortcode('[usb_pdf pdf_name="Export"]'); ?>
                    <a class="dwnpdf"
                      href='?pdf=<?php echo get_the_ID(); ?>&lang=<?php echo $_GET['lang'] ? $_GET['lang'] : 'en'; ?>'
                      target='_blank'>
                    <?php _e('Product PDF', 'usb'); ?></a>
                  <?php if (is_user_logged_in()) { ?>
                      <!-- <a class="usb_down_pdf_summary22" href='?usbofferpdf=<?php //echo get_the_ID(); ?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en'; ?>' target="_blank" data-productId="<?php //echo get_the_ID(); ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->
                  <?php } ?>
                    <!-- <a href="#">Offer</a> -->
                  </div>
                <?php
              } else {
                //
              }
              ?>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php if ($product_download_chk == 'yes') { ?>
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingFour">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
          data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
          <?php if ($product_reference_chk == 'yes') { ?>

            <?php echo get_field('tab_title_5', 'option'); ?>

          <?php } ?>
        </button>
      </h2>
      <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
        data-bs-parent="#producttabcontent">
        <div class="accordion-body">

          <?php if ($product_reference_chk == 'yes') { ?>
            <div id="reference" class="reference-data">
              <?php
              $elviracustom_gal_attachments = get_post_meta(get_the_ID(), '_elviracustom_gal_attachments', false);

              ?>
              <div class="gal_images">
                <?php
                if ($elviracustom_gal_attachments) {
                  foreach ($elviracustom_gal_attachments as $attachment) {
                    $thumb_url = wp_get_attachment_image_src($attachment, 'full');
                    if (!empty($thumb_url)) {
                      echo
                        '<div class="col-sm-3 col-xs-6">
        <div class="accessories-product">
        <div class="accessories-product-img">
        <a href="' . $thumb_url[0] . '" class="fancybox" data-fancybox-group="gallery"><img src="' . wp_get_attachment_thumb_url($attachment) . '"></a></div>
        </div>
        </div>';
                    }
                  }
                } ?>

              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php /*
<?php if ($product_image_chk == 'yes') { ?>
<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingFour">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
Image
</button>
</h2>

<div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive"
data-bs-parent="#producttabcontent">
<div class="accordion-body">
<?php if ($product_image_chk == 'yes') { ?>
<div id="image" class="image-data">
  <?php
  global $post;
  $ID = $post->ID;
  $image = get_post_meta($ID, $key = 'image', $single = true);
  echo apply_filters('the_content', $image);
  ?>
</div>

<?php } ?>
</div>
</div>
</div>

<?php } ?>*/ ?>





  

  <?php if (have_rows('create_tabs', $post->ID)) {
    $counter = 7;
    // Loop through each repeater row
    while (have_rows('create_tabs', $post->ID)) {
      the_row();
      $tab_title = get_sub_field('tqb_name');
      $tab_content = get_sub_field('tab_content');
      ?>

      <div class="accordion-item">
        <h2 class="accordion-header" id="flush-heading<?php echo $counter; ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapse<?php echo $counter; ?>" aria-expanded="false"
            aria-controls="flush-collapse<?php echo $counter; ?>">
            <?php echo esc_html($tab_title); ?>
          </button>
        </h2>
        <div id="flush-collapse<?php echo $counter; ?>" class="accordion-collapse collapse"
          aria-labelledby="flush-heading<?php echo $counter; ?>" data-bs-parent="#producttabcontent">
          <div class="accordion-body">
            <?php echo apply_filters('the_content', $tab_content); ?>
          </div>
        </div>
      </div>
      <?php
      $counter++;
    }
  } ?>

</div>


<?php /*
<ul class="nav nav-tabs ei-nav ">



<?php if ($product_data_chk == 'yes') { ?>

<li class="active"><a data-toggle="tab" href="#productdata">
<?php echo get_field('tab_title_1', 'option'); ?></a></li>



<?php } ?>




<?php if ($product_acccessories_chk == 'yes') { ?>

<li><a data-toggle="tab" href="#accessories"><?php echo get_field('tab_title_3', 'option'); ?></a></li>

<?php } ?>

<?php if ($product_download_chk == 'yes') { ?>

<li><a data-toggle="tab" href="#download"><?php echo get_field('tab_title_4', 'option'); ?></a></li>

<?php } ?>

<?php if ($product_reference_chk == 'yes') { ?>

<li><a data-toggle="tab" href="#reference"><?php echo get_field('tab_title_5', 'option'); ?></a></li>

<?php } ?>

<?php if (have_rows('create_tabs', $post->ID)) {
$counter = 1;

// Loop through each repeater row
while (have_rows('create_tabs', $post->ID)) {
the_row();

$tab_title = get_sub_field('tqb_name');
?>
<li><a data-toggle="tab" href="#custom_tab_<?php echo $counter; ?>"><?php echo $tab_title; ?></a></li>
<?php
$counter++;
}
?>
<?php } ?>
</ul>


<div class="tab-content">

<?php if ($product_data_chk == 'yes') { ?>

<div id="productdata" class="tab-pane fade show active">

<?php

global $post;

$specification_array = array('co2_data_source', 'brand', 'main_colour', 'pms_main_colour', 'net_item_weight_gr', 'packaging_type', 'outer_carton_size_cm', 'quantity_per_carton_outer', 'product_category', 'intracode', 'batteries_included', 'battery_type', 'sleeve_option', 'social_audited_factory', 'factory', 'rcs_claim', 'material', 'total_co2_kg', 'product_size_cm', 'gross_weight_item_gr', 'product_box_size_cm', 'quantity_in_box_inner', 'tare_weight_outer_carton_kg', 'product_subcategory', 'country_of_origin', 'number_of_batteries', 'battery_weight_gr', 'powerbank_capacity_mah', 'weee_registration');

$ID = $post->ID;


//  $productdata_content = get_post_meta( $ID, $key = 'productdata_content', $single = true);

// echo $productdata_content;

//echo apply_filters('the_content', $productdata_content);
// Example array of ACF fields and their labels

$co2_eq = get_field('co2-eq_sp', 'option');
$blank_mark_for_co2_emissions = get_field('blank_mark_for_co2-emissions', 'option');
$brand_name = get_field('brand_name_sp', 'option');
$wireless_charging = get_field('wireless_charging_sp', 'option');
$capacity_month = get_field('capacity_month_sp', 'option');
$inkl_batterier = get_field('inkl_batterier', 'option');
$number_of_batteries = get_field('number_of_batteries_sp', 'option');
$battery_type = get_field('battery_type_sp', 'option');
$batterier_iec_kod = get_field('batterier_iec-kod_sp', 'option');
$vikt_batterier = get_field('vikt_batterier_sp', 'option');
$usb_output = get_field('usb_output_sp', 'option');
$fast_charging = get_field('fast_charging_sp', 'option');
$magnetic_wireless_charging = get_field('magnetic_wireless_charging_sp', 'option');
$charging_capacity_for_laptops = get_field('charging_capacity_for_laptops_sp', 'option');
$simultaneous_loading_of_number_of_units = get_field('simultaneous_loading_of_number_of_units_sp', 'option');
$wireless_charging_input = get_field('wireless_charging_input_sp', 'option');
$continuous_charging = get_field('continuous_charging_sp', 'option');
$approved_as_hand_luggage = get_field('approved_as_hand_luggage_sp', 'option');
$charging_indicator = get_field('charging_indicator_sp', 'option');
$product_category = get_field('product_category', 'option');
$subcategory = get_field('subcategory_sp', 'option');
$material = get_field('material_sp', 'option');
$secondary_material = get_field('secondary_material_sp', 'option');
$recycled_content = get_field('recycled_content_sp', 'option');
$wide_product = get_field('wide_product_sp', 'option');
$product_length = get_field('product_length_sp', 'option');
$elevated_product = get_field('elevated_product_sp', 'option');
$net_weight_of_the_product = get_field('net_weight_of_the_product_sp', 'option');
$product_gross_weight = get_field('product_gross_weight_sp', 'option');
$packaging = get_field('packaging_sp', 'option');
$quantity_inner_box = get_field('quantity_inner_box_sp', 'option');
$product_box_length = get_field('product_box_length_sp', 'option');
$wide_product_box = get_field('wide_product_box_sp', 'option');
$hojd_produktlada = get_field('hojd_produktlada_sp', 'option');
$pms_color = get_field('pms_color_sp', 'option');

$acf_fields = array(
'co2-eq' => $co2_eq,
'blank_mark_for_co2-emissions' => $blank_mark_for_co2_emissions,
'_brand_name' => $brand_name,
'wireless_charging' => $wireless_charging,
'_capacity_month' => $capacity_month,
'inkl_batterier' => $inkl_batterier,
'number_of_batteries' => $number_of_batteries,
'battery_type' => $battery_type,
'batterier_iec-kod' => $batterier_iec_kod,
'vikt_batterier' => $vikt_batterier,
'usb_output' => $usb_output,
'fast_charging' => $fast_charging,
'_magnetic_wireless_charging' => $magnetic_wireless_charging,
'charging_capacity_for_laptops' => $charging_capacity_for_laptops,
'simultaneous_loading_of_number_of_units' => $simultaneous_loading_of_number_of_units,
'wireless_charging_input' => $wireless_charging_input,
'continuous_charging' => $continuous_charging,
'approved_as_hand_luggage' => $approved_as_hand_luggage,
'charging_indicator' => $charging_indicator,
'product_category' => $product_category,
'subcategory' => $subcategory,
'material' => $material,
'secondary_material' => $secondary_material,
'recycled_content' => $recycled_content,
'wide_product' => $wide_product,
'_product_length' => $product_length,
'elevated_product' => $elevated_product,
'net_weight_of_the_product' => $net_weight_of_the_product,
'product_gross_weight' => $product_gross_weight,
'_packaging' => $packaging,
'_quantity_inner_box' => $quantity_inner_box,
'_product_box_length' => $product_box_length,
'wide_product_box' => $wide_product_box,
'hojd_produktlada' => $hojd_produktlada,
'_pms_color' => $pms_color,
);

// $acf_fields = array(
//     'co2-eq' => 'CO2-eq',
//     'blank_mark_for_co2-emissions' => 'Blank mark for CO2-emissions',
//     '_brand_name' => 'Brand name',
//     'wireless_charging' => 'Wireless charging',
//     '_capacity_month' => 'Capacity (month)',
//     'inkl_batterier' => 'Inkl. batterier',
//     'number_of_batteries' => 'Number of batteries',
//     'battery_type' => 'Battery type',
//     'batterier_iec-kod' => 'Batterier IEC-kod',
//     'vikt_batterier' => 'Vikt batterier',
//     'usb_output' => 'USB output',
//     'fast_charging' => 'Fast charging',
//     '_magnetic_wireless_charging' => 'Magnetic wireless charging',
//     'charging_capacity_for_laptops' => 'Charging capacity for laptops',
//     'simultaneous_loading_of_number_of_units' => 'Simultaneous loading of number of units',
//     'wireless_charging_input' => 'Wireless charging (input)',
//     'continuous_charging' => 'Continuous charging',
//     'approved_as_hand_luggage' => 'Approved as hand luggage',
//     'charging_indicator' => 'Charging indicator',
//     'product_category' => 'Product category',
//     'subcategory' => 'Subcategory',
//     'material' => 'Material',
//     'secondary_material' => 'Secondary material',
//     'recycled_content' => 'Recycled content',
//     'wide_product' => 'Wide product',
//     '_product_length' => 'Product length',
//     'elevated_product' => 'Elevated product',
//     'net_weight_of_the_product' => 'Net weight of the product',
//     'product_gross_weight' => 'Product gross weight',
//     '_packaging' => 'Packaging',
//     '_quantity_inner_box' => 'Quantity (inner box)',
//     '_product_box_length' => 'Product box length',
//     'wide_product_box' => 'Wide product box',
//     'hojd_produktlada' => 'Raised product box',
//     '_pms_color' => 'PMS color',
// );

echo '<div class="full_width_tepl" style="width:100%;">';
// Start the table
echo '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse;">';

// Split the array into two columns
$fields_per_column = ceil(count($acf_fields) / 2);
$field_chunks = array_chunk($acf_fields, $fields_per_column, true);

// Display the two columns
echo '<tr>';
foreach ($field_chunks as $column) {
echo '<td style="vertical-align: top;">';
echo '<table style="width: 100%;">';
foreach ($column as $field_name => $label) {
$value = get_field($field_name); // Retrieve ACF field value
$value_display = !empty($value) ? $value : 'N/A'; // Placeholder if empty
echo '<tr>';
echo '<td style="font-weight: bold;">';
_e($label, 'usb-tab');
echo '</td>';
echo '<td>' . esc_html($value_display) . '</td>';
echo '</tr>';
}
echo '</table>';
echo '</td>';
}
echo '</tr>';

// End the table
echo '</table>';
echo '</div>';
?>

</div>

<?php } ?>

<?php if ($product_acccessories_chk == 'yes') { ?>

<div id="accessories" class="tab-pane fade">

<?php

global $product;
$id = $product->id;
$product = new WC_Product($id);
$upsells = $product->get_upsells();
$meta_query = WC()->query->get_meta_query();
$args = array(
'post_type' => 'product',
'ignore_sticky_posts' => 1,
'no_found_rows' => 1,
'posts_per_page' => $posts_per_page,
'orderby' => $orderby,
'post__in' => $upsells,
'post__not_in' => array($id),
'meta_query' => $meta_query
);

$products = new WP_Query($args);
if ($products->have_posts()) {
// Iterate over the each product
while ($products->have_posts()) {

$products->the_post();
$accessoriesimage = wp_get_attachment_image_src(get_post_thumbnail_id($p_query->ID), 'thumbnail');

?>


<div class="col-sm-3 col-xs-6">
<div class="accessories-product">
<a href="<?php the_permalink(); ?>">
<div class="accessories-product-img"><img src="<?php echo $accessoriesimage[0]; ?>"></div>
<h2><?php echo get_the_title($post->ID); ?></h2>
</a>
</div>
</div>
<?php
}
}
wp_reset_query();
?>

</div>

<?php } ?>

<?php if ($product_download_chk == 'yes') { ?>
<div id="download" class="tab-pane fade">
<?php
global $post;
$ID = $post->ID;
$download = get_post_meta($ID, $key = 'download', $single = true);
// echo $download;
echo apply_filters('the_content', $download);
?>

<?php
global $post, $product;
if ($product->is_type('standard')) {
?>
<div class="cus-margin-btn-warp">
<?php //echo do_shortcode('[usb_pdf pdf_name="Export"]'); ?>
<!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo get_the_ID(); ?>" target="_blank" data-productId="<?php //echo $id; ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->
<a class="dwnpdf" href='?pdf=<?php echo get_the_ID(); ?>&lang=<?php echo $_GET['lang'] ? $_GET['lang'] : 'en'; ?>'
target='_blank'>
<?php _e('Product PDF', 'usb'); ?></a>
<?php if (is_user_logged_in()) { ?>
<!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo get_the_ID(); ?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en'; ?>" target="_blank" data-productId="<?php //echo $id; ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->
<?php } ?>
</div>
<?php
} else if ($product->is_type('usb')) {
?>

<div class="cus-usb-offer">
<style type="text/css">
.standard-product .custom-usb .cus-usb-offer a {
margin: 5px;
}
</style>
<?php //echo do_shortcode('[usb_pdf pdf_name="Export"]'); ?>
<a class="dwnpdf" href='?pdf=<?php echo get_the_ID(); ?>&lang=<?php echo $_GET['lang'] ? $_GET['lang'] : 'en'; ?>'
target='_blank'>
<?php _e('Product PDF', 'usb'); ?></a>
<?php if (is_user_logged_in()) { ?>
<!-- <a class="usb_down_pdf_summary22" href='?usbofferpdf=<?php //echo get_the_ID(); ?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en'; ?>' target="_blank" data-productId="<?php //echo get_the_ID(); ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->
<?php } ?>
<!-- <a href="#">Offer</a> -->
</div>
<?php
} else {
//
}
?>
</div>
<?php } ?>
<?php if ($product_reference_chk == 'yes') { ?>
<div id="reference" class="tab-pane fade">
<?php
$elviracustom_gal_attachments = get_post_meta(get_the_ID(), '_elviracustom_gal_attachments', false);

?>
<div class="gal_images">
<?php
if ($elviracustom_gal_attachments) {
foreach ($elviracustom_gal_attachments as $attachment) {
$thumb_url = wp_get_attachment_image_src($attachment, 'full');
if (!empty($thumb_url)) {
echo
'<div class="col-sm-3 col-xs-6">
<div class="accessories-product">
<div class="accessories-product-img">
<a href="' . $thumb_url[0] . '" class="fancybox" data-fancybox-group="gallery"><img src="' . wp_get_attachment_thumb_url($attachment) . '"></a></div>
</div>
</div>';
}
}
} ?>

</div>
</div>
<?php } ?>

<?php if ($product_image_chk == 'yes') { ?>
<div id="image" class="tab-pane fade">
<?php
global $post;
$ID = $post->ID;
$image = get_post_meta($ID, $key = 'image', $single = true);
echo apply_filters('the_content', $image);
?>
</div>

<?php } ?>

<?php if (have_rows('create_tabs', $post->ID)) {
$counter = 1;
// Loop through each repeater row
while (have_rows('create_tabs', $post->ID)) {
the_row();
$tab_title = get_sub_field('tqb_name');
$tab_content = get_sub_field('tab_content');
?>

<div id="custom_tab_<?php echo $counter; ?>" class="tab-pane fade dynamic_tab_content">
<?php echo apply_filters('the_content', $tab_content); ?>
</div>
<?php
$counter++;
}
?>
<?php } ?>

</div>
*/ ?>

<script type="text/javascript">
  jQuery("body").on("click", "ul.ei-nav li a", function () {
    var href = jQuery(this).attr('href');
    jQuery('.tab-content .tab-pane').removeClass('show')
    jQuery(href).addClass('show');
  });

  // jQuery(document).ready(function(){

  //   if (jQuery("ul.ei-nav li:nth-child(1)").length) {

  //     jQuery("ul.ei-nav li:nth-child(1) a").trigger('click');

  //   }

  // });

</script>