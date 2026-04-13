<?php
    require_once( get_template_directory() . '/inc/theme-functions/dompdf2/vendor/autoload.php' );

use Dompdf\Dompdf;
use Dompdf\Options;

if (!function_exists('usb_v3_pdf_value_to_text')) {
  function usb_v3_pdf_value_to_text($value) {
    if (is_array($value)) {
      $items = array();
      array_walk_recursive($value, function ($item) use (&$items) {
        if (is_scalar($item) && $item !== '') {
          $items[] = $item;
        }
      });

      return implode(', ', $items);
    }

    return is_scalar($value) ? (string) $value : '';
  }
}

if (!function_exists('usb_v3_get_pdf_specification_html')) {
  function usb_v3_get_pdf_specification_html($product_id) {
    if (!function_exists('get_field')) {
      return '';
    }

    $acf_fields = array(
      'co2-eq' => get_field('co2-eq_sp', 'option'),
      'blank_mark_for_co2-emissions' => get_field('blank_mark_for_co2-emissions', 'option'),
      '_brand_name' => get_field('brand_name_sp', 'option'),
      'wireless_charging' => get_field('wireless_charging_sp', 'option'),
      '_capacity_month' => get_field('capacity_month_sp', 'option'),
      'inkl_batterier' => get_field('inkl_batterier', 'option'),
      'number_of_batteries' => get_field('number_of_batteries_sp', 'option'),
      'battery_type' => get_field('battery_type_sp', 'option'),
      'batterier_iec-kod' => get_field('batterier_iec-kod_sp', 'option'),
      'vikt_batterier' => get_field('vikt_batterier_sp', 'option'),
      'usb_output' => get_field('usb_output_sp', 'option'),
      'fast_charging' => get_field('fast_charging_sp', 'option'),
      '_magnetic_wireless_charging' => get_field('magnetic_wireless_charging_sp', 'option'),
      'charging_capacity_for_laptops' => get_field('charging_capacity_for_laptops_sp', 'option'),
      'simultaneous_loading_of_number_of_units' => get_field('simultaneous_loading_of_number_of_units_sp', 'option'),
      'wireless_charging_input' => get_field('wireless_charging_input_sp', 'option'),
      'continuous_charging' => get_field('continuous_charging_sp', 'option'),
      'approved_as_hand_luggage' => get_field('approved_as_hand_luggage_sp', 'option'),
      'charging_indicator' => get_field('charging_indicator_sp', 'option'),
      'product_category' => get_field('product_category', 'option'),
      'subcategory' => get_field('subcategory_sp', 'option'),
      'material' => get_field('material_sp', 'option'),
      'secondary_material' => get_field('secondary_material_sp', 'option'),
      'recycled_content' => get_field('recycled_content_sp', 'option'),
      'wide_product' => get_field('wide_product_sp', 'option'),
      '_product_length' => get_field('product_length_sp', 'option'),
      'elevated_product' => get_field('elevated_product_sp', 'option'),
      'net_weight_of_the_product' => get_field('net_weight_of_the_product_sp', 'option'),
      'product_gross_weight' => get_field('product_gross_weight_sp', 'option'),
      '_packaging' => get_field('packaging_sp', 'option'),
      '_quantity_inner_box' => get_field('quantity_inner_box_sp', 'option'),
      '_product_box_length' => get_field('product_box_length_sp', 'option'),
      'wide_product_box' => get_field('wide_product_box_sp', 'option'),
      'hojd_produktlada' => get_field('hojd_produktlada_sp', 'option'),
      '_pms_color' => get_field('pms_color_sp', 'option'),
      'intrastat_code' => get_field('intrastat_code_sp', 'option'),
      'dangerous_goods_class' => get_field('dangerous_goods_class_sp', 'option'),
      'ean_country_of_origin' => get_field('ean_country_of_origin_sp', 'option'),
    );

    $fields_per_column = ceil(count($acf_fields) / 2);
    $field_chunks = array_chunk($acf_fields, $fields_per_column, true);
    $columns = array();

    foreach ($field_chunks as $column_index => $column) {
      $rows = '';

      foreach ($column as $field_name => $label) {
        $value_display = trim(usb_v3_pdf_value_to_text(get_field($field_name, $product_id)));

        if ($value_display === '') {
          continue;
        }

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

        $label = trim(usb_v3_pdf_value_to_text($label));
        if ($label === '') {
          $label = ucwords(str_replace(array('_', '-'), ' ', $field_name));
        }

        $rows .= '<tr>';
        $rows .= '<td style="font-weight:bold; padding:4px 8px 4px 0; width:45%;">' . esc_html__($label, 'usb-tab') . '</td>';
        $rows .= '<td style="padding:4px 0;">' . esc_html($value_display) . '</td>';
        $rows .= '</tr>';
      }

      if ($rows !== '') {
        $heading = ($column_index === 0) ? __('Produkt Information', 'usb') : __('Produkt Specifikationer', 'usb');
        $columns[] = '<td style="vertical-align:top; width:50%; padding:0 15px 0 0;"><h3 style="font-size:14px; margin:0 0 8px 0;">' . esc_html($heading) . '</h3><table style="width:100%; border-collapse:collapse; font-size:11px;">' . $rows . '</table></td>';
      }
    }

    if (empty($columns)) {
      return '';
    }

    return '<table border="0" cellpadding="0" cellspacing="0" class="main_specification_table" style="width:100%; border-collapse:collapse;">'
      . '<tr>' . implode('', $columns) . '</tr>'
      . '</table>';
  }
}

    
   $post_id = $_GET['pdf'];

   if (isset($post_id)) {  
   $current_lang = $sitepress->get_current_language();

   var_dump($post_id);
  
 
   $product_title= get_the_title($post_id);
   $product_sku= get_post_meta($post_id,'_sku',true);
   $aDataTableDetailHTML[] = 'Art No.';
   $aDataTableDetailHTML[] = $product_sku;
   $product_description = get_the_excerpt($post_id);
   $product_thumbnail= get_the_post_thumbnail( $post_id, 'full', array( 'class' => 'alignleft' ) );
   $product = new WC_product($post_id);
   $custom_product_data = get_post_meta( $post_id,'productdata_content', true);
    
    $DOM = new DOMDocument();
    // $DOM->loadHTML($custom_product_data);
    if(!empty($custom_product_data)){

    
    $DOM->loadHTML(mb_convert_encoding($custom_product_data, 'HTML-ENTITIES', 'UTF-8'));

    $Detail = $DOM->getElementsByTagName('td');
    $i = 0;
    $j = 0;
    foreach($Detail as $sNodeDetail) 
    {
      $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
      
    }
    
    $cnt = 1;
    if($aDataTableDetailHTML) {
      $custom_product_data = '<table style="width:60%;"><tr>';
      foreach ($aDataTableDetailHTML as $key => $value) {
        $custom_product_data .= '<td style="font-size:13px;">'.$value.'</td>';
        if ($cnt%4 == 0 && $cnt < count($aDataTableDetailHTML)) {
          $custom_product_data .= '</tr><tr>';
        }
        $cnt++;
      }
      $custom_product_data .= '</tr></table>';
    }

   $sku= $product->get_sku();
    $html = '';
    $html.='<!DOCTYPE html>';
    $html.='<html>';
    $html.='<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    $html.='<style type="text/css">';
    $html.='*{padding:0; margin:0;} body{font-family: arial, sans-serif; padding:0; margin:0;} table{ text-align:left; border-spacing:0;} .img-tb{ background:#fff;  width:100%; } .gallery-img img{width:100%; height:auto; } .gallery-img.gallery-thumb img{ width:100%; height:auto; } .pdf_product_title{background:#5ba8dc;} .specification_data_table > table.summary{ width:100%; background:#e1e1e1; padding:20px 20px 20px 20px; margin:0 30px;} .specification_data_table > table > td{ font-size:10px; padding:0px 5px;} 
.specification_data_table > table > tbody > tr > td{ padding:5px 8px 5px 0; } .specification_data_table > table > tbody > tr > td:nth-child(2){padding-right:50px;}';  


    $html.='.summary-last{background:#7092be!important;color:#fff}.summary td{padding:5px 4px!important;font-size:12px}.table td{border:none;padding:4px 5px!important;vertical-align:middle!important;position:relative}.summary td{padding:5px 4px!important;font-size:12px}.table td{border:none;padding:4px 5px!important;vertical-align:middle!important;position:relative}.summary td.totalpcs span{background:#fff;color:#000;padding:0 3px}';

    
    $html.='</style>';
    $html.='</head>';

    $html.='<body style="background-color: #eee; padding:0; margin:0; position:relative;">';
      $html.='<table class="pdf-tbl 1" background:#fff; border-spacing:0; padding:0; margin:0;">';
        $html.='<tbody>';
          $html.='<tr>';
            $html.='<td>';
              $html.='<table>';
                $html.='<tbody>';
                  $html.='<tr height="70" class="pdf_product_title" style="width:100%;">';
                    $html.='<td>';
                      $html.='<h1 class="prod_title" style="color:#fff; height:60px; padding:20px 10px 0 50px; overflow:hidden;">';
                        $html.= $product_title;
                      $html.='</h1>';
                    $html.='</td>';
                  $html.='</tr>';
                $html.='</tbody>';
              $html.='</table>';
            $html.='</td>';
          $html.='</tr>';

          $html.='<tr>';
            $html.='<td style="padding:0 30px; background:#fff;">';
              $html.='<table class="img-tb" background:#fff; style:"width:100%; overflow:hidden;">';
                $html.='<tbody>';
                  $html.='<tr class="pro-block">';
                    $html.='<td class="gallery" bgcolor="#fff"; style="width:200px";>';
                      $html.='<div class="gallery-img" style="overflow: hidden; vertical-align: middle;">';
                        $html.= $product_thumbnail;
                      $html.='</div>';
                    $html.='</td>';
                    $html.='<td class="gallery" style="width:200px; height:250px;vertical-align: middle;">';
                      $html.='<ul>';
                        $attachment_ids = $product->get_gallery_attachment_ids();
                        $image_counter=0;
                        $attachment_ids = array_slice($attachment_ids, 0, 1);
                        foreach( $attachment_ids as $attachment_id ) 
                        { 
                          $html.='<div class="gallery-img gallery-thumb" style="text-align:right;">';
                          $img_url = wp_get_attachment_image_src($attachment_id,'full');
                            
                            if (!empty($img_url[0])) {
                              
                                $html.= '<img src="'.$img_url[0].'">';
                              }
                          $html.='</div>';
                          }
                      $html.='</ul>';
                    $html.='</td>';

                    $attachment_ids = $product->get_gallery_attachment_ids();
                    $image_counter=0;
                    $attachment_ids = array_slice($attachment_ids, 1, 1);
                    if ($attachment_ids) {
                      $html.='<td class="gallery" style="width:200px; height:250px;vertical-align: middle;">';
                      $html.='<ul>';
                      
                      
                      foreach( $attachment_ids as $attachment_id ) 
                      { 
                        $html.='<div class="gallery-img gallery-thumb" style="text-align:right;">';
                        $img_url = wp_get_attachment_image_src($attachment_id,'full');
                          
                          if (!empty($img_url[0])) {
                            
                              $html.= '<img src="'.$img_url[0].'">';
                            }
                        $html.='</div>';
                        } 
                      $html.='</ul>';
                      $html.='</td>';
                    }
                  $html.='</tr>';
                $html.='</tbody>';
              $html.='</table>';
            $html.='</td>';
          $html.='</tr>';

          $html.='<tr bgcolor="#eee">';
            $html.='<td style="padding:20px 35px">';
              $html.='<h3 style="font-family: arial, sans-serif; font-size:15px; line-height:17px; font-weight:bold; text-transform:uppercase; margin:0 0 5px 0">';
                $html.=  __('Description', 'usb').':';
              $html.='</h3>';
              $html.='<p class="description" style="font-size:16px; line-height:20px; padding-bottom:0; margin-botton:0; word-break: break-all; word-wrap: break-word;">';
                $html.= $product_description;
              $html.='</p>';
            $html.='</td>';
          $html.='</tr>';

          $html.='<tr style="padding:10px 30px">';
            $html.='<td style="position: relative;float: left;width: 100%; box-sizing: border-box;padding:20px 35px;" >';
              $html.='<h3 style="font-family: arial, sans-serif; font-size:15px; line-height:17px; font-weight:bold; text-transform:uppercase; padding:0; margin:0 0 5px 0">';
                $html.= __('Specification', 'usb').':';
              $html.='</h3>';
              $html.='<div class="specification_data_table" style="font-size:8px; line-height:14px;">';
                $html.= $custom_product_data;
              $html.='</div>';
            $html.='</td>';
          $html.='</tr>';

          $html.='<tr class="">';
            $html.='<td style="padding:10px 30px;">';
              $html.='<table style="color:#fff; width:90%;">';
                $html.='<tbody>';
                  $html.='<tr style="background:#7092be;">';
                    $html.='<td style="padding:10px 15px 10px 30px;"><span style="inline-block;"></span> <span style="display:inline-block; background:#fff; color:#000; padding:0 2px; margin-top:3px;"></span></td>';
                    $html.='<td class="totalpcs" style="white-space: nowrap; padding:10px 15px;"><span style="inline-block;">'.__('Qty', 'usb').'</span> <span style="display:inline-block; background:#fff; color:#000; padding:0 2px; margin-top:3px;">'.$_GET['margin_Qty'].'</span></td>';
                    $html.='<td class="pricemargin" style="white-space: nowrap; padding:10px 15px;"><input type="hidden" class="margin_price" name="margin_price" id="margin_price">'.__('Price/pcs', 'usb').' <span style="display:inline-block; background:#fff; color:#000; padding:0 2px; margin-top:3px;">'.$_GET['margin_Price'].'</span></td>';
                    $html.='<td class="totalmargin" style="white-space: nowrap; padding:10px 30px 10px 15px;"><input type="hidden" class="margin_amount" name="margin_amount" id="margin_amount">'.__('Total order', 'usb').' <span style="display:inline-block; background:#fff; color:#000; padding:0 2px;  margin-top:3px;">'.$_GET['margin_total'].'</span></td>';
                  $html.='</tr>';
                $html.='</tbody>';
              $html.='</table>';
            $html.='</td">';
          $html.='</tr >';
        $html.='</tbody>';
        $html.='<tfoot style="display:table; width:100%; padding:0; margin:0;line-height:0; background:#eee; height: 58px;">';
          $html.='<tr style="background:#eee;">';
            $html.='<td style="background:#eee;">';
              $html.='<h2 style="text-align:center; background:#eee; display:inline-block; position:absolute; left: 0;right: 0;bottom:0;border: 0;margin:0;padding:0;"><img src="https://www.usb.nu/wp-content/uploads/2019/09/usb-bg1.jpg"/ style="padding:0;  height;80px;"';
              $html.=' </h2>'; 
            $html.='</td>';
          $html.='</tr>';
        $html.='</tfoot>';
      $html.='</table>';
  $html.='</body>';
  $html.='</html>';
//   echo $html;
// die();
  //echo $html;
  // die();


  $dompdf = new Dompdf();
  $dompdf->set_option('isRemoteEnabled', TRUE);
  $dompdf->loadHtml($html);

  $dompdf->setPaper('A4', 'portrait');   

  $dompdf->render();
  $output = $dompdf->output();
  //$dompdf->stream();
  ob_end_clean();
  $dompdf->stream($product_title.".pdf", array("Attachment" => true));
  //$dompdf->stream("test.pdf", array("Attachment" => false));

exit();
}
   } else {
    
   }

//PDF function for logged in user
  $offer_post_id= $_GET['offerpdf'];

  if (isset($offer_post_id)) {  


      $current_lang = $sitepress->get_current_language(); 
      $user_ID = get_current_user_id();
      // $product_sku= get_post_meta($offer_post_id,'_sku',true);
      $userid = metadata_exists('post', $offer_post_id, '_offer_summary_html_'.$user_ID);

      $summary = '';
      if($userid){
        $summary = get_post_meta( $offer_post_id,'_offer_summary_html'.'_'.$user_ID, true);
      }
      else
      {
        $source = '';
      }

      //$summary_html_user_id = substr($userid, strrpos($userid, '_' )+1);

        if(!empty($summary))
        {
          $DOM = new DOMDocument();
          // $DOM->loadHTML($custom_product_data);
          $DOM->loadHTML(mb_convert_encoding($summary, 'HTML-ENTITIES', 'UTF-8'));
          $Detail = $DOM->getElementsByTagName('td');

          $i = 0;
        $j = 0;
        foreach($Detail as $sNodeDetail) 
        {
          $aDataTableDetailHTMLNew[] = trim($sNodeDetail->textContent);
        }

        $i = 0;
        $cnt = 1;
        $trcnt = 2;
        $totalcnt = count($aDataTableDetailHTMLNew);
        $last1td = $totalcnt-14;
        $last2td = $totalcnt-7;
        unset($aDataTableDetailHTMLNew[$last1td],$aDataTableDetailHTMLNew[$last2td]);
        $totalcntN = count($aDataTableDetailHTMLNew);
        $last1tr = ($totalcntN/6);
        $last2tr = $last1tr-1;

        if($aDataTableDetailHTMLNew) {
          $summary = '<style> th{ margin:0; color:#3f3f3f; font-size:14px; line-height:20px; padding:10px 8px;}
            .specification_data_table > table.lower-data-table > tbody > tr > td:nth-child(6){ width:200px;} 
          .specification_data_lower_table > table.lower-data-table > tbody > tr > td{ white-space: nowrap; padding:8px 8px;}
          </style>
          <table class="lower-data-table"style="width:695px; overflow: hidden;">
          <tr style="padding:5px 0px; margin:0;">
          <th style="width:65px; padding:5px;">Art&nbsp;no</th><th>'.__( 'Product', 'usb' ).'</th><th>'.__( 'Options', 'usb' ).'</th><th>'.__( 'Qty', 'usb' ).'</th><th>'.__( 'Price/pcs', 'usb' ).'</th><th>'.__( 'Total cost', 'usb' ).'</th>
          </tr>
          <tr style="font-size:12px; line-height:18px; background-color:#d3d5d6; color:#545454;">';
          foreach ($aDataTableDetailHTMLNew as $key => $value) {
            if ($trcnt%2 == 0) {
              $style = "font-size:12px; line-height:18px; background-color:#e1e2e3; padding:12px 0; color:#545454;";
            } else {
              $style = "font-size:12px; line-height:18px; background-color:#d3d5d6; padding:12px 0; color:#545454;";
            }
            if ($trcnt == $last1tr || $trcnt == $last2tr) {
              $style = "font-size:12px; line-height:18px; background-color:#6a8fbb; color:#fff; padding:12px 0;";
            }if ($trcnt == $last1tr) {
              $style = "font-size:12px; line-height:18px; display:none; background-color:#6a8fbb; color:#fff; padding:12px 0;";
            }
            $value = str_replace("Price/pcs", "Price/pcs ", $value);
            $value = str_replace("Total order", "Total order ", $value);
            $value = str_replace("Pris/st", "Pris/st ", $value);
            $value = str_replace("Pris totalt", "Pris totalt ", $value);
            $value = str_replace("Antal", "Antal ", $value);
            $value = str_replace("Qty", "Qty ", $value);
            $summary .= '<td>'.__($value,'usb').'</td>';
            if ($cnt%6 == 0 && $cnt < count($aDataTableDetailHTMLNew)) {
              $summary .= '</tr><tr style="'.$style.'">';
              $trcnt++;
            }
            $cnt++;
          }
          $summary .= '</tr></table>';
        }

        
        
        }

      
      $product_title= get_the_title($offer_post_id);
      $product_description = get_the_excerpt($offer_post_id);
      $product_thumbnail= get_the_post_thumbnail( $offer_post_id, 'full', array( 'class' => 'alignleft' ) );
      $product = new WC_product($offer_post_id);
      $custom_product_data = get_post_meta( $offer_post_id,'productdata_content', true);
      $pdf_specification_data = usb_v3_get_pdf_specification_html($offer_post_id);

    //  echo $product_title;
    //  echo $product_description;
    //  echo $product_thumbnail; 
    //  var_dump($product);

    //  die();


      $DOM = new DOMDocument();
      //  var_dump($custom_product_data);
        // $DOM->loadHTML($custom_product_data);
        if(!empty($custom_product_data)){
            $DOM->loadHTML(mb_convert_encoding($custom_product_data, 'HTML-ENTITIES', 'UTF-8'));

            $Detail = $DOM->getElementsByTagName('td');
            $i = 0;
            $j = 0;
            foreach($Detail as $sNodeDetail) 
            {
              $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
              
            }
            
            $cnt = 1;
            if($aDataTableDetailHTML) {
              $custom_product_data = '<table style="width:60%;"><tr>';
              foreach ($aDataTableDetailHTML as $key => $value) {
                $custom_product_data .= '<td style="font-size:13px;">'.$value.'</td>';
                if ($cnt%4 == 0 && $cnt < count($aDataTableDetailHTML)) {
                  $custom_product_data .= '</tr><tr>';
                }
                $cnt++;
              }
              $custom_product_data .= '</tr></table>';
            }
        }
        if (empty($pdf_specification_data)) {
          $pdf_specification_data = $custom_product_data;
        }

          $sku= $product->get_sku();
            $html = '';
            $html.='<!DOCTYPE html>';
            $html.='<html>';
            $html.='<head>';
            $html.='<style type="text/css">';
            $html.='*{padding:0; margin:0;} body{font-family: arial, sans-serif; padding:0; margin:0;} table{ text-align:left; border-spacing:0;} .img-tb{ background:#fff;  width:100%; } .gallery-img img{width:100%; height:auto; } .gallery-img.gallery-thumb img{ width:100%; height:auto; } .pdf_product_title{background:#5ba8dc;} .specification_data_table > table.summary{ width:100%; background:#e1e1e1; padding:20px 20px 20px 20px; margin:0 30px;} .specification_data_table > table > td{ font-size:10px; padding:0px 5px;} 
        .specification_data_table > table > tbody > tr > td{ padding:5px 8px 5px 0; white-space: nowrap; } .specification_data_table > table > tbody > tr > td:nth-child(2){padding-right:50px;}';    
            $html.='</style>';
            $html.='</head>';
            $html.='<body style="background-color: #eee; padding:0; margin:0; position:relative;">';
            $html.='<table class="pdf-tbl 2" background:#fff; border-spacing:0; padding:0; margin:0;">';
              $html.='<tbody>';
                $html.='<tr>';
                  $html.='<td>';
                    $html.='<table>';
                      $html.='<tbody>';
                        $html.='<tr height="70" class="pdf_product_title" style="width:100%;">';
                          $html.='<td>';
                            $html.='<h1 class="prod_title" style="color:#fff; height:60px; padding:20px 10px 0 50px;">';
                              $html.= $product_title;
                            $html.='</h1>';
                          $html.='</td>';
                        $html.='</tr>';
                      $html.='</tbody>';
                    $html.='</table>';
                  $html.='</td>';
                $html.='</tr>';
                $html.='<tr>';
                  $html.='<td style="padding:0 30px; background:#fff;">';
                    $html.='<table class="img-tb" background:#fff; style:"width:100%; overflow:hidden;">';
                      $html.='<tbody>';
                        $html.='<tr class="pro-block">';
                          $html.='<td class="gallery" bgcolor="#fff"; style="width:200px";>';
                            $html.='<div class="gallery-img" style="overflow: hidden; vertical-align: middle;">';
                              $html.= $product_thumbnail;
                            $html.='</div>';
                          $html.='</td>';
                          $html.='<td class="gallery" style="width:200px; height:250px;vertical-align: middle;">';
                            $html.='<ul>';
                              $attachment_ids = $product->get_gallery_attachment_ids();
                              $image_counter=0;
                              $attachment_ids = array_slice($attachment_ids, 0, 1);
                              foreach( $attachment_ids as $attachment_id ) 
                              { 
                                $html.='<div class="gallery-img gallery-thumb" style="text-align:right;">';
                                $img_url = wp_get_attachment_image_src($attachment_id,'full');
                                  
                                  if (!empty($img_url[0])) {
                                    
                                      $html.= '<img src="'.$img_url[0].'">';
                                    }
                                $html.='</div>';
                              } 
                            $html.='</ul>';
                          $html.='</td>';

                          $attachment_ids = $product->get_gallery_attachment_ids();
                          $image_counter=0;
                          $attachment_ids = array_slice($attachment_ids, 1, 1);
                          if ($attachment_ids) {
                            $html.='<td class="gallery" style="width:200px; height:250px;vertical-align: middle;">';
                              $html.='<ul>';
                                foreach( $attachment_ids as $attachment_id ) 
                                { 
                                  $html.='<div class="gallery-img gallery-thumb" style="text-align:right;">';
                                    $img_url = wp_get_attachment_image_src($attachment_id,'full');
                                      
                                      if (!empty($img_url[0])) {
                                        
                                          $html.= '<img src="'.$img_url[0].'">';
                                        }
                                  $html.='</div>';
                                } 
                              $html.='</ul>';
                            $html.='</td>';
                          }
                        $html.='</tr>';
                      $html.='</tbody>';
                    $html.='</table>';
                $html.='</td>';
                $html.='</tr>';

                $html.='<tr bgcolor="#eee">';
                  $html.='<td style="padding:20px 35px 10px">';
                    // $html.='<h3 style="font-size:20px; line-height:22px; font-weight:bold; padding:0; margin:0 0 5px 0">';
                    // $html.= 'Description';
                    // $html.='</h3>';
                    $html.='<p class="description" style="font-size:16px; line-height:20px; padding-bottom:0; margin-botton:0; word-break: break-all; word-wrap: break-word;">';
                      $html.= $product_description;
                    $html.='</p>';
                  $html.='</td>';
                $html.='</tr>';

                $html.='<tr style="padding:10px 40px">';
                  $html.='<td style="position: relative;float: left;width: 100%; box-sizing: border-box;padding:20px 35px;" >';
                    $html.='<h3 style="font-family: arial, sans-serif; font-size:15px; line-height:17px; font-weight:bold; text-transform:uppercase; padding:0; margin:0 0 5px 0">';
                    $html.= __('Specification', 'usb').':';
                    $html.='</h3>';
                    $html.='<div class="specification_data_table" style="font-size:8px; line-height:14px;">';
                    if (!empty($pdf_specification_data)) {
                      $html.= $pdf_specification_data;
                    }
                    $html.='</div>';
                  $html.='</td>';
                $html.='</tr>';

                $html.='<tr bgcolor="#eee" style="background:#e1e1e1; padding:30px 40px">';
                  $html.='<td style="bgcolor="#eee";width: 100%; box-sizing: border-box;padding:20px 40px;" >';
                    $html.='<h3 style="font-size:18px; line-height:20px; font-weight:bold; display:inline-block; background:#6a8fbb; color:#fff; padding:8px 25px; margin:0 0 0 35px">';
                      $html.= __( 'SUMMARY', 'usb' );
                    $html.='</h3>';
                    $html.='<div class="specification_data_lower_table" style="background:#e1e2e3; padding:15px; margin:0 30px 0 35px;">';
                      $html.= $summary;
                    $html.='</div>';
                  $html.='</td>';
                $html.='</tr>';
              $html.='</tbody>';
              $html.='<tfoot style="display:table; width:100%; padding:0; margin:0;line-height:0; background:#eee;">';
                $html.='<tr style="background:#eee;">';
                  $html.='<td style="background:#eee;">';
                    $html.='<h2 style="text-align:center; background:rgba(255,255,255,.7); display:inline-block; color: #000; font-size: 20px; line-height:22px; margin:30px auto; border-radius:27px; position:absolute; left: 0;right: 0;bottom:0;border: 0;margin:0;padding:0;"><img src="https://www.usb.nu/wp-content/uploads/2019/09/usb-bg.jpg"/ style="padding:0;  height;100%;"';
                    $html.=' </h2>'; 
                  $html.='</td>';
                $html.='</tr>';
              $html.='</tfoot>';
            $html.='</table>';
          $html.='</body>';
          $html.='</html>';

          // var_dump($html);
          // die();
          // echo $html; 
          $dompdf = new Dompdf();
          $dompdf->set_option('isRemoteEnabled', TRUE);
          $dompdf->loadHtml($html);

          $dompdf->setPaper('A4', 'portrait');   

          $dompdf->render();
          $output = $dompdf->output();
          //$dompdf->stream();
          $dompdf->stream($product_title.".pdf", array("Attachment" => true));
          $file_name = time()."-offer.pdf";
          // file_put_contents($file_name, $output);
          // mail('anis.elvirainfotech@gmail.com', 'usb pfd', 'I am send a pdf');
        
    exit();
}