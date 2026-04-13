<?php
    require_once( get_template_directory() . '/inc/theme-functions/dompdf2/vendor/autoload.php' );
use Dompdf\Dompdf;
use Dompdf\Options;

    
   $post_id= $_GET['pdf'];
   if (isset($post_id)) {  
   $current_lang = $sitepress->get_current_language();
  
 
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
   }else{
    
   }

$offer_post_id = $_GET['offerpdf'];

if (!empty($offer_post_id)) {

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $user_ID = get_current_user_id();

    // Get summary
    $summary = '';
    if (metadata_exists('post', $offer_post_id, '_offer_summary_html_'.$user_ID)) {
        $summary = get_post_meta($offer_post_id, '_offer_summary_html_'.$user_ID, true);
    }

    $aDataTableDetailHTMLNew = [];

    // =========================
    // PROCESS SUMMARY TABLE
    // =========================
    if (!empty($summary)) {

        $DOM = new DOMDocument();

        libxml_use_internal_errors(true); // prevent warnings
        $DOM->loadHTML(mb_convert_encoding($summary, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $Detail = $DOM->getElementsByTagName('td');

        foreach ($Detail as $node) {
            $aDataTableDetailHTMLNew[] = trim($node->textContent);
        }

        if (!empty($aDataTableDetailHTMLNew)) {

            $totalcnt = count($aDataTableDetailHTMLNew);

            // safe unset
            if ($totalcnt > 14) unset($aDataTableDetailHTMLNew[$totalcnt - 14]);
            if ($totalcnt > 7) unset($aDataTableDetailHTMLNew[$totalcnt - 7]);

            $totalcntN = count($aDataTableDetailHTMLNew);
            $last1tr = ($totalcntN / 6);
            $last2tr = $last1tr - 1;

            $cnt = 1;
            $trcnt = 2;

            $summary = '
            <style>
                th { color:#3f3f3f; font-size:14px; padding:10px 8px; }
                .lower-data-table td { padding:8px; white-space: nowrap; }
            </style>

            <table class="lower-data-table" style="width:695px;">
            <tr>
                <th>Art no</th>
                <th>'.__('Product','usb').'</th>
                <th>'.__('Options','usb').'</th>
                <th>'.__('Qty','usb').'</th>
                <th>'.__('Price/pcs','usb').'</th>
                <th>'.__('Total cost','usb').'</th>
            </tr>
            <tr style="background:#d3d5d6;">';

            foreach ($aDataTableDetailHTMLNew as $value) {

                $style = ($trcnt % 2 == 0)
                    ? "background:#e1e2e3;"
                    : "background:#d3d5d6;";

                if ($trcnt == $last1tr || $trcnt == $last2tr) {
                    $style = "background:#6a8fbb;color:#fff;";
                }

                $summary .= '<td>'.$value.'</td>';

                if ($cnt % 6 == 0 && $cnt < count($aDataTableDetailHTMLNew)) {
                    $summary .= '</tr><tr style="'.$style.'">';
                    $trcnt++;
                }

                $cnt++;
            }

            $summary .= '</tr></table>';
        }
    }

    // =========================
    // PRODUCT DATA
    // =========================
    $product = wc_get_product($offer_post_id);

    if (!$product) {
        wp_die('Invalid product');
    }

    $product_title = get_the_title($offer_post_id);
    $product_description = get_the_excerpt($offer_post_id);
    $product_thumbnail = get_the_post_thumbnail($offer_post_id, 'full');

    // =========================
    // SPEC TABLE
    // =========================
    $aDataTableDetailHTML = [];
    $custom_product_data = get_post_meta($offer_post_id, 'productdata_content', true);

    if (!empty($custom_product_data)) {

        $DOM = new DOMDocument();
        libxml_use_internal_errors(true);
        $DOM->loadHTML(mb_convert_encoding($custom_product_data, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        foreach ($DOM->getElementsByTagName('td') as $node) {
            $aDataTableDetailHTML[] = trim($node->textContent);
        }

        if (!empty($aDataTableDetailHTML)) {

            $custom_product_data = '<table style="width:60%"><tr>';
            $cnt = 1;

            foreach ($aDataTableDetailHTML as $value) {
                $custom_product_data .= '<td>'.$value.'</td>';

                if ($cnt % 4 == 0) {
                    $custom_product_data .= '</tr><tr>';
                }
                $cnt++;
            }

            $custom_product_data .= '</tr></table>';
        }
    }

    // =========================
    // HTML OUTPUT
    // =========================
    $html = '
    <!DOCTYPE html>
    <html>
    <head>
    <style>
        body { font-family: Arial; }
        table { border-spacing:0; }
        .pdf_product_title { background:#5ba8dc; color:#fff; padding:20px; }
    </style>
    </head>

    <body>

    <h1 class="pdf_product_title">'.$product_title.'</h1>

    '.$product_thumbnail.'

    <p>'.$product_description.'</p>

    <h3>Specification</h3>
    '.$custom_product_data.'

    <h3>Summary</h3>
    '.$summary.'

    </body>
    </html>';

    // =========================
    // DOMPDF
    // =========================
    $dompdf = new Dompdf();
    $dompdf->set_option('isRemoteEnabled', true);

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    ob_end_clean();
    $dompdf->stream($product_title.".pdf", ["Attachment" => true]);

    exit;
}