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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
  global $post;
  $product_data_chk = get_post_meta($post->ID,'_product_data_chk',true);
  $product_acccessories_chk = get_post_meta($post->ID,'_product_acccessories_chk',true);
  $product_download_chk = get_post_meta($post->ID,'_product_download_chk',true);
  $product_reference_chk = get_post_meta($post->ID,'_product_reference_chk',true);
  $product_image_chk = get_post_meta($post->ID,'_product_image_chk',true);
?>

<ul class="nav nav-tabs ei-nav">
    <?php if($product_image_chk == 'yes') {?>
    <li><a data-toggle="tab" href="#image"><?php _e( 'Image', 'usb' ); ?></a></li>
    <?php } ?>
    <?php if($product_acccessories_chk == 'yes') {?>
    <li><a data-toggle="tab" href="#accessories"><?php _e( 'Accessories', 'usb' ); ?></a></li>
    <?php } ?>
    <?php if($product_download_chk == 'yes') {?>
    <li><a data-toggle="tab" href="#download"><?php _e( 'Download', 'usb' ); ?></a></li>
    <?php } ?>
    <?php if($product_reference_chk == 'yes') {?>
    <li><a data-toggle="tab" href="#reference"><?php _e( 'Reference', 'usb' ); ?></a></li>
    <?php } ?>
    <?php if($product_data_chk == 'yes') {?>
    <li><a data-toggle="tab" href="#productdata"><?php _e( 'Product Data', 'usb' ); ?></a></li>
    <?php } ?>
    
  </ul>

  <div class="tab-content">
    <?php if($product_data_chk == 'yes') {?>
    <div id="productdata" class="tab-pane fade">
     <?php 
     global $post;
    $ID = $post->ID;
    $productdata_content = get_post_meta( $ID, $key = 'productdata_content', $single = true);
    // echo $productdata_content;
    echo apply_filters('the_content', $productdata_content);
    ?>
    </div>
    <?php } ?>
    <?php if($product_acccessories_chk == 'yes') {?>
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
          while ( $products->have_posts() ) {
                      
                $products->the_post();
                $accessoriesimage = wp_get_attachment_image_src( get_post_thumbnail_id($p_query->ID),'thumbnail');
      ?>
                  

            <div class="col-sm-3 col-xs-6">
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
    </div>
    <?php } ?>
    <?php if($product_download_chk == 'yes') {?>
    <div id="download" class="fdgd tab-pane fade">
      <?php 
      global $post;
      $ID = $post->ID;
      $download = get_post_meta( $ID, $key = 'download', $single = true);
      // echo $download;
      echo apply_filters('the_content', $download);
      ?>
    </div>
    <?php } ?>
    <?php if($product_reference_chk == 'yes') {?>
    <div id="reference" class="tab-pane fade">
      <?php 
      $elviracustom_gal_attachments = get_post_meta(get_the_ID(),'_elviracustom_gal_attachments',false);
      ?>
      <div class="gal_images">
        <?php 
        if($elviracustom_gal_attachments){
        foreach($elviracustom_gal_attachments as $attachment){    
        $thumb_url = wp_get_attachment_image_src( $attachment, 'full' ); 
        if(!empty($thumb_url)){
        echo 
        '<div class="col-sm-3 col-xs-6">
        <div class="accessories-product">
        <div class="accessories-product-img">

        <a href="'.$thumb_url[0].'" class="fancybox" data-fancybox-group="gallery"><img src="'.wp_get_attachment_thumb_url( $attachment ).'"></a></div>
        </div>
        </div>
        ';

        }


        }
        }?>
      </div> 
    </div>
    <?php } ?>

    <?php if($product_image_chk == 'yes') {?>
    <div id="image" class="tab-pane fade in active">
      <?php 
      global $post;
      $ID = $post->ID;
      $image = get_post_meta( $ID, $key = 'image', $single = true);
      echo apply_filters('the_content', $image);
      ?>
    </div>
    <?php } ?>
  </div>
<script type="text/javascript">
  // jQuery(document).ready(function(){
  //   if (jQuery("ul.ei-nav li:nth-child(1)").length) {
  //     jQuery("ul.ei-nav li:nth-child(1) a").trigger('click');
  //   }
  // });
</script>