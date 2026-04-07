<?php

add_action("admin_init", "checkbox_init_one");



function checkbox_init_one(){

  add_meta_box("checkbox", "Badges", "checkbox", "product", "normal", "high");

}



function checkbox(){

  global $post;

  $custom = get_post_custom($post->ID);

  $field_id = $custom["field_id_popular"][0];

  $field_id = $custom["field_id_new"][0];

 ?>



  <label>POPULAR</label>

  <?php $field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);

  if($field_id_value_popular == "yes") $field_id_checked_popular = 'checked="checked"'; ?>

    <input type="checkbox" name="field_id_popular" value="yes" <?php echo $field_id_checked_popular; ?> />





  <label>NEW</label>

  <?php $field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);

  if($field_id_value_new == "yes") $field_id_checked_new = 'checked="checked"'; ?>

    <input type="checkbox" name="field_id_new" value="yes" <?php echo $field_id_checked_new; ?> />



  <!-- =====12-06-2019====== -->

  <label>Front page big</label>

  <?php $front_page_big = get_post_meta($post->ID, '_front_page_big', true);

  if($front_page_big == "yes") $front_page_big_chk = 'checked="checked"'; ?>

  <input type="checkbox" name="front_page_big" value="yes" <?php echo $front_page_big_chk; ?> />





  <label>Front Page small</label>

  <?php $front_page_small = get_post_meta($post->ID, '_front_page_small', true);

  if($front_page_small == "yes") $front_page_small_chk = 'checked="checked"'; ?>

  <input type="checkbox" name="front_page_small" value="yes" <?php echo $front_page_small_chk; ?> /> 

   <label>Custom Badges</label>

  <?php 
  $custom_badges = get_post_meta($post->ID, '_custom_badges', true);
  $custom_badges_name = get_post_meta($post->ID, '_custom_badges_name', true);
  $custom_badges_color = get_post_meta($post->ID, '_custom_badges_color', true);

  if($custom_badges == "yes"){
      $custom_badges_chk = 'checked="checked"';
  }  ?>

  <input type="checkbox" name="custom_badges" value="yes" <?php echo $custom_badges_chk; ?> /> 
    <?php 
    //if($custom_badges == "yes"){?>

      <input type="text" name="custom_badges_name" value="<?php echo $custom_badges_name; ?>" > 

      <input type="color" name="custom_badges_color" value="<?php echo esc_attr($custom_badges_color ?: '#00a652'); ?>" />

   <?php// }  ?>

  <!-- =====12-06-2019===== -->   

  <?php



}

?><?php

// Save Meta Details

add_action('save_post', 'save_details_one');



function save_details_one(){

  global $post;



if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

    return $post->ID;

}



  update_post_meta($post->ID, "field_id_popular", $_POST["field_id_popular"]);

  update_post_meta($post->ID, "field_id_new", $_POST["field_id_new"]);

  /*12-06-2019*/

  /*Front page big and Front Page small*/

  update_post_meta($post->ID, "_front_page_big", $_POST["front_page_big"]);

  update_post_meta($post->ID, "_front_page_small", $_POST["front_page_small"]);

  update_post_meta($post->ID, "_custom_badges", $_POST["custom_badges"]);
  update_post_meta($post->ID, "_custom_badges_name", $_POST["custom_badges_name"]);
  update_post_meta($post->ID, "_custom_badges_color", $_POST["custom_badges_color"]);

} 



/*Anis*/

add_action("admin_init", "product_tabs_display");



function product_tabs_display(){

  add_meta_box("product-tabs-display", "Product Tabs (Show/Hide)", "product_tabs_display_box", "product", "normal", "high");

}



function product_tabs_display_box(){

  global $post;

  $product_data_chk = get_post_meta($post->ID,'_product_data_chk',true);

  $product_acccessories_chk = get_post_meta($post->ID,'_product_acccessories_chk',true);

  $product_download_chk = get_post_meta($post->ID,'_product_download_chk',true);

  $product_reference_chk = get_post_meta($post->ID,'_product_reference_chk',true);

  $product_image_chk = get_post_meta($post->ID,'_product_image_chk',true);

  

 ?>

  <p>

    <label>Product Data</label>

    <input type="checkbox" name="_product_data_chk" <?php echo (!empty($product_data_chk) && $product_data_chk=='yes') ? 'checked':''; ?> />

  

    <label>Accessories</label>

    <input type="checkbox" name="_product_acccessories_chk" <?php echo (!empty($product_acccessories_chk) && $product_acccessories_chk=='yes') ? 'checked':''; ?> />

  

    <label>Download</label>

    <input type="checkbox" name="_product_download_chk" <?php echo (!empty($product_download_chk) && $product_download_chk=='yes') ? 'checked':''; ?> />

  

    <label>Reference</label>

    <input type="checkbox" name="_product_reference_chk" <?php echo (!empty($product_reference_chk) && $product_reference_chk=='yes') ? 'checked':''; ?> />



    <label>Image</label>

    <input type="checkbox" name="_product_image_chk" <?php echo (!empty($product_image_chk) && $product_image_chk=='yes') ? 'checked':''; ?> />

  </p>  

  <?php



}



// Save Meta Details

add_action('save_post', 'save_product_tabs_display');



function save_product_tabs_display($post_id){

  global $post;



  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

      return $post_id;

  }

  if (isset($_POST['_product_data_chk'])) {

    update_post_meta($post_id, "_product_data_chk", 'yes');

  } else {

    update_post_meta($post_id, "_product_data_chk", 'no');

  }



  if (isset($_POST['_product_acccessories_chk'])) {

    update_post_meta($post_id, "_product_acccessories_chk", 'yes');

  } else {

    update_post_meta($post_id, "_product_acccessories_chk", 'no');

  }



  if (isset($_POST['_product_download_chk'])) {

    update_post_meta($post_id, "_product_download_chk", 'yes');

  } else {

    update_post_meta($post_id, "_product_download_chk", 'no');

  }



  if (isset($_POST['_product_reference_chk'])) {

    update_post_meta($post_id, "_product_reference_chk", 'yes');

  } else {

    update_post_meta($post_id, "_product_reference_chk", 'no');

  }



  if (isset($_POST['_product_image_chk'])) {

    update_post_meta($post_id, "_product_image_chk", 'yes');

  } else {

    update_post_meta($post_id, "_product_image_chk", 'no');

  }

  

} 