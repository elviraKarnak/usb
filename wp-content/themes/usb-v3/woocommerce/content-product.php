<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php post_class(); ?>>
	       <?php 
		   
		 $field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);
		 $field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);
		 
		 if($field_id_value_popular && $field_id_value_new){?>
                           <div class="popular_new_single multiple_ribon">
                              <?php } else{?>
							         <div class="popular_new_single">
                                 <?php } ?>
		<?php 
		$field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);
		if(!empty($field_id_value_popular)) { ?>
			<span class="tag-sky">
				<?php _e( 'Popular', 'usb' ); ?>
			</span>
		<?php } ?>

		<?php 
		$field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);
		if(!empty($field_id_value_new)) { ?>
			<span class="tag-red">
				<?php _e( 'New', 'usb' ); ?>
			</span>
		<?php } ?>
	</div>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="ei-related image-div">
		<a href="<?php the_permalink(); ?>">
			<?php
			// Get main product image
			$main_image_id = get_post_thumbnail_id($product->get_id());
			$main_image_url = $main_image_id ? wp_get_attachment_image_url($main_image_id, 'shop_catalog') : '';

			// Get the secondary image (first image from the product gallery)
			$attachment_ids = $product->get_gallery_image_ids();
			$second_image_url = !empty($attachment_ids) ? wp_get_attachment_image_url($attachment_ids[0], 'shop_catalog') : '';

			// Display images
			if ($main_image_url) : ?>
				<img src="<?php echo esc_url($main_image_url); ?>" alt="<?php the_title_attribute(); ?>" class="primary-image"/>
				<?php if ($second_image_url) : ?>
					<img src="<?php echo esc_url($second_image_url); ?>" alt="<?php the_title_attribute(); ?>" class="secondary-image" style="display: none;"/>
				<?php endif; ?>
			<?php endif; ?>
		</a>
	</div>

	<?php
	// Display product title
	do_action( 'woocommerce_shop_loop_item_title' );

	// Display product price
	do_action( 'woocommerce_after_shop_loop_item_title' );

	// Display attributes (if any)
	$product_attributes = $product->get_attributes();
	$product_url = get_the_permalink(get_the_ID());
	if (isset($product_attributes['pa_color'])) {
		$color_options = $product_attributes['pa_color']['options'];
		if ($color_options) {
			echo '<ul class="list-inline color_swatch">';
			foreach ($color_options as $col_opt) {
				if ($col_opt) {
					$col_opt_name = get_field('color_value', get_term($col_opt));
					$col_opt_term = get_term($col_opt);
					$color_url = '';
					$vars = ['color_att' => $col_opt_term->slug];

					if (strpos($product_url, '?') === false) { 
						$color_url = $product_url . '?' . http_build_query($vars);
					} else {
						$color_url = $product_url . '&' . http_build_query($vars);
					}										
					echo '<li class="list-inline-item"><a class="color-icon text-xs-center" href="' . esc_url($color_url) . '"><div class="circle_col" style="background:' . esc_attr($col_opt_name) . '">&nbsp;</div></a></li>';
				}			 
			}
			echo "</ul>";
		}
	}

	do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li>
