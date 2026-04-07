<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>


<div  <?php post_class('col-lg-6'); ?> style="">
<?php
 $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
                             $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
                             $field_id_value_custom = get_post_meta($post->ID, '_custom_badges', true);
                             $field_id_value_custom_name = get_post_meta($post->ID, '_custom_badges_name', true);
                             $custom_badges_color = get_post_meta($post->ID, '_custom_badges_color', true);

                                    
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
                                                                    
                           <?php 
                                    $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
                                    $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
                                    $field_id_value_custom = get_post_meta($post->ID, '_custom_badges', true);
                                    $field_id_value_custom_name = get_post_meta($post->ID, '_custom_badges_name', true);
                                    $custom_badges_color = get_post_meta($post->ID, '_custom_badges_color', true);
         
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
                                        <div class="upper-section-<?php echo $class; ?>">
                                    <?php
                                    $field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);
                                    //if// (!empty($field_id_value_popular)) { ?>
                                        <span class="tag-sky">
                                            <?php _e('Popular', 'usb'); ?>
                                        </span>
                                    <?php //} ?>

                                    <?php
                                   
                                   // if (!empty($field_id_value_custom) && $field_id_value_custom == 'yes' && $field_id_value_custom_name) { 
                                    ?>
                                        <!-- <span class="tag-sky tag_custom" style="background:<?php echo $custom_badges_color; ?> !important">
                                            <?php// _e($field_id_value_custom_name, 'usb'); ?>
                                        </span> -->
                                    <?php //} ?>

                                    <?php
                                   // $field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);
                                   // if (!empty($field_id_value_new)) { ?>
                                        <!-- <span class="tag-red">
                                            <?php //_e('New', 'usb'); ?>
                                        </span> -->
                                    <?php //} ?>
                                </div>

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
                                                <img src="<?php echo esc_url($second_image_url); ?>"
                                                    alt="<?php the_title_attribute(); ?>" class="secondary-image"
                                                    style="display: none;" />
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

                                <?php
                                do_action('woocommerce_after_shop_loop_item');
                                ?>
                                </div>
                            </div>

<script>
    jQuery().ready(function(){ 

        var container = $('.most_propular_product'); // replace with your actual container

        var popularItems = container.children('.popular:not(.new):not(.custom)');
        var newItems = container.children('.new:not(.popular):not(.custom)');
        var customItems = container.children('.custom:not(.popular):not(.new)');
        var popularNewItems = container.children('.popular.new:not(.custom)');
        var popularCustomItems = container.children('.popular.custom:not(.new)');
        var newCustomItems = container.children('.new.custom:not(.popular)');
        var allThreeItems = container.children('.popular.new.custom');

        // any other items not having any of those three classes
        var otherItems = container.children().filter(function () {
            return !$(this).hasClass('popular') && !$(this).hasClass('new') && !$(this).hasClass('custom');
        });

        // clear and re-append in desired order
        container.append(
            allThreeItems,
            popularNewItems,
            popularCustomItems,
            newCustomItems,
            popularItems,
            newItems,
            customItems,
            otherItems
        );

    });
</script>

