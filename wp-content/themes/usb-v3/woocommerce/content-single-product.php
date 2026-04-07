<?php
/**
 * The template for displaying product content in the single-product.php template
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

$back_to_overview = get_field('back_to_overview_sp', 'option');
$popular = get_field('popular_sp', 'option');
$new = get_field('new_sp', 'option');
$price_calculator = get_field('price_calculator_sp', 'option');
$buy_now = get_field('buy_now_sp', 'option');
$choose_user_tier = get_field('choose_user_tier_sp', 'option');
$search_user = get_field('search_user_sp', 'option');
$product_pdf = get_field('product_pdf_sp', 'option');
$comment = get_field('comment_sp', 'option');
$save = get_field('save_sp', 'option');

/**
 * Hook Woocommerce_before_single_product.
 *@hooked wc_print_notices - 10
 */

do_action('woocommerce_before_single_product');


// if (post_password_required()) {
// 	echo get_the_password_form(); // WPCS: XSS ok.
// 	return;
// }
?>

<div class="container product-details">
	<?php

	// Get parent product categories on single product pages
	$terms = wp_get_post_terms(get_the_id(), 'product_cat', array('include_children' => false));
	$term = reset($terms);
	$term_link = get_term_link($term->term_id, 'product_cat'); // The link /*href="'.$term_link.'"*/ ?>


	<?php /*
<?php echo "<div class='btn-blk'>";

echo '<h2 class="back_button"><a onclick="history.go(-1);" href="javascript:void(0)"><span class="fa fa-angle-left" aria-hidden="true"></span><span class="back_text">BACK</span></a></h2>';
'<h4 class="cat_button"><a href="'.$term_link.'"><span class="back_text">'.$back_to_overview.'</span></a></h4>';
echo "<div class='clearfix'></div>";
echo "</div>";
?> */ ?>

	<div class="row">
		<div class="col-12">
			<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php global $product;
				$attachment_ids = $product->get_gallery_image_ids();
				$attachment_ids_count = count($attachment_ids); ?>
				<div class="gall-<?php echo $attachment_ids_count; ?>">

							<?php 
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
		
						<?php

						/**
						 * Hook: woocommerce_before_single_product_summary.
						 *@hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */

						do_action('woocommerce_before_single_product_summary');
						?>
</div>
						<div class="summary entry-summary product-details-right">

							<?php

							/**
							 * Hook: Woocommerce_single_product_summary.
							 * @hooked woocommerce_template_single_title - 5
							 * @hooked woocommerce_template_single_rating - 10
							 * @hooked woocommerce_template_single_price - 10
							 * @hooked woocommerce_template_single_excerpt - 20
							 * @hooked woocommerce_template_single_add_to_cart - 30
							 * @hooked woocommerce_template_single_meta - 40
							 * @hooked woocommerce_template_single_sharing - 50
							 * @hooked WC_Structured_Data::generate_product_data() - 60
							 */

							do_action('woocommerce_single_product_summary');

							?>

							<div class="price_calculation">
								<?php
								do_action('usb_show_price_content');
								?>
							</div>
							<?php
							global $product;

							$back_to_overview = get_field('back_to_overview_sp', 'option');
							$popular = get_field('popular_sp', 'option');
							$new = get_field('new_sp', 'option');
							$price_calculator = get_field('price_calculator_sp', 'option');
							$buy_now = get_field('buy_now_sp', 'option');
							$choose_user_tier = get_field('choose_user_tier_sp', 'option');
							$search_user = get_field('search_user_sp', 'option');
							$product_pdf = get_field('product_pdf_sp', 'option');
							$comment = get_field('comment_sp', 'option');
							$save = get_field('save_sp', 'option');

							?>

							<div class="buy-flex third_column">


								<div class="flex-inner mt-4 d-flex">
									<!-- <div class="flex-col">
									<button class="usb_shop_button no_click"><?php echo $buy_now; ?></button>

									<div id="product_sidebar_download_e" class="product_sidebar_download">



									</div>
								</div> -->
									<div class="flex-col ">
										<?php if (current_user_can('administrator')) {
											$options = array("select", "level_1", "level_2", "level_3", "level_4", "level_5");
											if (isset($_GET['user_tier'])) {
												$user_tier = $_GET['user_tier'];
											} else {
												$user_tier = '';
											} ?>

											<div class="dropdown">
												<button class="btn btn-secondary dropdown-toggle" type="button"
													data-bs-toggle="dropdown" aria-expanded="false">
													<?php if (empty($user_tier)): ?> 		<?php echo $choose_user_tier; ?>
													<?php else: ?>
														<?php echo ucfirst(str_replace("_", " ", $user_tier)); ?>
													<?php endif; ?>
												</button>

												<ul class="dropdown-menu">
													<?php foreach ($options as $option) { ?>
														<?php if ($option == 'select'): ?>
															<li><a class="dropdown-item <?php if ($user_tier == $option): ?> active <?php endif; ?>"
																	href="?deafult=<?php echo $option; ?>"><?php echo ucfirst(str_replace("_", " ", $option)); ?></a>
															</li>
														<?php else: ?>
															<li><a class="dropdown-item <?php if ($user_tier == $option): ?> active <?php endif; ?>"
																	href="?user_tier=<?php echo $option; ?>"><?php echo ucfirst(str_replace("_", " ", $option)); ?></a>
															</li>
														<?php endif; ?>
													<?php } ?>
												</ul>
											</div>
										<?php } ?>
									</div>
									<?php if(is_user_logged_in()){?>
									<div class="flex-col ">
										<!-- Button trigger modal -->
										<button type="button" class="btn btn-primary price-calcualtion-btn"
											data-bs-toggle="modal">
											<?php echo $price_calculator; ?>
										</button>
									</div>
									<?php } ?>

									<?php if (current_user_can('administrator')) { ?>
										<div class="flex-col">
											<button type="button" class="btn btn-primary" data-bs-toggle="modal"
												data-bs-target="#user_price_calculatuion">
												<?php echo $search_user; ?>
											</button>
										</div>
										<div style="clear: both;"></div>
									<?php } ?>

									<div class="flex-col">
										<div class="cus-margin-btn-warp">

											<?php //echo do_shortcode('[usb_pdf pdf_name="Export"]'); ?>

											<!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo $product->get_id(); ?>" target="_blank" data-productId="<?php //echo $id; ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->

											<a class="dwnpdf"
												href='?pdf=<?php echo $product->get_id(); ?>&lang=<?php echo $_GET['lang'] ? $_GET['lang'] : 'en'; ?>'
												target='_blank'>


												<?php echo $product_pdf; ?>

											</a>

											<?php if (is_user_logged_in()) { ?>

												<!-- <a class="down_pdf_summary" href="?offerpdf=<?php //echo $product->get_id(); ?>&lang=<?php //echo $_GET['lang']?$_GET['lang']:'en'; ?>" target="_blank" data-productId="<?php //echo $id; ?>"><?php //_e( 'Offer', 'usb' ); ?></a> -->

											<?php } ?>

										</div>
									</div>

								</div>





							</div>

							<div class="price_calculator_form">
								<?php do_action('cart_dropdown_variation_show_price'); ?>
							</div>

							<?php if (is_user_logged_in() && current_user_can('administrator')) {

							$comments = get_field('product_internal_comments');
						?>

							<div class="admin_comments">
								<div class="admin_button_comments">
									<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit_internals_comment">Comments</button>
								</div>
								<?php if($comments){?>
									<div class="comments_box_internal">
										<?php echo $comments; ?>
									</div>
								<?php }?>
							</div>

							<div class="modal fade" id="edit_internals_comment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
								aria-labelledby="staticBackdropLabel" aria-hidden="true">
								<div class="modal-dialog modal-xl modal-dialog-centered">
									<div class="modal-content">
										<form id="internal-comments-form">
											<div class="modal-header">
        										<h5 class="modal-title">Edit Comments</h5>
        										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      										</div>
											<div class="modal-body">
												<?php
												wp_editor(
													get_post_meta(get_the_ID(), 'product_internal_comments', true),
													'product_internal_comments',
													[
														'textarea_name' => 'product_internal_comments',
														'textarea_rows' => 5,
														'media_buttons' => false,
														'teeny' => true,
													]
												);
												?>
												<?php wp_nonce_field('save_internal_comments_nonce_action', 'save_internal_comments_nonce'); ?>
												<input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>">
											</div>
											<div class="modal-footer">
												<!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
												<button type="submit" class="btn btn-primary">Save Comment</button>
											</div>
										</form>
									</div>
								</div>
							</div>

							<script>
								jQuery(document).ready(function($) {
									$('#internal-comments-form').on('submit', function(e) {
										e.preventDefault();

										// Ensure TinyMCE content is updated in the textarea
										if (typeof tinyMCE !== "undefined" && tinyMCE.get('product_internal_comments')) {
											tinyMCE.get('product_internal_comments').save();
										}

										var form = $(this);
										var formData = form.serialize();

										$.ajax({
											url: '<?php echo admin_url('admin-ajax.php'); ?>',
											type: 'POST',
											data: formData + '&action=save_internal_comments',
											dataType: 'json',
											success: function(response) {
												if (response.success) {
													//alert('Comment saved!');
													location.reload();
												} else {
													alert('Error: ' + response.data);
												}
											},
											error: function() {
												alert('AJAX error occurred.');
											}
										});
									});
								});
								</script>
							

						<?php }?>

						</div>
						
					</div>
				</div>
			</div>



			<div class="fullwidth_sec">

				<?php do_action('custom_tab_data'); ?>
			</div>
			<div class="row">

				<div class="summary-cart-section">

					<div class="product-details-left">

						<?php

						/**

																																																												   * Hook: woocommerce_template_single_add_to_cart.

																																																												   */

						//do_action( 'cart_dropdown_variation_show_price');
						
						?>

					</div>

				</div>

				<?php

				$user = wp_get_current_user();

				$roles = $user->roles;



				?>

				<?php if (is_super_admin() || $roles[0] == 'sales-user') { ?>

					<div class="col-sm-12 col-xs-12" style="display:none;">

						<div class="cus-editor" style="float: right;">

							<a href="#divForm" class="cus-editor-btn" id="btnForm"><?php echo $comment; ?></a>

						</div>

						<div id="divForm" style="display:none">

							<?php

							$post_id = get_the_ID();

							$content = get_post_meta($post_id, '_usbcomment', true);

							$editor_id = 'usbcomment';

							$settings = array('tinymce' => false);

							wp_editor($content, $editor_id, $settings);

							?>

							<button data-cmtid="<?php echo $post_id; ?>"
								class="btn editor-save-btn"><?php echo $save; ?></button>

						</div>

					</div>



					<script type="text/javascript">

						jQuery(document).ready(function () {

							jQuery(function () {

								jQuery("#btnForm").fancybox();

							});

							jQuery(document).on('click', '.editor-save-btn', function () {

								var usbcomment = jQuery("#usbcomment").val();

								var post_id = '<?php echo $post_id; ?>';

								// console.log(usbcomment+post_id);

								jQuery.ajax({

									type: "POST",

									data: { action: 'usbcomment', usbcomment: usbcomment, cus_product_id: post_id },

									//url: ajaxVars.ajaxurl,

									url: '<?php echo admin_url('admin-ajax.php'); ?>',

									success: function (msg) {

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

					$content = apply_filters('the_content', $content);

					if (!empty($content)) {

						?>

						<div class="col-sm-6 col-xs-12 cus_comment_wrap" style="display:none;">

							<?php echo $content; ?>


						</div>


					


					<?php }
				} ?>


				<div class="col-sm-12 col-xs-12">

					<?php

					/**

																																																				  * Hook: woocommerce_after_single_product_summary.

																																																				  *

																																																				  * @hooked woocommerce_output_product_data_tabs - 10

																																																				  * @hooked woocommerce_upsell_display - 15

																																																				  * @hooked woocommerce_output_related_products - 20

																																																				  */

					do_action('woocommerce_after_single_product_summary');

					?>

				</div>





			</div>

		</div>



		<!-- Modal -->
		<div class="modal fade" id="price_calculatuion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel"><?php echo $price_calculator; ?></h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

					</div>
					<!-- <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary">Understood</button>
	  </div> -->
				</div>
			</div>
		</div>

		<?php if (current_user_can('administrator')) { ?>
			<div class="modal fade" id="user_price_calculatuion" data-bs-backdrop="static" data-bs-keyboard="false"
				tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog modal-xl modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="staticBackdropLabel">Search User</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form id="user_search_admin">
								<div class="row gy-4">
									<div class="col-md-4">
										<div class="form-group">
											<input type="text" id="search_user_section" name="search_user_section"
												placeholder="Search User">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<input type="text" id="company_name_su" name="company_name_su"
												placeholder="Company Name">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<input type="text" id="customer_no_su" name="customer_no_su"
												placeholder="Customer No">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<input type="text" id="customer_email_su" name="customer_email_su"
												placeholder="Customer Email">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<select id="customer_tier_su" name="customer_tier_su">
												<option value="">Select</option>
												<option value="level_1">Level 1</option>
												<option value="level_2">Level 2</option>
												<option value="level_3">Level 3</option>
												<option value="level_4">Level 4</option>
												<option value="level_5">Level 5</option>
											</select>
										</div>
									</div>
									<!-- <input type="text" id="" name="customer_tier_su" placeholder="Customer Tier" > -->
									<div class="col-md-4">
										<div class="form-group w-100">
											<button type="submit" name="submit_search" class="w-100">Find User</button>
										</div>
									</div>
								</div>
								<input type="hidden" name="action" value="search_user_pd">
								<input type="hidden" id="search_user_id" name="user_id">
								<input type="hidden" id="search_user_level" name="user_level">

							</form>
							<div class="loader-user text-center d-none" id="loader-user">


								<div>
									<div class="loader-gif mt-5"></div>
								</div>

							</div>
							<div id="user-list" class="d-none"></div>
						</div>
					</div>
				</div>
			</div>


			<?php
			// Get all users
			$users = get_users();
			$user_data = array(); // Initialize an empty array to store user data
		
			foreach ($users as $user) {
				// Get user first name, last name, and ID
				$first_name = get_user_meta($user->ID, 'first_name', true);
				$last_name = get_user_meta($user->ID, 'last_name', true);
				$company_name = get_user_meta($user->ID, 'company', true);
				$email = $user->user_email;
				if ($company_name) {
					$name = $company_name;
				} else {
					$name = $first_name . ' ' . $last_name;
				}

				$user_level = get_field('user_level', 'user_' . $user->ID);
				if (empty($user_level)) {
					$user_level = 'level_1';
				}
				$user_data[] = array(
					//'label' => "$first_name $last_name (Customer ID: $user->ID)", // Combine first name, last name, and ID
					'label' => "$name (Customer Email: $email)",
					'value' => $user->ID,
					'user_level' => $user_level
				);
			}

			?>

			<script>
				jQuery(document).ready(function ($) {

					var url = '<?php echo home_url('wp-admin/admin-ajax.php'); ?>';

					$("#user_search_admin").on('submit', function (e) {
						e.preventDefault();
						var formData = $(this).serialize();
						//console.log(formData);
						$("#loader-user").removeClass('d-none');
						

						$.ajax({

							url: url, // WordPress AJAX URL
							type: 'POST',
							data: formData,

							beforeSend: function () {
								// $("#diamond_product_ajax_data").html(`<div id="loader-wrapper" style="display: none;"><div class="loader"></div></div>`);

								//showLoader();
								//console.log('Sending AJAX request with data:', ajaxData);
							},

							success: function (response) {


								// console.log('Response received:', response);

								$("#user-list").html(response);
								$("#user-list").removeClass('d-none');
									$("#loader-user").addClass('d-none');
								$(".user_list_search li").each(function () {
									$(this).find('.select_user').on('submit', function (e) {
										e.preventDefault();
										var userId = $(this).find('#user_id').val();
										var userlevel = $(this).find('#user_level').val();

										console.log(userId);
										console.log(userlevel);


										// Build new query string
										var newParams = '?user_id=' + userId + '&user_level=' + userlevel + '&submit_search=Search';
										var baseUrl = window.location.origin + window.location.pathname;

										window.location.href = baseUrl + newParams;



									})
								})




							},

							error: function (xhr, status, error) {
								console.error('Error occurred:', error);
							}
						});

					})

				})
			</script>
			<!-- <script type="text/javascript">
			jQuery(document).ready(function ($) {
				var userData = <?php echo json_encode($user_data); ?>;

				jQuery("#search_user_section").autocomplete({
					source: userData,  // Use the PHP array as the source for autocomplete
					select: function (event, ui) {
						console.log("Selected: " + ui.item.label + " with ID " + ui.item.value); // Debugging line
						// Set the value of the hidden input fields with the selected user's ID and level
						jQuery("#search_user_id").val(ui.item.value);
						jQuery("#search_user_level").val(ui.item.user_level);
						// Display the selected user's name and ID in the input field
						jQuery("#search_user_section").val(ui.item.label);
						return false; // Prevent the default behavior of the autocomplete
					}
				});

				// Custom CSS to increase z-index of autocomplete suggestions
				jQuery('<style>')
					.prop('type', 'text/css')
					.html('\n\
					.ui-autocomplete { \n\
						z-index: 999999 !important; \n\
					} \n\
				')
					.appendTo('head');
			});
		</script> -->
		<?php } ?>
		<?php do_action('woocommerce_after_single_product'); ?>