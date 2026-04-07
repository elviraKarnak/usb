<?php

add_action('template_redirect', 'redirect_shop_with_lang_param');

function redirect_shop_with_lang_param() {
    if (is_shop()) {
        // Get the current language from the query parameter
        $current_lang = isset($_GET['lang']) ? sanitize_text_field($_GET['lang']) : 'en'; // default to 'en'

        // Define your language-specific shop URLs
        $shop_urls = array(
            'en' => home_url('/shop/?lang=en'),
            'da' => home_url('/shop/?lang=da'),
            'fi' => home_url('/shop/?lang=fi'),
			'no' => home_url('/shop/?lang=no'),
        );

        // Current full URL
        $current_url = home_url(add_query_arg(null, null));

        // If current URL doesn't match the correct lang version, redirect
        if (isset($shop_urls[$current_lang])) {
            $target_url = $shop_urls[$current_lang];

            if (untrailingslashit($current_url) !== untrailingslashit($target_url)) {
                wp_redirect($target_url, 301);
                exit;
            }
        }
    }
}



add_action('wp_ajax_shop_filters', 'shop_filters_cb');
add_action('wp_ajax_nopriv_shop_filters', 'shop_filters_cb');


function shop_filters_cb()
{

	$customPaged = $_REQUEST['p'] ? $_REQUEST['p'] : "1";
	$orderby_value = $_REQUEST['orderby'] ? $_REQUEST['orderby'] : 'menu_order';
	$catId = $_REQUEST['catId'] ? $_REQUEST['catId'] : array();
	$sq = $_REQUEST['sq'] ? $_REQUEST['sq'] : '';
	


	// Default variables
	$orderby = 'menu_order';
	$order = 'ASC';
	$meta_key = '';

	//$meta_query = [];

	$meta_args = array('relation' => 'AND');
	$tax_args = array('relation' => 'AND');

	if (!empty($catId)) {

		$tax_args[] = array(
			'taxonomy' => 'product_cat',
			'field' => 'id',
			'terms' => $catId,
			'operator' => 'IN',
		);
	}

	// if(!empty($min_price) && !empty($max_price)){
	// 	$meta_args[] = array(
	// 		'key'     => '_price',
	// 		'value'   => array((int) $min_price, (int) $max_price),
	// 		'type'    => 'numeric',
	// 		'compare' => 'BETWEEN',
	// 	);

	// }


	// Sorting logic
	switch ($orderby_value) {
		case 'popularity':

			$meta_key = 'total_sales';
			$orderby = 'meta_value_num';
			$order = 'DESC';
			break;

		case 'rating':
			$meta_key = '_wc_average_rating';
			$orderby = 'meta_value_num';
			$order = 'DESC';
			break;

		case 'date':

			$orderby = 'date';
			$order = 'DESC';
			break;

		case 'date_asc':
			$orderby = 'date';
			$order = 'ASC';
			break;

		case 'title_asc':
			$orderby = 'title';
			$order = 'ASC';
			break;

		case 'title_desc':
			$orderby = 'title';
			$order = 'DESC';
			break;

		case 'price':
			$meta_key = '_price';
			$orderby = 'meta_value_num';
			$order = 'ASC';
			break;

		case 'price-desc':
			$meta_key = '_price';
			$orderby = 'meta_value_num';
			$order = 'DESC';
			break;

		default:
			$orderby = 'menu_order';
			$order = 'ASC';
			break;
	}


	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'product',
		'post_status' => 'publish',
		//'meta_query' => $meta_args,
		's'           =>$sq,
		'paged' => $paged,
		'tax_query' => $tax_args,
		'orderby' => $orderby,
		'order' => $order,
	);

	//print_r($args);

	$query = new WP_Query($args);

	if ($query->have_posts()) { ?>

		<!-- <div class="products-count"> Products</div> -->

		<input type="hidden" id="found_post" value="<?php echo $query->found_posts; ?>">

		<?php while ($query->have_posts()) {
			$query->the_post();
			//wc_get_template_part('content', 'product');
			$product = wc_get_product(get_the_ID());

				if($orderby_value == 'menu_order'){

					        $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
							$field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
							$field_id_value_custom = get_post_meta(get_the_ID(), '_custom_badges', true);
							$custom_badges_color = get_post_meta(get_the_ID(), '_custom_badges_color', true);
							$field_id_value_custom_name = get_post_meta(get_the_ID(), '_custom_badges_name', true);

                                    
		                     if ($field_id_value_popular && $field_id_value_new && $field_id_value_custom) {
                                $class = 'popular new custom';
                            } elseif ($field_id_value_popular && $field_id_value_new) {
                                $class = 'popular new';
                            } elseif ($field_id_value_popular && $field_id_value_custom) {
                                $class = 'popular custom';
                            } elseif ($field_id_value_new && $field_id_value_custom) {
                                $class = 'new custom';
                            } elseif ($field_id_value_popular) {
                                $class = 'popular';
                            } elseif ($field_id_value_new) {
                                $class = 'new';
                            } elseif ($field_id_value_custom) {
                                $class = 'custom';
                            } else {
                                $class = 'normal'; // or set a default class if needed
                            }?>
					<div <?php post_class($class); ?>>
				<?php }else{?>
					<div <?php post_class(); ?>>
				<?php }
	
                                    $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
		                            $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
                                    $field_id_value_custom = get_post_meta(get_the_ID(), '_custom_badges', true);
									 $custom_badges_color = get_post_meta(get_the_ID(), '_custom_badges_color', true);
									 $field_id_value_custom_name = get_post_meta(get_the_ID(), '_custom_badges_name', true);
		 
		                            if ($field_id_value_popular && $field_id_value_new && $field_id_value_custom) {
                                        $class = 'popular_new_single multiple_ribon_hattrick';
                                    } elseif ($field_id_value_custom && ($field_id_value_popular || $field_id_value_new)) {
                                        $class = 'popular_new_single multiple_ribon_custom';
                                    } elseif ($field_id_value_custom && !$field_id_value_popular && !$field_id_value_new) {
                                        $class = 'popular_new_single single_custom';
                                    } elseif ($field_id_value_popular && $field_id_value_new) {
                                        $class = 'popular_new_single multiple_ribon';
                                    }else{
                                    	$class = 'popular_new_single';
                                    }?>
										<div class="<?php echo $class; ?>">
									<?php
                                    $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
                                    if (!empty($field_id_value_popular)) { ?>
                                        <span class="tag-sky">
                                            <?php _e('Popular', 'usb'); ?>
                                        </span>
                                    <?php } ?>

                                    <?php
                                   
                                    if (!empty($field_id_value_custom) && $field_id_value_custom == 'yes' && $field_id_value_custom_name) { 
                                    ?>
                                        <span class="tag-sky tag_custom" style="background:<?php echo $custom_badges_color; ?> !important">
                                            <?php _e($field_id_value_custom_name, 'usb'); ?>
                                        </span>
                                    <?php } ?>

                                    <?php
                                    $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
                                    if (!empty($field_id_value_new)) { ?>
                                        <span class="tag-red">
                                            <?php _e('New', 'usb'); ?>
                                        </span>
                                    <?php } ?>
                                </div>

					<?php do_action('woocommerce_before_shop_loop_item'); ?>


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
							if ($main_image_url): ?>
								<img src="<?php echo esc_url($main_image_url); ?>" alt="<?php the_title_attribute(); ?>"
									class="primary-image" />
								<?php if ($second_image_url): ?>
									<img src="<?php echo esc_url($second_image_url); ?>" alt="<?php the_title_attribute(); ?>"
										class="secondary-image" style="display: none;" />
								<?php endif; ?>
							<?php endif; ?>
						</a>
					</div>

					<div class="content_product">
						<div class="title-sc">
							<div class="lft-sc">
								<?php
								// Display product title
								do_action('woocommerce_shop_loop_item_title');
								?>
							</div>

							<div class="rgt-sc">
								<?php
								// Display product price
								do_action('woocommerce_after_shop_loop_item_title');
								?>
							</div>
						</div>

						<?php

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

						?>

						<?php do_action('woocommerce_after_shop_loop_item'); ?>

					</div>
				</div>
				<?php
		}
	}

	// $total_pages = $query->max_num_pages;
	// $current_page = max(1, intval($customPaged));
	//     if ($total_pages > 1) {
	//         echo '<div class="custom-pagination">';
	//         if ($current_page > 1) {
	//             echo '<a href="#" class="page-link" data-page="' . ($current_page - 1) . '">&laquo; Previous</a>';
	//         }
	//         for ($i = 1; $i <= $total_pages; $i++) {
	//             echo '<a href="#" class="page-link' . ($i == $current_page ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
	//         }
	//         if ($current_page < $total_pages) {
	//             echo '<a href="#" class="page-link" data-page="' . ($current_page + 1) . '">Next &raquo;</a>';
	//         }
	//         echo '</div>';
	//     }
	exit;

}

add_action('wp_ajax_search_user_pd', 'search_user_pd_cb');
add_action('wp_ajax_nopriv_search_user_pd', 'search_user_pd_cb');


function search_user_pd_cb()
{

	$search_user_section = $_POST['search_user_section'];
	$company_name_su = $_POST['company_name_su'];
	$customer_no_su = $_POST['customer_no_su'];
	$customer_email_su = $_POST['customer_email_su'];
	$customer_tier_su = $_POST['customer_tier_su'];

	$roles = array('customer');
	$order_by = 'company'; // must be a valid user meta key if you're using meta_value ordering
	$order = 'ASC';

	// Prepare meta query
	$meta_args = array('relation' => 'AND');

	if (!empty($customer_no_su)) {
		$meta_args[] = array(
			'key' => 'customer_no',
			'value' => $customer_no_su,
			'compare' => 'LIKE'
		);
	}

	if (!empty($company_name_su)) {
		$meta_args[] = array(
			'key' => 'company',
			'value' => $company_name_su,
			'compare' => 'LIKE'
		);
	}

	if (!empty($customer_tier_su)) {
		$meta_args[] = array(
			'key' => 'user_level',
			'value' => $customer_tier_su,
			'compare' => '='
		);
	}

	// WP_User_Query arguments
	$args = array(
		'role__in' => $roles,
		'meta_query' => $meta_args,
		'orderby' => 'meta_value',
		'meta_key' => $order_by,
		'order' => $order,
	);

	


	$search_user_section = $_POST['search_user_section'] ?? '';
	$customer_email_su = $_POST['customer_email_su'] ?? '';

	$search_term = '';

	if (!empty($search_user_section) && !empty($customer_email_su)) {
		// If both are available, you can decide whether to combine or prioritize one
		$search_term = $search_user_section . ' ' . $customer_email_su;
	} elseif (!empty($search_user_section)) {
		$search_term = $search_user_section;
	} elseif (!empty($customer_email_su)) {
		$search_term = $customer_email_su;
	}

	if (!empty($search_term)) {
		$args['search'] = '*' . esc_attr($search_term) . '*';
		$args['search_columns'] = array('user_email', 'display_name');
	}

	// Execute the query
	$user_query = new WP_User_Query($args);

	if (!empty($user_query->get_results())) {

		$userData = array();
		echo "<ul class='user_list_search'>";
		foreach ($user_query->get_results() as $user) {

			$userLevel = get_user_meta($user->ID, 'user_level', true) ? get_user_meta($user->ID, 'user_level', true) : "level_1";
			echo "<li><p>" . $user->display_name . "," . get_user_meta($user->ID, 'first_name', true) . " " . get_user_meta($user->ID, 'last_name', true) . "(" . $user->user_email . ") - Level: " . $userLevel . "</p><form class=select_user>
				<input type='hidden' value='" . $user->ID . "' id='user_id' 'name='user_id'>
				<input type='hidden' value='" . $userLevel . "' id='user_level' name='user_level'>
				<button type='select_user'>Select</button>
				</form></li>";

		}
		echo "<ul>";
	} else {
		echo "<ul><li>No User Found</li></ul>";
	}


	exit;
}

add_action('wp_ajax_save_internal_comments', function () {
    if (!isset($_POST['save_internal_comments_nonce']) || !wp_verify_nonce($_POST['save_internal_comments_nonce'], 'save_internal_comments_nonce_action')) {
        wp_send_json_error('Invalid nonce.');
    }

    if (!isset($_POST['post_id']) || !current_user_can('edit_post', $_POST['post_id'])) {
        wp_send_json_error('Permission denied.');
    }

    $post_id = absint($_POST['post_id']);
    $comment = wp_kses_post($_POST['product_internal_comments']);

    update_post_meta($post_id, 'product_internal_comments', $comment);

    wp_send_json_success('Comment saved.');
});
