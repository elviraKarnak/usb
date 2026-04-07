<?php
    require_once( get_template_directory() . '/inc/theme-functions/dompdf2/vendor/autoload.php' );
use Dompdf\Dompdf;
use Dompdf\Options;
//PDF function for logged in user
  $offer_post_id= $_GET['usbofferpdf'];
  if (isset($offer_post_id)) {  
    $user_ID = get_current_user_id();
    $tlcproductsummary_id = metadata_exists('post', $offer_post_id, '_offer_tlcproductsummary_html_'.$user_ID);
    $tlcproductsummary = '';
    if($tlcproductsummary_id){
      $tlcproductsummary = get_post_meta( $offer_post_id,'_offer_tlcproductsummary_html'.'_'.$user_ID, true);
    }

    // echo $tlcproductsummary; die();

    $mlcproductsummary_id = metadata_exists('post', $offer_post_id, '_offer_mlcproductsummary_html_'.$user_ID);
    $mlcproductsummary = '';
    if($mlcproductsummary_id){
      $mlcproductsummary = get_post_meta( $offer_post_id,'_offer_mlcproductsummary_html'.'_'.$user_ID, true);
    }

    // echo $mlcproductsummary; die();

    $originalproductsummary_id = metadata_exists('post', $offer_post_id, '_offer_originalproductsummary_html_'.$user_ID);
    $originalproductsummary = '';
    if($originalproductsummary_id){
      $originalproductsummary = get_post_meta( $offer_post_id,'_offer_originalproductsummary_html'.'_'.$user_ID, true);
    }
    // echo $originalproductsummary; die();
    // 1 table
    $DOM = new DOMDocument();
    // $DOM->loadHTML($custom_product_data);
    $DOM->loadHTML(mb_convert_encoding($tlcproductsummary, 'HTML-ENTITIES', 'UTF-8'));

    $Detail = $DOM->getElementsByTagName('td');
    $i = 0;
    $j = 0;
    $aDataTableDetailHTML = array();
    foreach($Detail as $sNodeDetail) 
    {
      $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
      
    }
    $i = 0;
    $cnt = 1;
    $trcnt = 2;
    $totalcnt = count($aDataTableDetailHTML);
    // $last1td = $totalcnt-14;
    // $last2td = $totalcnt-7;
    // unset($aDataTableDetailHTML[$last1td],$aDataTableDetailHTML[$last2td]);
    $totalcntN = count($aDataTableDetailHTML);
     $show_tlc_qty = json_decode(get_post_meta($offer_post_id,'_show_tlc_qty',true),true); 
     $count_show_tlc_qty = (8-count($show_tlc_qty));
     $tlc_th = '<tr>';
     $tlc_th .= '<th scope="col">'.__( 'Quantity', 'usb' ).'</th>';
     if (!empty($show_tlc_qty) && !in_array('50', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '50', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('100', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '100', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('250', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '250', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('500', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '500', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('1000', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '1000', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('2500', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '2500', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('5000', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '5000', 'usb' ).'</th>';
     }
     $tlc_th .= '</tr>'; 
                    

    if($aDataTableDetailHTML) {
      $tlcproductsummary = '<table style="width:100%; overflow: hidden; margin-bottobn:50px;">';
      $tlcproductsummary .= $tlc_th;
      
      $tlcproductsummary .= '<tr style="font-size:13px; line-height:18px; background-color:#d3d5d6; color:#545454;">';
      foreach ($aDataTableDetailHTML as $key => $value) {
        if ($trcnt%2 == 0) {
          $style = "font-size:13px; line-height:18px; background-color:#e1e2e3; padding:12px 0; color:#545454;";
        } else {
          $style = "font-size:13px; line-height:18px; background-color:#d3d5d6; padding:12px 0; color:#545454;";
        }


        $tlcproductsummary .= '<td>'.$value.'</td>';
        if ($cnt%$count_show_tlc_qty == 0 && $cnt < count($aDataTableDetailHTML)) {
          $tlcproductsummary .= '</tr><tr style="'.$style.'">';
          $trcnt++;
        }
        $cnt++;
      }
      $tlcproductsummary .= '</tr></table>';
    }


    ////////////////////////////
    // 2 table
    $DOM = new DOMDocument();
    // $DOM->loadHTML($custom_product_data);
    $DOM->loadHTML(mb_convert_encoding($mlcproductsummary, 'HTML-ENTITIES', 'UTF-8'));

    $Detail = $DOM->getElementsByTagName('td');
    $i = 0;
    $j = 0;
    $aDataTableDetailHTML = array();
    foreach($Detail as $sNodeDetail) 
    {
      $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
      
    }
    $i = 0;
    $cnt = 1;
    $trcnt = 2;
    $totalcnt = count($aDataTableDetailHTML);
    // $last1td = $totalcnt-14;
    // $last2td = $totalcnt-7;
    // unset($aDataTableDetailHTML[$last1td],$aDataTableDetailHTML[$last2td]);
    $totalcntN = count($aDataTableDetailHTML);
     $show_tlc_qty = json_decode(get_post_meta($offer_post_id,'_show_mlc_qty',true),true); 
     $count_show_tlc_qty = (8-count($show_tlc_qty));
     $tlc_th = '<tr>';
     $tlc_th .= '<th scope="col">'.__( 'Quantity', 'usb' ).'</th>';
     if (!empty($show_tlc_qty) && !in_array('50', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '50', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('100', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '100', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('250', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '250', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('500', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '500', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('1000', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '1000', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('2500', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '2500', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('5000', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '5000', 'usb' ).'</th>';
     }
     $tlc_th .= '</tr>'; 
                    

    if($aDataTableDetailHTML) {
      $mlcproductsummary = '<table style="width:100%; overflow: hidden;">';
      $mlcproductsummary .= $tlc_th;
      
      $mlcproductsummary .= '<tr style="font-size:13px; line-height:18px; background-color:#d3d5d6; color:#545454;">';
      foreach ($aDataTableDetailHTML as $key => $value) {
        if ($trcnt%2 == 0) {
          $style = "font-size:13px; line-height:18px; background-color:#e1e2e3; padding:12px 0; color:#545454;";
        } else {
          $style = "font-size:13px; line-height:18px; background-color:#d3d5d6; padding:12px 0; color:#545454;";
        }


        $mlcproductsummary .= '<td>'.$value.'</td>';
        if ($cnt%$count_show_tlc_qty == 0 && $cnt < count($aDataTableDetailHTML)) {
          $mlcproductsummary .= '</tr><tr style="'.$style.'">';
          $trcnt++;
        }
        $cnt++;
      }
      $mlcproductsummary .= '</tr></table>';
    }

    // echo $mlcproductsummary;

    ////////////////////////////
    // 3 table
    $DOM = new DOMDocument();
    // $DOM->loadHTML($custom_product_data);
    $DOM->loadHTML(mb_convert_encoding($originalproductsummary, 'HTML-ENTITIES', 'UTF-8'));

    $Detail = $DOM->getElementsByTagName('td');
    $i = 0;
    $j = 0;
    $aDataTableDetailHTML = array();
    foreach($Detail as $sNodeDetail) 
    {
      $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
      
    }
    $i = 0;
    $cnt = 1;
    $trcnt = 2;
    $totalcnt = count($aDataTableDetailHTML);
    // $last1td = $totalcnt-14;
    // $last2td = $totalcnt-7;
    // unset($aDataTableDetailHTML[$last1td],$aDataTableDetailHTML[$last2td]);
    $totalcntN = count($aDataTableDetailHTML);
     $show_tlc_qty = json_decode(get_post_meta($offer_post_id,'_show_original_qty',true),true); 
     $count_show_tlc_qty = (8-count($show_tlc_qty));
     $tlc_th = '<tr>';
     $tlc_th .= '<th scope="col">'.__( 'Quantity', 'usb' ).'</th>';
     if (!empty($show_tlc_qty) && !in_array('50', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '50', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('100', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '100', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('250', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '250', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('500', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '500', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('1000', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '1000', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('2500', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '2500', 'usb' ).'</th>';
     }
     if (!empty($show_tlc_qty) && !in_array('5000', $show_tlc_qty)) {
      $tlc_th .= '<th scope="col">'.__( '5000', 'usb' ).'</th>';
     }
     $tlc_th .= '</tr>'; 
                    

    if($aDataTableDetailHTML) {
      $originalproductsummary = '<table style="width:100%; overflow: hidden;">';
      $originalproductsummary .= $tlc_th;
      
      $originalproductsummary .= '<tr style="font-size:13px; line-height:18px; background-color:#d3d5d6; color:#545454;">';
      foreach ($aDataTableDetailHTML as $key => $value) {
        if ($trcnt%2 == 0) {
          $style = "font-size:13px; line-height:18px; background-color:#e1e2e3; padding:12px 0; color:#545454;";
        } else {
          $style = "font-size:13px; line-height:18px; background-color:#d3d5d6; padding:12px 0; color:#545454;";
        }


        $originalproductsummary .= '<td>'.$value.'</td>';
        if ($cnt%$count_show_tlc_qty == 0 && $cnt < count($aDataTableDetailHTML)) {
          $originalproductsummary .= '</tr><tr style="'.$style.'">';
          $trcnt++;
        }
        $cnt++;
      }
      $originalproductsummary .= '</tr></table>';
    }

    // echo $originalproductsummary;
    // die();

  
   $product_title= get_the_title($offer_post_id);
   $product_description = get_the_excerpt($offer_post_id);
   $product_thumbnail= get_the_post_thumbnail( $offer_post_id, 'thumbnail', array( 'class' => 'alignleft' ) );
   $product = new WC_product($offer_post_id);
   $custom_product_data = get_post_meta( $offer_post_id,'productdata_content', true);
   $DOM = new DOMDocument();
    // $DOM->loadHTML($custom_product_data);
    $DOM->loadHTML(mb_convert_encoding($custom_product_data, 'HTML-ENTITIES', 'UTF-8'));

    $Detail = $DOM->getElementsByTagName('td');
    $i = 0;
    $j = 0;
    $aDataTableDetailHTML = array();
    foreach($Detail as $sNodeDetail) 
    {
      $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
      
    }
    
    $cnt = 1;
    if($aDataTableDetailHTML) {
      $custom_product_data = '<table style="width:100%;"><tr>';
      foreach ($aDataTableDetailHTML as $key => $value) {
        $custom_product_data .= '<td style="padding:5px 20px 5px 0; font-size:14px;">'.$value.'</td>';
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
    $html.='<head>';
    $html.='<style type="text/css">';
    $html.='*{padding:0; margin:0;} body{font-family: arial, sans-serif; padding:0; margin:0;} table{ text-align:left; border-spacing:0;} .img-tb{ background:#fff;  width:100%; } .gallery-img img{width:100%; height:auto; } .gallery-img.gallery-thumb img{ width:100%; height:auto; } .pdf_product_title{background:#5ba8dc;} .specification_data_table > table.summary{ width:100%; background:#e1e1e1; padding:20px 20px 20px 20px; margin:0 30px;} .specification_data_table > table > td{ font-size:10px; padding:0px 5px;} 
.specification_data_table > table > tbody > tr > td{ padding:5px 8px 5px 0; white-space: nowrap; } .specification_data_table > table > tbody > tr > td:nth-child(2){padding-right:50px;}';    
    $html.='</style>';
    $html.='</head>';
    $html.='<body style="background-color: #eee; padding:0; margin:0; position:relative;">';
    $html.='<table class="pdf-tbl" background:#fff; border-spacing:0; padding:0; margin:0;">';
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
    $thml.='</table>';
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
  $html.='<td style="padding:20px 10px 10px">';
  // $html.='<h3 style="font-size:20px; line-height:22px; font-weight:bold; padding:0; margin:0 0 5px 0">';
  // $html.= 'Description';
  // $html.='</h3>';
  $html.='<p class="description" style="font-size:16px; line-height:20px; width: 95%; padding-right:20px; padding-bottom:0; margin-botton:0; padding-left:25px;">';
  $html.= $product_description;
  $html.='</p>';
  $html.='</td>';
  $html.='</tr>';
  $html.='<tr style="padding:10px 20px">';
  $html.='<td style="position: relative;float: left;width: 100%; box-sizing: border-box;padding:20px 40px;" >';
  $html.='<h3 style="font-family: arial, sans-serif; font-size:15px; line-height:17px; font-weight:bold; text-transform:uppercase; padding:0; margin:0 0 0 0">';
  $html.= __( 'Specification', 'usb' );
  $html.='</h3>';
  $html.='<div class="specification_data_table" style="font-size:8px; line-height:14px;">';
  $html.= $custom_product_data;
  $html.='</div>';
  $html.='</td>';
  $html.='</tr>';
  $html.='<tr bgcolor="#eee" style="background:#e1e1e1; padding:30px 40px; margin:0 0 35px 0;">';
  $html.='<td style="bgcolor="#eee";width: 100%; box-sizing: border-box;padding:20px 40px;" >';
  $html.='<h3 style="font-size:18px; line-height:20px; font-weight:bold; display:inline-block; background:#6a8fbb; color:#fff; padding:8px 25px; margin:15px 0 0 35px">';
  $html.= 'Summary';
  $html.='</h3>';
  $html.='<div class="specification_data_table" style=" background:#e1e2e3; padding:15px; margin:0px 35px 10px;">';
  $html.= 'OEM TLC';
  $html.= $tlcproductsummary;
  $html.='</div>';
  $html.='</td>';
  $html.='</tr>';
  $html.='<tr bgcolor="#eee" >';
  $html.='<td style="height:50px;">';
  $html.='</td>';
  $html.='</tr>';



  $html.='<tr bgcolor="#eee" style="background:#e1e1e1; padding:80px 40px;">';
  $html.='<td style="bgcolor="#eee";width: 100%; box-sizing: border-box;padding:20px 40px;" >';
  $html.='<div class="specification_data_table" style="background:#e1e2e3; padding:15px; margin:30px 35px; 30px">';
  $html.= 'OEM MLC';
  $html.= $mlcproductsummary;
  $html.='</div>';
  $html.='</td>';
  $html.='</tr>';

  $html.='<tr bgcolor="#eee" style="background:#e1e1e1; padding:30px 40px">';
  $html.='<td style="bgcolor="#eee";width: 100%; box-sizing: border-box;padding:20px 40px;" >';
  $html.='<div class="specification_data_table" style="background:#e1e2e3; padding:15px; margin:0 35px;">';
  $html.= 'Original';
  $html.= $originalproductsummary;
  $html.='</div>';
  $html.='</td>';
  $html.='</tr>';


  $html.='</tbody>';
  $html.='<tfoot style="display:table; width:100%; padding:0; margin:0;line-height:0; background:#eee;">';
  $html.='<tr style="background:#eee;">';
  $html.='<td style="background:#eee;">';
  $html.='<h2 style="text-align:center; background:rgba(255,255,255,.7); display:inline-block; color: #000; font-size: 20px; line-height:22px; margin:30px auto; border-radius:27px; position:absolute;
    left: 0;right: 0;bottom:0;border: 0;margin:0;padding:0;"><img src="https://www.usb.nu/wp-content/uploads/2019/09/usb-bg.jpg"/ style="padding:0;  height;100%;"';
  $html.=' </h2>'; 
  $html.='</td>';
  $html.='</tr>';
  $html.='</tfoot>';
  $html.='</table>';
  $html.='</body>';
  $html.='</html>';

  // echo $html;
  // die();
  //echo $html; 
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