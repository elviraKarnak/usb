<?php
// create custom plugin settings menu
add_action('admin_menu', 'usb_export_create_menu');

function usb_export_create_menu() {
  //create new top-level menu
  // add_menu_page('USB Export', 'Export Settings', 'administrator', __FILE__, 'usb_export_settings_page'  );
  add_menu_page('USBExport', 'USBExport', 'manage_options', 'usbexport','usb_export_settings_page','dashicons-admin-post');
  add_submenu_page( 'usbexport', 'USBExport', 'USBExport', 'manage_options', 'usbexport');
  add_action( 'admin_menu', 'register_sub_menu' );
  add_submenu_page('usbexport', 'FTP Settings', 'FTP Settings', 'manage_options', 'usbexportftp', 'usbexportftp_page_callback' );

  add_action( 'admin_init', 'register_usbexportftp_settings' );
}

function usb_export_settings_page() {


  if(isset($_POST['submit'])){
    $leanguage_name=$_POST['leanguage_name'];
    $csv_type_name=$_POST['csv_type_name'];
    if($leanguage_name=='sv'){
      $cat=$_POST['csv_type_catsv'];
    } else{
      $cat=$_POST['csv_type_caten'];
    }


    if($csv_type_name=='attributes' && $cat==''){
      global $sitepress;
      $current_lang = $sitepress->get_current_language();
      if($leanguage_name!=$current_lang){
        $sitepress->switch_lang($leanguage_name);
      }

      function outputCsv($fileName, $assocDataArray)  {
        ob_clean();
        $keys = array_keys($assocDataArray, max($assocDataArray));
        $longestKey = array_reduce($keys, function ($a, $b) { return strlen($a) > strlen($b) ? $a : $b; });
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);    
        if(isset($assocDataArray['0'])){
          $fp = fopen(dirname(__FILE__).'/export/'.$fileName, 'w');
          fputcsv($fp, array_keys($assocDataArray[$longestKey]));
          foreach($assocDataArray AS $values){
            fputcsv($fp, $values);
          }
          fclose($fp);
        }
        ob_flush();
      }

      $array = wc_get_attribute_taxonomies();
      $row = array(); $rows = array(); $usb_ocm_tlc = array(); $usb_oem_mlc = array(); $usb_original = array();
      foreach ($array as $keys ) {
        $keys->attribute_name;
        $terms = get_terms( array( 'taxonomy' => 'pa_'.$keys->attribute_name, 'hide_empty' => false, ) );
        $n=0;
        foreach($terms as $item){                 
          $qt50 = get_term_meta($item->term_id, '_price50', true);
          $qt100 = get_term_meta($item->term_id, '_price100', true);
          $qt250 = get_term_meta($item->term_id, '_price250', true);
          $qt500 = get_term_meta($item->term_id, '_price500', true);
          $qt1000 = get_term_meta($item->term_id, '_price1000', true);
          $qt2500=get_term_meta($item->term_id, '_price2500', true);
          $qt5000=get_term_meta($item->term_id, '_price5000', true);
          $row["id"] = $n;
          $row["Attributes"] = $keys->attribute_name;
          $row["Name"] = $item->name;
          $row["Slug"] = $item->slug;
          $row["Quantity-50"] = $qt50;
          $row["Quantity-100"] = $qt100;
          $row["Quantity-250"] = $qt250;
          $row["Quantity-500"] = $qt500;
          $row["Quantity-1000"] = $qt1000;
          $row["Quantity-2500"] = $qt2500;
          $row["Quantity5000"] = $qt5000;
          $usb_ocm_tlc = json_decode(get_term_meta($item->term_id,'_usb_ocm_tlc',true),true);
          if ($usb_ocm_tlc) {
            foreach($usb_ocm_tlc as $key=>$val) {
              $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
              $name = $term->name;
              $keyname50 = 'ocm-tlc-'.$name.'-50';
              $keyname100 = 'ocm-tlc-'.$name.'-100';
              $keyname250 = 'ocm-tlc-'.$name.'-250';
              $keyname500 = 'ocm-tlc-'.$name.'-500';
              $keyname1000 = 'ocm-tlc-'.$name.'-1000';
              $keyname2500 = 'ocm-tlc-'.$name.'-2500';
              $keyname5000 = 'ocm-tlc-'.$name.'-5000';
              $row[$keyname50] = $val[1];
              $row[$keyname100] = $val[2];
              $row[$keyname250] = $val[3];
              $row[$keyname500] = $val[4];
              $row[$keyname1000] = $val[5];
              $row[$keyname2500] = $val[6];
              $row[$keyname5000] = $val[7];
            }
          }
          $usb_oem_mlc = json_decode(get_term_meta($item->term_id,'_usb_oem_mlc',true),true);
          if($usb_oem_mlc){
            foreach($usb_oem_mlc as $key=>$val) {
              $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
              $name = $term->name;
              $keyname50 = 'ocm-mlc-'.$name.'-50';
              $keyname100 = 'ocm-mlc-'.$name.'-100';
              $keyname250 = 'ocm-mlc-'.$name.'-250';
              $keyname500 = 'ocm-mlc-'.$name.'-500';
              $keyname1000 = 'ocm-mlc-'.$name.'-1000';
              $keyname2500 = 'ocm-mlc-'.$name.'-2500';
              $keyname5000 = 'ocm-mlc-'.$name.'-5000';
              $row[$keyname50] = $val[1];
              $row[$keyname100] = $val[2];
              $row[$keyname250] = $val[3];
              $row[$keyname500] = $val[4];
              $row[$keyname1000] = $val[5];
              $row[$keyname2500] = $val[6];
              $row[$keyname5000] = $val[7];
            }
          }
          $usb_original = json_decode(get_term_meta($item->term_id,'_usb_original_data',true),true); 
          if($usb_original){
            foreach($usb_oem_mlc as $key=>$val) {
              $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
              $name = $term->name;
              $keyname50 = 'original-'.$name.'-50';
              $keyname100 = 'original-'.$name.'-100';
              $keyname250 = 'original-'.$name.'-250';
              $keyname500 = 'original-'.$name.'-500';
              $keyname1000 = 'original-'.$name.'-1000';
              $keyname2500 = 'original-'.$name.'-2500';
              $keyname5000 = 'original-'.$name.'-5000';
              $row[$keyname50] = $val[1];
              $row[$keyname100] = $val[2];
              $row[$keyname250] = $val[3];
              $row[$keyname500] = $val[4];
              $row[$keyname1000] = $val[5];
              $row[$keyname2500] = $val[6];
              $row[$keyname5000] = $val[7];
            }
          }
          $rows[]=$row;
          $n++;
        }

      }
      outputCsv('attribute.csv', $rows);
      update_option('attribute-log',time());
      do_this_daily();
      $sitepress->switch_lang( $current_lang );
      exit;
    }


    if($csv_type_name == 'standard' || $csv_type_name == 'usb'){

        global $sitepress;
        $current_lang = $sitepress->get_current_language();
        if($leanguage_name!=$current_lang){
          $sitepress->switch_lang($leanguage_name);
        }
        $product_cat = array();
        $tax_query = array(array( 'taxonomy' => 'product_type', 'field'    => 'slug', 'terms'    => $csv_type_name, ),);

        if (!empty($cat)) {
          $product_cat['taxonomy'] = 'product_cat';
          $product_cat['field'] = 'slug';
          $product_cat['terms'] = $cat;
          $tax_query[] = $product_cat;
        }

        $postsmsg_en = '';
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'suppress_filters' => false,
          'tax_query' => $tax_query
        );
        $get_products = get_posts( $args );



        $n = 0; $rows = array(); $row = array(); $rowkey = array(); $odd = array(); $even = array();
        $both = array(&$even, &$odd);
        foreach( $get_products as $post ) :  setup_postdata($post);
          global $product,$woocommerce; 
          $product = wc_get_product($post->ID);

          $terms = get_the_terms ($post->ID, 'product_cat' );
          $cat = array();
          foreach ( $terms as $term ) {
            $cat[]=$term->name;
          }

          $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

          $product = new WC_product($post->ID);
          $attachment_ids = $product->get_gallery_attachment_ids();
          $gallery=array(); 
          foreach( $attachment_ids as $attachment_id ) {
            // Display the image URL
            $gallery[] = wp_get_attachment_url( $attachment_id );
          }
        

          $row[$n]['Id'] = $n;
          $row[$n]["Name"] = $post->post_title;
          $row[$n]["SKU"] = get_post_meta($post->ID,'_sku',true);
          $row[$n]["content"] = $post->post_content;
          $row[$n]["Short Description"] = $post->post_excerpt;
          $row[$n]["sku"] = $product->get_sku();
          $row[$n]["category"] = implode(",",$cat);
          $row[$n]["Gallery Image"] = implode(",",$gallery);
          $row[$n]["Product Image"] = $image_url[0];
          $row[$n]["Download"] = get_post_meta($post->ID,'download',true);
          $row[$n]["Image"] = strip_tags(get_post_meta($post->ID,'image',true));


          if ($product->get_attributes()) {
            foreach($product->get_attributes() as $att){

              $attname=explode('pa_',$att['name']);
              $get_attr_terms = wc_get_product_terms($post->ID,  $att['name'], array( 'fields' => 'names' ));
              
              $get_attr_slug = wc_get_product_terms($post->ID,  $att['name'], array( 'fields' => 'slugs' ));
              
              if ($get_attr_terms) {
                $get_join_attr_terms = join(",",$get_attr_terms);
              }
              //$row[$n][$attname[1].'-name']=$get_join_attr_terms ;
              if ($get_attr_slug) {
                $get_join_attr_terms_slug = join(",",$get_attr_slug);
              }
              $row[$n][$attname[1]]=$get_join_attr_terms_slug ;
            }
            $custom_product_data = get_post_meta($post->ID,'productdata_content', true);
            $DOM = new DOMDocument();
            // $DOM->loadHTML($custom_product_data);
            @$DOM->loadHTML(mb_convert_encoding($custom_product_data, 'HTML-ENTITIES', 'UTF-8'));

            $Detail = $DOM->getElementsByTagName('td');
            $i = 0;
            $j = 0;
            $aDataTableDetailHTML = array();
            foreach($Detail as $sNodeDetail) 
            {
             $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
              
            }
  
          }
            $odd = array();
            $even = array();
            $c = array();
            foreach ($aDataTableDetailHTML as $k => $v) {
                if ($k % 2 == 0) {
                    $even[] = $v;
                }
                else {
                    $odd[] = $v;
                }
            }
            $c = array_combine($even, $odd);
            
            if($c){
              foreach($c as $key => $value) {
                $key = sanitize_title($key);
                $row[$n][$key] = $value;
              }
            }
          


          if ($csv_type_name == 'standard') {
            $row[$n]['price option 50'] = get_post_meta($post->ID, '_price_option_50',   true );
            $row[$n]['price option 100'] = get_post_meta($post->ID, '_price_option_100',  true );
            $row[$n]['price option 250'] = get_post_meta($post->ID, '_price_option_250',  true );
            $row[$n]['price option 500'] = get_post_meta($post->ID, '_price_option_500',  true );
            $row[$n]['price option 1000'] = get_post_meta($post->ID, '_price_option_1000', true );
            $row[$n]['price option 2500'] = get_post_meta($post->ID, '_price_option_2500', true );
            $row[$n]['price option 5000'] = get_post_meta($post->ID, '_price_option_5000', true );
          } else {
            $usb_ocm_tlc = json_decode(get_post_meta($post->ID,'_usb_ocm_tlc',true));
            if($usb_ocm_tlc){                                       
              foreach($usb_ocm_tlc as $key=>$val) {
                $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
                $name = $term->name;
                $keyname50 = 'oem-tlc-'.$name.'-50';
                $keyname100 = 'oem-tlc-'.$name.'-100';
                $keyname250 = 'oem-tlc-'.$name.'-250';
                $keyname500 = 'oem-tlc-'.$name.'-500';
                $keyname1000 = 'oem-tlc-'.$name.'-1000';
                $keyname2500 = 'oem-tlc-'.$name.'-2500';
                $keyname5000 = 'oem-tlc-'.$name.'-5000';
                $row[$n][$keyname50] = $val[1];
                $row[$n][$keyname100] = $val[2];
                $row[$n][$keyname250] = $val[3];
                $row[$n][$keyname500] = $val[4];
                $row[$n][$keyname1000] = $val[5];
                $row[$n][$keyname2500] = $val[6];
                $row[$n][$keyname5000] = $val[7];
              }
            }

            $usb_oem_mlc = json_decode(get_post_meta($post->ID,'_usb_oem_mlc',true));
            if($usb_oem_mlc){
              foreach($usb_oem_mlc as $key=>$val) {
                $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
                $name = $term->name;
                $keyname50 = 'oem_mlc-'.$name.'-50';
                $keyname100 = 'oem_mlc-'.$name.'-100';
                $keyname250 = 'oem_mlc-'.$name.'-250';
                $keyname500 = 'oem_mlc-'.$name.'-500';
                $keyname1000 = 'oem_mlc-'.$name.'-1000';
                $keyname2500 = 'oem_mlc-'.$name.'-2500';
                $keyname5000 = 'oem_mlc-'.$name.'-5000';
                $row[$n][$keyname50] = $val[1];
                $row[$n][$keyname100] = $val[2];
                $row[$n][$keyname250] = $val[3];
                $row[$n][$keyname500] = $val[4];
                $row[$n][$keyname1000] = $val[5];
                $row[$n][$keyname2500] = $val[6];
                $row[$n][$keyname5000] = $val[7];
              }
            }

            $usb_original = json_decode(get_post_meta($post->ID,'_usb_original',true));
            if($usb_original){
              foreach($usb_original as $key=>$val) {
                $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
                $name = $term->name;
                $keyname50 = 'original-'.$name.'-50';
                $keyname100 = 'original-'.$name.'-100';
                $keyname250 = 'original-'.$name.'-250';
                $keyname500 = 'original-'.$name.'-500';
                $keyname1000 = 'original-'.$name.'-1000';
                $keyname2500 = 'original-'.$name.'-2500';
                $keyname5000 = 'original-'.$name.'-5000';
                $row[$n][$keyname50] = $val[1];
                $row[$n][$keyname100] = $val[2];
                $row[$n][$keyname250] = $val[3];
                $row[$n][$keyname500] = $val[4];
                $row[$n][$keyname1000] = $val[5];
                $row[$n][$keyname2500] = $val[6];
                $row[$n][$keyname5000] = $val[7];
              }
            }
          }

              
            $n++; 
        endforeach;
        // echo '<pre>';print_r($row);echo '</pre>';
        // die();
        
        function productOutputCsv($fileName, $assocDataArray)  {
          ob_clean();
          $result = array_reduce($assocDataArray, 'array_merge', array());
          if ($result) {
            foreach ($result as $key => $value) {
              $blankArr[$key] = '-';
            }
          }
          header('Pragma: public');
          header('Expires: 0');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          header('Cache-Control: private', false);
          header('Content-Type: text/csv');
          header('Content-Disposition: attachment;filename=' . $fileName);    
          if(isset($assocDataArray['0'])){
            $fp = fopen(dirname(__FILE__).'/export/'.$fileName, 'w');
            fputcsv($fp, array_keys($result));
            foreach($assocDataArray as $values){
              $values = array_merge($blankArr, $values);
              fputcsv($fp, $values);
            }
            fclose($fp);
          }
          ob_flush();
        }
        productOutputCsv($csv_type_name.'-product.csv', $row);
        update_option($csv_type_name.'-product-log',time());
        do_this_daily();



        $sitepress->switch_lang( $current_lang );
        exit;
    }
  }

      

  ?>
  <div class="wrap">
  <h1><?php _e( 'Export Setting', 'usb' );?></h1>
  <?php 
  $attribute_log = get_option('attribute-log');
  $usb_product_log = get_option('usb-product-log');
  $standard_product_log = get_option('standard-product-log');
  echo '<h4>';
  if (!empty($attribute_log)) {
    ?>
    <?php _e( 'Attribute Log Time: '.date('l, F j, Y h:i:s',$attribute_log), 'usb' );?>
    <?php
  }
  if (!empty($usb_product_log)) {
    ?>
    <?php _e( 'USB Product Log Time: '.date('l, F j, Y h:i:s',$usb_product_log), 'usb' );?>
    <?php
  }
  if (!empty($standard_product_log)) {
    ?>
    <?php _e( 'Standrad Product Log Time: '.date('l, F j, Y h:i:s',$standard_product_log), 'usb' );?>
    <?php
  }
  echo '</h4>';
  $filename1 = get_template_directory_uri().'/inc/theme-functions/export/usb-product.csv';
  $filename2 = get_template_directory_uri().'/inc/theme-functions/export/standard-product.csv';
  $filename3 = get_template_directory_uri().'/inc/theme-functions/export/attribute.csv';
  ?>
  <a download class="button" href="<?php echo $filename1;?>">usb-product</a>
  <a download class="button" href="<?php echo $filename2;?>">standard-product</a>
  <a download class="button" href="<?php echo $filename3;?>">attribute</a>
  
  
  
  <form method="post" action="" enctype="multipart/form-data">   
      <table class="form-table">
          <tr>
              <td><?php _e( 'Choose Leanguage:', 'usb' );?></td>
              <td>
                <select name="leanguage_name" class="csv_len_name">
                  <option value="en"><?php _e( 'En', 'usb' );?></option>
                  <option value="sv"><?php _e( 'Sv', 'usb' );?></option>
                </select>
              </td>
          </tr>
          <tr class="csv_type_name">
              <td><?php _e( 'Choose Type:', 'usb' );?></td>
              <td>
                  <select name="csv_type_name" class="csv_type_name1" onchange="change(this.value)">                 
                      <option value="standard"><?php _e( 'Standrad', 'usb' );?></option>
                      <option value="usb"><?php _e( 'USB', 'usb' );?></option>
                      <option value="attributes"><?php _e( 'Attributes', 'attributes' );?></option>
                  </select>
              </td>
          </tr>

          <tr class="csv_type_en" >
              <td><?php _e( 'Product Category:', 'usb' );?></td>
              <td>
                  <select name="csv_type_caten" >

                      <option value=""><?php _e( 'All', 'usb' );?></option>
                     <?php 
                      // since wordpress 4.5.0
                      $product_categories = $terms = get_terms( 'product_cat', array( 'hide_empty' => false, ) );
                      foreach( $product_categories as $cat ) {
                      ?>
                      <option value="<?php echo $cat->slug;?>"><?php echo $cat->name; ?></option>
                     <?php } ?>
                  </select>
              </td>
          </tr>
          <tr class="csv_type_sv" style="display: none;">
              <td><?php _e( 'Product Category:', 'usb' );?></td>
              <td>
                  <select name="csv_type_catsv" >

                      <option value=""><?php _e( 'All', 'usb' );?></option>
                      <?php
                      global $sitepress;
                      $original_lang = ICL_LANGUAGE_CODE; // Save the current language
                      $new_lang = 'sv'; // The language in which you want to get the terms
                      $sitepress->switch_lang($new_lang); // Switch to new language
                        
                      // Query the terms in new language instead of current language
                      $terms = get_terms( array('taxonomy' => 'product_cat','hide_empty' => false) );
                        
                      // Roll back to current language            
                      $sitepress->switch_lang($original_lang);
                      foreach( $terms as $cat ) {
                      ?>
                      <option value="<?php echo $cat->slug;?>"><?php echo $cat->name; ?></option>
                     <?php } ?>
                  </select>
              </td>
          </tr>        
      </table>
      <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Export Csv"></p>
  </form>
  <script type="text/javascript">
      jQuery(".csv_len_name").change(function(){

          if (jQuery('.csv_len_name :selected').val()=='en') {
              jQuery(".csv_type_sv").hide();
              jQuery(".csv_type_en").show();
          } else if(jQuery('.csv_len_name :selected').val()=='sv') {
           
              jQuery(".csv_type_en").hide();
              jQuery(".csv_type_sv").show();
          }
          else {
              jQuery(".csv_type_en").show();
          }
      });

       function change(str){
        var len=jQuery(".csv_len_name").val();
        
        if(str=='attributes'){

         jQuery(".csv_type_en").hide();
         jQuery(".csv_type_sv").hide(); 
        }else{
           if(len=='en') {
            jQuery(".csv_type_en").show();
          } else{
           jQuery(".csv_type_sv").show();
          } 
          }
        }
       
  </script>
  </div>

  <?php 
}
function usbexportftp_page_callback() {
  ?>
  <div class="wrap">
  <h1>FTP Settings</h1>

  <form method="post" action="options.php">
      <?php settings_fields( 'usbexportftp-group' ); ?>
      <?php do_settings_sections( 'usbexportftp-group' ); ?>
      <table class="form-table">
          <tr valign="top">
          <th scope="row">FTP User Name:</th>
          <td><input type="text" name="ftpuser" value="<?php echo esc_attr( get_option('ftpuser') ); ?>" /></td>
          </tr>
           
          <tr valign="top">
          <th scope="row">FTP Server Name:</th>
          <td><input type="text" name="ftpserver" value="<?php echo esc_attr( get_option('ftpserver') ); ?>" /></td>
          </tr>
          
          <tr valign="top">
          <th scope="row">FTP Password:</th>
          <td><input type="password" name="ftppassword" value="<?php echo esc_attr( get_option('ftppassword') ); ?>" /></td>
          </tr>

          <tr valign="top">
          <th scope="row">FTP Path:</th>
          <td><input type="text" name="ftppath" value="<?php echo esc_attr( get_option('ftppath') ); ?>" /></td>
          </tr>
      </table>
      
      <?php submit_button(); ?>

  </form>
  </div>
  <?php 

   







} 
function register_usbexportftp_settings() {
  //register our settings
  register_setting( 'usbexportftp-group', 'ftpuser' );
  register_setting( 'usbexportftp-group', 'ftpserver' );
  register_setting( 'usbexportftp-group', 'ftppassword' );
  register_setting( 'usbexportftp-group', 'ftppath' );
}


add_action( 'after_setup_theme', 'usb_activation' );

function usb_activation() {
    if (! wp_next_scheduled ( 'usb_daily_event' )) {
      wp_schedule_event(time(), 'daily', 'usb_daily_event');
    }
}

add_action('usb_daily_event', 'do_this_daily');


function do_this_daily(){


    $host = 'sftp.unitedprofile.se';
    $port = 22;
    $username = 'ctwolev';
    $password = '81005c4ebe17ddf2b9c512af2c3d6bf1';

    // Establish SSH connection
    $sshConnection = ssh2_connect($host, $port);

    if ($sshConnection === false) {
        die("Failed to connect to SSH server.");
    }

    // Authenticate using username and password
    if (!ssh2_auth_password($sshConnection, $username, $password)) {
        die("SSH authentication failed.");
    }

    // Initialize SFTP session
    $sftp = ssh2_sftp($sshConnection);

    if (!$sftp) {
        die("Failed to initialize SFTP session.");
    }
    $ftppath = get_option('ftppath');
    $filename1 = get_template_directory().'/inc/theme-functions/export/usb-product.csv';

    $filename2 = get_template_directory().'/inc/theme-functions/export/standard-product.csv';
    $filename3 = get_template_directory().'/inc/theme-functions/export/attribute.csv';

    $remote1 = $ftppath."/usb-product.csv";
    $remote2 = $ftppath."/standard-product.csv";
    $remote3 = $ftppath."/attribute.csv";
    // Create connection the the remote host
    $conn = ssh2_connect($host, $port);
    ssh2_auth_password($conn, $username, $password);
     
    // Create SFTP session
    $sftp = ssh2_sftp($conn);
     
    $sftpStream = fopen('ssh2.sftp://'.$sftp.$remote1, 'w');
     
    try {
     
        if (!$sftpStream) {
            throw new Exception("Could not open remote file: $remote1");
        }
     
        $data_to_send = file_get_contents($filename1);
     
        if ($data_to_send === false) {
            throw new Exception("Could not open local file: $filename1.");
        }
     
        if (fwrite($sftpStream, $data_to_send) === false) {
            throw new Exception("Could not send data from file: $filename1.");
        }
     
        fclose($sftpStream);
     
    } catch (Exception $e) {
        error_log('Exception: ' . $e->getMessage());
        fclose($sftpStream);
    }

      $sftpStream = fopen('ssh2.sftp://'.$sftp.$remote2, 'w');

      try {
       
          if (!$sftpStream) {
              throw new Exception("Could not open remote file: $remote2");
          }
       
          $data_to_send = file_get_contents($filename2);
       
          if ($data_to_send === false) {
              throw new Exception("Could not open local file: $filename2.");
          }
       
          if (fwrite($sftpStream, $data_to_send) === false) {
              throw new Exception("Could not send data from file: $filename2.");
          }
       
          fclose($sftpStream);
       
      } catch (Exception $e) {
          
      }


       $sftpStream = fopen('ssh2.sftp://'.$sftp.$remote3, 'w');    
        try {
         
            if (!$sftpStream) {
                throw new Exception("Could not open remote file: $remote3");
            }
         
            $data_to_send = file_get_contents($filename3);
         
            if ($data_to_send === false) {
                throw new Exception("Could not open local file: $filename3.");
            }
         
            if (fwrite($sftpStream, $data_to_send) === false) {
                throw new Exception("Could not send data from file: $filename3.");
            }
         
            fclose($sftpStream);
         
        } catch (Exception $e) {}


}

function do_this_daily_old() {
  // do something daily
  // connect and login to FTP server
  $ftpuser = get_option('ftpuser');
  $ftpserver = get_option('ftpserver');
  $ftppassword = get_option('ftppassword');
  $ftppath = get_option('ftppath');
  if (!empty($ftpuser) && !empty($ftpserver) && !empty($ftppassword) && !empty($ftppath)) {
    $ftp_server = $ftpserver;
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $ftp_username=$ftpuser;
    $ftp_userpass=$ftppassword;
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

    $filename1 = get_template_directory_uri().'/inc/theme-functions/export/usb-product.csv';
    $filename2 = get_template_directory_uri().'/inc/theme-functions/export/standard-product.csv';
    $filename3 = get_template_directory_uri().'/inc/theme-functions/export/attribute.csv';

    $remote1 = $ftppath."/usb-product.csv";
    $remote2 = $ftppath."/standard-product.csv";
    $remote3 = $ftppath."/attribute.csv";

    if (ftp_put($ftp_conn, $remote1, $filename1, FTP_BINARY)){ "Successfully uploaded";}
    if (ftp_put($ftp_conn, $remote2, $filename2, FTP_BINARY)){ "Successfully uploaded";}
    if (ftp_put($ftp_conn, $remote3, $filename3, FTP_BINARY)){ "Successfully uploaded";}

    // close connection
    ftp_close($ftp_conn); 
  }
}

// 03-12-2019



function usb_export_attributes_four_hour(){
  
  $leanguage_name = 'sv';
  $csv_type_name = 'attributes';

  if($csv_type_name=='attributes'){
      global $sitepress;
      $current_lang = $sitepress->get_current_language();
      if($leanguage_name!=$current_lang){
        $sitepress->switch_lang($leanguage_name);
      }

      function outputCsv($fileName, $assocDataArray)  {
        ob_clean();
        $keys = array_keys($assocDataArray, max($assocDataArray));
        $longestKey = array_reduce($keys, function ($a, $b) { return strlen($a) > strlen($b) ? $a : $b; });
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $fileName);    
        if(isset($assocDataArray['0'])){
          $fp = fopen(dirname(__FILE__).'/export/'.$fileName, 'w');
          fputcsv($fp, array_keys($assocDataArray[$longestKey]));
          foreach($assocDataArray AS $values){
            fputcsv($fp, $values);
          }
          fclose($fp);
        }
        ob_flush();
      }

      $array = wc_get_attribute_taxonomies();
      $row = array(); $rows = array(); $usb_ocm_tlc = array(); $usb_oem_mlc = array(); $usb_original = array();
      foreach ($array as $keys ) {
        $keys->attribute_name;
        $terms = get_terms( array( 'taxonomy' => 'pa_'.$keys->attribute_name, 'hide_empty' => false, ) );
        $n=0;
        foreach($terms as $item){                 
          $qt50 = get_term_meta($item->term_id, '_price50', true);
          $qt100 = get_term_meta($item->term_id, '_price100', true);
          $qt250 = get_term_meta($item->term_id, '_price250', true);
          $qt500 = get_term_meta($item->term_id, '_price500', true);
          $qt1000 = get_term_meta($item->term_id, '_price1000', true);
          $qt2500=get_term_meta($item->term_id, '_price2500', true);
          $qt5000=get_term_meta($item->term_id, '_price5000', true);
          $row["id"] = $n;
          $row["Attributes"] = $keys->attribute_name;
          $row["Name"] = $item->name;
          $row["Slug"] = $item->slug;
          $row["Quantity-50"] = $qt50;
          $row["Quantity-100"] = $qt100;
          $row["Quantity-250"] = $qt250;
          $row["Quantity-500"] = $qt500;
          $row["Quantity-1000"] = $qt1000;
          $row["Quantity-2500"] = $qt2500;
          $row["Quantity5000"] = $qt5000;
          $usb_ocm_tlc = json_decode(get_term_meta($item->term_id,'_usb_ocm_tlc',true),true);
          if ($usb_ocm_tlc) {
            foreach($usb_ocm_tlc as $key=>$val) {
              $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
              $name = $term->name;
              $keyname50 = 'ocm-tlc-'.$name.'-50';
              $keyname100 = 'ocm-tlc-'.$name.'-100';
              $keyname250 = 'ocm-tlc-'.$name.'-250';
              $keyname500 = 'ocm-tlc-'.$name.'-500';
              $keyname1000 = 'ocm-tlc-'.$name.'-1000';
              $keyname2500 = 'ocm-tlc-'.$name.'-2500';
              $keyname5000 = 'ocm-tlc-'.$name.'-5000';
              $row[$keyname50] = $val[1];
              $row[$keyname100] = $val[2];
              $row[$keyname250] = $val[3];
              $row[$keyname500] = $val[4];
              $row[$keyname1000] = $val[5];
              $row[$keyname2500] = $val[6];
              $row[$keyname5000] = $val[7];
            }
          }
          $usb_oem_mlc = json_decode(get_term_meta($item->term_id,'_usb_oem_mlc',true),true);
          if($usb_oem_mlc){
            foreach($usb_oem_mlc as $key=>$val) {
              $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
              $name = $term->name;
              $keyname50 = 'ocm-mlc-'.$name.'-50';
              $keyname100 = 'ocm-mlc-'.$name.'-100';
              $keyname250 = 'ocm-mlc-'.$name.'-250';
              $keyname500 = 'ocm-mlc-'.$name.'-500';
              $keyname1000 = 'ocm-mlc-'.$name.'-1000';
              $keyname2500 = 'ocm-mlc-'.$name.'-2500';
              $keyname5000 = 'ocm-mlc-'.$name.'-5000';
              $row[$keyname50] = $val[1];
              $row[$keyname100] = $val[2];
              $row[$keyname250] = $val[3];
              $row[$keyname500] = $val[4];
              $row[$keyname1000] = $val[5];
              $row[$keyname2500] = $val[6];
              $row[$keyname5000] = $val[7];
            }
          }
          $usb_original = json_decode(get_term_meta($item->term_id,'_usb_original_data',true),true); 
          if($usb_original){
            foreach($usb_oem_mlc as $key=>$val) {
              $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
              $name = $term->name;
              $keyname50 = 'original-'.$name.'-50';
              $keyname100 = 'original-'.$name.'-100';
              $keyname250 = 'original-'.$name.'-250';
              $keyname500 = 'original-'.$name.'-500';
              $keyname1000 = 'original-'.$name.'-1000';
              $keyname2500 = 'original-'.$name.'-2500';
              $keyname5000 = 'original-'.$name.'-5000';
              $row[$keyname50] = $val[1];
              $row[$keyname100] = $val[2];
              $row[$keyname250] = $val[3];
              $row[$keyname500] = $val[4];
              $row[$keyname1000] = $val[5];
              $row[$keyname2500] = $val[6];
              $row[$keyname5000] = $val[7];
            }
          }
          $rows[]=$row;
          $n++;
        }

      }
      outputCsv('attribute-automatic.csv', $rows);
      update_option('attribute-log',time());
      $sitepress->switch_lang( $current_lang );
      exit;
    }
}

function usb_export_standard_four_hour(){
}

function usb_export_usb_four_hour(){

    $leanguage_name = 'sv';
    $csv_type_name = 'usb';
    if($csv_type_name == 'usb'){

        global $sitepress;
        $current_lang = $sitepress->get_current_language();
        if($leanguage_name!=$current_lang){
          $sitepress->switch_lang($leanguage_name);
        }
        $product_cat = array();
        $tax_query = array(array( 'taxonomy' => 'product_type', 'field'    => 'slug', 'terms'    => $csv_type_name, ),);

        $postsmsg_en = '';
        $args = array(
          'post_type' => 'product',
          'posts_per_page' => -1,
          'suppress_filters' => false,
          'tax_query' => $tax_query
        );
        $get_products = get_posts( $args );

        $n = 0; $rows = array(); $row = array(); $rowkey = array(); $odd = array(); $even = array();
        $both = array(&$even, &$odd);
        foreach( $get_products as $post ) :  setup_postdata($post);
          global $product,$woocommerce; 
          $product = wc_get_product($post->ID);

          $terms = get_the_terms ($post->ID, 'product_cat' );
          $cat = array();
          foreach ( $terms as $term ) {
            $cat[]=$term->name;
          }

          $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

          $product = new WC_product($post->ID);
          $attachment_ids = $product->get_gallery_attachment_ids();
          $gallery=array(); 
          foreach( $attachment_ids as $attachment_id ) {
            // Display the image URL
            $gallery[] = wp_get_attachment_url( $attachment_id );
          }
        

          $row[$n]['Id'] = $n;
          $row[$n]["Name"] = $post->post_title;
          $row[$n]["SKU"] = get_post_meta($post->ID,'_sku',true);
          $row[$n]["content"] = $post->post_content;
          $row[$n]["Short Description"] = $post->post_excerpt;
          $row[$n]["sku"] = $product->get_sku();
          $row[$n]["category"] = implode(",",$cat);
          $row[$n]["Gallery Image"] = implode(",",$gallery);
          $row[$n]["Product Image"] = $image_url[0];
          $row[$n]["Download"] = get_post_meta($post->ID,'download',true);
          $row[$n]["Image"] = strip_tags(get_post_meta($post->ID,'image',true));


          if ($product->get_attributes()) {
            foreach($product->get_attributes() as $att){

              $attname=explode('pa_',$att['name']);
              $get_attr_terms = wc_get_product_terms($post->ID,  $att['name'], array( 'fields' => 'names' ));
              
              $get_attr_slug = wc_get_product_terms($post->ID,  $att['name'], array( 'fields' => 'slugs' ));
              
              if ($get_attr_terms) {
                $get_join_attr_terms = join(",",$get_attr_terms);
              }
              //$row[$n][$attname[1].'-name']=$get_join_attr_terms ;
              if ($get_attr_slug) {
                $get_join_attr_terms_slug = join(",",$get_attr_slug);
              }
              $row[$n][$attname[1]]=$get_join_attr_terms_slug ;
            }
            $custom_product_data = get_post_meta($post->ID,'productdata_content', true);
            $DOM = new DOMDocument();
            // $DOM->loadHTML($custom_product_data);
            @$DOM->loadHTML(mb_convert_encoding($custom_product_data, 'HTML-ENTITIES', 'UTF-8'));

            $Detail = $DOM->getElementsByTagName('td');
            $i = 0;
            $j = 0;
            $aDataTableDetailHTML = array();
            foreach($Detail as $sNodeDetail) 
            {
             $aDataTableDetailHTML[] = trim($sNodeDetail->textContent);
              
            }
            $array=$aDataTableDetailHTML;
            $r = array_walk($array, function($v, $k) use ($both) { $both[$k % 2][] = $v; });
            @$c= array_combine($even, $odd);
            if($c){
              foreach(@$c as $key => $value) {
                $key = sanitize_title($key);
                $row[$n][$key] = $value;
              }
            }
          }


          
            $usb_ocm_tlc = json_decode(get_post_meta($post->ID,'_usb_ocm_tlc',true));
            if($usb_ocm_tlc){                                       
              foreach($usb_ocm_tlc as $key=>$val) {
                $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
                $name = $term->name;
                $keyname50 = 'oem-tlc-'.$name.'-50';
                $keyname100 = 'oem-tlc-'.$name.'-100';
                $keyname250 = 'oem-tlc-'.$name.'-250';
                $keyname500 = 'oem-tlc-'.$name.'-500';
                $keyname1000 = 'oem-tlc-'.$name.'-1000';
                $keyname2500 = 'oem-tlc-'.$name.'-2500';
                $keyname5000 = 'oem-tlc-'.$name.'-5000';
                $row[$n][$keyname50] = $val[1];
                $row[$n][$keyname100] = $val[2];
                $row[$n][$keyname250] = $val[3];
                $row[$n][$keyname500] = $val[4];
                $row[$n][$keyname1000] = $val[5];
                $row[$n][$keyname2500] = $val[6];
                $row[$n][$keyname5000] = $val[7];
              }
            }

            $usb_oem_mlc = json_decode(get_post_meta($post->ID,'_usb_oem_mlc',true));
            if($usb_oem_mlc){
              foreach($usb_oem_mlc as $key=>$val) {
                $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
                $name = $term->name;
                $keyname50 = 'oem_mlc-'.$name.'-50';
                $keyname100 = 'oem_mlc-'.$name.'-100';
                $keyname250 = 'oem_mlc-'.$name.'-250';
                $keyname500 = 'oem_mlc-'.$name.'-500';
                $keyname1000 = 'oem_mlc-'.$name.'-1000';
                $keyname2500 = 'oem_mlc-'.$name.'-2500';
                $keyname5000 = 'oem_mlc-'.$name.'-5000';
                $row[$n][$keyname50] = $val[1];
                $row[$n][$keyname100] = $val[2];
                $row[$n][$keyname250] = $val[3];
                $row[$n][$keyname500] = $val[4];
                $row[$n][$keyname1000] = $val[5];
                $row[$n][$keyname2500] = $val[6];
                $row[$n][$keyname5000] = $val[7];
              }
            }

            $usb_original = json_decode(get_post_meta($post->ID,'_usb_original',true));
            if($usb_original){
              foreach($usb_original as $key=>$val) {
                $term = get_term_by('term_id', $val[0], 'usb_quantity'); 
                $name = $term->name;
                $keyname50 = 'original-'.$name.'-50';
                $keyname100 = 'original-'.$name.'-100';
                $keyname250 = 'original-'.$name.'-250';
                $keyname500 = 'original-'.$name.'-500';
                $keyname1000 = 'original-'.$name.'-1000';
                $keyname2500 = 'original-'.$name.'-2500';
                $keyname5000 = 'original-'.$name.'-5000';
                $row[$n][$keyname50] = $val[1];
                $row[$n][$keyname100] = $val[2];
                $row[$n][$keyname250] = $val[3];
                $row[$n][$keyname500] = $val[4];
                $row[$n][$keyname1000] = $val[5];
                $row[$n][$keyname2500] = $val[6];
                $row[$n][$keyname5000] = $val[7];
              }
            }
          

              
            $n++; 
        endforeach;

        
        function productOutputCsv($fileName, $assocDataArray)  {
          ob_clean();
          $result = array_reduce($assocDataArray, 'array_merge', array());
          if ($result) {
            foreach ($result as $key => $value) {
              $blankArr[$key] = '-';
            }
          }
          header('Pragma: public');
          header('Expires: 0');
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          header('Cache-Control: private', false);
          header('Content-Type: text/csv');
          header('Content-Disposition: attachment;filename=' . $fileName);    
          if(isset($assocDataArray['0'])){
            $fp = fopen(dirname(__FILE__).'/export/'.$fileName, 'w');
            fputcsv($fp, array_keys($result));
            foreach($assocDataArray as $values){
              $values = array_merge($blankArr, $values);
              fputcsv($fp, $values);
            }
            fclose($fp);
          }
          ob_flush();
        }
        productOutputCsv($csv_type_name.'-product-automatic.csv', $row);
        update_option($csv_type_name.'-product-log',time());



        $sitepress->switch_lang( $current_lang );
        exit;
    }
}



function do_this_four_hourly() {
  // do something daily
  // connect and login to FTP server
  $ftpuser = get_option('ftpuser');
  $ftpserver = get_option('ftpserver');
  $ftppassword = get_option('ftppassword');
  $ftppath = get_option('ftppath');
  if (!empty($ftpuser) && !empty($ftpserver) && !empty($ftppassword) && !empty($ftppath)) {
    $ftp_server = $ftpserver;
    $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $ftp_username=$ftpuser;
    $ftp_userpass=$ftppassword;
    $login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

    $filename1 = get_template_directory_uri().'/inc/theme-functions/export/usb-product-automatic.csv';
    $filename2 = get_template_directory_uri().'/inc/theme-functions/export/standard-product-automatic.csv';
    $filename3 = get_template_directory_uri().'/inc/theme-functions/export/attribute-automatic.csv';

    $remote1 = $ftppath."/usb-product-automatic.csv";
    $remote2 = $ftppath."/standard-product-automatic.csv";
    $remote3 = $ftppath."/attribute-automatic.csv";

    if (ftp_put($ftp_conn, $remote1, $filename1, FTP_BINARY)){ "Successfully uploaded";}
    if (ftp_put($ftp_conn, $remote2, $filename2, FTP_BINARY)){ "Successfully uploaded";}
    if (ftp_put($ftp_conn, $remote3, $filename3, FTP_BINARY)){ "Successfully uploaded";}

    // close connection
    ftp_close($ftp_conn); 
  }
}
// 03-12-2019

// Add a new interval of 180 seconds
// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
//add_filter( 'cron_schedules', 'add_every_four_hours' );
// function add_every_four_hours( $schedules ) {
//     $schedules['every_four_hour_export_attributes'] = array(
//             'interval'  => (60*60)*4,
//             'display'   => __( 'Every 4 hour', 'textdomain' )
//     );
//     $schedules['every_four_hour_export_standard'] = array(
//             'interval'  => 120,
//             'display'   => __( 'Every 4 hour', 'textdomain' )
//     ); 
//     $schedules['every_four_hour_export_usb'] = array(
//             'interval'  => (60*60)*4,
//             'display'   => __( 'Every 4 hour', 'textdomain' )
//     );
//     $schedules['every_four_hour_ftp'] = array(
//             'interval'  => (60*60)*4,
//             'display'   => __( 'Every 4 hour', 'textdomain' )
//     );
//     return $schedules;
// }

// // Schedule an action if it's not already scheduled
// wp_schedule_event( time(), 'every_four_hour_export_attributes', 'usb_export_attributes_four_hour_action' );
// wp_schedule_event( time(), 'every_four_hour_export_standard', 'usb_export_standard_four_hour_action' );
// wp_schedule_event( time(), 'every_four_hour_export_usb', 'usb_export_usb_four_hour_action' );
// wp_schedule_event( time(), 'every_four_hour_ftp', 'every_four_hour_ftp_action' );

// // Hook into that action that'll fire every three minutes
// add_action( 'usb_export_attributes_four_hour_action', 'usb_export_attributes_four_hour' );
// add_action( 'usb_export_standard_four_hour_action', 'usb_export_standard_four_hour' );
// add_action( 'usb_export_usb_four_hour_action', 'usb_export_usb_four_hour' );
// add_action( 'every_four_hour_ftp_action', 'do_this_four_hourly' );

