<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hook Woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>

<div class="container product-details">
	<?php
	// Get parent product categories on single product pages
	$terms = wp_get_post_terms( get_the_id(), 'product_cat', array( 'include_children' => false ) );
	$term = reset($terms);
	$term_link =  get_term_link( $term->term_id, 'product_cat' ); // The link /*href="'.$term_link.'"*/
	echo "<div class='btn-blk'>";
	echo '<h2 class="back_button"><a onclick="history.go(-1);" href="javascript:void(0)"><span class="fa fa-angle-left" aria-hidden="true"></span><span class="back_text">BACK</span></a></h2>';
	_e('<h4 class="cat_button"><a href="'.$term_link.'"><span class="back_text">'.$term->name.'</span></a></h4>');
	echo "<div class='clearfix'></div>";
	echo "</div>";
	?>
	<div class="row">
		<div class="col-sm-12 col-xs-12">

			<div class="popular_new_single">
				<?php $field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);
				if(!empty($field_id_value_popular)){ ?>
				    <span class="tag-sky">
				      <?php _e( 'Popular', 'usb' );?>
				    </span>
				<?php } ?>
				<?php $field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);
				  if(!empty($field_id_value_new)){ ?>
					    <span class="tag-red">
					      <?php _e( 'New', 'usb' );?>
					    </span>
				  <?php } ?>
			</div>
			<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php global $product; $attachment_ids = $product->get_gallery_image_ids(); $attachment_ids_count = count($attachment_ids); ?>
				<div class="gall-<?php echo $attachment_ids_count;?>">
					<?php
						/**
						 * Hook: woocommerce_before_single_product_summary.
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						do_action( 'woocommerce_before_single_product_summary' );
					?>

					<div class="summary entry-summary product-details-right">
						
						<?php
							/**
							 * Hook: Woocommerce_single_product_summary.
							 *
							 * @hooked woocommerce_template_single_title - 5
							 * @hooked woocommerce_template_single_rating - 10
							 * @hooked woocommerce_template_single_price - 10
							 * @hooked woocommerce_template_single_excerpt - 20
							 * @hooked woocommerce_template_single_add_to_cart - 30
							 * @hooked woocommerce_template_single_meta - 40
							 * @hooked woocommerce_template_single_sharing - 50
							 * @hooked WC_Structured_Data::generate_product_data() - 60
							 */
							do_action( 'woocommerce_single_product_summary' );
						?>

					</div>
				</div>

		
			</div>	
		</div>
		<div class="summary-cart-section">
		<div class="product-details-left">
		<?php
		/**
		* Hook: woocommerce_template_single_add_to_cart.
		*/
		do_action( 'cart_dropdown_variation_show_price');
		?>
		</div>
		</div>
		<?php 
        $user = wp_get_current_user();
        $roles = $user->roles;
        
		?>
		<?php if ( is_super_admin() || $roles[0]=='sales-user') { ?>
		<div class="col-sm-12 col-xs-12">
			<div class="cus-editor" style="float: right;">
				<a href="#divForm" class="cus-editor-btn" id="btnForm">Comment</a>
			</div>
			<div id="divForm" style="display:none">
			    <?php
					$post_id = get_the_ID();
					$content = get_post_meta($post_id,'_usbcomment',true);
					$editor_id = 'usbcomment';
					$settings= array('tinymce'=> false);
					wp_editor( $content, $editor_id, $settings );
				?>
				<button data-cmtid="<?php echo $post_id;?>" class="btn editor-save-btn">Save</button>
			</div>
		</div>
	
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery(function(){
					jQuery("#btnForm").fancybox();
				});
				jQuery(document).on('click','.editor-save-btn',function(){
					var usbcomment = jQuery("#usbcomment").val();
					var post_id = '<?php echo $post_id; ?>';
					// console.log(usbcomment+post_id);
					jQuery.ajax({
						type: "POST",
						data: {action: 'usbcomment',usbcomment:usbcomment,cus_product_id:post_id},
						//url: ajaxVars.ajaxurl,
						url: '<?php echo admin_url( 'admin-ajax.php' );?>',
						success: function(msg){
							if (msg) {
								jQuery(".fancybox-close").trigger('click');
								location.reload();
							}
						}
				    });
				});
			 
			});		 
		</script>
		<?php
		$content= apply_filters('the_content', $content);
		if(!empty($content)){
		?>
		<div class="col-sm-6 col-xs-12 cus_comment_wrap">
			<?php echo $content; ?>
		</div>
		<?php }} ?>
		<div class="col-sm-12 col-xs-12">
			<?php
				/**
				 * Hook: woocommerce_after_single_product_summary.
				 *
				 * @hooked woocommerce_output_product_data_tabs - 10
				 * @hooked woocommerce_upsell_display - 15
				 * @hooked woocommerce_output_related_products - 20
				 */
				do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>
			
		
	</div>		
</div>




<?php do_action( 'woocommerce_after_single_product' ); ?>
