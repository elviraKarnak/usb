<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
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

if (!defined('ABSPATH')) {
	exit;
}

if ($related_products):

	$viewed_products = !empty($_COOKIE['usb_recently_viewed']) ? (array) explode('|', wp_unslash($_COOKIE['usb_recently_viewed'])) : array();
	$viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
	if (empty($viewed_products))
		return;


	if ($viewed_products) { ?>
		<section class="related products ei-rel-prdt">
<div class="last_view_rap">
			<div class="row ">
				<div class="col-md-6">
					<h2><?php esc_html_e('Last Viewed Products', 'woocommerce'); ?></h2>
				</div>
				<div class="col-md-6">
					<div class="button_group">
						<a href="<?php echo home_url('/shop'); ?>" class="theme_button"><?php esc_html_e('View All', 'usb');?></a>
						<form name="clear_recent_products" method="POST">
							<button type="submit" name="clear_recent_products"><?php esc_html_e('Clear', 'usb');?></button>
						</form>
					</div>
				</div>
			</div>

			</div>

			<?php // woocommerce_product_loop_start(); ?>

			<?php //foreach ( $related_products as $related_product ) : ?>

			<?php
			//$post_object = get_post( $related_product->get_id() );
			//
			//setup_postdata( $GLOBALS['post'] =& $post_object );
	
			//wc_get_template_part( 'content', 'product' ); ?>

			<?php
			$args = array(
				'post_type' => array('product'),
				'post__in' => $viewed_products,
				'posts_per_page' => 6,
			);

			$get_viewed_products = new WP_Query($args);
			if ($get_viewed_products->have_posts()): ?>
				<div class="show_recent_product mt-4 mb-4 clear">
					<div class="row gy-3">


						<?php while ($get_viewed_products->have_posts()):
							$get_viewed_products->the_post();
							global $product; // Get WooCommerce product object
							?>
							<div class="col-xl-3 col-md-4">
								<div class="row align-items-center">
									<div class="col-4 pe-0">
										<div class="product-thumbnail">
											<?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
										</div>
									</div>
									<div class="col-8">
										<!-- Product Title -->
										<h4 class="product-title mb-0">
											<a href="<?php echo get_permalink(); ?>">
												<?php echo get_the_title(); ?>
											</a>
										</h4>

										<!-- Item No. (SKU) -->
										<?php if ($product->get_sku()): ?>
											<div class="product-sku mb-2">
												<span class="itemNo_label"><?php _e( 'Item no.:', 'usb' ); ?> </span>
												<span class="itemNo"><?php echo $product->get_sku(); ?></span>
											</div>
										<?php endif; ?>
 <!-- Product Price -->
 <div class="product-price mb-2">
                            <span class="price"><?php echo $product->get_price_html(); ?></span>
                        </div>

										<a href="<?php echo get_permalink(); ?>" class="btn"><?php _e( 'Read More', 'usb' ); ?></a>

									</div>
								</div>

							</div>
						<?php endwhile; ?>

					</div> <!-- /.row -->
				</div> <!-- /.show_recent_product -->
				<?php
			endif;
			wp_reset_postdata();
			?>


		</section>
	<?php } ?>
<?php endif;

wp_reset_postdata();