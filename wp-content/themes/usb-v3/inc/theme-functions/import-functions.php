<?php
// create custom plugin settings menu
add_action('admin_menu', 'usb_import_create_menu');
function usb_import_create_menu() {
    //create new top-level menu
    add_menu_page('USB Import', 'Import Settings', 'administrator', __FILE__, 'usb_import_settings_page'  );

    //call register settings function
    add_action( 'admin_init', 'register_usb_import_settings' );
}


function register_usb_import_settings() {
    //register our settings

}
function get_product_by_sku( $sku ) {
  global $wpdb;

  $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

  if ( $product_id ) return $product_id;

  return false;
}
/*================*/
function save_product_attribute_from_name( $name, $label='', $set=true ){
    global $wpdb;

    $label = $label == '' ? ucfirst($name) : $label;
    $attribute_id = get_attribute_id_from_name( $name );

    if( empty($attribute_id) ){
        $attribute_id = NULL;
    } else {
        $set = false;
    }
    $args = array(
        'attribute_id'      => $attribute_id,
        'attribute_name'    => $name,
        'attribute_label'   => $label,
        'attribute_type'    => 'select',
        'attribute_orderby' => 'menu_order',
        'attribute_public'  => 0,
    );

    if( empty($attribute_id) )
        $wpdb->insert(  "{$wpdb->prefix}woocommerce_attribute_taxonomies", $args );

    if( $set ){
        $attributes = wc_get_attribute_taxonomies();
        $args['attribute_id'] = get_attribute_id_from_name( $name );
        $attributes[] = (object) $args;
        //print_r($attributes);
        set_transient( 'wc_attribute_taxonomies', $attributes );
    } else {
        return;
    }
}
function get_attribute_id_from_name( $name ){
    global $wpdb;
    $attribute_id = $wpdb->get_col("SELECT attribute_id
    FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
    WHERE attribute_name LIKE '$name'");
    return reset($attribute_id);
}
/*================*/
function upload_product_image( $image_url,$post_id ) {
    // Add Featured Image to Post
    // $image_url        = 'http://s.wordpress.org/style/images/wp-header-logo.png'; // Define the image URL here
    $fileParts = pathinfo($image_url);
    $image_name       = $fileParts['basename'];
    $upload_dir       = wp_upload_dir(); // Set upload folder
    $image_data       = file_get_contents($image_url); // Get image data
    $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
    $filename         = basename( $unique_file_name ); // Create image file name

    // Check folder permission and define file location
    if( wp_mkdir_p( $upload_dir['path'] ) ) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    // Create the image  file on the server
    file_put_contents( $file, $image_data );

    // Check image file type
    $wp_filetype = wp_check_filetype( $filename, null );

    // Set attachment data
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title'     => sanitize_file_name( $filename ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );

    // Create the attachment
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

    // Include image.php
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Define attachment metadata
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

    // Assign metadata to attachment
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

function usb_import_settings_page() {

    $msg = '';
    if (isset($_POST['usb_import'])&&$_POST['usb_import']=='usb_import') {
        if (isset($_POST['csv_cat_name'])&&$_POST['csv_cat_name']=='product') {
            if (isset($_POST['csv_type_name'])&&$_POST['csv_type_name']=='standrad') {
                $file=$_FILES['fileToUpload']['tmp_name'];
                $fileto = fopen($file,"r");


                $all_rows = array();
                $header = fgetcsv($fileto);
                while ($row = fgetcsv($fileto)) {
                    $all_rows[] = array_combine($header, $row);
                }
                foreach ($all_rows as $key => $value) {

                    /*echo "<pre>";
                    print_r($value);
                    die;*/




                    if ( strtolower($value['product_data_name']) == 'standard') {

                        $product_sku = $value['product_sku'];
                        $product_id = get_product_by_sku($product_sku);
                        if ($product_id == false) { 
                            $ins_arg = array(
                                'post_title'    => $value['product_title'],
                                'post_content'    => $value['product_content'],
                                'post_type'     => 'product',
                                'post_status'     => 'publish',
                                'meta_input' => array(
                                    'business_facts' => $value['product_summary'],
                                    'post_excerpt' => $post['product_short_description'],
                                    '_sku' => $value['product_sku'],
                                    '_active_qty' => $value['standrad_active_qty'],
                                    'productdata_content' => $value['product_data'],
                                    'download' => $value['product_download'],
                                ) 
                            );
                            $post_id = wp_insert_post( $ins_arg );
                            if ($post_id) {
                                wp_set_object_terms( $post_id, strtolower($value['product_data_name']), 'product_type' );
                                $product_cat = explode(",", $value['product_cat']);
                                wp_set_object_terms( $post_id, $product_cat, 'product_cat' );
                                // insert product image thumbnail
                                if (!empty($value['product_thumbnail'])) {
                                    $attach_id = upload_product_image($value['product_thumbnail'],$post_id);
                                    // And finally assign featured image to post
                                    set_post_thumbnail( $post_id, $attach_id );
                                }
                                // update gallery images
                                if(!empty($value['product_gallery'])){
                                    $img_links = explode(',', $value['product_gallery']);
                                    $list_id_arr = array();
                                    foreach ($img_links as $link) {
                                        $list_id_arr[] = upload_product_image($link,$post_id);
                                    }
                                    $list_id = implode(',', $list_id_arr);
                                    update_post_meta($post_id,'_product_image_gallery',$list_id);
                                }
                                // update reference images
                                if(!empty($value['product_add_reference_images'])){
                                    $img_links = explode(',', $value['product_add_reference_images']);
                                    foreach ($img_links as $link) {
                                        $attach_id = upload_product_image($link,$post_id);
                                        add_post_meta($post_id,'_elviracustom_gal_attachments',$attach_id);
                                    }
                                }
                                // Accessories product insert
                                if(!empty($value['accessories_products_sku'])){
                                    $accessories_sku = explode(',', $value['accessories_products_sku']);
                                    $accessories = array();
                                    foreach ($accessories_sku as $single_sku) {
                                       $accessories[] = get_product_by_sku($single_sku);
                                    }
                                    wp_set_object_terms($post_id, $accessories, '_upsell_ids');
                                    update_post_meta($post_id, '_upsell_ids', $accessories);
                                }

                                if(!empty($value['price_option_50'])){
                                    $price_option_50 = $value['price_option_50'];
                                    update_post_meta($post_id, '_price_option_50', $price_option_50);
                                }
                                if(!empty($value['price_option_100'])){
                                    $price_option_100 = $value['price_option_100'];
                                    update_post_meta($post_id, '_price_option_100', $price_option_100);
                                }
                                if(!empty($value['price_option_250'])){
                                    $price_option_250 = $value['price_option_250'];
                                    update_post_meta($post_id, '_price_option_250', $price_option_250);
                                }
                                if(!empty($value['price_option_500'])){
                                    $price_option_500 = $value['price_option_500'];
                                    update_post_meta($post_id, '_price_option_500', $price_option_500);
                                }
                                if(!empty($value['price_option_1000'])){
                                    $price_option_1000 = $value['price_option_1000'];
                                    update_post_meta($post_id, '_price_option_1000', $price_option_1000);
                                }
                                if(!empty($value['price_option_2500'])){
                                    $price_option_2500 = $value['price_option_2500'];
                                    update_post_meta($post_id, '_price_option_2500', $price_option_2500);
                                }
                                if(!empty($value['price_option_5000'])){
                                    $price_option_5000 = $value['price_option_5000'];
                                    update_post_meta($post_id, '_price_option_5000', $price_option_5000);
                                }
                                
                                foreach ($value as $key => $val) {
                                    if (strpos($key, 'attributes_') !== false) {
                                        $taxonomy_name = str_replace("attributes_", "", $key);
                                        $taxonomy = wc_attribute_taxonomy_name($taxonomy_name); // The taxonomy slug 
                                        $attr_label = ucfirst($taxonomy_name); // attribute label name
                                        $attr_name = ( wc_sanitize_taxonomy_name($taxonomy_name)); // attribute slug

                                        $_product_attributes[$taxonomy] = array (
                                            'name'         => $taxonomy,
                                            'value'        => '',
                                            'position'     => '',
                                            'is_visible'   => 1,
                                            'is_variation' => 1,
                                            'is_taxonomy'  => 1
                                        );
                                        $terms_arr = explode(',', $val);
                                        foreach ($terms_arr as $term) {
                                            wp_set_object_terms( $post_id, $term, $taxonomy, true );
                                        }
                                                                
                                    }
                                }
                                update_post_meta($post_id, '_product_attributes', $_product_attributes);
                                $msg = 'Data Successfully Inserted';
                            }
                        }
                    }   
                }
            }
            if (isset($_POST['csv_type_name'])&&$_POST['csv_type_name']=='usb') {
                $file=$_FILES['fileToUpload']['tmp_name'];
                $fileto = fopen($file,"r");
                $all_rows = array();
                $header = fgetcsv($fileto);
                while ($row = fgetcsv($fileto)) {
                  $all_rows[] = array_combine($header, $row);
                }
                foreach ($all_rows as $key => $value) {
                    if (strtolower($value['product_data_name']) == 'usb') {
                        $product_sku = $value['product_sku'];
                        $product_id = get_product_by_sku($product_sku);
                        if ($product_id == false) {                    
                            $ins_arg = array(
                                'post_title'    => $value['product_title'],
                                'post_content'    => $value['product_content'],
                                'post_type'     => 'product',
                                'post_status'     => 'publish',
                                'meta_input' => array(
                                    'business_facts' => $value['product_summary'],
                                    'post_excerpt' => $post['product_short_description'],
                                    '_sku' => $value['product_sku'],
                                    'productdata_content' => $value['product_data'],
                                    'download' => $value['product_download'],
                                    '_show_oem' => $value['show_oem'],
                                    '_show_mlc' => $value['show_mlc'],
                                    '_original' => $value['show_original'],                
                                ) 
                            );
                            
                            $post_id = wp_insert_post( $ins_arg );
                            if ($post_id) {
                                wp_set_object_terms( $post_id, strtolower($value['product_data_name']), 'product_type' );
                                $product_cat = explode(",", $value['product_cat']);
                                wp_set_object_terms( $post_id, $product_cat, 'product_cat' );
                                // insert product image thumbnail
                                if (!empty($value['product_thumbnail'])) {
                                    $attach_id = upload_product_image($value['product_thumbnail'],$post_id);
                                    // And finally assign featured image to post
                                    set_post_thumbnail( $post_id, $attach_id );
                                    $image_attributes = wp_get_attachment_image_src( $attach_id,'medium' );
                                    if ( $image_attributes ) {
                                        update_post_meta($post_id,'image','<img src="'.$image_attributes[0].'" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'" />');
                                    }
                                    
                                }
                                // update gallery images
                                if(!empty($value['product_gallery'])){
                                    $img_links = explode(',', $value['product_gallery']);
                                    $list_id_arr = array();
                                    foreach ($img_links as $link) {
                                        $list_id_arr[] = upload_product_image($link,$post_id);
                                    }
                                    $list_id = implode(',', $list_id_arr);
                                    update_post_meta($post_id,'_product_image_gallery',$list_id);
                                }
                                // update reference images
                                if(!empty($value['product_add_reference_images'])){
                                    $img_links = explode(',', $value['product_add_reference_images']);
                                    foreach ($img_links as $link) {
                                        $attach_id = upload_product_image($link,$post_id);
                                        add_post_meta($post_id,'_elviracustom_gal_attachments',$attach_id);
                                    }
                                }
                                // Accessories product insert
                                if(!empty($value['accessories_products_sku'])){
                                    $accessories_sku = explode(',', $value['accessories_products_sku']);
                                    $accessories = array();
                                    foreach ($accessories_sku as $single_sku) {
                                       $accessories[] = get_product_by_sku($single_sku);
                                    }
                                    wp_set_object_terms($post_id, $accessories, '_upsell_ids');
                                    update_post_meta($post_id, '_upsell_ids', $accessories);
                                }

                                if(!empty($value['usb_quentity_name']))
                                {
                                    $term_name = $value['usb_quentity_name'];
                                    $taxonomy = 'usb_quantity';
                                    // Check if the term already exists
                                    $term = term_exists($term_name, $taxonomy);
                                    if ($term !== 0 && $term !== null) {
                                        $term_quent_id = $term['term_id'];
                                    } else {
                                        $inserted_term = wp_insert_term($term_name, $taxonomy);
                                        if (!is_wp_error($inserted_term)) {
                                            $term_quent_id = $inserted_term['term_id'];
                                        } 
                                    }


                                }


                                foreach ($value as $key => $val) {
                                    if (strpos($key, 'attributes_') !== false) {
                                        $taxonomy_name = str_replace("attributes_", "", $key);
                                        $taxonomy = wc_attribute_taxonomy_name($taxonomy_name); // The taxonomy slug 
                                        $attr_label = ucfirst($taxonomy_name); // attribute label name
                                        $attr_name = ( wc_sanitize_taxonomy_name($taxonomy_name)); // attribute slug

                                        $_product_attributes[$taxonomy] = array (
                                            'name'         => $taxonomy,
                                            'value'        => '',
                                            'position'     => '',
                                            'is_visible'   => 1,
                                            'is_variation' => 1,
                                            'is_taxonomy'  => 1
                                        );
                                        $terms_arr = explode(',', $val);
                                        foreach ($terms_arr as $term) {
                                            wp_set_object_terms( $post_id, $term, $taxonomy, true );
                                        }
                                                                
                                    }
                                }
                                update_post_meta($post_id, '_product_attributes', $_product_attributes);
                                $msg = 'Data Successfully Inserted';
                            }
                            
                        }
                    }
                }
            }
        }
        if (isset($_POST['csv_cat_name'])&&$_POST['csv_cat_name']=='attribute') {
            $file=$_FILES['fileToUpload']['tmp_name'];
            $fileto = fopen($file,"r");
            $all_rows = array();
            $header = fgetcsv($fileto);
            while ($row = fgetcsv($fileto)) {
              $all_rows[] = array_combine($header, $row);
            }
            foreach ($all_rows as $key => $value) {
                $attribute_slug = $value['attribute_slug'];
                $attribute_name = $value['attribute_name'];
                $attribute_terms = $value['attribute_terms'];
                $attribute_term_slug = $value['attribute_term_slug'];
                $st_50 = $value['st_50'];
                $st_100 = $value['st_100'];
                $st_250 = $value['st_250'];
                $st_500 = $value['st_500'];
                $st_1000 = $value['st_1000'];
                $st_2500 = $value['st_2500'];
                $st_5000 = $value['st_5000'];
                $ot = $om = $or = array();
                foreach ($value as $key => $val) {
                    if (strpos($key, 'ot_') !== false) {
                        $gb = str_replace("ot_", "", $key);
                        $term = get_term_by('name', $gb, 'usb_quantity');
                        $term->term_id;
                        $ot[$term->term_id][]=$term->term_id;
                        $ot_val=explode(",",$val);

                        foreach ($ot_val as $item){
                            $ot[$term->term_id][] = $item;
                        }                        
                    }
                    if (strpos($key, 'om_') !== false) {
                        $gb = str_replace("om_", "", $key);
                        $term = get_term_by('name', $gb, 'usb_quantity');
                        $term->term_id;
                        $om[$term->term_id][]=$term->term_id;
                        $om_val=explode(",",$val);

                        foreach ($om_val as $item){
                            $om[$term->term_id][] = $item;
                        }                        
                    }
                    if (strpos($key, 'or_') !== false) {
                        $gb = str_replace("or_", "", $key);
                        $term = get_term_by('name', $gb, 'usb_quantity');
                        $term->term_id;
                        $or[$term->term_id][]=$term->term_id;
                        $or_val=explode(",",$val);
                        foreach ($or_val as $item){
                            $or[$term->term_id][] = $item;
                        }                        
                    }
                }

                $taxonomy_name = $attribute_name;
                $taxonomy = wc_attribute_taxonomy_name($taxonomy_name); // The taxonomy slug 
                $attr_label = ucfirst($taxonomy_name); // attribute label name
                $attr_name = ( wc_sanitize_taxonomy_name($taxonomy_name)); // attribute slug
                save_product_attribute_from_name( $attr_name, $attr_label );
                $term_name = $attribute_terms;
                $term_slug = sanitize_title($attribute_term_slug);
                // Check if the Term name exist and if not we create it.
                if(  !term_exists( $value, $taxonomy ) ){
                    $insert_term = wp_insert_term( $term_name, $taxonomy, array('slug' => $term_slug ) ); // Create the term
                    if (!empty($insert_term->error_data['term_exists'])) {
                        $termid = $insert_term->error_data['term_exists'];
                        if(!empty($st_50))update_term_meta($termid, '_price50', $st_50);
                        if(!empty($st_100))update_term_meta($termid, '_price100', $st_100);
                        if(!empty($st_250))update_term_meta($termid, '_price250', $st_250);
                        if(!empty($st_500))update_term_meta($termid, '_price500', $st_500);
                        if(!empty($st_1000))update_term_meta($termid, '_price1000', $st_1000);
                        if(!empty($st_2500))update_term_meta($termid, '_price2500', $st_2500);
                        if(!empty($st_5000))update_term_meta($termid, '_price5000', $st_5000);

                        if ($ot) {
                            update_term_meta($termid, '_usb_ocm_tlc', json_encode($ot));
                        }
                        if ($om) {
                            update_term_meta($termid, '_usb_oem_mlc', json_encode($om));
                        }
                        if ($or) {
                            update_term_meta($termid, '_usb_original_data', json_encode($or));
                        }
                    } else {
                        $termid = $insert_term['term_id'];
                        if(!empty($st_50))update_term_meta($termid, '_price50', $st_50);
                        if(!empty($st_100))update_term_meta($termid, '_price100', $st_100);
                        if(!empty($st_250))update_term_meta($termid, '_price250', $st_250);
                        if(!empty($st_500))update_term_meta($termid, '_price500', $st_500);
                        if(!empty($st_1000))update_term_meta($termid, '_price1000', $st_1000);
                        if(!empty($st_2500))update_term_meta($termid, '_price2500', $st_2500);
                        if(!empty($st_5000))update_term_meta($termid, '_price5000', $st_5000);
                        if ($ot) {
                            update_term_meta($termid, '_usb_ocm_tlc', json_encode($ot));
                        }
                        if ($om) {
                            update_term_meta($termid, '_usb_oem_mlc', json_encode($om));
                        }
                        if ($or) {
                            update_term_meta($termid, '_usb_original_data', json_encode($or));
                        }
                    }                   
                }  
            }
            $msg = 'Data Successfully Inserted';
        }
        if (isset($_POST['csv_cat_name'])&&$_POST['csv_cat_name']=='price') {
            if (isset($_POST['csv_type_name'])&&$_POST['csv_type_name']=='standrad') {
                $file=$_FILES['fileToUpload']['tmp_name'];
                $fileto = fopen($file,"r");
                $all_rows = array();
                $header = fgetcsv($fileto);
                while ($row = fgetcsv($fileto)) {
                  $all_rows[] = array_combine($header, $row);
                }
                // print_r($all_rows);
                // die();
                foreach ($all_rows as $key => $value) {

                    if (strtolower($value['product_data_name']) == 'standard') {
                        $product_sku = $value['product_sku'];
                        $product_id = get_product_by_sku($product_sku);
                        $st_50 = floatval($value['st_50'])>0?floatval($value['st_50']):'0.0';
                        $st_100 = floatval($value['st_100'])>0?floatval($value['st_100']):'0.0';
                        $st_250 = floatval($value['st_250'])>0?floatval($value['st_250']):'0.0';
                        $st_500 = floatval($value['st_500'])>0?floatval($value['st_500']):'0.0';
                        $st_1000 = floatval($value['st_1000'])>0?floatval($value['st_1000']):'0.0';
                        $st_2500 = floatval($value['st_2500'])>0?floatval($value['st_2500']):'0.0';
                        $st_5000 = floatval($value['st_5000'])>0?floatval($value['st_5000']):'0.0';

                        if (!empty($product_id)) {
                            update_post_meta($product_id, '_price_option_50', floatval($value['st_50']));
                            update_post_meta($product_id, '_custom_quantity_set99', $st_50);

                            update_post_meta($product_id, '_price_option_100', floatval($value['st_100']));
                            update_post_meta($product_id, '_custom_quantity_set249', $st_100);

                            update_post_meta($product_id, '_price_option_250', floatval($value['st_250']));
                            update_post_meta($product_id, '_custom_quantity_set499', $st_250);

                            update_post_meta($product_id, '_price_option_500', floatval($value['st_500']));
                            update_post_meta($product_id, '_custom_quantity_set999', $st_500);

                            update_post_meta($product_id, '_price_option_1000', floatval($value['st_1000']));
                            update_post_meta($product_id, '_custom_quantity_set2499', $st_1000);

                            update_post_meta($product_id, '_price_option_2500', floatval($value['st_2500']));
                            update_post_meta($product_id, '_custom_quantity_set4999', $st_2500);

                            update_post_meta($product_id, '_price_option_5000', floatval($value['st_5000']));
                            update_post_meta($product_id, '_custom_quantity_set9999', $st_5000);
                            $msg = 'Data Successfully Inserted';
                        }
                    }
                }

            }
       
            if (isset($_POST['csv_type_name'])&&$_POST['csv_type_name']=='usb') {
                $file=$_FILES['fileToUpload']['tmp_name'];
                $fileto = fopen($file,"r");
                $all_rows = array();
                $header = fgetcsv($fileto);
                while ($row = fgetcsv($fileto)) {
                  $all_rows[] = array_combine($header, $row);
                }
                foreach ($all_rows as $key => $value) {
                    if (strtolower($value['product_data_name']) == 'usb') {
                        $product_sku = $value['product_sku'];
                        $product_id = get_product_by_sku($product_sku);
                        if (!empty($product_id)) {
                            $ot = $om = $or = array();
                            foreach ($value as $key => $val) {
                                if (strpos($key, 'ot_') !== false) {
                                    $gb = str_replace("ot_", "", $key);
                                    $term = get_term_by('name', $gb, 'usb_quantity');
                                    $term->term_id;
                                    $ot[$term->term_id][]=$term->term_id;
                                    $ot_val=explode(",",$val);

                                    foreach ($ot_val as $item){
                                        $ot[$term->term_id][] = floatval($item) > 0 ? floatval($item) : '0.0';
                                    }                        
                                }
                                if (strpos($key, 'om_') !== false) {
                                    $gb = str_replace("om_", "", $key);
                                    $term = get_term_by('name', $gb, 'usb_quantity');
                                    $term->term_id;
                                    $om[$term->term_id][]=$term->term_id;
                                    $om_val=explode(",",$val);

                                    foreach ($om_val as $item){
                                        $om[$term->term_id][] = floatval($item) > 0 ? floatval($item) : '0.0';
                                    }                        
                                }
                                if (strpos($key, 'or_') !== false) {
                                    $gb = str_replace("or_", "", $key);
                                    $term = get_term_by('name', $gb, 'usb_quantity');
                                    $term->term_id;
                                    $or[$term->term_id][]=$term->term_id;
                                    $or_val=explode(",",$val);
                                    foreach ($or_val as $item){
                                        $or[$term->term_id][] = floatval($item) > 0 ? floatval($item) : '0.0';
                                    }                        
                                }
                            }
                        
                            if (!empty($ot)) {
                                update_post_meta($product_id, '_usb_ocm_tlc', json_encode($ot));
                            }
                            if (!empty($om)) {
                                update_post_meta($product_id, '_usb_oem_mlc', json_encode($om));
                            }
                            if (!empty($or)) {
                                update_post_meta($product_id, '_usb_original', json_encode($or));
                            }
                            $msg = 'Data Successfully Inserted';
                        }
                        $id = icl_object_id($product_id, 'product', false,'sv');
                        if (!empty($id)) {
                            $product_id = $id;
                            if (!empty($product_id)) {
                                $ot = $om = $or = array();
                                foreach ($value as $key => $val) {
                                    if (strpos($key, 'ot_') !== false) {
                                        $gb = str_replace("ot_", "", $key);
                                        $term = get_term_by('name', $gb, 'usb_quantity');
                                        $term->term_id;
                                        $ot[$term->term_id][]=$term->term_id;
                                        $ot_val=explode(",",$val);

                                        foreach ($ot_val as $item){
                                            $ot[$term->term_id][] = floatval($item) > 0 ? floatval($item) : '0.0';
                                        }                        
                                    }
                                    if (strpos($key, 'om_') !== false) {
                                        $gb = str_replace("om_", "", $key);
                                        $term = get_term_by('name', $gb, 'usb_quantity');
                                        $term->term_id;
                                        $om[$term->term_id][]=$term->term_id;
                                        $om_val=explode(",",$val);

                                        foreach ($om_val as $item){
                                            $om[$term->term_id][] = floatval($item) > 0 ? floatval($item) : '0.0';
                                        }                        
                                    }
                                    if (strpos($key, 'or_') !== false) {
                                        $gb = str_replace("or_", "", $key);
                                        $term = get_term_by('name', $gb, 'usb_quantity');
                                        $term->term_id;
                                        $or[$term->term_id][]=$term->term_id;
                                        $or_val=explode(",",$val);
                                        foreach ($or_val as $item){
                                            $or[$term->term_id][] = floatval($item) > 0 ? floatval($item) : '0.0';
                                        }                        
                                    }
                                }
                            
                                if (!empty($ot)) {
                                    update_post_meta($product_id, '_usb_ocm_tlc', json_encode($ot));
                                }
                                if (!empty($om)) {
                                    update_post_meta($product_id, '_usb_oem_mlc', json_encode($om));
                                }
                                if (!empty($or)) {
                                    update_post_meta($product_id, '_usb_original', json_encode($or));
                                }
                                $msg = 'Data Successfully Inserted';
                            }
                        }
                    }
                }
                // add_action( 'admin_notices', 'usb_update_notice' );

            }
                
            
        }
    }

    if (isset($_POST['usb_import'])&&$_POST['usb_import']=='usb_import') {
        if (isset($_POST['csv_cat_name'])&&$_POST['csv_cat_name']=='newproduct') {
            $file=$_FILES['fileToUpload']['tmp_name'];
                $fileto = fopen($file,"r");


                $all_rows = array();
                $header = fgetcsv($fileto);
                while ($row = fgetcsv($fileto)) {
                    $all_rows[] = array_combine($header, $row);
                }
                // print "<pre>"; print_r($all_rows); print "</pre>";
                // die();
                foreach ($all_rows as $key => $value) {
                    
                    $TypeOfProduct = strtoupper($value['TypeOfProduct']);

                    
                    if ($TypeOfProduct == 'USB') {
                        $USBType = strtoupper($value['USBType']);
                        $show_oem = $show_mlc = $show_original = 'no';
                        if (strpos($USBType, 'TLC') !== false) { $show_oem = 'yes'; }
                        if (strpos($USBType, 'MLC') !== false) { $show_mlc = 'yes'; }
                        if (strpos($USBType, 'ORIGINAL') !== false) { $show_original = 'yes'; }
                        $html_product_data = '';
                        $html_product_data .= '<table>';
                        $html_product_data .= '<tbody>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['Size'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec1ValueSe'].'</td>';
                        $html_product_data .= '</tr>';

                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>Colors</td>';
                        $html_product_data .= '<td>'.$value['Colors'].'</td>';
                        $html_product_data .= '</tr>';


                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['Material'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec2ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['Weight'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec3ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['ImprintSurfacer'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec4ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['ImprintMethod'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec5ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['USBVersion'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec6ValueSe'].'</td>';
                        $html_product_data .= '</tr>';

                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>Certificates</td>';
                        $html_product_data .= '<td>'.$value['Certificates'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '</tbody>';
                        $html_product_data .= '</table>';


                        $SKU = $value['SKU'];
                        if (!empty($SKU)) {
                            $product_id = get_product_by_sku($SKU);
                        }
                    
                        if ($product_id == false) {

       
                            $ins_arg = array(
                                'post_title'    => $value['ProductName'],
                                'post_content'    => $value['DescritionText'],
                                'post_type'     => 'product',
                                'post_status'     => 'publish',
                                'post_excerpt' => $value['DescritionText'],
                                'meta_input' => array(
                                    '_sku' => $value['SKU'],
                                    'productdata_content' => $html_product_data,               
                                ) 
                            );
                            // print "<pre>"; print_r($ins_arg); print "</pre>";
                            // die();
                            $post_id = wp_insert_post( $ins_arg );
                            update_post_meta($post_id,'_product_data_chk','yes');
                            update_post_meta($post_id,'_show_oem',$show_oem);
                            update_post_meta($post_id,'_show_mlc',$show_mlc);
                            update_post_meta($post_id,'_original',$show_original);
                            update_post_meta($post_id,'_product_image_chk','yes');
                     
                            if ($post_id) {
                                wp_set_object_terms( $post_id, 'usb', 'product_type' );
                                $product_cat = explode(",", $value['Category']);
                                wp_set_object_terms( $post_id, $product_cat, 'product_cat' );

                                // insert product image thumbnail
                                if (!empty($value['MainProductImage'])) {
                                    $attach_id = upload_product_image($value['MainProductImage'],$post_id);
                                    // And finally assign featured image to post
                                    set_post_thumbnail( $post_id, $attach_id );
                                    $image_attributes = wp_get_attachment_image_src( $attach_id,'medium' );
                                    if ( $image_attributes ) : 
                                        $img_data = '<img src="'.$image_attributes[0].'" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'" />';
                                    endif; 
                                    update_post_meta($post_id,'image',$img_data);
                                }

                                if(!empty($value['ProductGallery'])){
                                    $img_links = explode(',', $value['ProductGallery']);
                                    $list_id_arr = array();
                                    foreach ($img_links as $link) {
                                        $list_id_arr[] = upload_product_image($link,$post_id);
                                    }
                                    $list_id = implode(',', $list_id_arr);
                                    update_post_meta($post_id,'_product_image_gallery',$list_id);
                                }
                            }
                        }
                    }
                    if ($TypeOfProduct == 'STANDARD') {

                        $html_product_data = '';
                        $html_product_data .= '<table>';
                        $html_product_data .= '<tbody>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['Size'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec1ValueSe'].'</td>';
                        $html_product_data .= '</tr>';

                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>Colors</td>';
                        $html_product_data .= '<td>'.$value['Colors'].'</td>';
                        $html_product_data .= '</tr>';


                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['Material'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec2ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['Weight'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec3ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['ImprintSurfacer'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec4ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['ImprintMethod'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec5ValueSe'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>'.$value['USBVersion'].'</td>';
                        $html_product_data .= '<td>'.$value['Spec6ValueSe'].'</td>';
                        $html_product_data .= '</tr>';

                        $html_product_data .= '<tr>';
                        $html_product_data .= '<td>Certificates</td>';
                        $html_product_data .= '<td>'.$value['Certificates'].'</td>';
                        $html_product_data .= '</tr>';
                        $html_product_data .= '</tbody>';
                        $html_product_data .= '</table>';


                        $SKU = $value['SKU'];
                        if (!empty($SKU)) {
                            $product_id = get_product_by_sku($SKU);
                        }

                        if ($product_id == false) {
       
                            $ins_arg = array(
                                'post_title'    => $value['ProductName'],
                                'post_content'    => $value['DescritionText'],
                                'post_type'     => 'product',
                                'post_status'     => 'publish',
                                'post_excerpt' => $value['DescritionText'],
                                'meta_input' => array(
                                    '_sku' => $value['SKU'],
                                    'productdata_content' => $html_product_data,               
                                ) 
                            );
                            // print "<pre>"; print_r($ins_arg); print "</pre>";
                            // die();
                            $post_id = wp_insert_post( $ins_arg );
                            update_post_meta($post_id,'_product_data_chk','yes');
                            // update_post_meta($post_id,'_show_oem',$show_oem);
                            // update_post_meta($post_id,'_show_mlc',$show_mlc);
                            // update_post_meta($post_id,'_original',$show_original);
                            update_post_meta($post_id,'_product_image_chk','yes');
                     
                            if ($post_id) {
                                wp_set_object_terms( $post_id, 'standard', 'product_type' );
                                $product_cat = explode(",", $value['Category']);
                                wp_set_object_terms( $post_id, $product_cat, 'product_cat' );

                                // insert product image thumbnail
                                if (!empty($value['MainProductImage'])) {
                                    $attach_id = upload_product_image($value['MainProductImage'],$post_id);
                                    // And finally assign featured image to post
                                    set_post_thumbnail( $post_id, $attach_id );
                                    $image_attributes = wp_get_attachment_image_src( $attach_id,'medium' );
                                    if ( $image_attributes ) : 
                                        $img_data = '<img src="'.$image_attributes[0].'" width="'.$image_attributes[1].'" height="'.$image_attributes[2].'" />';
                                    endif; 
                                    update_post_meta($post_id,'image',$img_data);
                                }

                                if(!empty($value['ProductGallery'])){
                                    $img_links = explode(',', $value['ProductGallery']);
                                    $list_id_arr = array();
                                    foreach ($img_links as $link) {
                                        $list_id_arr[] = upload_product_image($link,$post_id);
                                    }
                                    $list_id = implode(',', $list_id_arr);
                                    update_post_meta($post_id,'_product_image_gallery',$list_id);
                                }
                            }
                        }
                    }
                    
                    
                }

        }
    }
    
if (!empty($msg)) {
?>
<div class="wrap">
<div class="notice notice-success is-dismissible">
<p><?php _e( $msg, 'usb' ); ?></p>
</div>
<?php } ?>
<h1><?php _e( 'Import Setting', 'usb' );?></h1>

<form method="post" action="" enctype="multipart/form-data">
    <?php settings_fields( 'usb-import-settings-group' ); ?>
    <?php do_settings_sections( 'usb-import-settings-group' ); ?>
    <table class="form-table">
        <tr>
            <td><?php _e( 'Choose Category:', 'usb' );?></td>
            <td>
                <select name="csv_cat_name" class="csv_cat_name">
                    <option value=""><?php _e( 'Choose', 'usb' );?></option>
                    <option value="attribute"><?php _e( 'Attribute', 'usb' );?></option>
                    <option value="product"><?php _e( 'Product', 'usb' );?></option>
                    <option value="price"><?php _e( 'Price', 'usb' );?></option>
                    <option value="newproduct"><?php _e( 'New CSV', 'usb' );?></option>
                </select>
            </td>
        </tr>
        <tr class="csv_type_name" style="display: none;">
            <td><?php _e( 'Choose Type:', 'usb' );?></td>
            <td>
                <select name="csv_type_name" >
                    <option value=""><?php _e( 'Choose', 'usb' );?></option>
                    <option value="standrad"><?php _e( 'Standrad', 'usb' );?></option>
                    <option value="usb"><?php _e( 'USB', 'usb' );?></option>
                </select>
            </td>
        </tr>
        <tr class="csv_standrad_product" style="display: none;">
            <td><?php _e( 'Sample Standrad Product CSV:', 'usb' );?></td>
            <td><a href="<?php echo get_template_directory_uri(); ?>/inc/theme-functions/sample/import-standard-product.csv">Download CSV</a></td>
        </tr>
         <tr class="csv_usb_product" style="display: none;">
            <td><?php _e( 'Sample USB Product CSV:', 'usb' );?></td>
            <td><a href="<?php echo get_template_directory_uri(); ?>/inc/theme-functions/sample/import-usb-product.csv">Download CSV</a></td>
        </tr>
        <tr>
        <td><?php _e( 'Select CSV file to upload:', 'usb' );?></td>
        <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
        <tr>
    </table>
    <input type="hidden" name="usb_import" value="usb_import">
    <?php submit_button(); ?>

</form>
<script type="text/javascript">
    jQuery(".csv_cat_name").change(function(){
        if (jQuery('.csv_cat_name :selected').val()=='attribute') {
            jQuery(".csv_type_name").hide();
            jQuery(".csv_standrad_product").hide();
            jQuery(".csv_usb_product").hide();
        } else if(jQuery('.csv_cat_name :selected').val()=='newproduct') {
            jQuery(".csv_type_name").hide();
            jQuery(".csv_standrad_product").hide();
            jQuery(".csv_usb_product").hide();
        }
        else {
            jQuery(".csv_type_name").show();
            jQuery(".csv_standrad_product").hide();
            jQuery(".csv_usb_product").hide();
        }
    });

    jQuery(".csv_type_name").change(function(){
        if (jQuery('.csv_type_name :selected').val()=='standrad') {
            jQuery(".csv_standrad_product").show();
            jQuery(".csv_usb_product").hide();
        } else if(jQuery('.csv_type_name :selected').val()=='usb') {
            jQuery(".csv_standrad_product").hide();
            jQuery(".csv_usb_product").show();
        }
        else {
            jQuery(".csv_standrad_product").hide();
            jQuery(".csv_usb_product").hide();
        }
    });
</script>
</div>
<?php } 