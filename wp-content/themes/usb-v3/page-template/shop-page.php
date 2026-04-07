<?php
/**
 * Template Name: Shop Page
 * Description: Shop Page template full width.
 *
 */
get_header(); ?>

<section class="shop_page new-shop-page grid-view-wrap">

    <div class="container">
        <div class="bredCrumb_shop">
            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb(array(
                    'delimiter' => ' &raquo; ', // Arrow separator
                    'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
                    'wrap_after' => '</nav>',
                    'before' => '',
                    'after' => '',
                    'home' => _x('Home', 'breadcrumb', 'woocommerce'),
                ));
            }
            ?>
        </div>
        <div class="row">
            <div class="col-lg-4">

                <select class="usb_cat_select" multiple="multiple">
                    <?php
                    $taxonomy = 'product_cat';
                    $orderby = 'name';
                    $show_count = false;      // 1 for count
                    $pad_counts = false;      // 1 for hierarchical
                    $hierarchical = true;       // 1 for parent-child
                    $title = '';
                    $empty = true;

                    $args = array(
                        'taxonomy' => $taxonomy,
                        'orderby' => $orderby,
                        'show_count' => $show_count,
                        'pad_counts' => $pad_counts,
                        'hierarchical' => $hierarchical,
                        'title_li' => $title,
                        'hide_empty' => $empty,
                    );

                    $product_categories = get_categories($args);

                    foreach ($product_categories as $category) { ?>

                        <option value="<?php echo $category->term_id ?>" data-badge=""><?php echo $category->name ?>
                        </option>

                    <?php } ?>
                </select>
            </div>
            <div class="col-lg-8 mt-lg-0 mt-4">
                <div class="rgt-product-sc position-relative">
                    <div class="loader-full text-center" id="loader-full"  bis_skin_checked="1">
                      
                           
                            <div bis_skin_checked="1">
                                <div class="loader-gif mt-5" bis_skin_checked="1"></div>
                            </div>
                        
                    </div>
               <h2 class="mb-4 heading-product">Shop</h2>
                        <div class="filter_form d-flex align-items-center justify-content-end">
                            <div class="featured-box d-flex align-items-center">
                                <p class="mb-0">Sort by:</p>

                                <!-- <div class=""> -->
                                <select id="orderby" name="orderby">
                                    <option value="menu_order">Default sorting</option>
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="rating">Sort by average rating</option>
                                    <option value="date">Sort by latest</option>
                                    <option value="date_asc">Sort by oldest</option>
                                    <option value="title_asc">Sort by: Alphabetically, A-Z</option>
                                    <option value="title_desc">Sort by: Alphabetically, Z-A</option>
                                    <option value="price">Sort by price: low to high</option>
                                    <option value="price-desc">Sort by price: high to low</option>
                                </select>

                                <!-- </div> -->

                            </div>
                            <div class="view-list d-flex align-items-center ">
                                <p class="mb-0">View:</p>
                                <button type="button" class="me-2" id="list-view"><img
                                        src="<?php echo get_template_directory_uri() . '/images/icon1.png'; ?>" />
                                </button>
                                <button type="button" id="grid-view"><img
                                        src="<?php echo get_template_directory_uri() . '/images/icon2.png'; ?>" />
                                </button>
                            </div>
                        </div>
                <div id="product_content" class="products columns-3">
                    <?php
                    $customPaged = $_REQUEST['p'] ? $_REQUEST['p'] : "1";
                    $orderby_value = $_GET['orderby'] ?? 'menu_order';
                    // $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : floatval(1);
                    // $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : floatval(500);
                    
                    // Default variables
                    $orderby = 'menu_order';
                    $order = 'ASC';
                    $meta_key = '';
                    //$meta_query = [];
                    
                    $meta_args = array('relation' => 'AND');


                    // if(!empty($min_price) && !empty($max_price)){
                    //     $meta_args[] = array(
                    //         'key'     => '_price',
                    //         'value'   => array((int) $min_price, (int) $max_price),
                    //         'type'    => 'numeric',
                    //         'compare' => 'BETWEEN',
                    //     );
                    
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
                        'meta_query' => $meta_args,
                        // 'tax_query' => $tax_args,
                        'orderby' => $orderby,
                        'order' => $order,
                    );

                    $query = new WP_Query($args);

                    if ($query->have_posts()) { ?>

                        <!-- <div class="products-count"> Products</div> -->
                        <input type="hidden" id="found_post" value="<?php echo $query->found_posts; ?>">


                        <?php while ($query->have_posts()) {
                            $query->the_post();
                            //wc_get_template_part('content', 'product');
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
                                                                    
                        
                            <div <?php post_class($class); ?> >
                                		<?php 
                                    // $field_id_value_popular = get_post_meta(get_the_ID(), 'field_id_popular', true);
		                            // $field_id_value_new = get_post_meta(get_the_ID(), 'field_id_new', true);
                                    // $field_id_value_custom = get_post_meta($post->ID, '_custom_badges', true);
                                    // $field_id_value_custom_name = get_post_meta($post->ID, '_custom_badges_name', true);
									// $custom_badges_color = get_post_meta($post->ID, '_custom_badges_color', true);
		 
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
                                    $field_id_value_popular = get_post_meta($post->ID, 'field_id_popular', true);
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
                                    $field_id_value_new = get_post_meta($post->ID, 'field_id_new', true);
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
                            <?php
                        }
                    }

                    // $total_pages = $query->max_num_pages;
                    // $current_page = max(1, intval($customPaged));

                    // // Pagination
                    // if ($total_pages > 1) {
                    //     echo '<div class="custom-pagination">';

                    //     if ($page > 1) {
                    //         echo '<a href="#" class="page-link prev" data-page="' . ($page - 1) . '">&laquo; Prev</a>';
                    //     }

                    //     $range = 2;
                    //     $start_range = max(1, $page - $range);
                    //     $end_range = min($total_pages, $page + $range);

                    //     if ($start_range > 1) {
                    //         echo '<a href="#" class="page-link" data-page="1">1</a>';
                    //         if ($start_range > 2) {
                    //             echo '<span class="dots">...</span>';
                    //         }
                    //     }

                    //     for ($i = $start_range; $i <= $end_range; $i++) {
                    //         echo '<a href="#" class="page-link' . ($i == $page ? ' active' : '') . '" data-page="' . $i . '">' . $i . '</a>';
                    //     }

                    //     if ($end_range < $total_pages) {
                    //         if ($end_range < $total_pages - 1) {
                    //             echo '<span class="dots">...</span>';
                    //         }
                    //         echo '<a href="#" class="page-link" data-page="' . $total_pages . '">' . $total_pages . '</a>';
                    //     }

                    //     if ($page < $total_pages) {
                    //         echo '<a href="#" class="page-link next" data-page="' . ($page + 1) . '">Next &raquo;</a>';
                    //     }

                    //     echo '</div>';
                    // }

                    wp_reset_postdata();
                    ?>

                </div>
            </div> </div>

        </div>
    </div>
    </div>




</section>
<script>
    jQuery(document).ready(function ($) {

        var siteurl = '<?php home_url(); ?>';

 var container = $('#product_content'); // replace with your actual container

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
        newCustomItems,
        popularNewItems,
        popularCustomItems,
         newItems,
        popularItems,
        customItems,
        otherItems
    );



        $(".usb_cat_select").select2({
            closeOnSelect: false,
            placeholder: "Search Categories",
            allowClear: true,
            tags: true
        });

        if ($(window).width() > 1200) {
            setTimeout(function () {
                // Open the Select2 dropdown
                $(".usb_cat_select").select2("open");

                // Focus the search field after a slight delay to ensure the dropdown is rendered
                setTimeout(function () {
                    $(".select2-search__field")
                        .val('')
                        .trigger('input')
                        .focus();
                }, 50);
            }, 100); // Initial delay to ensure Select2 is fully initialized
        }

        $(".loader-full").addClass('d-none');

        $(".usb_cat_select").on('change', function (e) {
            var selectedValues = $(this).val(); // Get selected value(s)
            console.log(selectedValues);
            var sortOrder = $("#orderby").val();
            $(".loader-full").removeClass('d-none');
            $.ajax({
                url: siteurl + '/usb/wp-admin/admin-ajax.php',

                data: {
                    'action': 'shop_filters',
                    'orderby': sortOrder,
                    'catId': selectedValues,
                },

                type: 'post',
                success: function (result) {
                    //console.log(result);
                    $("#product_content").html('');
                    $("#product_content").html(result);

                    $(".containAll").addClass('d-none');

                    $(".loader-full").addClass('d-none');
                    // Create a temporary DOM element to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = result;

                    // Find the input element with id="found_post"
                    const foundPostInput = tempDiv.querySelector('#found_post');

                    // Get the value attribute
                    const foundPostValue = foundPostInput ? foundPostInput.value : null;


                    // var nop = getData.find("#found_post").text();
                    console.log(foundPostValue);
                    $(".dropdown-box").css('display', 'none');

                    $(".custom-pagination").each(function () {

                        $(this).find('.page-link').on('click', function (e) {
                            e.preventDefault();
                            var pageNo = $(this).attr('data-page');
                            var sortOrder = $("#orderby").val();
                            var catIds = $(".usb_cat_select").val();
                            // console.log(pageNo);


                            $.ajax({
                                url: siteurl + '/usb/wp-admin/admin-ajax.php',

                                data: {
                                    'action': 'shop_filters',
                                    'orderby': sortOrder,
                                    'catId': catIds,
                                    'p': pageNo
                                },

                                type: 'post',
                                success: function (result) {
                                    //console.log(result);
                                    $("#product_content").html('');
                                    $("#product_content").html(result);

                                    $(".containAll").addClass('d-none');
                                    $(".loader-full").addClass('d-none');

                                    var container = $('#product_content'); // replace with your actual container

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
                                        newCustomItems,
                                        popularNewItems,
                                        popularCustomItems,
                                         newItems,
                                        popularItems,
                                        customItems,
                                        otherItems
                                    );

                                    // Create a temporary DOM element to parse the HTML
                                    const tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = result;

                                    // Find the input element with id="found_post"
                                    const foundPostInput = tempDiv.querySelector('#found_post');

                                    // Get the value attribute
                                    const foundPostValue = foundPostInput ? foundPostInput.value : null;


                                    // var nop = getData.find("#found_post").text();
                                    console.log(foundPostValue);
                                    $(".dropdown-box").css('display', 'none');
                                    //location.reload();
                                },
                                error: function (result) {
                                    console.warn(result);

                                }, complete: function () {
                                    $(".material-loader").hide();
                                }
                            })
                        })

                    })
                    //location.reload();
                },
                error: function (result) {
                    console.warn(result);

                }, complete: function () {
                    $(".material-loader").hide();
                }
            })
        });



        $("#orderby").on('change', function (e) {
            e.preventDefault();
            var sortOrder = $(this).val();
            var catIds = $(".usb_cat_select").val();
            $(".loader-full").removeClass('d-none');

            $.ajax({
                url: siteurl + '/usb/wp-admin/admin-ajax.php',

                data: {
                    'action': 'shop_filters',
                    'orderby': sortOrder,
                    'catId': catIds,
                },

                type: 'post',
                success: function (result) {
                    //console.log(result);
                    $("#product_content").html('');
                    $("#product_content").html(result);

                         var container = $('#product_content'); // replace with your actual container

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


                    $(".containAll").addClass('d-none');
                    $(".loader-full").addClass('d-none');


                    // Create a temporary DOM element to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = result;

                    // Find the input element with id="found_post"
                    const foundPostInput = tempDiv.querySelector('#found_post');

                    // Get the value attribute
                    const foundPostValue = foundPostInput ? foundPostInput.value : null;


                    // var nop = getData.find("#found_post").text();
                    console.log(foundPostValue);
                    $(".dropdown-box").css('display', 'none');
                    //location.reload();

                    $(".custom-pagination").each(function () {

                        $(this).find('.page-link').on('click', function (e) {
                            e.preventDefault();
                            var pageNo = $(this).attr('data-page');
                            var sortOrder = $("#orderby").val();
                            var catIds = $(".usb_cat_select").val();
                            // console.log(pageNo);


                            $.ajax({
                                url: siteurl + '/usb/wp-admin/admin-ajax.php',

                                data: {
                                    'action': 'shop_filters',
                                    'orderby': sortOrder,
                                    'catId': catIds,
                                    'p': pageNo
                                },

                                type: 'post',
                                success: function (result) {
                                    //console.log(result);
                                    $("#product_content").html('');
                                    $("#product_content").html(result);

                                    $(".containAll").addClass('d-none');


                                    // Create a temporary DOM element to parse the HTML
                                    const tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = result;

                                    // Find the input element with id="found_post"
                                    const foundPostInput = tempDiv.querySelector('#found_post');

                                    // Get the value attribute
                                    const foundPostValue = foundPostInput ? foundPostInput.value : null;


                                    // var nop = getData.find("#found_post").text();
                                    console.log(foundPostValue);
                                    $(".dropdown-box").css('display', 'none');
                                    //location.reload();
                                },
                                error: function (result) {
                                    console.warn(result);

                                }, complete: function () {
                                    $(".material-loader").hide();
                                }
                            })
                        })

                    })
                },
                error: function (result) {
                    console.warn(result);

                }, complete: function () {
                    $(".material-loader").hide();
                }
            })

        })


        $(".custom-pagination").each(function () {

            $(this).find('.page-link').on('click', function (e) {
                e.preventDefault();
                var pageNo = $(this).attr('data-page');
                var sortOrder = $("#orderby").val();
                var catIds = $(".usb_cat_select").val();
                // console.log(pageNo);


                $.ajax({
                    url: siteurl + '/usb/wp-admin/admin-ajax.php',

                    data: {
                        'action': 'shop_filters',
                        'orderby': sortOrder,
                        'catId': catIds,
                        'p': pageNo
                    },

                    type: 'post',
                    success: function (result) {
                        //console.log(result);
                        $("#product_content").html('');
                        $("#product_content").html(result);

                        $(".containAll").addClass('d-none');


                        // Create a temporary DOM element to parse the HTML
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = result;

                        // Find the input element with id="found_post"
                        const foundPostInput = tempDiv.querySelector('#found_post');

                        // Get the value attribute
                        const foundPostValue = foundPostInput ? foundPostInput.value : null;


                        // var nop = getData.find("#found_post").text();
                        console.log(foundPostValue);
                        $(".dropdown-box").css('display', 'none');
                        //location.reload();
                    },
                    error: function (result) {
                        console.warn(result);

                    }, complete: function () {
                        $(".material-loader").hide();
                    }
                })
            })

        })



        $('#list-view').click(function () {
            $('.new-shop-page').removeClass('grid-view-wrap');
            $('.new-shop-page').addClass('list-view-wrap');
        });
        $('#grid-view').click(function () {
            $('.new-shop-page').removeClass('list-view-wrap');
            $('.new-shop-page').addClass('grid-view-wrap');
        });



    })
</script>
<?php
get_footer();
?>