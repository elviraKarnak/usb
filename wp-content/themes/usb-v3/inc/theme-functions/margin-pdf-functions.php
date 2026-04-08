 <?php
require_once( get_template_directory() . '/inc/theme-functions/dompdf2/vendor/autoload.php' );
use Dompdf\Dompdf;
use Dompdf\Options;

  $offer_post_id= $_GET['marginpdf'];
  if (isset($offer_post_id)) {  
  $current_lang = $sitepress->get_current_language(); 
  $user_ID = get_current_user_id();
  // $product_sku= get_post_meta($offer_post_id,'_sku',true);
  $userid = metadata_exists('post', $offer_post_id, '_offer_summary_html_'.$user_ID);
  $summary = '';
  if($userid){
    $summary = get_post_meta( $offer_post_id,'_offer_summary_html'.'_'.$user_ID, true);
    
  }
  //$summary_html_user_id = substr($userid, strrpos($userid, '_' )+1);


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
    /*echo '<pre>';
    print_r($aDataTableDetailHTMLNew);
    die();*/
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
      <th style="width:65px; padding:5px;">Art&nbsp;no</th><th>'.__( 'Product', 'usb' ).'</th><th>'.__( 'Options', 'usb' ).'</th><th>'.__( 'Qty', 'usb' ).'</th></tr>
      <tr style="font-size:12px; line-height:18px; background-color:#d3d5d6; color:#545454;">';
      
      $as = 1;
      foreach ($aDataTableDetailHTMLNew as $key => $value) {
        if ($trcnt%2 == 0) {
          $style = "font-size:12px; line-height:18px; background-color:#e1e2e3; padding:12px 0; color:#545454;";
        } else {
          $style = "font-size:12px; line-height:18px; background-color:#d3d5d6; padding:12px 0; color:#545454;";
        }
        if ($trcnt == $last1tr || $trcnt == $last2tr) {
          $style = "font-size:12px; line-height:18px; background-color:#6a8fbb; color:#fff; padding:12px 0; display:none; ";
        }
        if ($trcnt == $last1tr) {
          $style = "font-size:12px; line-height:18px; background-color:#6a8fbb; color:#fff; padding:12px 0;  ";
        }
        
        
        $value = str_replace("Price/pcs", "Price/pcs ", $value);
        $value = str_replace("Total order", "Total order ", $value);
        $value = str_replace("Pris/st", "Pris/st ", $value);
        $value = str_replace("Pris totalt", "Pris totalt ", $value);
        $value = str_replace("Antal", "Antal ", $value);
        $value = str_replace("Qty", "Qty ", $value);
        if($as < 5 && $trcnt != (intval($last1tr)+1)) {
          $summary .= '<td>'.__($value,'usb').'</td>';
        } 
        if ($trcnt == (intval($last1tr)+1)) {
          if (!empty($value)) {
            if ($value == 'Marginal') {
              $value = '';
            }
            $summary .= '<td>'.__($value,'usb').'</td>';
          }
          
        }


        if ($cnt%6 == 0 && $cnt < count($aDataTableDetailHTMLNew)) {
          $summary .= '</tr><tr style="'.$style.'">';
          $trcnt++;
          $as = 0;
        }
        $cnt++;
        $as++;
      }
      $summary .= '</tr></table>';
    }


   $product_title= get_the_title($offer_post_id);
   $product_description = get_the_excerpt($offer_post_id);
   $product_thumbnail= get_the_post_thumbnail( $offer_post_id, 'full', array( 'class' => 'alignleft' ) );
   $product = new WC_product($offer_post_id);
   $custom_product_data = get_post_meta( $offer_post_id,'productdata_content', true) ? get_post_meta( $offer_post_id,'productdata_content', true) : '';
   
   if(!empty($custom_product_data)) {
      $DOM = new DOMDocument();
        // $DOM->loadHTML($custom_product_data);
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
   
   $sku= $product->get_sku();
    $html = '';
    $html.='<!DOCTYPE html>';
    $html.='<html>';
    $html.='<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
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
    $html.='<h1 class="prod_title" style="color:#fff; height:60px; padding:20px 10px 0 50px;">';
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
  if (!empty($custom_product_data)) {
    $html.= $custom_product_data;
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
  $dompdf->stream($product_title.".2pdf", array("Attachment" => true));
  $file_name = time()."-margin.pdf";
  // file_put_contents($file_name, $output);
  // mail('anis.elvirainfotech@gmail.com', 'usb pfd', 'I am send a pdf');
  
exit();
}