
<?php 
// Add Hook For Taxomoy for search//
function search_filters($query) {
 $taxquery=array();

    if(isset($_GET['pa_paint']) && !empty($_GET['pa_paint'])){
      $taxquery[]=array(
             'taxonomy' => 'pa_paint',
             'field' => 'id',
             'terms' => $_GET['pa_paint'],
             'operator'=> 'IN'
         );
     }
     if(isset($_GET['pa_capacity']) && !empty($_GET['pa_capacity'])){
      $taxquery[]=array(
             'taxonomy' => 'pa_capacity',
             'field' => 'id',
             'terms' => $_GET['pa_capacity'],
             'operator'=> 'IN'
         );
     }
     
   
   if(!empty($taxquery)){
     
     if(count($taxquery) > 1){   
      $taxquery['relation'] = 'AND' ;
     }
     
    $query->set( 'tax_query', $taxquery );
   }
    
}
add_action( 'pre_get_posts', 'search_filters' );

//Renaming WooCommerce Product Tabs//


add_filter( 'woocommerce_product_tabs', 'woocommerce_new_product_tab' );
add_filter( 'woocommerce_product_tabs', 'woo_remove_tabs', 98 );
add_action( 'add_meta_boxes', 'custom_post_meta_box' );
add_action( 'save_post', 'save_custom_post_meta_vale' );



function custom_post_meta_box() {

  add_meta_box( 'productdata_for_id', __( 'Product Data', 'productdata_for_domain' ),'productdata_inner_custom','product');
  add_meta_box( 'download_for_id', __( 'Download', 'download_for_domain' ),'download_inner_custom','product');
  add_meta_box( 'image_for_id', __( 'Image', 'image_for_domain' ),'image_inner_custom','product');
  
}



function productdata_inner_custom()

{

  $productdata_content = get_post_meta( $_GET['post'], $key = 'productdata_content', $single = true );

  ?>

  <table>
         <tr>
          <th><?php _e( 'Product Data', 'usb' );?></th>
        </tr>
         <tr>
          <td><?php wp_editor($productdata_content,'productdata_content');?></td>
        </tr>
   </table>

  <?php

}

function download_inner_custom()

{

  $download = get_post_meta( $_GET['post'], $key = 'download', $single = true );

  ?>

  <table>
      <tr>
       <th><?php _e( 'NOTE: You must be put your pdf name and link this format: [usb_zip_download zip_file_name="Your File Name" zip_file_link="Your File Url"]', 'usb' );?></th>
      </tr>
       <tr>
       <td><?php wp_editor($download,'download');?></td>
       </tr>
  </table>

  <?php

}

function image_inner_custom()

{

  $image = get_post_meta( $_GET['post'], $key = 'image', $single = true );

  ?>

  <table>
      <tr>
       <th><?php _e( 'Image', 'usb' );?></th>
      </tr>
       <tr>
       <td><?php wp_editor($image,'image');?></td>
       </tr>
  </table>

  <?php

}

function save_custom_post_meta_vale($postId)

{

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )

    return;



    if ( 'product' == $_POST['post_type'] ) {

      $post_ID = $_POST['post_ID'];

      $productdata_content = stripcslashes( $_POST['productdata_content'] );
      $download = stripcslashes( $_POST['download'] );
      $image = stripcslashes( $_POST['image'] );
      
      update_post_meta($post_ID, 'productdata_content', $productdata_content);
      update_post_meta($post_ID, 'download', $download);
      update_post_meta($post_ID, 'image', $image);
      
      

  }

}

function woo_remove_tabs( $tabs ) {

  global $product;
    unset($tabs['reviews']);
    unset($tabs['description']);
    unset($tabs['additional_information']);
    return $tabs;

}



function woocommerce_new_product_tab($tabs)

{
    global $post;
    $ID = $post->ID;

  $productdata_content = get_post_meta( $ID, $key = 'productdata_content', $single = true );
  $download = get_post_meta( $ID, $key = 'download', $single = true );
  $image = get_post_meta( $ID, $key = 'image', $single = true );
  
  
   if($productdata_content != '' )

  {

    $tabs['product_tab_one'] = array(

      'title'   => __( 'Product Data', 'woocommerce' ),

      'priority'  => 5,

      'callback'  => 'woocommerce_product_product_tab_one'

    );

  }

  

  if($download != '' )

  {

    $tabs['product_tab_three'] = array(

      'title'   => __( 'Download', 'woocommerce' ),

      'priority'  => 15,

      'callback'  => 'woocommerce_product_product_tab_three'

    );

  }

  if($image != '' )

  {

    $tabs['product_tab_four'] = array(

      'title'   => __( 'Image', 'woocommerce' ),

      'priority'  => 16,

      'callback'  => 'woocommerce_product_product_tab_four'

    );

  }

  return $tabs;

}

    

function woocommerce_product_product_tab_one()

{

  global $post;
    $ID = $post->ID;
    $productdata_content = get_post_meta( $ID, $key = 'productdata_content', $single = true);
    echo $productdata_content;

}



function woocommerce_product_product_tab_three()

{

  global $post;
    $ID = $post->ID;
    $download = get_post_meta( $ID, $key = 'download', $single = true);
    echo $download;

}

function woocommerce_product_product_tab_four()

{

  global $post;
    $ID = $post->ID;
    $image = get_post_meta( $ID, $key = 'image', $single = true);
    echo $image;

}



//Shortcode for single page Accessrories section show//
function  show_accessories_func( $atts ) {
    ob_start();
  extract( shortcode_atts( array (
         'orderdate' => 'date',
         'ids' => '',
         'orderby' => 'title',
         'limit' => 1,
    ), $atts, 'show_accessories' ) );
     if(!empty($ids)){
     $accessories_id=explode(',', $ids);
      }
     else{
     $accessories_id=array();
      }
  
  global $product;
           $id = $product->id;
           $product = new WC_Product($id);
           $upsells = $product->get_upsells();
           if (!$upsells)
            return;

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
          while ( $products->have_posts() ) {
                      
                $products->the_post();
                $accessoriesimage = wp_get_attachment_image_src( get_post_thumbnail_id($p_query->ID),'thumbnail');
  ?>
                  

            <div class="col-sm-3 col-xs-12">
                  <div class="accessories-product">
                     <a href="<?php the_permalink(); ?>">
                     
                        <div class="accessories-product-img"><img src="<?php echo $accessoriesimage[0];?>"></div>
                        <h2><?php echo get_the_title($post->ID);?></h2>
                        
                     </a>
                      
                  </div>
               </div>
              <?php
              }
            }
        wp_reset_query();
           ?>
          

  <?php
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
  wp_reset_postdata();
}
add_shortcode( 'show_accessories', 'show_accessories_func' );


//Shortcode for single page Reference image section show//
function  reference_function( $atts ) {
    ob_start();
  extract( shortcode_atts( array (
         'orderdate' => 'date',
         'ids' => '',
         'orderby' => 'title',
         'limit' => 1,
    ), $atts, 'show_reference' ) );
     if(!empty($ids)){
     $reference_id=explode(',', $ids);
      }
     else{
     $reference_id=array();
      }
  
  
  $elviracustom_gal_attachments = get_post_meta(get_the_ID(),'_elviracustom_gal_attachments',false);
  //print_r($elviracustom_gal_attachments);

  ?>
          
      <div class="gal_images">
      <?php 
    if($elviracustom_gal_attachments){
      foreach($elviracustom_gal_attachments as $attachment){     
        echo 
        '<div class="col-sm-3 col-xs-12">
         <div class="accessories-product">
         <div class="accessories-product-img"><img src="'.wp_get_attachment_thumb_url( $attachment ).'"></div>
          </div>
         </div>
        ';
      }
    }?>
      </div> 
              
          

  <?php
  $output_string = ob_get_contents();
  ob_end_clean();
  return $output_string;
  wp_reset_postdata();
}
add_shortcode( 'show_reference', 'reference_function' );
// End of show reference shortcode for product details page//


// Removes tabs from their original loaction 
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

// Inserts tabs under the main right product content 
add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 20 );

//Sku Show at product details page//
add_action( 'woocommerce_single_product_summary', 'dev_designs_show_sku',10 );
function dev_designs_show_sku(){
    global $product;
    echo '<div class="cus-sku" >' . $product->get_sku().'</div>';
}

// Remove action for product details page remove price//
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 ); 

// Add action for product details page show dropdown price//
add_action( 'cart_dropdown_variation_show_price', 'woocommerce_template_single_add_to_cart', 30 ); 

// Add code for multiple image uplaod at product section at backend
function elviracustom_gallery_add_meta_box() {
   $screens = array( 'product');
   
  foreach ( $screens as $screen ) {

    add_meta_box(
      'elviracustom_gallery_sectionid',
      __( 'Add Reference Images', 'elviracustom_gallery_textdomain' ),
      'elviracustom_gallery_meta_box_callback',
      $screen
    );
  }
}
add_action( 'add_meta_boxes', 'elviracustom_gallery_add_meta_box' );

function elviracustom_gallery_meta_box_callback( $post ) {

  wp_nonce_field( 'elviracustom_gallery_meta_box', 'elviracustom_gallery_meta_box_nonce' );
    
  global $wpdb;
  $table = $wpdb->prefix."postmeta";
  $_elviracustom_gal_attachments = $wpdb->get_results("SELECT * FROM $table WHERE post_id =".$post->ID." AND meta_key ='_elviracustom_gal_attachments'");
  
  ?>
    <style type="text/css"> 
  .gal_but  { border: 0 none; margin-left: 5px;position: absolute;z-index: 999;display:none;top:0;cursor:pointer; }
  .gal_images img {position:relative;}
  .abc:hover .gal_but{display:block;border: 0 none;margin-left: 5px;position: absolute;z-index: 999;}
  .abc {width:150px;float:left;height:150px;position:relative;margin:1px;}
  .inside {display:inline-block;}
  </style>
    
    <div class="supports-drag-drop" style="position: relative; display: none; text-align:center;" id="add_mediq_elviracustom" tabindex="0">
    <div class="media-modal wp-core-ui" id="media-modal-close-elviracustom-div">
      <img style="padding:4px; margin-top:25px; border:10px solid #fff; position: relative; box-sizing:border-box;" id="popup_image_elviracustomsols" src="http://localhost/artisan/wp-content/uploads/2015/03/iron-1.jpg" />
            .<a href="javascript:;" id="media-modal-close-elviracustom" style="background: none repeat scroll 0 0 #fff;
    border-radius: 33px;
    margin-top: -200px;
    padding: 5px 10px;
    position: relative;
    right: 23px;
    text-decoration: none;
    top: -79%;">X</a>
   </div>
    <div class="media-modal-backdrop"></div>
  </div>
    <div class="uploader">
      <input class="button" name="wevq_upload_button" id="wevq_upload_button" value="Add Reference image" />
  </div> 
    <br />
    <div class="gal_images">
    <?php 
  if($_elviracustom_gal_attachments){
    foreach($_elviracustom_gal_attachments as $attachment){
      
      echo '
      <div class="abc">
      <a href="'.wp_get_attachment_url( $attachment->meta_value ).'" id="gal_img_wq_a">
      <img class="elviracustom_gal_image" src="'.wp_get_attachment_thumb_url( $attachment->meta_value ).'" width="150" height="150" >
      <input class="gal_but" id="'.$attachment->meta_id.'" type="button" value="x">
      </a>
      </div>
      ';
    }
  }?>
    </div>   
<script type="text/javascript">

jQuery(document).ready(function($)
{
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;

    // ADJUST THIS to match the correct button
    $('.uploader .button').on('click',function(e) 
    {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        var id = button.attr('id').replace('_button', '');
        _custom_media = true;
        wp.media.editor.send.attachment = function(props, attachment)
        {
            if ( _custom_media ) 
            {
                var data = {
          'action': 'custom_attachment_my_action',
          'attachment_id': attachment.id ,
          'post_id': '<?php echo $post->ID; ?>'
          
        };
    
        $.post(ajaxurl, data, function(response) {
          
          $( ".gal_images" ).prepend( response );
        });
        
            } else {
                return _orig_send_attachment.apply( this, [props, attachment] );
            };
        }

        wp.media.editor.open(button);
        return false;
    });

    $('.add_media').on('click', function()
    {
        _custom_media = false;
    });
  
  
  //remove_gal_image
  $(document).on('click','.abc .gal_but', function(e) {
    
    $(this).parent().remove();  
    
    var data = {
      'action': 'removecustom_attachment_my_action',
      'meta_id': this.id      
    };

    $.post(ajaxurl, data, function(response) {
      //
    });

  });
  
  
  //for popup
  $(document).on('click','#gal_img_wq_a', function(e) {
    
    
    e.preventDefault()
    $('#popup_image_elviracustomsols').attr('src', $(this).attr('href'));
    $('#add_mediq_elviracustom').show();

  });
  
  $(document).on('click','#media-modal-close-elviracustom,#media-modal-close-elviracustom-div', function(e) {
    
    $('#add_mediq_elviracustom').hide();

  });
  
  
});

</script>
<?php
}

add_action( 'wp_ajax_custom_attachment_my_action', 'custom_attachment_my_action_callback' );

function custom_attachment_my_action_callback() {
  global $wpdb;
  
  $elviracustom_metaid = add_post_meta($_POST['post_id'], '_elviracustom_gal_attachments', $_POST['attachment_id']);
  
  echo '  
  <div class="abc">
    <img class="elviracustom_gal_image" src="'.wp_get_attachment_thumb_url( $_POST['attachment_id'] ).'" width="150" height="150" >
    <input class="gal_but" id="'.$elviracustom_metaid.'" type="button" value="x">
  </div>
  ';

  die(); 
}

//for remove
add_action( 'wp_ajax_removecustom_attachment_my_action', 'removecustom_attachment_my_action_callback' );

function removecustom_attachment_my_action_callback() {
  global $wpdb ;
  $wpdb->delete( $wpdb->prefix.'postmeta', array('meta_id' => $_POST['meta_id']) );
  
  die(); 
}