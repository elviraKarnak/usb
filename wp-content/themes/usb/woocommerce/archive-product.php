<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version   3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
//do_action( 'woocommerce_before_main_content' );

?>
<!-- <div class="container">
	<div class="row">
		<div class="col-sm-12 col-xs-12">
			<header class="woocommerce-products-header"><meta charset="euc-kr">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );
				?>
			</header>
		</div>
	</div>
</div>  -->
<div class="product-shop-page">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 col-xs-12">
<?php 
if(is_shop()){ if ( have_posts() ) {

?> 
<?php	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked wc_print_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 *
			 * @hooked WC_Structured_Data::generate_product_data() - 10
			 */
			do_action( 'woocommerce_shop_loop' );

			wc_get_template_part( 'content', 'product' );
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} } 

else { ?>

<section class="full top-five-section">
         <div class="top-five-container">
            <div class="row section-title">
	               <div class="col-xs-12 col-sm-12 no-padding ">
	                  <header class="woocommerce-products-header ei-cat-header">
						<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1 class="woocommerce-products-header__title page-title cei-cat-page-title"><?php woocommerce_page_title(); ?></h1>
						<?php endif; ?>

						<?php
						/**
						 * Hook: woocommerce_archive_description.
						 *
						 * @hooked woocommerce_taxonomy_archive_description - 10
						 * @hooked woocommerce_product_archive_description - 10
						 */
						do_action( 'woocommerce_archive_description' );
						?>
					</header>
					<div class="btn-blk cus-btn-blk"><h2 class="back_button"><a onclick="history.go(-1);" href="javascript:void(0)"><span class="fa fa-angle-left" aria-hidden="true"></span><span class="back_text">BACK</span></a></h2><div class="clearfix"></div></div>
	               </div>

<?php if(is_product_category()) {?>
<?php 
$value = get_term_meta( get_queried_object()->term_id, '__term_meta_text', true );
if(!empty($value)) {
    $link = $value;
$video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
if (empty($video_id[1]))
    $video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

$video_id = explode("&", $video_id[1]); // Deleting any other params
$video_id = $video_id[0];
?>

			<div class="col-xs-12 col-sm-12 no-padding ">
			    <div class="ei-cat-video" style="text-align: center;"><iframe width="500" height="300" src="https://www.youtube.com/embed/<?php echo $video_id;?>?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
			</div>
<?php } ?>
<?php } ?>
	               
               <form action="" method=GET>
				    <?php
					if(isset($_GET['submit']))
					{
						$pa_paint = $_GET['pa_paint'];
						$pa_capacity = $_GET['pa_capacity'];
					}
				    ?>
               <div class="col-sm-5 col-xs-12">
                  <div class="col-sm-4 col-xs-12 select-sec"> 
		            <?php $terms = get_terms( 'pa_paint' );
		            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					 echo '<select class="form-control" name="pa_paint">';
					 echo '<option value="">Farg</option>';	
					foreach ( $terms as $term ) {
					echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
					}
					echo '</select>';
					}
		            ?>
                     <!-- <select>
                       <option>Farg</option>
                       <option>Farg 12</option>
                       <option>Farg 13</option>
                       <option>Farg 14</option>
                       <option>Farg 15</option>
                     </select> -->
                  </div>
                  <div class="col-sm-4 col-xs-12 select-sec">
                  	<?php $terms = get_terms( 'pa_capacity' );
		            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					 echo '<select class="form-control" name="pa_capacity">';
					 echo '<option value="">Kapacitet</option>';	
					foreach ( $terms as $term ) {
					echo '<option value="'.$term->term_id.'">' . $term->name . '</option>';
					}
					echo '</select>';
					}
		            ?>
                     <!-- <select>
                       <option>Kapacitet</option>
                       <option>Kapacitet 12</option>
                       <option>Kapacitet 13</option>
                       <option>Kapacitet 14</option>
                       <option>Kapacitet 15</option>
                     </select> -->
                  </div>
                  
               </div>
                <input type="hidden" name="submit" class="top-filter-serach" />
           </form>
            </div>
            <div class="row">
            <div class="category_wraper">
				<?php
				if(have_posts()){
					$kk = 1;
				  while ( have_posts() ) : the_post();
				    
				  if ( has_post_thumbnail() ) {
				  
				    $url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
				    
				  }else{
				    $url = "";
				  }
				?>

               <div class="col-sm-2 col-xs-12 no-padding <?php echo ($kk==1)?'elm1':'';?> <?php echo ($kk==2)?'elm2':'';?> <?php echo ($kk==3)?'elm3':'';?> <?php echo ($kk==4)?'elm4':'';?> <?php echo ($kk==5)?'elm5':'';?> ">
                  <div class="top-five-box asn">
					<div class="popular_new">
						


						<?php 
						$field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
						if(!empty($field_id_value_popular)){ ?>
						<span class="tag-sky1">
						<?php _e( 'Popular', 'usb' );?>
						</span>
						<?php } ?>
						<?php $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
						if(!empty($field_id_value_new)){ ?>
						<span class="tag-red1">
						<?php _e( 'New', 'usb' );?>
						</span>
						<?php } ?>
					</div>
                     <a href="<?php echo get_permalink($post->ID);?>">
                        <div class="top-five-img"><img src="<?php echo $url;?>"><!-- <span class="tag-sky">Populär</span> --></div>
                        <!-- <h3>Nyheter</h3> -->
                        <div class="cei-cat-pro-title">
                        	<h4><?php the_title(); ?></h4>
                        </div>
                        
                     </a>
                  </div>
               </div>
               <?php $kk++; if($kk > 5) {$kk = 1;} endwhile; }else{
                 ?>
            <p><?php _e( 'No Product Were Found', 'usb' );?></p>
        <?php
      }
     wp_reset_query();
  ?>
              
    
            </div>


        </div>
         </div>
</section>

<?php 
 } 

?>
</div>
    </div>
  </div>
</div>
<?php get_footer(); ?>