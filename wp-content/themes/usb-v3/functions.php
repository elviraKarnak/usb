<?php
// This file is part of the USB Theme 
$theme_customizer = __DIR__ . '/inc/customizer.php';
if (is_readable($theme_customizer)) {
    require_once $theme_customizer;
}
if (!function_exists('usb_v2_setup_theme')) {
    /**
     * General Theme Settings.
     *
     * @since v1.0
     *
     * @return void
     */
    function usb_v2_setup_theme()
    {
        // Make theme available for translation: Translations can be filed in the /languages/ directory.
        load_theme_textdomain('usb-v2', __DIR__ . '/languages');

        /**
         * Set the content width based on the theme's design and stylesheet.
         *
         * @since v1.0
         */
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 800;
        }

        // Theme Support.
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'script',
                'style',
                'navigation-widgets',
            )
        );

        // Add support for Block Styles.
        add_theme_support('wp-block-styles');
        // Add support for full and wide alignment.
        add_theme_support('align-wide');
        // Add support for Editor Styles.
        add_theme_support('editor-styles');

        add_theme_support('custom-logo'); // Header Logo 

        // Enqueue Editor Styles.
        add_editor_style('style-editor.css');

        // Default attachment display settings.
        update_option('image_default_align', 'none');
        update_option('image_default_link_type', 'none');
        update_option('image_default_size', 'large');

        // Custom CSS styles of WorPress gallery.
        add_filter('use_default_gallery_style', '__return_false');
    }
    add_action('after_setup_theme', 'usb_v2_setup_theme');

    // Disable Block Directory: https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/filters/editor-filters.md#block-directory
    remove_action('enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets');
    remove_action('enqueue_block_editor_assets', 'gutenberg_enqueue_block_editor_assets_block_directory');
}

if (!function_exists('wp_body_open')) {
    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     * @since v2.2
     *
     * @return void
     */
    function wp_body_open()
    {
        do_action('wp_body_open');
    }
}

if (!function_exists('usb_v2_add_user_fields')) {
    /**
     * Add new User fields to Userprofile:
     * get_user_meta( $user->ID, 'facebook_profile', true );
     *
     * @since v1.0
     *
     * @param array $fields User fields.
     *
     * @return array
     */
    function usb_v2_add_user_fields($fields)
    {
        // Add new fields.
        $fields['facebook_profile'] = 'Facebook URL';
        $fields['twitter_profile'] = 'Twitter URL';
        $fields['linkedin_profile'] = 'LinkedIn URL';
        $fields['xing_profile'] = 'Xing URL';
        $fields['github_profile'] = 'GitHub URL';

        return $fields;
    }
    add_filter('user_contactmethods', 'usb_v2_add_user_fields');
}

/**
 * Test if a page is a blog page.
 * if ( is_blog() ) { ... }
 *
 * @since v1.0
 *
 * @return bool
 */
function is_blog()
{
    global $post;
    $posttype = get_post_type($post);

    return ((is_archive() || is_author() || is_category() || is_home() || is_single() || (is_tag() && ('post' === $posttype))) ? true : false);
}

/**
 * Disable comments for Media (Image-Post, Jetpack-Carousel, etc.)
 *
 * @since v1.0
 *
 * @param bool $open    Comments open/closed.
 * @param int  $post_id Post ID.
 *
 * @return bool
 */
function usb_v2_filter_media_comment_status($open, $post_id = null)
{
    $media_post = get_post($post_id);

    if ('attachment' === $media_post->post_type) {
        return false;
    }

    return $open;
}
add_filter('comments_open', 'usb_v2_filter_media_comment_status', 10, 2);

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Post Edit Link.
 *
 * @return string
 */
function usb_v2_custom_edit_post_link($link)
{
    return str_replace('class="post-edit-link"', 'class="post-edit-link badge bg-secondary"', $link);
}
add_filter('edit_post_link', 'usb_v2_custom_edit_post_link');

/**
 * Style Edit buttons as badges: https://getbootstrap.com/docs/5.0/components/badge
 *
 * @since v1.0
 *
 * @param string $link Comment Edit Link.
 */
function usb_v2_custom_edit_comment_link($link)
{
    return str_replace('class="comment-edit-link"', 'class="comment-edit-link badge bg-secondary"', $link);
}
add_filter('edit_comment_link', 'usb_v2_custom_edit_comment_link');

/**
 * Responsive oEmbed filter: https://getbootstrap.com/docs/5.0/helpers/ratio
 *
 * @since v1.0
 *
 * @param string $html Inner HTML.
 *
 * @return string
 */
function usb_v2_oembed_filter($html)
{
    return '<div class="ratio ratio-16x9">' . $html . '</div>';
}
add_filter('embed_oembed_html', 'usb_v2_oembed_filter', 10);

if (!function_exists('usb_v2_content_nav')) {
    /**
     * Display a navigation to next/previous pages when applicable.
     *
     * @since v1.0
     *
     * @param string $nav_id Navigation ID.
     */
    function usb_v2_content_nav($nav_id)
    {
        global $wp_query;

        if ($wp_query->max_num_pages > 1) {
            ?>
            <div id="<?php echo esc_attr($nav_id); ?>" class="d-flex mb-4 justify-content-between">
                <div><?php next_posts_link('<span aria-hidden="true">←</span> ' . esc_html__('Older posts', 'usb-v2')); ?>
                </div>
                <div>
                    <?php previous_posts_link(esc_html__('Newer posts', 'usb-v2') . ' <span aria-hidden="true">→</span>'); ?>
                </div>
            </div><!-- /.d-flex -->
            <?php
        } else {
            echo '<div class="clearfix"></div>';
        }
    }

    /**
     * Add Class.
     *
     * @since v1.0
     *
     * @return string
     */
    function posts_link_attributes()
    {
        return 'class="btn btn-secondary btn-lg"';
    }
    add_filter('next_posts_link_attributes', 'posts_link_attributes');
    add_filter('previous_posts_link_attributes', 'posts_link_attributes');
}

/**
 * Init Widget areas in Sidebar.
 *
 * @since v1.0
 *
 * @return void
 */
function usb_v2_widgets_init()
{
    // Area 1.
    register_sidebar(
        array(
            'name' => 'Primary Widget Area (Sidebar)',
            'id' => 'primary_widget_area',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );

    // Area 2.
    register_sidebar(
        array(
            'name' => 'Secondary Widget Area (Header Navigation)',
            'id' => 'secondary_widget_area',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );

    // Area 3.
    register_sidebar(
        array(
            'name' => 'Third Widget Area (Footer)',
            'id' => 'third_widget_area',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}
add_action('widgets_init', 'usb_v2_widgets_init');

if (!function_exists('usb_v2_article_posted_on')) {
    /**
     * "Theme posted on" pattern.
     *
     * @since v1.0
     */
    function usb_v2_article_posted_on()
    {
        printf(
            wp_kses_post(__('<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author-meta vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'usb-v2')),
            esc_url(get_the_permalink()),
            esc_attr(get_the_date() . ' - ' . get_the_time()),
            esc_attr(get_the_date('c')),
            esc_html(get_the_date() . ' - ' . get_the_time()),
            esc_url(get_author_posts_url((int) get_the_author_meta('ID'))),
            sprintf(esc_attr__('View all posts by %s', 'usb-v2'), get_the_author()),
            get_the_author()
        );
    }
}

/**
 * Template for Password protected post form.
 *
 * @since v1.0
 *
 * @return string
 */
function usb_v2_password_form()
{
    global $post;
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);

    $output = '<div class="row">';
    $output .= '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">';
    $output .= '<h4 class="col-md-12 alert alert-warning">' . esc_html__('This content is password protected. To view it please enter your password below.', 'usb-v2') . '</h4>';
    $output .= '<div class="col-md-6">';
    $output .= '<div class="input-group">';
    $output .= '<input type="password" name="post_password" id="' . esc_attr($label) . '" placeholder="' . esc_attr__('Password', 'usb-v2') . '" class="form-control" />';
    $output .= '<div class="input-group-append"><input type="submit" name="submit" class="btn btn-primary" value="' . esc_attr__('Submit', 'usb-v2') . '" /></div>';
    $output .= '</div><!-- /.input-group -->';
    $output .= '</div><!-- /.col -->';
    $output .= '</form>';
    $output .= '</div><!-- /.row -->';

    return $output;
}
add_filter('the_password_form', 'usb_v2_password_form');
if (!function_exists('usb_v2_comment')) {
    /**
     * Style Reply link.
     *
     * @since v1.0
     *
     * @param string $class Link class.
     *
     * @return string
     */
    function usb_v2_replace_reply_link_class($class)
    {
        return str_replace("class='comment-reply-link", "class='comment-reply-link btn btn-outline-secondary", $class);
    }
    add_filter('comment_reply_link', 'usb_v2_replace_reply_link_class');

    /**
     * Template for comments and pingbacks:
     * add function to comments.php ... wp_list_comments( array( 'callback' => 'usb_v2_comment' ) );
     *
     * @since v1.0
     *
     * @param object $comment Comment object.
     * @param array  $args    Comment args.
     * @param int    $depth   Comment depth.
     */
    function usb_v2_comment($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type):
            case 'pingback':
            case 'trackback':
                ?>
                <li class="post pingback">
                    <p>
                        <?php
                        esc_html_e('Pingback:', 'usb-v2');
                        comment_author_link();
                        edit_comment_link(esc_html__('Edit', 'usb-v2'), '<span class="edit-link">', '</span>');
                        ?>
                    </p>
                    <?php
                    break;
            default:
                ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                    <article id="comment-<?php comment_ID(); ?>" class="comment">
                        <footer class="comment-meta">
                            <div class="comment-author vcard">
                                <?php
                                $avatar_size = ('0' !== $comment->comment_parent ? 68 : 136);
                                echo get_avatar($comment, $avatar_size);

                                /* Translators: 1: Comment author, 2: Date and time */
                                printf(
                                    wp_kses_post(__('%1$s, %2$s', 'usb-v2')),
                                    sprintf('<span class="fn">%s</span>', get_comment_author_link()),
                                    sprintf(
                                        '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                                        esc_url(get_comment_link($comment->comment_ID)),
                                        get_comment_time('c'),
                                        /* Translators: 1: Date, 2: Time */
                                        sprintf(esc_html__('%1$s ago', 'usb-v2'), human_time_diff((int) get_comment_time('U'), current_time('timestamp')))
                                    )
                                );

                                edit_comment_link(esc_html__('Edit', 'usb-v2'), '<span class="edit-link">', '</span>');
                                ?>
                            </div><!-- .comment-author .vcard -->

                            <?php if ('0' === $comment->comment_approved) { ?>
                                <em class="comment-awaiting-moderation">
                                    <?php esc_html_e('Your comment is awaiting moderation.', 'usb-v2'); ?>
                                </em>
                                <br />
                            <?php } ?>
                        </footer>

                        <div class="comment-content"><?php comment_text(); ?></div>

                        <div class="reply">
                            <?php
                            comment_reply_link(
                                array_merge(
                                    $args,
                                    array(
                                        'reply_text' => esc_html__('Reply', 'usb-v2') . ' <span>↓</span>',
                                        'depth' => $depth,
                                        'max_depth' => $args['max_depth'],
                                    )
                                )
                            );
                            ?>
                        </div><!-- /.reply -->
                    </article><!-- /#comment-## -->
                    <?php
                    break;
        endswitch;
    }

    /**
     * Custom Comment form.
     *
     * @since v1.0
     * @since v1.1: Added 'submit_button' and 'submit_field'
     * @since v2.0.2: Added '$consent' and 'cookies'
     *
     * @param array $args    Form args.
     * @param int   $post_id Post ID.
     *
     * @return array
     */
    function usb_v2_custom_commentform($args = array(), $post_id = null)
    {
        if (null === $post_id) {
            $post_id = get_the_ID();
        }

        $commenter = wp_get_current_commenter();
        $user = wp_get_current_user();
        $user_identity = $user->exists() ? $user->display_name : '';

        $args = wp_parse_args($args);

        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true' required" : '');
        $consent = (empty($commenter['comment_author_email']) ? '' : ' checked="checked"');
        $fields = array(
            'author' => '<div class="form-floating mb-3">
                            <input type="text" id="author" name="author" class="form-control" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . esc_html__('Name', 'usb-v2') . ($req ? '*' : '') . '"' . $aria_req . ' />
                            <label for="author">' . esc_html__('Name', 'usb-v2') . ($req ? '*' : '') . '</label>
                        </div>',
            'email' => '<div class="form-floating mb-3">
                            <input type="email" id="email" name="email" class="form-control" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . esc_html__('Email', 'usb-v2') . ($req ? '*' : '') . '"' . $aria_req . ' />
                            <label for="email">' . esc_html__('Email', 'usb-v2') . ($req ? '*' : '') . '</label>
                        </div>',
            'url' => '',
            'cookies' => '<p class="form-check mb-3 comment-form-cookies-consent">
                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="form-check-input" type="checkbox" value="yes"' . $consent . ' />
                            <label class="form-check-label" for="wp-comment-cookies-consent">' . esc_html__('Save my name, email, and website in this browser for the next time I comment.', 'usb-v2') . '</label>
                        </p>',
        );

        $defaults = array(
            'fields' => apply_filters('comment_form_default_fields', $fields),
            'comment_field' => '<div class="form-floating mb-3">
                                            <textarea id="comment" name="comment" class="form-control" aria-required="true" required placeholder="' . esc_attr__('Comment', 'usb-v2') . ($req ? '*' : '') . '"></textarea>
                                            <label for="comment">' . esc_html__('Comment', 'usb-v2') . '</label>
                                        </div>',
            /** This filter is documented in wp-includes/link-template.php */
            'must_log_in' => '<p class="must-log-in">' . sprintf(wp_kses_post(__('You must be <a href="%s">logged in</a> to post a comment.', 'usb-v2')), wp_login_url(esc_url(get_the_permalink(get_the_ID())))) . '</p>',
            /** This filter is documented in wp-includes/link-template.php */
            'logged_in_as' => '<p class="logged-in-as">' . sprintf(wp_kses_post(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'usb-v2')), get_edit_user_link(), $user->display_name, wp_logout_url(apply_filters('the_permalink', esc_url(get_the_permalink(get_the_ID()))))) . '</p>',
            'comment_notes_before' => '<p class="small comment-notes">' . esc_html__('Your Email address will not be published.', 'usb-v2') . '</p>',
            'comment_notes_after' => '',
            'id_form' => 'commentform',
            'id_submit' => 'submit',
            'class_submit' => 'btn btn-primary',
            'name_submit' => 'submit',
            'title_reply' => '',
            'title_reply_to' => esc_html__('Leave a Reply to %s', 'usb-v2'),
            'cancel_reply_link' => esc_html__('Cancel reply', 'usb-v2'),
            'label_submit' => esc_html__('Post Comment', 'usb-v2'),
            'submit_button' => '<input type="submit" id="%2$s" name="%1$s" class="%3$s" value="%4$s" />',
            'submit_field' => '<div class="form-submit">%1$s %2$s</div>',
            'format' => 'html5',
        );

        return $defaults;
    }
    add_filter('comment_form_defaults', 'usb_v2_custom_commentform');
}

if (function_exists('register_nav_menus')) {
    /**
     * Nav menus.
     *
     * @since v1.0
     *
     * @return void
     */
    register_nav_menus(
        array(
            'main-menu' => 'Main Navigation Menu',
            'footer-menu' => 'Footer Menu',
            'footer1' => 'Footer Service Menu',
            'footer2' => 'Footer About Menu',
            'footer3' => 'Footer Privacy Menu',
            'cat_1' => 'Category Menu 1',
            'cat_2' => 'Category Menu 2',
            'cat_3' => 'Category Menu 3',
            'cat_4' => 'Category Menu 4',
            'cat_5' => 'Category Menu 5',
        )
    );
}

// Custom Nav Walker: wp_bootstrap_navwalker().
$custom_walker = __DIR__ . '/inc/wp-bootstrap-navwalker.php';
if (is_readable($custom_walker)) {
    require_once $custom_walker;
}

$custom_walker_footer = __DIR__ . '/inc/wp-bootstrap-navwalker-footer.php';
if (is_readable($custom_walker_footer)) {
    require_once $custom_walker_footer;
}

/**
 * Loading All CSS Stylesheets and Javascript Files.
 *
 * @since v1.0
 *
 * @return void
 */
function usb_v2_scripts_loader()
{
    $theme_version = time();
    // 1. Styles.
    wp_enqueue_style('bootstrap', get_theme_file_uri('assets/css/bootstrap.min.css'), array(), $theme_version, 'all');
    wp_enqueue_style('owl.carousel', get_theme_file_uri('assets/css/owl.carousel.min.css'), array(), $theme_version, 'all');
    wp_enqueue_style('fancybox', get_theme_file_uri('assets/css/jquery.fancybox.css'), array(), $theme_version, 'all');
    wp_enqueue_style('style', get_theme_file_uri('style.css'), array(), $theme_version, 'all');
    wp_enqueue_style('main', get_theme_file_uri('assets/dist/main.css'), array(), $theme_version, 'all'); // main.scss: Compiled Framework source + custom styles.
    wp_enqueue_style('awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), $theme_version, 'all');
    wp_enqueue_style('select_2_bootstrap_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css', array(), $theme_version, 'all');
    wp_enqueue_style('select_2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css', array(), $theme_version, 'all');
    wp_enqueue_style('main_style', get_theme_file_uri('assets/css/style.css'), array(), $theme_version, 'all');
    wp_enqueue_style('dev_style', get_theme_file_uri('assets/css/dev_style.css'), array(), $theme_version, 'all');
    wp_enqueue_style('slick', get_theme_file_uri('assets/css/slick.css'), array(), $theme_version, 'all');
    wp_enqueue_style('main_responsive', get_theme_file_uri('assets/css/responsive.css'), array(), $theme_version, 'all');
    wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css', array(), $theme_version, 'all');
    wp_enqueue_style('jquery-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.3/themes/base/jquery-ui.min.css', array(), $theme_version, 'all');



    if (is_rtl()) {
        wp_enqueue_style('rtl', get_theme_file_uri('assets/dist/rtl.css'), array(), $theme_version, 'all');
    }

    // 2. Scripts.
    wp_enqueue_script('mainbundle', get_theme_file_uri('assets/dist/main.bundle.js'), array('jquery'), $theme_version, true);
    //wp_enqueue_script( 'custom-js', get_theme_file_uri( 'assets/js/custom.js' ), array('jquery'), time(), true );

    //wp_enqueue_script( 'jquery', get_theme_file_uri( 'assets/js/jquery-3.6.0.min.js' ), array('jquery'), time(), true );
    wp_enqueue_script('bootstrap', get_theme_file_uri('assets/js/bootstrap.min.js'), array('jquery'), time(), true);
    wp_enqueue_script('owl', get_theme_file_uri('assets/js/owl.carousel.min.js'), array('jquery'), time(), true);
    wp_enqueue_script('slick', get_theme_file_uri('assets/js/slick.min.js'), array('jquery'), time(), true);
    wp_enqueue_script('fancybox-js', get_theme_file_uri('assets/js/jquery.fancybox.js'), array('jquery'), time(), true);
    wp_enqueue_script('select_2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js', array('jquery'), time(), true);
    wp_enqueue_script('main_js', get_theme_file_uri('assets/js/main.js'), array('jquery'), time(), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script('jquery-ui-autocomplete');
}
add_action('wp_enqueue_scripts', 'usb_v2_scripts_loader');


/*** acf page options ***/

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Header', // Set your desired page title
        'menu_title' => 'Header', // Set your desired menu title
        'menu_slug' => 'header', // Set a unique menu slug
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-editor-kitchensink', // Set the desired icon URL or use a built-in Dashicon
        'redirect' => false,
    ));

    acf_add_options_page(array(
        'page_title' => 'Footer', // Set your desired page title
        'menu_title' => 'Footer', // Set your desired menu title
        'menu_slug' => 'footer', // Set a unique menu slug
        'capability' => 'edit_posts',
        'icon_url' => 'dashicons-admin-generic', // Set the desired icon URL or use a built-in Dashicon
        'redirect' => false,
    ));

    acf_add_options_page(array(
        'page_title' => 'Membership Level', // Set your desired page title
        'menu_title' => 'Membership Level', // Set your desired menu title
        'menu_slug' => 'membership-level', // Set a unique menu slug
        'icon_url' => 'dashicons-groups', // Set the desired icon URL or use a built-in Dashicon
        'redirect' => false,
    ));
    acf_add_options_page(array(
        'page_title' => 'Theme Translatable Fields', // Set your desired page title
        'menu_title' => 'Theme Translatable Fields', // Set your desired menu title
        'menu_slug' => 'theme-translatable-fields', // Set a unique menu slug
        'icon_url' => 'dashicons-translation', // Set the desired icon URL or use a built-in Dashicon
        'redirect' => false,
    ));

}
$functions_path = get_template_directory() . '/functions/';
$post_type_path = get_template_directory() . '/inc/post-types/';
$post_meta_path = get_template_directory() . '/inc/post-metabox/';
$theme_function_path = get_template_directory() . '/inc/theme-functions/';
require_once($theme_function_path . 'extra-functions.php');
require_once($theme_function_path . 'pdf-functions.php');
require_once($theme_function_path . 'usb-pdf-functions.php');
require_once($theme_function_path . 'margin-pdf-functions.php');
require_once($theme_function_path . 'import-functions.php');
require_once($theme_function_path . 'exportcsv-functions.php');
require_once($theme_function_path . 'shortcode-tab-functions.php');
require_once($theme_function_path . 'cat-video.php');

/*--------------------------------------*/
/* Multipost Thumbnail Functions
/*--------------------------------------*/
//require_once($functions_path.'multipost-thumbnail/multi-post-thumbnails.php');

/*--------------------------------------*/
/* Optional Panel Helper Functions
/*--------------------------------------*/
require_once($functions_path . 'admin-functions.php');
require_once($functions_path . 'admin-interface.php');
require_once($functions_path . 'theme-options.php');
require_once($functions_path . 'admin_user.php');
function elvirainfotech_ftn_wp_enqueue_scripts()
{
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        if (is_singular() and get_site_option('thread_comments')) {
            wp_print_scripts('comment-reply');
        }
    }
}
add_action('wp_enqueue_scripts', 'elvirainfotech_ftn_wp_enqueue_scripts');
function elvirainfotech_ftn_get_option($name)
{
    $options = get_option('elvirainfotech_ftn_options');
    if (isset($options[$name]))
        return $options[$name];
}
function elvirainfotech_ftn_update_option($name, $value)
{
    $options = get_option('elvirainfotech_ftn_options');
    $options[$name] = $value;
    return update_option('elvirainfotech_ftn_options', $options);
}
function elvirainfotech_ftn_delete_option($name)
{
    $options = get_option('elvirainfotech_ftn_options');
    unset($options[$name]);
    return update_option('elvirainfotech_ftn_options', $options);
}
function get_theme_value($field)
{
    $field1 = elvirainfotech_ftn_get_option($field);
    if (!empty($field1)) {
        $field_val = $field1;
    }
    return $field_val;
}

require_once($post_meta_path . 'taxonomy-image-meta.php');
require_once($post_type_path . 'sliders.php');
require_once($post_meta_path . 'product-metabox.php');
require_once($post_meta_path . 'check-metabox.php');
//require_once($post_type_path.'product-meta.php');
add_image_size('sliders_image_size', 870, 350, true);
/*--------------------------------------*/
/* Theme Helper Functions
/*--------------------------------------*/
// if(!function_exists('elvirainfotech_theme_setup')):
//     function elvirainfotech_theme_setup(){
//         add_theme_support('title-tag');
//         add_theme_support('post-thumbnails');
//         register_nav_menus(array(
//             'primary' => __('Primary Menu','elvirainfotech'),
//             'secondary'  => __('Secondary Menu','elvirainfotech'),
//             ));
//         add_theme_support('html5',array('search-form','comment-form','comment-list','gallery','caption'));
//         }
//     endif;
// add_action('after_setup_theme','elvirainfotech_theme_setup');
// function elvirainfotech_widgets_init(){
//     register_sidebar(array(
//         'name'          => __('Widget Area','elvirainfotech'),
//         'id'            => 'sidebar-1',
//         'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
//         'before_widget' => '<div id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h2 class="widget-title">',
//         'after_title'   => '</h2>',
//         ));
//     register_sidebar(array(
//         'name'          => __('Footer Widget Area','elvirainfotech'),
//         'id'            => 'sidebar-2',
//         'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
//         'before_widget' => '<div id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h2 class="widget-title">',
//         'after_title'   => '</h2>',
//         ));
//     register_sidebar(array(
//         'name'          => __('Footer Widget Area','elvirainfotech'),
//         'id'            => 'sidebar-3',
//         'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
//         'before_widget' => '<div id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h2 class="widget-title">',
//         'after_title'   => '</h2>',
//         ));
//     register_sidebar(array(
//         'name'          => __('Footer Widget Area','elvirainfotech'),
//         'id'            => 'sidebar-4',
//         'description'   => __('Add widgets here to appear in your sidebar.','elvirainfotech'),
//         'before_widget' => '<div id="%1$s" class="widget %2$s">',
//         'after_widget'  => '</div>',
//         'before_title'  => '<h2 class="widget-title">',
//         'after_title'   => '</h2>',
//         ));
//     }
//add_action('widgets_init','elvirainfotech_widgets_init');
function elvirainfotech_scripts()
{

    //     wp_enqueue_style('elvirainfotech-bootstrapmin',get_template_directory_uri().'/css/bootstrap.min.css',array());
//     wp_enqueue_style('elvirainfotech-owlcarousel',get_template_directory_uri().'/css/owl.carousel.min.css',array());
//     wp_enqueue_style('elvirainfotech-fancyboxcss',get_template_directory_uri().'/css/jquery.fancybox.css',array());
//     wp_enqueue_style('elvirainfotech-style',get_template_directory_uri().'/css/style.css',array());
    wp_enqueue_style('elvirainfotech-customs_style', get_template_directory_uri() . '/css/custom.css', array());

    //     wp_enqueue_style('elvirainfotech-fontaewsome',get_template_directory_uri().'/css/font-awesome.css',array());
//     wp_enqueue_style('elvirainfotech-main-style',get_stylesheet_uri());

    //     // Load the Internet Explorer specific script.
//     global $wp_scripts;
//     wp_enqueue_script('elvirainfotech-jsbootstrap',get_template_directory_uri().'/js/bootstrap.min.js',array('jquery'),'20170808',true);
//     wp_enqueue_script('elvirainfotech-jscarousel',get_template_directory_uri().'/js/owl.carousel.min.js',array('jquery'),'20170810',true);
//      wp_enqueue_script('elvirainfotech-fancybox',get_template_directory_uri().'/js/jquery.fancybox.js',array('jquery'),'20170812',true);
//     wp_enqueue_script('elvirainfotech-bootstraphoverdropdown',get_template_directory_uri().'/js/bootstrap-hover-dropdown.min.js',array('jquery'),'20170809',true);
//     wp_enqueue_script( 'elvirainfotech-select2', get_template_directory_uri() . '/js/select2.js', array( 'jquery' ), '20151817', true );

    //     wp_enqueue_script('elvirainfotech-carouselminjs',get_template_directory_uri().'/js/main.js',array('jquery'),'20170811',true);
}

add_action('wp_enqueue_scripts', 'elvirainfotech_scripts');

add_filter('comments_template', 'legacy_comments');
function legacy_comments($file)
{
    if (!function_exists('wp_list_comments'))
        $file = TEMPLATEPATH . '/legacy.comments.php';
    return $file;
}
// Add Theme Woocommerce
add_action('after_setup_theme', 'woocommerce_support');
function woocommerce_support()
{
    add_theme_support('woocommerce');
}

// Ship to a different address opened by default
add_filter('woocommerce_ship_to_different_address_checked', '__return_true');

/// Contents of the builder options product tab.
function builder_product_tabs($tabs)
{

    $tabs['builder'] = array(
        'label' => __('Standard Prices', 'woocommerce'),
        'target' => 'builder_options'

    );
    $tabs['usb_builder'] = array(
        'label' => __('USB', 'woocommerce'),
        'target' => 'usb_builder_options'

    );
    return $tabs;

}
add_filter('woocommerce_product_data_tabs', 'builder_product_tabs');

add_action('woocommerce_product_write_panels', 'builder_write_panel');
function builder_write_panel()
{
    global $woocommerce, $post;
    $product = get_product($post->ID);
    ?>
    <style type="text/css">
        #woocommerce-product-data .inside {width: 100%;}
        table.hide_if_standard.show_if_usb tbody tr td,.dsbl-chk-bx tbody tr td {
            float: left;
            position: relative;
            padding-right: 15px;
        }
    </style>

   <div id='builder_options' class='panel woocommerce_options_panel'>
        <div id="usb_builder" class="usb_builder show_if_standard hide_if_usb">
            <div class='options_group'>
                <p class="toolbar"></p>
                <table class="dsbl-chk-bx">
                    <tr>
                        <th>Disable For Front-End</th>
                    </tr>
                    <?php
                    $show_stnd_qty = json_decode(get_post_meta($post->ID,'_show_stnd_qty',true));
                    ?>                  
                    <tr>
                        <td>1 <input <?php if(!empty($show_stnd_qty) && in_array('1', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="1"></td>
                        <td>25 <input <?php if(!empty($show_stnd_qty) && in_array('25', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="25"></td>
                        <td>50 <input <?php if(!empty($show_stnd_qty) && in_array('50', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="50"></td>
                        <td>100 <input <?php if(!empty($show_stnd_qty) && in_array('100', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="100"></td>
                        <td>250 <input <?php if(!empty($show_stnd_qty) && in_array('250', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="250"></td>
                        <td>500 <input <?php if(!empty($show_stnd_qty) && in_array('500', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="500"></td>
                        <td>1000 <input <?php if(!empty($show_stnd_qty) && in_array('1000', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="1000"></td>
                        <td>2500 <input <?php if(!empty($show_stnd_qty) && in_array('2500', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="2500"></td>
                        <td>5000 <input <?php if(!empty($show_stnd_qty) && in_array('5000', $show_stnd_qty)) {echo "checked";} ?> type="checkbox" name="_show_stnd_qty[]" value="5000"></td>
                    </tr>                    
                </table>            
                
            </div>

            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 1 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 1 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

                <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_1" value="<?php echo get_post_meta($post->ID, '_price_option_1', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/>
                            <input type="radio" name="_active_qty" value="1" <?php if('50'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
                 <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 25 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 25 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>
            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_25" value="<?php echo get_post_meta($post->ID, '_price_option_25', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/>
                            <input type="radio" name="_active_qty" value="25" <?php if('25'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
                 <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 50 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 50 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>
            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_50" value="<?php echo get_post_meta($post->ID, '_price_option_50', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/>
                            <input type="radio" name="_active_qty" value="50" <?php if('50'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 100 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 100 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_100" value="<?php echo get_post_meta($post->ID, '_price_option_100', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="100" <?php if('100'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 250 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 250 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_250" value="<?php echo get_post_meta($post->ID, '_price_option_250', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="250" <?php if('250'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 500 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 500 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_500" value="<?php echo get_post_meta($post->ID, '_price_option_500', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="500" <?php if('500'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 1000 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 1000 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_1000" value="<?php echo get_post_meta($post->ID, '_price_option_1000', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="1000" <?php if('1000'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 2500 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 2500 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_2500" value="<?php echo get_post_meta($post->ID, '_price_option_2500', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/>
                            <input type="radio" name="_active_qty" value="2500" <?php if('2500'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active? 
                        </p>
                    </div>
                </div>      
            </div>
            <div class='options_group'>
                <p class="toolbar">
                    <span class="options_group_h3">
                        <?php _e('Choose 5000 Pcs', 'woocommerce-builder-products'); ?>
                       <?php echo wc_help_tip(__('Please enter 5000 Choose pcs below..', 'woocommerce-builder-products')); ?>
                   </span>             
                </p>
            </div>

            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>                    
                        <p class='form-field'>  
                        <label>Enter Price incl. options </label>                                                              
                            <input type="text" name="_price_option_5000" value="<?php echo get_post_meta($post->ID, '_price_option_5000', true); ?>" style="width:100%;" placeholder="Enter Price incl. options "/> 
                            <input type="radio" name="_active_qty" value="5000" <?php if('5000'==get_post_meta($post->ID, '_active_qty', true)) { echo 'checked';}?> > Active?
                        </p>
                    </div>
                </div>      
            </div>
       
                <div class='options_group'> 
                    <div class='wc-metaboxes'>  
                        <div class='wc-metabox'>  

                            <?php
                            $get_attribute_vl = get_post_meta($post->ID,'attribute_vl',true);
                            $get_attribute_pr_vl = get_post_meta($post->ID,'attribute_pr_vl',true);
                            $attributes = $product->get_attributes();
                            foreach ( $attributes as $attribute ) {
                                $attribute_name = $attribute['name'];

                                $explode_attribute_name = explode("_",$attribute_name);
                                ?>
                                <div class='options_group'> 
                                    <div class='wc-metaboxes'>  
                                        <div class='wc-metabox'>                    
                                            <p class='form-field'>  
                                                <strong><?php echo $explode_attribute_name[1];?></strong>
                                            </p>
                                        </div>
                                    </div>      
                                </div>
                                <?php
                                $get_attribute = wc_get_product_terms( $product->id,$attribute_name, array( 'fields' => 'all' ) );
                                foreach ( $get_attribute as $get_attribute_key => $get_attribute_value) {

                                        $get_attribute_id = $get_attribute_value->term_id;
                                        $get_attribute_name = $get_attribute_value->name;

                                        $field_name = $get_attribute_name.'_'.$get_attribute_id;
                                        $field_name = str_replace(' ', '', $field_name);
                                        $attribute_vl = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                                        $attribute_pr_vl = (!empty($get_attribute_pr_vl[$field_name])) ? $get_attribute_pr_vl[$field_name] :'';
                                        $attribute_vl_chk = ($attribute_vl=='yes')?'checked':'';

                                        ?>
                                        <div class='options_group'> 
                                            <div class='wc-metaboxes'>  
                                                <div class='wc-metabox'>                    
                                                    <p class='form-field'>  
                                                        <label><?php echo $get_attribute_name;?></label>
                                                        <input <?php echo $attribute_vl_chk;?> type="checkbox" name="attribute_vl[<?php echo $field_name;?>]"  value="yes"/>

                                                        <input type="text" name="attribute_pr_vl[<?php echo $field_name;?>]"  value="<?php echo $attribute_pr_vl;?>"/>
                                                    </p>
                                                </div>
                                            </div>      
                                        </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>           

        </div> 
        <!-- <div class="usb_builder show_if_usb hide_if_standard">dddddddddddddddddddddd</div> -->
    </div>

    <div id='usb_builder_options' class='panel woocommerce_options_panel'>
        <div id="usb_builder_option" class="usb_builder_option hide_if_standard show_if_usb">
            <div class='options_group'>
                <?php 
                $usb_ocm_tlc = array();
                $usb_ocm_tlc = json_decode(get_post_meta($post->ID,'_usb_ocm_tlc',true),true); 
                $c = !empty($usb_ocm_tlc) ? count($usb_ocm_tlc) : 0;
                if (!empty($usb_ocm_tlc)) {
                    $usb_ocm_tlc = array_map('array_filter', $usb_ocm_tlc);
                    $usb_ocm_tlc = array_filter($usb_ocm_tlc);
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function( $ ){
                        var count = <?php echo $c; ?>;
                        $( '#add-row' ).on('click', function() {
                            count = count + 1;
                            $( '.empty-row.screen-reader-text td input' ).attr('name','usb_ocm_tlc['+count+'][]');
                            $( '.empty-row.screen-reader-text td select' ).attr('name','usb_ocm_tlc['+count+'][]');
                            var row = $( '.empty-row.screen-reader-text' ).clone(true);
                            row.removeClass( 'empty-row screen-reader-text' );
                            row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
                            return false;
                        });
                    
                        $( '.remove-row' ).on('click', function() {
                            $(this).parents('tr').remove();                
                            return false;
                        });
                    });
                </script>
                <table class="hide_if_standard show_if_usb">
                    <tr>
                        <th>Disable For Front-End</th>
                    </tr>
                    <?php
                    $show_tlc_qty = json_decode(get_post_meta($post->ID,'_show_tlc_qty',true));
                    ?>
                  
                    <tr>
                        <td>50 <input <?php if(!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="50"></td>
                        <td>100 <input <input <?php if(!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="100"></td>
                        <td>250 <input <?php if(!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="250"></td>
                        <td>500 <input <?php if(!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="500"></td>
                        <td>1000 <input <?php if(!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="1000"></td>
                        <td>2500 <input <?php if(!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="2500"></td>
                        <td>5000 <input <?php if(!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_tlc_qty[]" value="5000"></td>
                    </tr>
                    
                </table>
                 <p class='form-field'>  
                <?php
                global $post;                
                ?>
                
                <span class="hide_if_standard show_if_usb">
                    
                 <label>Show OEM TLC</label>
                  <?php
                $show_oem_value = get_post_meta($post->ID, '_show_oem', true);
                if ($show_oem_value == "yes") {$show_oem_checked = 'checked="checked"';} else{$show_oem_checked = '';}
                    ?>
                   <input type="checkbox" name="show_oem" value="yes" <?php echo $show_oem_checked; ?> />
                </span> 
                </p>
                <p class='form-field'>
                    <span class="hide_if_standard show_if_usb">
                    <label><strong>Info:</strong></label> <textarea name="_info_oemtlc"><?php echo get_post_meta($post->ID, '_info_oemtlc', true);?></textarea>
                   </span>
                </p>


                <p><strong>OEM TLC</strong></p>
                <table id="repeatable-fieldset-one" >
                    <thead>
                        <tr>
                            <th>GB</th>
                            <th>50</th>
                            <th>100</th>
                            <th>250</th>                           
                            <th>500</th>
                            <th>1000</th>
                            <th>2500</th>
                            <th>5000</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if ($usb_ocm_tlc) {
                            
                            foreach ($usb_ocm_tlc as $key => $value) {
                                // print_r($value);
                                ?>
                                <tr>
                                    <td>
                                        <!-- <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php //echo $key;?>][]" value="<?php //echo $value[0]; ?>" /> -->
                                        <?php
                                        $usb_quantities = get_terms( array(
                                        'taxonomy' => 'usb_quantity',
                                        'hide_empty' => false,
                                        ) );
                                        ?>
                                        <select name="usb_ocm_tlc[<?php echo $key;?>][]">  
                                          <option value="">Select</option>                                
                                            <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                              <option <?php if($value[0]==$usb_quantity->term_id){echo 'selected';}?> value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                            <?php }?>
                                          </select>
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[1]; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[2]; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[3]; ?>" />
                                    </td>
                                    
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[4]; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[5]; ?>" />                    
                                    </td>
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[6]; ?>" />                    
                                    </td>    
                                    <td>
                                        <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $key;?>][]" value="<?php echo $value[7]; ?>" />                    
                                    </td> 
                                    <td><a class="button remove-row" href="#">Remove</a></td>
                                </tr>
                                <?php
                            } 
                        } else {
                            ?>
                            <tr>
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php //echo $c;?>][]" value="" /> -->
                                    <?php
                                    $usb_quantities = get_terms( array(
                                    'taxonomy' => 'usb_quantity',
                                    'hide_empty' => false,
                                    ) );
                                    ?>
                                    <select name="usb_ocm_tlc[<?php echo $c;?>][]"> 
                                        <option value="">Select</option>                                  
                                        <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                          <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                        <?php }?>
                                      </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                            <?php
                        }
                        ?>
                    
                    
                        
                        
                        
                        <!-- empty hidden one for jQuery -->
                        <tr class="empty-row screen-reader-text">
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php //echo $c;?>][]" value="" /> -->
                                    <?php
                                    $usb_quantities = get_terms( array(
                                    'taxonomy' => 'usb_quantity',
                                    'hide_empty' => false,
                                    ) );
                                    ?>
                                    <select name="usb_ocm_tlc[<?php echo $c;?>][]"> 
                                        <option value="">Select</option>                                  
                                        <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                          <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                        <?php }?>
                                      </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_ocm_tlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                    </tbody>
                </table>
                
                <p><a id="add-row" class="button" href="#">Add another</a></p> 

                <?php 
                $usb_oem_mlc = array();
                $usb_oem_mlc = json_decode(get_post_meta($post->ID,'_usb_oem_mlc',true),true); 
                if (!empty($usb_oem_mlc)) {
                    $c = count($usb_oem_mlc);
                    $usb_oem_mlc = array_map('array_filter', $usb_oem_mlc);
                    $usb_oem_mlc = array_filter($usb_oem_mlc);
                } else {
                    $c = 0;
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function( $ ){
                        var oem_mlc_count = <?php echo $c; ?>;
                        $( '#add-row-oem-mlc' ).on('click', function() {
                            oem_mlc_count = oem_mlc_count + 1;
                            $( '.empty-row.oem_mlc td input' ).attr('name','usb_oem_mlc['+oem_mlc_count+'][]');
                            $( '.empty-row.oem_mlc td select' ).attr('name','usb_oem_mlc['+oem_mlc_count+'][]');
                            var row = $( '.empty-row.oem_mlc' ).clone(true);
                            row.removeClass( 'empty-row oem_mlc' );
                            row.insertBefore( '#repeatable-fieldset-one-oem-mlc tbody>tr:last' ).show();
                            return false;
                        });
                    
                        $( '.remove-row' ).on('click', function() {
                            $(this).parents('tr').remove();                
                            return false;
                        });
                    });
                </script>
                <table class="hide_if_standard show_if_usb">
                        <tr>
                            <th>Disable For Front-End</th>
                        </tr>
                        <?php
                        $show_mlc_qty = json_decode(get_post_meta($post->ID,'_show_mlc_qty',true));
                        ?>
                        <tr>
                            <td>50 <input <?php if(!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="50"></td>
                            <td>100 <input <?php if(!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="100"></td>
                            <td>250 <input <?php if(!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="250"></td>
                            <td>500 <input <?php if(!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="500"></td>
                            <td>1000 <input <?php if(!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="1000"></td>
                            <td>2500 <input <?php if(!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="2500"></td>
                            <td>5000 <input <?php if(!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) {echo "checked";} ?> type="checkbox" name="_show_mlc_qty[]" value="5000"></td>
                        </tr>
                    </table>
                <p class='form-field'>  
                <?php
                global $post;                
                ?>

                <span class="hide_if_standard show_if_usb">
                    
                 <label>Show OEM MLC</label>
                  <?php
                $show_mlc_value = get_post_meta($post->ID, '_show_mlc', true);
                if ($show_mlc_value == "yes"){$show_mlc_checked = 'checked="checked"';} else {$show_mlc_checked = '';}
                    ?>
                   <input type="checkbox" name="show_mlc" value="yes" <?php echo $show_mlc_checked; ?> />
                </span> 
                </p>
                <p class='form-field'>
                <span class="hide_if_standard show_if_usb">
                    <label><strong>Information:</strong></label> <textarea name="_info_oemmlc"><?php echo get_post_meta($post->ID, '_info_oemmlc', true);?></textarea>
                </span>
                </p>
                <p><strong>OEM MLC</strong></p>
                <table id="repeatable-fieldset-one-oem-mlc" >
                    <thead>
                        <tr>
                            <th>GB</th>
                            <th>50</th>
                            <th>100</th>
                            <th>250</th>                           
                            <th>500</th>
                            <th>1000</th>
                            <th>2500</th>
                            <th>5000</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($usb_oem_mlc){
                                foreach ($usb_oem_mlc as $key => $value) {
                                    // print_r($value);
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $key;?>][]" value="<?php //echo $value[0]; ?>" /> -->
                                            <?php
                                            $usb_quantities = get_terms( array(
                                            'taxonomy' => 'usb_quantity',
                                            'hide_empty' => false,
                                            ) );
                                            ?>
                                            <select name="usb_oem_mlc[<?php echo $key;?>][]">  
                                              <option value="">Select</option>                                
                                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                                  <option <?php if($value[0]==$usb_quantity->term_id){echo 'selected';}?> value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                                <?php }?>
                                              </select>
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[1]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[2]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[3]; ?>" />
                                        </td>
                                        
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[4]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[5]; ?>" />                    
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[6]; ?>" />                    
                                        </td>    
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $key;?>][]" value="<?php echo $value[7]; ?>" />                    
                                        </td> 
                                        <td><a class="button remove-row" href="#">Remove</a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $c;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_oem_mlc[<?php echo $c;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                                <?php
                            }
                        ?>
                        <!-- empty hidden one for jQuery -->
                        <tr class="empty-row oem_mlc" style="display: none;">
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $c;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_oem_mlc[<?php echo $c;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $c;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                    </tbody>
                </table>

                <p><a id="add-row-oem-mlc" class="button" href="#">Add another</a></p>    
                <?php 
                $usb_original = array();
                $usb_original = json_decode(get_post_meta($post->ID,'_usb_original',true),true); 
                if (!empty($usb_original)) {
                    $original_cnt = count($usb_original);
                    $usb_original = array_map('array_filter', $usb_original);
                    $usb_original = array_filter($usb_original);
                } else {
                    $original_cnt = 0;
                }
                
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function( $ ){
                        var original_count = <?php echo $original_cnt; ?>;
                        $( '#add-row-original' ).on('click', function() {
                            original_count = original_count + 1;
                            $( '.empty-row.original td input' ).attr('name','usb_original['+original_count+'][]');
                            $( '.empty-row.original td select' ).attr('name','usb_original['+original_count+'][]');
                            var row = $( '.empty-row.original' ).clone(true);
                            row.removeClass( 'empty-row original' );
                            row.insertBefore( '#repeatable-fieldset-one-original tbody>tr:last' ).show();
                            return false;
                        });
                    
                        $( '.remove-row' ).on('click', function() {
                            $(this).parents('tr').remove();                
                            return false;
                        });
                    });
                </script>

                <table class="hide_if_standard show_if_usb">
                        <tr><th>Disable For Front-End</th></tr>
                        <?php
                        $show_original_qty = json_decode(get_post_meta($post->ID,'_show_original_qty',true));
                        ?>
                        <tr>
                            <td>50 <input <?php if(!empty($show_original_qty) && in_array('50', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="50"></td>
                            <td>100 <input <?php if(!empty($show_original_qty) && in_array('100', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="100"></td>
                            <td>250 <input <?php if(!empty($show_original_qty) && in_array('250', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="250"></td>
                            <td>500 <input <?php if(!empty($show_original_qty) && in_array('500', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="500"></td>
                            <td>1000 <input <?php if(!empty($show_original_qty) && in_array('1000', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="1000"></td>
                            <td>2500 <input <?php if(!empty($show_original_qty) && in_array('2500', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="2500"></td>
                            <td>5000 <input <?php if(!empty($show_original_qty) && in_array('5000', $show_original_qty)) {echo "checked";} ?> type="checkbox" name="_show_original_qty[]" value="5000"></td>
                        </tr>
                    </table>
                <p class='form-field'>  
                <?php
                global $post;                
                ?>

                <span class="hide_if_standard show_if_usb">
                    
                 <label>Show Original</label>
                  <?php
                $original_value = get_post_meta($post->ID, '_original', true);
                if ($original_value == "yes") {$original_checked = 'checked="checked"';}else {$original_checked = '';}
                    ?>
                   <input type="checkbox" name="original" value="yes" <?php echo $original_checked; ?> />
                </span> 
                </p>
                <p class='form-field'>
                    <span class="hide_if_standard show_if_usb">
                    <label><strong>Info:</strong></label> <textarea name="_info_original"><?php echo get_post_meta($post->ID, '_info_original', true);?></textarea>
                    </span>
                </p>
                <p><strong>Original</strong></p>
                <table id="repeatable-fieldset-one-original" >
                    <thead>
                        <tr>
                            <th>GB</th>
                            <th>50</th>
                            <th>100</th>
                            <th>250</th>                           
                            <th>500</th>
                            <th>1000</th>
                            <th>2500</th>
                            <th>5000</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($usb_original){
                                foreach ($usb_original as $key => $value) {
                                    // print_r($value);
                                    ?>
                                    <tr>
                                        <td>
                                            <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $key;?>][]" value="<?php //echo $value[0]; ?>" /> -->
                                            <?php
                                            $usb_quantities = get_terms( array(
                                            'taxonomy' => 'usb_quantity',
                                            'hide_empty' => false,
                                            ) );
                                            ?>
                                            <select name="usb_original[<?php echo $key;?>][]">  
                                              <option value="">Select</option>                                
                                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                                  <option <?php if($value[0]==$usb_quantity->term_id){echo 'selected';}?> value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                                <?php }?>
                                              </select>
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[1]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[2]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[3]; ?>" />
                                        </td>
                                        
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[4]; ?>" />
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[5]; ?>" />                    
                                        </td>
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[6]; ?>" />                    
                                        </td>    
                                        <td>
                                            <input type="text" style="width: 100%;" name="usb_original[<?php echo $key;?>][]" value="<?php echo $value[7]; ?>" />                    
                                        </td> 
                                        <td><a class="button remove-row" href="#">Remove</a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $original_cnt;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_original[<?php echo $original_cnt;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                                <?php
                            }
                        ?>
                        <!-- empty hidden one for jQuery -->
                        <tr class="empty-row original" style="display: none;">
                            <td>
                                <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $original_cnt;?>][]" value="" /> -->
                                <?php
                                $usb_quantities = get_terms( array(
                                'taxonomy' => 'usb_quantity',
                                'hide_empty' => false,
                                ) );
                                ?>
                                <select name="usb_original[<?php echo $original_cnt;?>][]"> 
                                    <option value="">Select</option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                    <?php }?>
                                  </select>
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td>    
                            <td>
                                <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_cnt;?>][]" value="" />                    
                            </td> 
                            <td><a class="button remove-row" href="#">Remove</a></td>
                        </tr>
                    </tbody>
                </table>

                <p><a id="add-row-original" class="button" href="#">Add another</a></p> 
                               
            </div>
            <div class='options_group'> 
                <div class='wc-metaboxes'>  
                    <div class='wc-metabox'>  

                        <?php
                        $get_attribute_vl = get_post_meta($post->ID,'attribute_vl_2',true);
                       // print_r($get_attribute_vl);
                        $get_attribute_pr_vl = get_post_meta($post->ID,'attribute_pr_vl_usb',true);
                        $attributes = $product->get_attributes();
                        foreach ( $attributes as $attribute ) {
                            $attribute_name = $attribute['name'];

                            $explode_attribute_name = explode("_",$attribute_name);
                            ?>
                            <div class='options_group'> 
                                <div class='wc-metaboxes'>  
                                    <div class='wc-metabox'>                    
                                        <p class='form-field'>  
                                            <strong><?php echo $explode_attribute_name[1];?></strong>
                                        </p>
                                    </div>
                                </div>      
                            </div>
                            <?php
                            $get_attribute = wc_get_product_terms( $product->id,$attribute_name, array( 'fields' => 'all' ) );
                            foreach ( $get_attribute as $get_attribute_key => $get_attribute_value) {

                                    $get_attribute_id = $get_attribute_value->term_id;
                                    $get_attribute_name = $get_attribute_value->name;

                                    $field_name = $get_attribute_name.'_'.$get_attribute_id;
                                    $field_name = str_replace(' ', '', $field_name);
                                    $attribute_vl = (!empty($get_attribute_vl[$field_name])) ? $get_attribute_vl[$field_name] :'';
                                    $attribute_pr_vl = (!empty($get_attribute_pr_vl[$field_name])) ? $get_attribute_pr_vl[$field_name] :'';
                                    $attribute_vl_chk = ($attribute_vl=='yes')?'checked':'';
                                    ?>
                                    <div class='options_group'> 
                                        <div class='wc-metaboxes'>  
                                            <div class='wc-metabox'>                    
                                                <p class='form-field'>  
                                                    <label><?php echo $get_attribute_name;?></label>
                                                    <input <?php echo $attribute_vl_chk;?> type="checkbox" name="attribute_vl_2[<?php echo $field_name;?>]"  value="yes"/>



                                                    <input type="text" name="attribute_pr_vl_usb[<?php echo $field_name;?>]"  value="<?php echo $attribute_pr_vl;?>"/>
                                                </p>
                                            </div>
                                        </div>      
                                    </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php
}



// Save the custom fields.
function process_builder_meta_standard($post_id)
{

    update_post_meta($post_id, 'attribute_vl', $_POST['attribute_vl']);
    update_post_meta($post_id, 'attribute_pr_vl', $_POST['attribute_pr_vl']);
    update_post_meta($post_id, '_price_option_1', $_POST['_price_option_1']);
    update_post_meta($post_id, '_price_option_25', $_POST['_price_option_25']);
    update_post_meta($post_id, '_price_option_50', $_POST['_price_option_50']);
    update_post_meta($post_id, '_price_option_100', $_POST['_price_option_100']);
    update_post_meta($post_id, '_price_option_250', $_POST['_price_option_250']);
    update_post_meta($post_id, '_price_option_500', $_POST['_price_option_500']);
    update_post_meta($post_id, '_price_option_1000', $_POST['_price_option_1000']);
    update_post_meta($post_id, '_price_option_2500', $_POST['_price_option_2500']);
    update_post_meta($post_id, '_price_option_5000', $_POST['_price_option_5000']);
    if (isset($_POST['_active_qty'])) {
        update_post_meta($post_id, '_active_qty', $_POST['_active_qty']);
    } else {
        update_post_meta($post_id, '_active_qty', '50');
    }
    update_post_meta($post_id, '_show_stnd_qty', json_encode($_POST['_show_stnd_qty']));

    // Updating Data For set Own Quantity

}
add_action('woocommerce_process_product_meta_standard', 'process_builder_meta_standard');


function process_builder_meta_usb($post_id)
{
    update_post_meta($post_id, 'attribute_vl_2', $_POST['attribute_vl_2']);
    update_post_meta($post_id, 'attribute_pr_vl_usb', $_POST['attribute_pr_vl_usb']);

    update_post_meta($post_id, '_info_oemtlc', $_POST['_info_oemtlc']);
    update_post_meta($post_id, '_info_oemmlc', $_POST['_info_oemmlc']);
    update_post_meta($post_id, '_info_original', $_POST['_info_original']);

    update_post_meta($post_id, '_show_tlc_qty', json_encode($_POST['_show_tlc_qty']));
    update_post_meta($post_id, '_show_mlc_qty', json_encode($_POST['_show_mlc_qty']));
    update_post_meta($post_id, '_show_original_qty', json_encode($_POST['_show_original_qty']));

    $usb_ocm_tlc = array_map('array_filter', $_POST['usb_ocm_tlc']);
    $usb_ocm_tlc = array_filter($usb_ocm_tlc);

    $usb_oem_mlc = array_map('array_filter', $_POST['usb_oem_mlc']);
    $usb_oem_mlc = array_filter($usb_oem_mlc);

    $usb_original = array_map('array_filter', $_POST['usb_original']);
    $usb_original = array_filter($usb_original);

    foreach ($usb_ocm_tlc as $key => $value) {
        foreach ($value as $key2 => $value2) {
            if ($key2 == 0) {
                $newkey = $value2;
            }
            $usb_ocm_tlc_arr[$newkey][] = $value2;
        }
    }
    foreach ($usb_oem_mlc as $key => $value) {
        foreach ($value as $key2 => $value2) {
            if ($key2 == 0) {
                $newkey = $value2;
            }
            $usb_oem_mlc_arr[$newkey][] = $value2;
        }
    }
    foreach ($usb_original as $key => $value) {
        foreach ($value as $key2 => $value2) {
            if ($key2 == 0) {
                $newkey = $value2;
            }
            $usb_original_arr[$newkey][] = $value2;
        }
    }

    update_post_meta($post_id, '_usb_ocm_tlc', json_encode($usb_ocm_tlc_arr));
    update_post_meta($post_id, '_usb_oem_mlc', json_encode($usb_oem_mlc_arr));
    update_post_meta($post_id, '_usb_original', json_encode($usb_original_arr));

    if (isset($_POST['show_oem'])) {
        update_post_meta($post_id, '_show_oem', 'yes');
    } else {
        update_post_meta($post_id, '_show_oem', 'no');
    }
    if (isset($_POST['show_mlc'])) {
        update_post_meta($post_id, '_show_mlc', 'yes');
    } else {
        update_post_meta($post_id, '_show_mlc', 'no');
    }
    if (isset($_POST['original'])) {
        update_post_meta($post_id, '_original', 'yes');
    } else {
        update_post_meta($post_id, '_original', 'no');
    }
}
add_action('woocommerce_process_product_meta_usb', 'process_builder_meta_usb');
//  Add code for select option
add_filter('product_type_selector', 'custom_usb_type');
function custom_usb_type($type)
{
    $type['standard'] = __('Standard');
    $type['usb'] = __('USB');
    return $type;
}

/**
 * Register the custom product type after init
 */
function register_standard_product_type()
{
    /**
     * This should be in its own separate file.
     */
    class WC_Product_standard extends WC_Product
    {
        public function __construct($product)
        {
            $this->product_type = 'standard';
            parent::__construct($product);
        }
    }

}
add_action('init', 'register_standard_product_type');

function register_usb_product_type()
{
    /**
     * This should be in its own separate file.
     */
    class WC_Product_usb extends WC_Product
    {
        public function __construct($product)
        {
            $this->product_type = 'usb';
            parent::__construct($product);
        }
    }

}
add_action('init', 'register_usb_product_type');
add_filter('woocommerce_product_data_tabs', 'usb_product_data_tabs');
function usb_product_data_tabs($tabs)
{
    $tabs['variations']['class'][] = 'show_if_standard';
    $tabs['variations']['class'][] = 'show_if_usb';

    $tabs['inventory']['class'][] = 'show_if_standard';
    $tabs['inventory']['class'][] = 'show_if_usb';

    $tabs['usb_builder']['class'][] = 'hide_if_standard';
    $tabs['usb_builder']['class'][] = 'show_if_usb';

    $tabs['builder']['class'][] = 'show_if_standard';
    $tabs['builder']['class'][] = 'hide_if_usb';
    return $tabs;
}
/// Add code for include standard and usb page in woocoomerce
function standard_add_to_cart()
{
    wc_get_template('woocommerce/single-product/add-to-cart/standard.php');
}
add_action('woocommerce_standard_add_to_cart', 'standard_add_to_cart');

function usb_add_to_cart()
{
    wc_get_template('woocommerce/single-product/add-to-cart/usb.php');
}
add_action('woocommerce_usb_add_to_cart', 'usb_add_to_cart');

function variable_add_to_cart()
{
    wc_get_template('woocommerce/single-product/add-to-cart/variable.php');
}
add_action('woocommerce_variable_add_to_cart', 'variable_add_to_cart');
add_action('wp_enqueue_scripts', 'usb_ajx_scripts');
function usb_ajx_scripts()
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-form');
    $ajaxurl = admin_url('admin-ajax.php');
    $ajax_nonce = wp_create_nonce('USB');
    wp_localize_script('jquery-core', 'ajaxVars', array('ajaxurl' => $ajaxurl, 'ajax_nonce' => $ajax_nonce));
}
add_action('wp_ajax_data_usb_ocm_tlc', 'data_usb_ocm_tlc_fnc');
add_action('wp_ajax_nopriv_data_usb_ocm_tlc', 'data_usb_ocm_tlc_fnc');
function data_usb_ocm_tlc_fnc()
{
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    // $crncy = get_woocommerce_currency();
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];

    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $show_tlc_qty = json_decode(get_post_meta($cus_product_id, '_show_tlc_qty', true), true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id, '_usb_ocm_tlc', true));

    /*get attribute price for USB product*/
    $usb_quantity = get_terms('usb_quantity', array(
        'hide_empty' => 0,
    ));
    if (!empty($usb_quantity) && !is_wp_error($usb_quantity)) {
        $usb_quantity_arr = array();
        foreach ($usb_quantity as $usb_qty) {
            $usb_quantity_arr[] = $usb_qty->term_id;
        }
    }
    /*get attribute price for USB product*/

    foreach ($dataset as $key => $value) {
        // $usb_arr[] = json_decode(get_term_meta($key,'_usb_ocm_tlc',true),true);
        $usb_atr = array();
        $price50 = get_term_meta($key, '_price50', true);
        $price50 = str_replace(",", ".", $price50);
        $price50 = (!empty($price50)) ? $price50 : '0.0';

        $price100 = get_term_meta($key, '_price100', true);
        $price100 = str_replace(",", ".", $price100);
        $price100 = (!empty($price100)) ? $price100 : '0.0';

        $price250 = get_term_meta($key, '_price250', true);
        $price250 = str_replace(",", ".", $price250);
        $price250 = (!empty($price250)) ? $price250 : '0.0';

        $price500 = get_term_meta($key, '_price500', true);
        $price500 = str_replace(",", ".", $price500);
        $price500 = (!empty($price500)) ? $price500 : '0.0';

        $price1000 = get_term_meta($key, '_price1000', true);
        $price1000 = str_replace(",", ".", $price1000);
        $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

        $price2500 = get_term_meta($key, '_price2500', true);
        $price2500 = str_replace(",", ".", $price2500);
        $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

        $price5000 = get_term_meta($key, '_price5000', true);
        $price5000 = str_replace(",", ".", $price5000);
        $price5000 = (!empty($price5000)) ? $price5000 : '0.0';

        foreach ($usb_quantity_arr as $usb_value) {
            $usb_atr[$usb_value][] = $usb_value;
            $usb_atr[$usb_value][] = $price50;
            $usb_atr[$usb_value][] = $price100;
            $usb_atr[$usb_value][] = $price250;
            $usb_atr[$usb_value][] = $price500;
            $usb_atr[$usb_value][] = $price1000;
            $usb_atr[$usb_value][] = $price2500;
            $usb_atr[$usb_value][] = $price5000;
        }
        $usb_arr[] = $usb_atr;
    }

    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $resume)) {
                $resume[$key] = $value;
            } else {
                foreach ($value as $index => $number) {
                    $resume[$key][$index] += $number;
                }
            }
        }
    }

    ksort($resume);
    // $resume = json_encode($resume);
    // $resume = json_decode($resume,true);
    // echo $resume[64][2];
    // die();

    foreach ($usb_ocm_tlc as $key => $value) {
        ?>
            <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                    <?php
                    $category = get_term_by('id', $key, 'usb_quantity');
                    echo $category->name;
                    ?>
                </td>
                <?php
                $qty1 = $resume[$key][1];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty1 = $qty1 * $rate_change;
                    $qty1 = number_format((float) $qty1, 2, '.', '');
                }
                ?>
                <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty1; ?>
                </td>
                <?php
                $qty2 = $resume[$key][2];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty2 = $qty2 * $rate_change;
                    $qty2 = number_format((float) $qty2, 2, '.', '');
                }
                ?>
                <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty2; ?>
                </td>
                <?php
                $qty3 = $resume[$key][3];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty3 = $qty3 * $rate_change;
                    $qty3 = number_format((float) $qty3, 2, '.', '');
                }
                ?>
                <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty3; ?>
                </td>
                <?php
                $qty4 = $resume[$key][4];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty4 = $qty4 * $rate_change;
                    $qty4 = number_format((float) $qty4, 2, '.', '');
                }
                ?>
                <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty4; ?>
                </td>
                <?php
                $qty5 = $resume[$key][5];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty5 = $qty5 * $rate_change;
                    $qty5 = number_format((float) $qty5, 2, '.', '');
                }
                ?>
                <td class="customer qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty5; ?>
                </td>
                <?php
                $qty6 = $resume[$key][6];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty6 = $qty6 * $rate_change;
                    $qty6 = number_format((float) $qty6, 2, '.', '');
                }
                ?>
                <td class="customer qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty6; ?>
                </td>
                <?php
                $qty7 = $resume[$key][7];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty7 = $qty7 * $rate_change;
                    $qty7 = number_format((float) $qty7, 2, '.', '');
                }
                ?>
                <td class="customer qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty7; ?>
                </td>
            </tr>
            <?php
    }

    die();
}
add_action('wp_ajax_data_usb_oem_mlc', 'data_usb_oem_mlc_fnc');
add_action('wp_ajax_nopriv_data_usb_oem_mlc', 'data_usb_oem_mlc_fnc');

function data_usb_oem_mlc_fnc()
{
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];

    $show_mlc_qty = json_decode(get_post_meta($cus_product_id, '_show_mlc_qty', true), true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id, '_usb_oem_mlc', true));
    /*get attribute price for USB product*/
    $usb_quantity = get_terms('usb_quantity', array(
        'hide_empty' => 0,
    ));
    if (!empty($usb_quantity) && !is_wp_error($usb_quantity)) {
        $usb_quantity_arr = array();
        foreach ($usb_quantity as $usb_qty) {
            $usb_quantity_arr[] = $usb_qty->term_id;
        }
    }
    /*get attribute price for USB product*/


    foreach ($dataset as $key => $value) {
        // $usb_arr[] = json_decode(get_term_meta($key,'_usb_oem_mlc',true),true);
        $usb_atr = array();
        $price50 = get_term_meta($key, '_price50', true);
        $price50 = str_replace(",", ".", $price50);
        $price50 = (!empty($price50)) ? $price50 : '0.0';

        $price100 = get_term_meta($key, '_price100', true);
        $price100 = str_replace(",", ".", $price100);
        $price100 = (!empty($price100)) ? $price100 : '0.0';

        $price250 = get_term_meta($key, '_price250', true);
        $price250 = str_replace(",", ".", $price250);
        $price250 = (!empty($price250)) ? $price250 : '0.0';

        $price500 = get_term_meta($key, '_price500', true);
        $price500 = str_replace(",", ".", $price500);
        $price500 = (!empty($price500)) ? $price500 : '0.0';

        $price1000 = get_term_meta($key, '_price1000', true);
        $price1000 = str_replace(",", ".", $price1000);
        $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

        $price2500 = get_term_meta($key, '_price2500', true);
        $price2500 = str_replace(",", ".", $price2500);
        $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

        $price5000 = get_term_meta($key, '_price5000', true);
        $price5000 = str_replace(",", ".", $price5000);
        $price5000 = (!empty($price5000)) ? $price5000 : '0.0';

        foreach ($usb_quantity_arr as $usb_value) {
            $usb_atr[$usb_value][] = $usb_value;
            $usb_atr[$usb_value][] = $price50;
            $usb_atr[$usb_value][] = $price100;
            $usb_atr[$usb_value][] = $price250;
            $usb_atr[$usb_value][] = $price500;
            $usb_atr[$usb_value][] = $price1000;
            $usb_atr[$usb_value][] = $price2500;
            $usb_atr[$usb_value][] = $price5000;
        }
        $usb_arr[] = $usb_atr;
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $resume)) {
                $resume[$key] = $value;
            } else {
                foreach ($value as $index => $number) {
                    $resume[$key][$index] += $number;
                }
            }
        }
    }

    ksort($resume);

    foreach ($usb_ocm_tlc as $key => $value) {
        ?>
            <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                    <?php
                    $category = get_term_by('id', $key, 'usb_quantity');
                    echo $category->name;
                    ?>
                </td>
                <?php
                $qty1 = $resume[$key][1];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty1 = $qty1 * $rate_change;
                    $qty1 = number_format((float) $qty1, 2, '.', '');
                }
                ?>
                <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty1; ?>
                </td>
                <?php
                $qty2 = $resume[$key][2];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty2 = $qty2 * $rate_change;
                    $qty2 = number_format((float) $qty2, 2, '.', '');
                }
                ?>
                <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty2; ?>
                </td>
                <?php
                $qty3 = $resume[$key][3];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty3 = $qty3 * $rate_change;
                    $qty3 = number_format((float) $qty3, 2, '.', '');
                }
                ?>
                <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty3; ?>
                </td>
                <?php
                $qty4 = $resume[$key][4];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty4 = $qty4 * $rate_change;
                    $qty4 = number_format((float) $qty4, 2, '.', '');
                }
                ?>
                <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty4; ?>
                </td>
                <?php
                $qty5 = $resume[$key][5];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty5 = $qty5 * $rate_change;
                    $qty5 = number_format((float) $qty5, 2, '.', '');
                }
                ?>
                <td class="customer qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty5; ?>
                </td>
                <?php
                $qty6 = $resume[$key][6];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty6 = $qty6 * $rate_change;
                    $qty6 = number_format((float) $qty6, 2, '.', '');
                }
                ?>
                <td class="customer qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty6; ?>
                </td>
                <?php
                $qty7 = $resume[$key][7];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty7 = $qty7 * $rate_change;
                    $qty7 = number_format((float) $qty7, 2, '.', '');
                }
                ?>
                <td class="customer qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty7; ?>
                </td>
            </tr>
            <?php
    }

    die();
}
add_action('wp_ajax_data_usb_original', 'data_usb_original_fnc');
add_action('wp_ajax_nopriv_data_usb_original', 'data_usb_original_fnc');
function data_usb_original_fnc()
{
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $show_original_qty = json_decode(get_post_meta($cus_product_id, '_show_original_qty', true), true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id, '_usb_original', true));

    // echo get_post_meta($cus_product_id,'_usb_original',true);
    // die();
    /*get attribute price for USB product*/
    $usb_quantity = get_terms('usb_quantity', array(
        'hide_empty' => 0,
    ));
    if (!empty($usb_quantity) && !is_wp_error($usb_quantity)) {
        $usb_quantity_arr = array();
        foreach ($usb_quantity as $usb_qty) {
            $usb_quantity_arr[] = $usb_qty->term_id;
        }
    }
    /*get attribute price for USB product*/


    foreach ($dataset as $key => $value) {
        // $usb_arr[] = json_decode(get_term_meta($key,'_usb_original_data',true),true);
        $usb_atr = array();
        $price50 = get_term_meta($key, '_price50', true);
        $price50 = str_replace(",", ".", $price50);
        $price50 = (!empty($price50)) ? $price50 : '0.0';

        $price100 = get_term_meta($key, '_price100', true);
        $price100 = str_replace(",", ".", $price100);
        $price100 = (!empty($price100)) ? $price100 : '0.0';

        $price250 = get_term_meta($key, '_price250', true);
        $price250 = str_replace(",", ".", $price250);
        $price250 = (!empty($price250)) ? $price250 : '0.0';

        $price500 = get_term_meta($key, '_price500', true);
        $price500 = str_replace(",", ".", $price500);
        $price500 = (!empty($price500)) ? $price500 : '0.0';

        $price1000 = get_term_meta($key, '_price1000', true);
        $price1000 = str_replace(",", ".", $price1000);
        $price1000 = (!empty($price1000)) ? $price1000 : '0.0';

        $price2500 = get_term_meta($key, '_price2500', true);
        $price2500 = str_replace(",", ".", $price2500);
        $price2500 = (!empty($price2500)) ? $price2500 : '0.0';

        $price5000 = get_term_meta($key, '_price5000', true);
        $price5000 = str_replace(",", ".", $price5000);
        $price5000 = (!empty($price5000)) ? $price5000 : '0.0';

        foreach ($usb_quantity_arr as $usb_value) {
            $usb_atr[$usb_value][] = $usb_value;
            $usb_atr[$usb_value][] = $price50;
            $usb_atr[$usb_value][] = $price100;
            $usb_atr[$usb_value][] = $price250;
            $usb_atr[$usb_value][] = $price500;
            $usb_atr[$usb_value][] = $price1000;
            $usb_atr[$usb_value][] = $price2500;
            $usb_atr[$usb_value][] = $price5000;
        }
        $usb_arr[] = $usb_atr;
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $resume)) {
                $resume[$key] = $value;
            } else {
                foreach ($value as $index => $number) {
                    $resume[$key][$index] += $number;
                }
            }
        }
    }

    ksort($resume);

    foreach ($usb_ocm_tlc as $key => $value) {
        ?>
            <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                    <?php
                    $category = get_term_by('id', $key, 'usb_quantity');
                    echo $category->name;
                    ?>
                </td>
                <?php
                $qty1 = $resume[$key][1];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty1 = $qty1 * $rate_change;
                    $qty1 = number_format((float) $qty1, 2, '.', '');
                }
                ?>
                <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_original_qty) && in_array('50', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty1; ?>
                </td>
                <?php
                $qty2 = $resume[$key][2];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty2 = $qty2 * $rate_change;
                    $qty2 = number_format((float) $qty2, 2, '.', '');
                }
                ?>
                <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_original_qty) && in_array('100', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty2; ?>
                </td>
                <?php
                $qty3 = $resume[$key][3];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty3 = $qty3 * $rate_change;
                    $qty3 = number_format((float) $qty3, 2, '.', '');
                }
                ?>
                <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_original_qty) && in_array('250', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty3; ?>
                </td>
                <?php
                $qty4 = $resume[$key][4];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty4 = $qty4 * $rate_change;
                    $qty4 = number_format((float) $qty4, 2, '.', '');
                }
                ?>
                <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_original_qty) && in_array('500', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty4; ?>
                </td>
                <?php
                $qty5 = $resume[$key][5];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty5 = $qty5 * $rate_change;
                    $qty5 = number_format((float) $qty5, 2, '.', '');
                }
                ?>
                <td class="customer qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_original_qty) && in_array('1000', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty5; ?>
                </td>
                <?php
                $qty6 = $resume[$key][6];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty6 = $qty6 * $rate_change;
                    $qty6 = number_format((float) $qty6, 2, '.', '');
                }
                ?>
                <td class="customer qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_original_qty) && in_array('2500', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty6; ?>
                </td>
                <?php
                $qty7 = $resume[$key][7];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty7 = $qty7 * $rate_change;
                    $qty7 = number_format((float) $qty7, 2, '.', '');
                }
                ?>
                <td class="customer qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_original_qty) && in_array('5000', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php echo $qty7; ?>
                </td>
            </tr>
            <?php
    }

    die();
}


// margin
add_action('wp_ajax_margin_usb_ocm_tlc', 'margin_usb_ocm_tlc_fnc');
add_action('wp_ajax_nopriv_margin_usb_ocm_tlc', 'margin_usb_ocm_tlc_fnc');

function margin_usb_ocm_tlc_fnc()
{
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $cus_margin = $_POST['cus_margin'];
    $show_tlc_qty = json_decode(get_post_meta($cus_product_id, '_show_tlc_qty', true), true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id, '_usb_ocm_tlc', true));


    if ($dataset) {
        foreach ($dataset as $key => $value) {
            $usb_arr[] = json_decode(get_term_meta($key, '_usb_ocm_tlc', true), true);
        }
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $resume)) {
                $resume[$key] = $value;
            } else {
                foreach ($value as $index => $number) {
                    $resume[$key][$index] += $number;
                }
            }
        }
    }

    ksort($resume);

    foreach ($usb_ocm_tlc as $key => $value) {
        ?>
            <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                    <?php
                    $category = get_term_by('id', $key, 'usb_quantity');
                    echo $category->name;
                    ?>
                </td>
                <?php
                $qty1 = $resume[$key][1];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty1 = $qty1 * $rate_change;
                    $qty1 = number_format((float) $qty1, 2, '.', '');
                }
                ?>
                <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_tlc_qty) && in_array('50', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key1 = $qty1;
                    echo $key1 + (($key1 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty2 = $resume[$key][2];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty2 = $qty2 * $rate_change;
                    $qty2 = number_format((float) $qty2, 2, '.', '');
                }
                ?>
                <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_tlc_qty) && in_array('100', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key2 = $qty2;
                    echo $key2 + (($key2 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty3 = $resume[$key][3];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty3 = $qty3 * $rate_change;
                    $qty3 = number_format((float) $qty3, 2, '.', '');
                }
                ?>
                <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_tlc_qty) && in_array('250', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key3 = $qty3;
                    echo $key3 + (($key3 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty4 = $resume[$key][4];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty4 = $qty4 * $rate_change;
                    $qty4 = number_format((float) $qty4, 2, '.', '');
                }
                ?>
                <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_tlc_qty) && in_array('500', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key4 = $qty4;
                    echo $key4 + (($key4 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty5 = $resume[$key][5];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty5 = $qty5 * $rate_change;
                    $qty5 = number_format((float) $qty5, 2, '.', '');
                }
                ?>
                <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_tlc_qty) && in_array('1000', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key5 = $qty5;
                    echo $key5 + (($key5 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty6 = $resume[$key][6];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty6 = $qty6 * $rate_change;
                    $qty6 = number_format((float) $qty6, 2, '.', '');
                }
                ?>
                <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_tlc_qty) && in_array('2500', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key6 = $qty6;
                    echo $key6 + (($key6 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty7 = $resume[$key][7];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty7 = $qty7 * $rate_change;
                    $qty7 = number_format((float) $qty7, 2, '.', '');
                }
                ?>
                <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_tlc_qty) && in_array('5000', $show_tlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key7 = $qty7;
                    echo $key7 + (($key7 * $cus_margin) / 100);
                    ?>
                </td>
            </tr>
            <?php
    }

    die();
}


/**/
add_action('wp_ajax_margin_usb_oem_mlc', 'margin_usb_oem_mlc_fnc');
add_action('wp_ajax_nopriv_margin_usb_oem_mlc', 'margin_usb_oem_mlc_fnc');

function margin_usb_oem_mlc_fnc()
{
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $cus_margin = $_POST['cus_margin'];
    $show_mlc_qty = json_decode(get_post_meta($cus_product_id, '_show_mlc_qty', true), true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id, '_usb_oem_mlc', true));



    foreach ($dataset as $key => $value) {
        $usb_arr[] = json_decode(get_term_meta($key, '_usb_oem_mlc', true), true);
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $resume)) {
                $resume[$key] = $value;
            } else {
                foreach ($value as $index => $number) {
                    $resume[$key][$index] += $number;
                }
            }
        }
    }

    ksort($resume);

    foreach ($usb_ocm_tlc as $key => $value) {
        ?>
            <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                    <?php
                    $category = get_term_by('id', $key, 'usb_quantity');
                    echo $category->name;
                    ?>
                </td>
                <?php
                $qty1 = $resume[$key][1];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty1 = $qty1 * $rate_change;
                    $qty1 = number_format((float) $qty1, 2, '.', '');
                }
                ?>
                <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_mlc_qty) && in_array('50', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key1 = $qty1;
                    echo $key1 + (($key1 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty2 = $resume[$key][2];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty2 = $qty2 * $rate_change;
                    $qty2 = number_format((float) $qty2, 2, '.', '');
                }
                ?>
                <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_mlc_qty) && in_array('100', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key2 = $qty2;
                    echo $key2 + (($key2 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty3 = $resume[$key][3];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty3 = $qty3 * $rate_change;
                    $qty3 = number_format((float) $qty3, 2, '.', '');
                }
                ?>
                <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_mlc_qty) && in_array('250', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key3 = $qty3;
                    echo $key3 + (($key3 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty4 = $resume[$key][4];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty4 = $qty4 * $rate_change;
                    $qty4 = number_format((float) $qty4, 2, '.', '');
                }
                ?>
                <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_mlc_qty) && in_array('500', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key4 = $qty4;
                    echo $key4 + (($key4 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty5 = $resume[$key][5];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty5 = $qty5 * $rate_change;
                    $qty5 = number_format((float) $qty5, 2, '.', '');
                }
                ?>
                <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_mlc_qty) && in_array('1000', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key5 = $qty5;
                    echo $key5 + (($key5 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty6 = $resume[$key][6];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty6 = $qty6 * $rate_change;
                    $qty6 = number_format((float) $qty6, 2, '.', '');
                }
                ?>
                <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_mlc_qty) && in_array('2500', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key6 = $qty6;
                    echo $key6 + (($key6 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty7 = $resume[$key][7];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty7 = $qty7 * $rate_change;
                    $qty7 = number_format((float) $qty7, 2, '.', '');
                }
                ?>
                <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_mlc_qty) && in_array('5000', $show_mlc_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key7 = $qty7;
                    echo $key7 + (($key7 * $cus_margin) / 100);
                    ?>
                </td>
            </tr>
            <?php
    }

    die();
}


add_action('wp_ajax_margin_usb_original', 'margin_usb_original_fnc');
add_action('wp_ajax_nopriv_margin_usb_original', 'margin_usb_original_fnc');

function margin_usb_original_fnc()
{
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = $_POST['woo_currency'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $dataset = $_POST['info'];
    $tablename = $_POST['tablename'];
    $cus_product_id = $_POST['cus_product_id'];
    $cus_margin = $_POST['cus_margin'];
    $show_original_qty = json_decode(get_post_meta($cus_product_id, '_show_original_qty', true), true);

    $usb_ocm_tlc = json_decode(get_post_meta($cus_product_id, '_usb_original', true));

    // echo get_post_meta($cus_product_id,'_usb_original',true);
    // die();



    foreach ($dataset as $key => $value) {
        $usb_arr[] = json_decode(get_term_meta($key, '_usb_original_data', true), true);
    }
    $usb_arr[] = $usb_ocm_tlc;

    $resume = [];

    foreach ($usb_arr as $data) {
        foreach ($data as $key => $value) {
            if (!array_key_exists($key, $resume)) {
                $resume[$key] = $value;
            } else {
                foreach ($value as $index => $number) {
                    $resume[$key][$index] += $number;
                }
            }
        }
    }

    ksort($resume);

    foreach ($usb_ocm_tlc as $key => $value) {
        ?>
            <tr class="ocm_tlc_qnty_size" data-class="<?php echo $key; ?>">
                <td class="qty0" data-qty0="<?php echo $value[0]; ?>">
                    <?php
                    $category = get_term_by('id', $key, 'usb_quantity');
                    echo $category->name;
                    ?>
                </td>
                <?php
                $qty1 = $resume[$key][1];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty1 = $qty1 * $rate_change;
                    $qty1 = number_format((float) $qty1, 2, '.', '');
                }
                ?>
                <td class="qty1" data-qty1="<?php echo $qty1; ?>" <?php if (!empty($show_original_qty) && in_array('50', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key1 = $qty1;
                    echo $key1 + (($key1 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty2 = $resume[$key][2];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty2 = $qty2 * $rate_change;
                    $qty2 = number_format((float) $qty2, 2, '.', '');
                }
                ?>
                <td class="qty2" data-qty2="<?php echo $qty2; ?>" <?php if (!empty($show_original_qty) && in_array('100', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key2 = $qty2;
                    echo $key2 + (($key2 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty3 = $resume[$key][3];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty3 = $qty3 * $rate_change;
                    $qty3 = number_format((float) $qty3, 2, '.', '');
                }
                ?>
                <td class="qty3" data-qty3="<?php echo $qty3; ?>" <?php if (!empty($show_original_qty) && in_array('250', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key3 = $qty3;
                    echo $key3 + (($key3 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty4 = $resume[$key][4];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty4 = $qty4 * $rate_change;
                    $qty4 = number_format((float) $qty4, 2, '.', '');
                }
                ?>
                <td class="qty4" data-qty4="<?php echo $qty4; ?>" <?php if (!empty($show_original_qty) && in_array('500', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key4 = $qty4;
                    echo $key4 + (($key4 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty5 = $resume[$key][5];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty5 = $qty5 * $rate_change;
                    $qty5 = number_format((float) $qty5, 2, '.', '');
                }
                ?>
                <td class="qty5" data-qty5="<?php echo $qty5; ?>" <?php if (!empty($show_original_qty) && in_array('1000', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key5 = $qty5;
                    echo $key5 + (($key5 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty6 = $resume[$key][6];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty6 = $qty6 * $rate_change;
                    $qty6 = number_format((float) $qty6, 2, '.', '');
                }
                ?>
                <td class="qty6" data-qty6="<?php echo $qty6; ?>" <?php if (!empty($show_original_qty) && in_array('2500', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key6 = $qty6;
                    echo $key6 + (($key6 * $cus_margin) / 100);
                    ?>
                </td>
                <?php
                $qty7 = $resume[$key][7];
                if ($cur_lang == 'sv' || $cur_lang == 'en') {
                    $qty7 = $qty7 * $rate_change;
                    $qty7 = number_format((float) $qty7, 2, '.', '');
                }
                ?>
                <td class="qty7" data-qty7="<?php echo $qty7; ?>" <?php if (!empty($show_original_qty) && in_array('5000', $show_original_qty)) {
                       echo 'style="display:none;"';
                   } ?>>
                    <?php
                    $key7 = $qty7;
                    echo $key7 + (($key7 * $cus_margin) / 100);
                    ?>
                </td>
            </tr>
            <?php
    }

    die();
}


add_action('wp_ajax_usbcomment', 'usbcomment_fnc');
add_action('wp_ajax_nopriv_usbcomment', 'usbcomment_fnc');

function usbcomment_fnc()
{
    global $wpdb;
    if (!empty(trim($_POST['usbcomment'])) && isset($_POST['usbcomment']) && isset($_POST['cus_product_id'])) {
        update_post_meta($_POST['cus_product_id'], '_usbcomment', $_POST['usbcomment']);
    }
    wp_die();
}

// redirect user as per language
add_filter('woocommerce_login_redirect', 'wc_login_redirect');

function wc_login_redirect($redirect_to)
{
    $current_user_id = get_current_user_id();
    $user_meta = get_user_meta(2, 'locale', true);
    $lang_arr = explode('_', $user_meta);
    $lang = $lang_arr[0];
    $languages = icl_get_languages('skip_missing=0');
    if (!empty($lang)) {
        $redirect_to = $languages[$lang]['url'];
        return $redirect_to;
    } else {
        return $redirect_to;
    }

}

function usb_remove_product_editor()
{
    remove_post_type_support('product', 'editor');
}
add_action('init', 'usb_remove_product_editor');


/******************************************************** Updated On 25-03-2019 ***********************************/

/* Join posts and postmeta tables
 *
 * @param string   $join
 * @param WP_Query $query
 *
 * @return string
 */
function el_product_search_join($join, $query)
{
    if (!$query->is_main_query() || is_admin() || !is_search() || !is_woocommerce()) {
        return $join;
    }

    global $wpdb;

    $join .= " LEFT JOIN {$wpdb->postmeta} el_post_meta ON {$wpdb->posts}.ID = el_post_meta.post_id ";

    return $join;
}

add_filter('posts_join', 'el_product_search_join', 10, 2);

/**
 * Modify the search query with posts_where.
 *
 * @param string   $where
 * @param WP_Query $query
 *
 * @return string
 */
function el_product_search_where($where, $query)
{
    if (!$query->is_main_query() || is_admin() || !is_search() || !is_woocommerce()) {
        return $where;
    }

    global $wpdb;

    $where = preg_replace(
        "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
        "({$wpdb->posts}.post_title LIKE $1) OR (el_post_meta.meta_key = '_sku' AND el_post_meta.meta_value LIKE $1)",
        $where
    );

    return $where;
}
add_filter('posts_where', 'el_product_search_where', 10, 2);
//USB Download PDF shortcode function
if (!function_exists('usb_pdf_down_fun')) {
    // Add Shortcode
    function usb_pdf_down_fun($atts)
    {
        $atts = shortcode_atts(array(
            'pdf_name' => ''
        ), $atts, 'usb_pdf_down_fun');
        $pdf_name = explode(",", $atts['pdf_name']);
        ob_start();
        ?>
            <a class="dwnpdf" href='' target='_blank'><?php if (!empty($pdf_name[0]))
                echo $pdf_name[0]; ?></a>
            <?php
    }
    add_shortcode('usb_pdf', 'usb_pdf_down_fun');
}

add_filter('woocommerce_account_menu_items', 'usb_remove_my_account_links');
function usb_remove_my_account_links($menu_links)
{

    unset($menu_links['edit-address']); // Addresses
    return $menu_links;
}
// Adding a custom Meta container to admin products pages for custom quantity set
add_action('add_meta_boxes', 'create_custom_meta_box_set_quantity');
if (!function_exists('create_custom_meta_box_set_quantity')) {
    function create_custom_meta_box_set_quantity()
    {
        add_meta_box(
            'set_own_quantity',
            __('Set Price For Own Quantity', 'usb'),
            'add_custom_content_meta_box',
            'product',
            'normal',
            'default'
        );
    }
}
//  Custom metabox content in admin product pages
if (!function_exists('add_custom_content_meta_box')) {
    function add_custom_content_meta_box($post)
    {
        ?>
            <table>
                <tbody>
                    <tr>
                        <td>
                            <label>Set own price 1 - 24</label><br />
                            <?php $custom_quantity_set99 = get_post_meta($post->ID, '_custom_quantity_set99', true) ? get_post_meta($post->ID, '_custom_quantity_set99', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set99" value="<?php echo $custom_quantity_set99; ?>">
                        </td>
                        <td>
                            <label>Set own price 25 - 49</label><br />
                            <?php $custom_quantity_set249 = get_post_meta($post->ID, '_custom_quantity_set249', true) ? get_post_meta($post->ID, '_custom_quantity_set249', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set249" value="<?php echo $custom_quantity_set249; ?>">
                        </td>

                        <td>
                            <label>Set own price 50 - 99</label><br />
                            <?php $custom_quantity_set499 = get_post_meta($post->ID, '_custom_quantity_set499', true) ? get_post_meta($post->ID, '_custom_quantity_set499', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set499" value="<?php echo $custom_quantity_set499; ?>">
                        </td>
                        <td>
                            <label> Set own price 100 - 499</label><br />
                            <?php $custom_quantity_set999 = get_post_meta($post->ID, '_custom_quantity_set999', true) ? get_post_meta($post->ID, '_custom_quantity_set999', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set999" value="<?php echo $custom_quantity_set999; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Set own price 500 - 999</label><br />
                            <?php $custom_quantity_set2499 = get_post_meta($post->ID, '_custom_quantity_set2499', true) ? get_post_meta($post->ID, '_custom_quantity_set2499', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set2499" value="<?php echo $custom_quantity_set2499; ?>">
                        </td>
                        <td>
                            <label>Set own price 1000 - 4999</label><br />
                            <?php $custom_quantity_set4999 = get_post_meta($post->ID, '_custom_quantity_set4999', true) ? get_post_meta($post->ID, '_custom_quantity_set4999', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set4999" value="<?php echo $custom_quantity_set4999; ?>">
                        </td>
                        <td>
                            <label>Set own price 5000 - 9999</label><br />
                            <?php $custom_quantity_set9999 = get_post_meta($post->ID, '_custom_quantity_set9999', true) ? get_post_meta($post->ID, '_custom_quantity_set9999', true) : ''; ?>
                            <input type="text" name="_custom_quantity_set9999" value="<?php echo $custom_quantity_set9999; ?>">
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php
    }
}

//Save the data of the Meta field
add_action('save_post', 'save_custom_content_meta_box', 10, 1);
if (!function_exists('save_custom_content_meta_box')) {

    function save_custom_content_meta_box($post_id)
    {

        // Sanitize user input and update the meta field in the database.
        /*update_post_meta( $post_id, '_custom_quantity_set99', wp_kses_post($_POST[ '_custom_quantity_set99' ]) );
        update_post_meta( $post_id, '_custom_quantity_set249', wp_kses_post($_POST[ '_custom_quantity_set249' ]) );
        update_post_meta( $post_id, '_custom_quantity_set499', wp_kses_post($_POST[ '_custom_quantity_set499' ]) );
        update_post_meta( $post_id, '_custom_quantity_set999', wp_kses_post($_POST[ '_custom_quantity_set999' ]) );
        update_post_meta( $post_id, '_custom_quantity_set2499', wp_kses_post($_POST[ '_custom_quantity_set2499' ]) );
        update_post_meta( $post_id, '_custom_quantity_set4999', wp_kses_post($_POST[ '_custom_quantity_set4999' ]) );
        update_post_meta( $post_id, '_custom_quantity_set9999', wp_kses_post($_POST[ '_custom_quantity_set9999' ]) );*/

        // Updating Value for Set Own Quantity
        update_post_meta($post_id, '_custom_quantity_set99', $_POST['_price_option_50']);
        update_post_meta($post_id, '_custom_quantity_set249', $_POST['_price_option_100']);
        update_post_meta($post_id, '_custom_quantity_set499', $_POST['_price_option_250']);
        update_post_meta($post_id, '_custom_quantity_set999', $_POST['_price_option_500']);
        update_post_meta($post_id, '_custom_quantity_set2499', $_POST['_price_option_1000']);
        update_post_meta($post_id, '_custom_quantity_set4999', $_POST['_price_option_2500']);
        update_post_meta($post_id, '_custom_quantity_set9999', $_POST['_price_option_5000']);
    }
}

add_action('wp_ajax_usbown_quantity', 'usbown_quantity_fnc');
add_action('wp_ajax_nopriv_usbown_quantity', 'usbown_quantity_fnc');
function usbown_quantity_fnc()
{
    global $wpdb;
    global $product;
    global $woocommerce_wpml;
    $cur_lang = ICL_LANGUAGE_CODE;

    $productid = $_POST['productid'];
    $usbquantity = $_POST['qtyval'];
    $crncyval = $_POST['curncyval'];
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncyval]['rate'];

    if ((50 <= $usbquantity) && ($usbquantity <= 99)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set99', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set99', true);
        }
    } else if ((100 <= $usbquantity) && ($usbquantity <= 249)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set249', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set249', true);
        }
    } else if ((250 <= $usbquantity) && ($usbquantity <= 499)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set499', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set499', true);
        }
    } else if ((500 <= $usbquantity) && ($usbquantity <= 999)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set999', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set999', true);
        }
    } else if ((1000 <= $usbquantity) && ($usbquantity <= 2499)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set2499', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set2499', true);
        }
    } else if ((2500 <= $usbquantity) && ($usbquantity <= 4999)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set4999', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set4999', true);
        }
    } else if ((5000 <= $usbquantity) && ($usbquantity <= 9999)) {
        if ($cur_lang == 'sv' || $cur_lang == 'en') {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set9999', true);
            $quantity_price = $quantity_price * $rate_change;
            $quantity_price = number_format((float) $quantity_price, 2, '.', '');
        } else {
            $quantity_price = get_post_meta($productid, '_custom_quantity_set9999', true);
        }
    } else {
        $quantity_price = 0;
    }
    echo $quantity_price;
    die();
}

//Standar product Offer pdf for calulation
add_action('wp_ajax_usb_product_summary', 'usb_product_summary_fnc');
add_action('wp_ajax_nopriv_usb_product_summary', 'usb_product_summary_fnc');
function usb_product_summary_fnc()
{
    $offer_id = $_POST['product_id'];
    $summary = $_POST['summary'];
    $user_ID = get_current_user_id();
    $summary_html = get_post_meta($offer_id, '_offer_summary_html' . '_' . $user_ID, true);
    update_post_meta($offer_id, '_offer_summary_html' . '_' . $user_ID, $summary, $summary_html);
}

// usb product pdf akax
add_action('wp_ajax_usb_product_summary_v2', 'usb_product_summary_v2_fnc');
add_action('wp_ajax_nopriv_usb_product_summary_v2', 'usb_product_summary_v2_fnc');

function usb_product_summary_v2_fnc()
{
    $offer_id = $_POST['product_id'];

    $oem_tlc = $_POST['oem_tlc'];
    $oem_mlc = $_POST['oem_mlc'];
    $original = $_POST['original'];

    $user_ID = get_current_user_id();

    update_post_meta($offer_id, '_offer_tlcproductsummary_html' . '_' . $user_ID, $oem_tlc);
    update_post_meta($offer_id, '_offer_mlcproductsummary_html' . '_' . $user_ID, $oem_mlc);
    update_post_meta($offer_id, '_offer_originalproductsummary_html' . '_' . $user_ID, $original);
}
//set product per page
add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 20);
function new_loop_shop_per_page($cols)
{
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    $cols = '-1';
    return $cols;
}
add_filter('woocommerce_account_menu_items', 'usbnu_remove_address_my_account', 999);
function usbnu_remove_address_my_account($items)
{
    unset($items['orders']);
    unset($items['downloads']);
    return $items;
}

/**
 * Remove password strength check.
 */
function usb_remove_password_strength()
{
    wp_dequeue_script('wc-password-strength-meter');
}
add_action('wp_print_scripts', 'usb_remove_password_strength', 10);
function customer_data_hide_function()
{
    $user = wp_get_current_user();
    if (in_array('customer', (array) $user->roles)) {
        //The user has the "author" role
        ?>
            <style type="text/css">
                .custom-usb-table-sec .customer {
                    display: none;
                }
            </style>
            <?php
    }
}
add_action('wp_footer', 'customer_data_hide_function');

function my_custom_styles()
{
    $popular_color = get_theme_value("product_popular_color_code");
    $novelty_color = get_theme_value("product_novelty_color_code");
    if (!empty($popular_color)) {
        echo "<style>.tag-sky1, .tag-sky { background:" . $popular_color . " !important }</style>";
    }
    if (!empty($novelty_color)) {
        echo "<style>.tag-red1, .tag-red { background:" . $novelty_color . " !important }</style>";
    }
}

add_action('wp_head', 'my_custom_styles');

////////////
//USB Download zip shortcode function
if (!function_exists('usb_zip_file_down_fun')) {
    // Add Shortcode
    function usb_zip_file_down_fun($atts)
    {
        $atts = shortcode_atts(
            array(
                'zip_file_name' => '',
                'zip_file_link' => '',
            ),
            $atts,
            'usb_zip_file_down_fun'
        );
        $zip_file_name = explode(",", $atts['zip_file_name']);
        $zip_file_link = explode(",", $atts['zip_file_link']);
        ob_start();
        ?>
            <p><a class="dwnzip_file"
                    href="<?php if (!empty($zip_file_link[0]))
                        echo $zip_file_link[0]; ?>"><?php if (!empty($zip_file_name[0]))
                              echo $zip_file_name[0]; ?></a>
            </p>
            <?php
    }
    add_shortcode('usb_zip_download', 'usb_zip_file_down_fun');
}


/*10-11-2020*/
/*
 * Add Revision support to WooCommerce Products
 * 
 */

// add_filter( 'woocommerce_register_post_type_product', 'cinch_add_revision_support' );

// function cinch_add_revision_support( $supports ) {
//      $supports['supports'][] = 'revisions';

//      return $supports;
// }


function modify_price_customer_tier_wise($amount)
{

    if (is_user_logged_in()) {
        $final_amt = 0;
        $user_ID = get_current_user_id();
        if (current_user_can('administrator')) {
            if (isset($_GET['user_tier']) && !empty($_GET['user_tier'])) {
                $user_level = $_GET['user_tier'];
                $price_fractor = get_field('price_fractor', 'option');
                if ($user_level) {
                    $get_discount = get_field($user_level, 'option');
                    $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
                    return $final_amt;
                } else {
                    return $amount;
                }
            } else {
                return $amount;
            }

        } else {
            $user_level = get_field('user_level', 'user_' . $user_ID);
            $price_fractor = get_field('price_fractor', 'option');
            if ($user_level) {
                $get_discount = get_field($user_level, 'option');
                $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
                return $final_amt;
            } else {
                return $amount;
            }
        }

    } else {
        $user_level = 'level_1';
        $price_fractor = get_field('price_fractor', 'option');
        if ($user_level) {
            $get_discount = get_field($user_level, 'option');
            $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
            return $final_amt;
        } else {
            return $amount;
        }

    }

}


function modify_net_price_customer_tier_wise($amount)
{

    if (is_user_logged_in()) {
        $final_amt = 0;
        $user_ID = get_current_user_id();
        if (current_user_can('administrator')) {
            if (isset($_GET['user_tier']) && !empty($_GET['user_tier'])) {
                $user_level = $_GET['user_tier'];
                $price_fractor = get_field('price_fractor', 'option');
                if ($user_level) {
                    $get_discount = get_field($user_level, 'option');
                    $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
                    return $final_amt;
                } else {
                    return $amount;
                }
            } else {
                return $amount;
            }

        } else {
            $user_level = 'level_1';
            $price_fractor = get_field('price_fractor', 'option');
            if ($user_level) {
                $get_discount = get_field($user_level, 'option');
                $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
                return $final_amt;
            } else {
                return $amount;
            }
        }

    } else {
        $user_level = 'level_1';
        $price_fractor = get_field('price_fractor', 'option');
        if ($user_level) {
            $get_discount = get_field($user_level, 'option');
            $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
            return $final_amt;
        } else {
            return $amount;
        }

    }

}

function modify_price_customer_search_tier_wise($amount)
{

    if (is_user_logged_in()) {
        $final_amt = 0;
        if (isset($_GET['user_id']) && isset($_GET['user_level'])) {

            $user_ID = $_GET['user_id'];
            $user_level = $_GET['user_level'];

            if (current_user_can('administrator')) {
                $user_level = get_field('user_level', 'user_' . $user_ID);
                $price_fractor = get_field('price_fractor', 'option');
                if ($user_level) {
                    $get_discount = get_field($user_level, 'option');
                    $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
                    return $final_amt;
                } else {
                    return $amount;
                }

            }
        }

    } else {
        $user_level = 'level_1';
        $price_fractor = get_field('price_fractor', 'option');
        if ($user_level) {
            $get_discount = get_field($user_level, 'option');
            $final_amt = (floatval($amount) * floatval($price_fractor)) - (((floatval($amount) * floatval($price_fractor)) * floatval($get_discount)) / 100);
            return $final_amt;
        } else {
            return $amount;
        }

    }

}

add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
    function loop_columns()
    {
        return 3; // 3 products per row
    }
}

function custom_sidebar()
{
    register_sidebar(array(
        'name' => __('Product Category Sidebar', 'your-theme-textdomain'),
        'id' => 'product-category',
        'description' => __('Add widgets here to appear in the custom sidebar.', 'your-theme-textdomain'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}
add_action('widgets_init', 'custom_sidebar');


// remove private product 

add_filter('posts_where', 'bbloomer_no_private_products_posts_frontend_administrator');

function bbloomer_no_private_products_posts_frontend_administrator($where)
{
    //if ( is_admin() ) return $where;
    global $wpdb;
    return " $where AND {$wpdb->posts}.post_status != 'private' ";
}
function cmp_exclude_featured_posts($query)
{

    if ($query->is_main_query()) {
        if (isset($_GET['attr_color'])) {
            $taxquery = array(
                array(
                    'taxonomy' => 'pa_color',
                    'field' => 'slug',
                    'terms' => array($_GET['attr_color']),
                    'operator' => 'IN'
                )
            );
            $query->set('tax_query', $taxquery);

        }

        if (isset($_GET['search'])) {
            $search_word = $_GET['search'];
            $query->set('s', $search_word);

        }
    }
}

add_filter('pre_get_posts', 'cmp_exclude_featured_posts');
// remove result count
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
// add_action('woocommerce_after_shop_loop_custom', 'woocommerce_result_count', 5);
// add_action('woocommerce_before_shop_loop', 'show_most_propular_product', 5);
function show_most_propular_product()
{
    if (is_product_category()) {
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $args = array(
            'post_type' => array('product'),
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'order' => 'desc',
            'posts_per_page' => 2,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id', // Field to query by term_id
                    'terms' => $term_id, // Replace with the actual term ID
                ),
            ),
        );

        $popular_products = new WP_Query($args);
        if ($popular_products->have_posts()):
            echo '<div class="most_propular_product mt-4 mb-4">';
            echo '<div class="row">';
            while ($popular_products->have_posts()):
                $popular_products->the_post();
                wc_get_template_part('large', 'product');
            endwhile;
            echo '</div>';
            echo '</div>';
        endif;

        wp_reset_postdata();
    }
}

add_action('pre_get_posts', 'exclude_specific_products', 20);
//add_action( 'wp', 'exclude_specific_products',20 );
function exclude_specific_products($query)
{
    // Check if on the shop page and it's the main query

    // if ( ! $query->is_main_query() ) return;
    if (is_product_category() && $query->is_main_query()) {
        $excluded_product_ids = array();
        $queried_object = get_queried_object();
        $term_id = $queried_object->term_id;
        $args = array(
            'post_type' => array('product'),
            'meta_key' => 'total_sales',
            'orderby' => 'meta_value_num',
            'order' => 'desc',
            'fields' => 'ids', // Retrieve only post IDs
            'posts_per_page' => 2,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id', // Field to query by term_id
                    'terms' => $term_id, // Replace with the actual term ID
                ),
            ),
        );
        $exluded_post_ids = get_posts($args);
        if ($exluded_post_ids):
            foreach ($exluded_post_ids as $product_ids):
                array_push($excluded_product_ids, $product_ids);
            endforeach;
        endif;
        $query->set('post__not_in', $excluded_product_ids);
    }

}

remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10);
function abChangeProductsTitle()
{
    echo '<a href="' . get_the_permalink() . '"><h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3></a>';
}
// save product ids in cookie
add_action('template_redirect', 'save_recent_product_to_cookie', 9999);

function save_recent_product_to_cookie()
{
    if (!is_singular('product'))
        return;
    global $post;
    if (empty($_COOKIE['usb_recently_viewed'])) {
        $viewed_products = array();
    } else {
        $viewed_products = wp_parse_id_list((array) explode('|', wp_unslash($_COOKIE['usb_recently_viewed'])));
    }
    $keys = array_flip($viewed_products);
    if (isset($keys[$post->ID])) {
        unset($viewed_products[$keys[$post->ID]]);
    }
    $viewed_products[] = $post->ID;
    if (count($viewed_products) > 15) {
        array_shift($viewed_products);
    }
    wc_setcookie('usb_recently_viewed', implode('|', $viewed_products));
}

add_shortcode('recently_viewed_products', 'usb_recently_viewed_shortcode');

function usb_recently_viewed_shortcode()
{
    $viewed_products = !empty($_COOKIE['usb_recently_viewed']) ? (array) explode('|', wp_unslash($_COOKIE['usb_recently_viewed'])) : array();
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if (empty($viewed_products))
        return;
    $title = '<h3>Recently Viewed Products</h3>';
    $product_ids = implode(",", $viewed_products);
    return $title . do_shortcode("[products ids='$product_ids']");
}


add_action('woocommerce_after_shop_loop', 'show_recent_products_from_cookie', 99);

function show_recent_products_from_cookie()
{

    $viewed_products = !empty($_COOKIE['usb_recently_viewed']) ? (array) explode('|', wp_unslash($_COOKIE['usb_recently_viewed'])) : array();
    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));
    if (empty($viewed_products))
        return;


    if ($viewed_products) {

        $args = array(
            'post_type' => array('product'),
            'post__in' => $viewed_products,
            'posts_per_page' => 5,

        );

        $get_viewed_products = new WP_Query($args);
        if ($get_viewed_products->have_posts()):
            echo '<div class="show_recent_product mt-4 mb-4 clear">';
            echo '<div class="row">';
            echo $title = '<h3>Recently Viewed Products</h3>';
            while ($get_viewed_products->have_posts()):
                $get_viewed_products->the_post();
                wc_get_template_part('small', 'product');
            endwhile;
            echo '</div>';
            echo '</div>';
        endif;

        wp_reset_postdata();
    }
}
// disable zoom
function remove_image_zoom_support()
{
    remove_theme_support('wc-product-gallery-zoom');
}
add_action('wp', 'remove_image_zoom_support', 999);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

add_action('custom_tab_data', 'woocommerce_output_product_data_tabs');

/* create user role for translator*/
$user_role = __DIR__ . '/inc/user-role.php';
require_once $user_role;
$translator_view = __DIR__ . '/inc/class-translator_view.php';
require_once $translator_view;

global $current_user;
$user_id = get_current_user_id();
$specific_role = 'translator'; // Replace 'editor' with the role you want to check
if (current_user_has_role($specific_role)) {
    $translator_menu = __DIR__ . '/inc/class_menu_for_translator.php';
    require_once $translator_menu;
}

// add code hide admin menu for translator 17-05-2024

function current_user_has_role($role)
{
    // Get the current user
    $current_user = wp_get_current_user();

    // Check if the user has the specified role
    if (in_array($role, (array) $current_user->roles)) {
        return true;
    }

    return false;
}
add_action('admin_head', 'admin_css_for_hide');
function admin_css_for_hide()
{
    global $current_user;
    $user_id = get_current_user_id();
    $specific_role = 'translator'; // Replace 'editor' with the role you want to check
    if (current_user_has_role($specific_role)) {

        echo '<style>
        #menu-posts-iksm_faq{display:none !important;}
        #toplevel_page_header{display:none !important;}
        #menu-tools{display:none !important;}        
         #menu-posts-user-tier,#toplevel_page_tm-menu-main,#toplevel_page_membership-level,#menu-media,#menu-posts-sliders,#menu-comments{display:none !important;}
    } 
  </style>';

    }

}
function get_translated_post_ids($post_id)
{

    global $sitepress;
    $translated_ids = array();
    if (!isset($sitepress))
        return;
    $trid = $sitepress->get_element_trid($post_id, 'post_product');
    $translations = $sitepress->get_element_translations($trid, 'product');
    foreach ($translations as $lang => $translation) {
        $translated_ids[] = $translation->element_id;
    }
    return $translated_ids;
}


add_action('init', 'submit_clear_recent');

function submit_clear_recent()
{
    if (isset($_POST['clear_recent_products'])) {
        $cookie_name = 'usb_recently_viewed';

        // Get the current expiration time of the cookie if it exists
        $current_expiration = isset($_COOKIE[$cookie_name]) ? time() + 86400 : 0; // default 1 day if not already set

        // Set the cookie with an empty value and the same expiration time
        setcookie($cookie_name, '', $current_expiration, COOKIEPATH, COOKIE_DOMAIN);

        // Update the value in the $_COOKIE superglobal
        $_COOKIE[$cookie_name] = '';
    }
}



require get_template_directory() . '/functions/woocommerce/price_calculation_single_product.php';

require get_template_directory() . '/functions/woocommerce/price_show_products.php';

require get_template_directory() . '/functions/woocommerce/shop_ajax.php';


add_action('acf/save_post', 'sync_specific_acf_options_across_languages', 20);

function sync_specific_acf_options_across_languages($post_id)
{
    // Only proceed if this is the options page with the slug 'membership-level'
    if ($post_id !== 'options') {
        return;
    }

    // Verify if we are on the correct options page
    if (isset($_GET['page']) && $_GET['page'] === 'membership-level') {

        // Get the current language
        $current_lang = apply_filters('wpml_current_language', NULL);

        // Get all active languages
        $languages = apply_filters('wpml_active_languages', NULL, 'skip_missing=0');

        // Specific ACF fields to sync
        $fields_to_sync = array('level_1', 'level_2', 'level_3', 'level_4', 'level_5', 'price_fractor');

        // Loop through each language and update the specified fields
        if ($languages && !empty($fields_to_sync)) {
            foreach ($languages as $lang) {
                if ($lang['code'] !== $current_lang) {
                    // Switch to the other language
                    do_action('wpml_switch_language', $lang['code']);

                    // Update the specified fields in the other language
                    foreach ($fields_to_sync as $field_key) {
                        $translated_key = '' . $lang['code'] . '_' . $field_key;
                        $field_value = get_field($field_key, 'options'); // Get field value from original language
                        update_field($translated_key, $field_value, 'options');
                    }
                }
            }

            // Switch back to the original language
            do_action('wpml_switch_language', $current_lang);
        }
    }
}


function custom_product_categories_shortcode()
{
    ob_start();

    // Get all product categories
    $args = array(
        'taxonomy' => 'product_cat',
        'hide_empty' => true,
        'parent' => 0,
        'orderby' => 'id',
        'order' => 'ASC'
    );
    $categories = get_terms($args);

    if ($categories && !is_wp_error($categories)) {
        echo '<div class="custom-accordion">'; ?>
       <?php /** do not remove this code */?>
            <div class="filter-btn-ac">
                <button class="filter-toggle">Filter</button>
            </div>
            <?php /** do not remove this code */?>
            <div class="category-wrap">
            <?php
            foreach ($categories as $category) {
                $cat_id = $category->term_id;
                $cat_name = $category->name;
                $cat_count = $category->count;

                // Check for subcategories
                $subcategories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'hide_empty' => true,
                    'parent' => $cat_id
                ));

                if ($subcategories && !is_wp_error($subcategories)) {
                    // Output accordion header
                    echo '<div class="accordion-header"><a href="' . get_term_link($cat_id) . '">' . esc_html($cat_name) . '</a> (' . esc_html($cat_count) . ')</div>';
                    echo '<div class="accordion-content">';
                    echo '<ul>';

                    foreach ($subcategories as $subcategory) {
                        $subcat_id = $subcategory->term_id;
                        $subcat_name = $subcategory->name;
                        $subcat_count = $subcategory->count;
                        echo '<li><a href="' . get_term_link($subcat_id) . '">' . esc_html($subcat_name) . '</a> (' . esc_html($subcat_count) . ')</li>';
                    }

                    echo '</ul>';
                    echo '</div>';
                } else {
                    // Output category without subcategories
                    echo '<div class="category-item"><a href="' . get_term_link($cat_id) . '">' . esc_html($cat_name) . '</a> (' . esc_html($cat_count) . ')</div>';
                }
            }

            echo '</div>';?>
            </div>
            <?php
    }

    return ob_get_clean();
}
add_shortcode('custom_product_categories', 'custom_product_categories_shortcode');

acf_add_options_page(array(
    'page_title' => 'Footprint Option Setting',
    'menu_title' => 'Footprint Logos',
    'menu_slug' => 'footprint-option-settings',
    'capability' => 'edit_posts',
    'redirect' => false
));


// Dynamically populate checkbox field with logos from the options page
add_filter('acf/load_field/name=select_footprint', 'populate_footprint_checkbox_with_images');
function populate_footprint_checkbox_with_images($field)
{
    // Get the logos repeater field from the options page
    $footprints = get_field('footprint_option', 'option');

    // Reset the choices
    $field['choices'] = array();

    // Loop through each footprint and add it as a checkbox option
    if ($footprints) {
        foreach ($footprints as $index => $footprint) {
            $logo_image_url = $footprint['footprint_logo']['url']; // Get the image URL
            $logo_label = '<img src="' . $logo_image_url . '" style="max-width: 50px; height: auto;" />'; // Display logo image

            // Add to checkbox options (image URL as value, logo image as label)
            $field['choices'][$logo_image_url] = $logo_label;
        }
    }

    // Automatically check all checkboxes by default
    $field['value'] = array_keys($field['choices']); // Set all choices as selected

    return $field;
}


// Display custom price for quantity 50-99 under the product title
function display_custom_quantity_price_after_title()
{
    global $product;
    global $woocommerce_wpml;

    $cur_lang = ICL_LANGUAGE_CODE;
    $crncy = get_woocommerce_currency();
    $rate_change = $woocommerce_wpml->settings['currency_options'][$crncy]['rate'];

    $rate_change = get_field('price_fractor', 'option');

    // if ($crncy == 'SEK') {
    //     $crncy = ' Kr';
    // }


    // Check if we are in a WooCommerce loop and the product is available
    if (!is_a($product, 'WC_Product')) {
        return;
    }

    // Get the translated product ID for the current language (for WPML)
    $product_id = apply_filters('wpml_object_id', $product->get_id(), 'product', true);

   

    $price_500 = get_post_meta(get_the_ID(), '_price_option_500', true);

    $price_500 = modify_price_customer_tier_wise($price_500);




    if ( $rate_change > 0 ) {
        $price_500 = floatval($rate_change) * floatval($price_500);
        }

    // Display the price if it exists
    if (!empty($price_500)) {

        // ROUND TO NEAREST 0.50

        $price_500 = round($price_500 * 2) / 2;

        $price_num = number_format((float)$price_500, 2, ',', ' ');

        $int_part = '';
        $decimal_part = '';

        list($int_part, $decimal_part) = explode(',', $price_num);
        //echo '<p class="custom-price-range">' .__('From').$price_num .get_woocommerce_currency_symbol(). '</p>';
        echo '<p class="custom-price-range"><span class="from_span">'. __('FROM ', 'usb').'</span><span  class="price_span">' . $int_part . ',<sup class="decimal-part">' . $decimal_part . '</sup> '. get_woocommerce_currency_symbol(). '</span></p>';
    }
}

// Hook to display custom price after product title in WooCommerce loop
add_action('woocommerce_after_shop_loop_item_title', 'display_custom_quantity_price_after_title', 15);



// SKU as article numbner

// Display SKU as "Article No." after product title
function display_sku_as_article_no_after_title()
{
    global $product;

    // Check if we are in a WooCommerce loop and the product is available
    if (!is_a($product, 'WC_Product')) {
        return;
    }

    // Get the SKU
    $sku = $product->get_sku();

    // Display SKU as Article No. if it exists
    if (!empty($sku)) {
        echo '<p class="product-article-no">Article No.: ' . esc_html($sku) . '</p>';
    }
}

// Hook to display SKU after product title and before price in WooCommerce loop
add_action('woocommerce_after_shop_loop_item_title', 'display_sku_as_article_no_after_title', 5);

add_action('admin_enqueue_scripts', 'enqueue_custom_js_for_new_product');

function enqueue_custom_js_for_new_product($hook)
{
    // Check if the current screen is the "Add New Product" page
    $screen = get_current_screen();
    if ($screen && $screen->id === 'product' && $screen->action === 'add') {
        // Enqueue your custom JavaScript
        wp_enqueue_script(
            'custom-new-product-js',
            get_template_directory_uri() . '/admin_js/custom-new-product.js', // Path to your JS file
            array('jquery'), // Dependencies
            time(),
            true // Load in footer
        );
    }
}



//do_action( 'wpml_register_string', 'usb', 'tab_specifications', 'Specifications' );
/** 20 mar 25 */
add_filter('woocommerce_breadcrumb_defaults', function ($defaults) {
    $defaults['delimiter'] = ' <span class="breadcrumb-icon">></span> '; // Change ▶ to your preferred icon
    return $defaults;
});

// add_action('admin_head-users.php', function () {
//     echo '<style>
//         .users-php .search-box {
//             display: none !important;
//         }
//     </style>';
// });

// add_action('admin_init', 'action_admin_init' )

// /**
//  * Fires as an admin screen or script is being initialized.
//  *
//  */
// function action_admin_init() {
//     $screen = get_current_screen();

// print_r($screen );
// }

add_action('admin_enqueue_scripts', 'enqueue_script_on_users_list_page');

function enqueue_script_on_users_list_page($hook)
{
    // Get the current screen
    $screen = get_current_screen();

    // Use URI for URLs, not get_stylesheet_directory()
    $uri = get_stylesheet_directory_uri() . '/assets/admin/';
    $ver = time(); // Define a version

    // Register styles and scripts
    wp_register_style('select_2_css_user', $uri . 'select2.min.css', [], $ver);
    wp_register_style('admin_style_modification', $uri . 'admin_style.css', [], $ver);

    wp_register_script('select_2_js_user', $uri . 'select2.min.js', ['jquery'], $ver, true);
    wp_register_script('admin_script_modification', $uri . 'admin_script.js', ['jquery'], $ver, true);

    // Enqueue Select2 only on the Users list page
    if (!empty($screen) && 'users' === $screen->id) {
        wp_enqueue_style('select_2_css_user');
        wp_enqueue_script('select_2_js_user');
    }

    // Enqueue admin styles and script on all admin pages
    wp_enqueue_style('admin_style_modification');
    wp_enqueue_script('admin_script_modification');
}

// add_filter('wp_nav_menu_objects', 'add_position_based_query_to_submenus', 10, 2);

// function add_position_based_query_to_submenus($items, $args) {

//      $menuLocation = array('main-menu','cat_1', 'cat_2','cat_3','cat_4');
//     if (!in_array($args->theme_location, $menuLocation)) {
//         return $items;
//     }


// if($args->theme_location == 'main-menu'){
//     $parent_positions = [];
//     $position = 1;

//     // Map top-level menu item IDs to their numeric position
//     foreach ($items as $item) {
//         if ($item->menu_item_parent == 0) {
//             $parent_positions[$item->ID] = $position;
//             $position++;
//         }
//     }

//     // For each submenu item, append ?parent=POSITION
//     foreach ($items as $item) {
//         $parent_id = $item->menu_item_parent;
//         if ($parent_id && isset($parent_positions[$parent_id])) {
//             $item->url = add_query_arg('parent', $parent_positions[$parent_id], $item->url);
//         }
//     }
// }else{
//     // foreach ($items as $item) {
//     //     $parent_id = $item->menu_item_parent;
//     //     if ($parent_id) {
//     //         $item->url = add_query_arg('parent', (int)substr($args->theme_location, -1)+1, $item->url);
//     //     }
//     // }
// }

//     return $items;
// }

add_filter('wp_nav_menu_objects', 'add_parent_param_by_menu_location', 10, 2);

function add_parent_param_by_menu_location($items, $args) {

    if (empty($args->theme_location)) {
        return $items;
    }

     // Fixed mapping for category menus
    $location_parent_map = [
        'cat_1' => 1,
        'cat_2' => 2,
        'cat_3' => 3,
        'cat_4' => 4,
    ];

    if ($args->theme_location === 'main-menu') {

        $top_index = 0;
        $parent_map = [];

        // STEP 1: Assign parent values to top-level items
        foreach ($items as $item) {

            if ((int) $item->menu_item_parent === 0) {

                $top_index++;

                // 🔥 EXACT rule:
                // 1 → 1
                // 2 → 1
                // 3 → 2
                // 4 → 3
                // 5 → 4 ...
                $parent_value = max(1, $top_index - 1);

                $parent_map[$item->ID] = $parent_value;
            }
        }

        // STEP 2: Apply parent param to sub-menu URLs
        foreach ($items as $item) {

            if ($item->menu_item_parent && isset($parent_map[$item->menu_item_parent])) {

                $clean_url = remove_query_arg('parent', $item->url);

                $item->url = add_query_arg(
                    'parent',
                    $parent_map[$item->menu_item_parent],
                    $clean_url
                );
            }
        }

        return $items;
    }

    /*
     * CAT MENUS → fixed parent value
     */
    if (isset($location_parent_map[$args->theme_location])) {

        $parent_value = (int) $location_parent_map[$args->theme_location];

        foreach ($items as $item) {

            if ((int) $item->menu_item_parent !== 0) {

                $clean_url = remove_query_arg('parent', $item->url);

                $item->url = add_query_arg(
                    'parent',
                    $parent_value,
                    $clean_url
                );
            }
        }
    }


    return $items;
}






add_filter('wp_nav_menu_objects', 'add_product_cat_count_to_menu', 10, 2);
function add_product_cat_count_to_menu($items, $args) {
    $menuLocation = array('cat_1', 'cat_2','cat_3','cat_4');
    if (!in_array($args->theme_location, $menuLocation)) {
        return $items;
    }

    foreach ($items as $item) {
        // Only for category items
        if ($item->type === 'taxonomy' && $item->object === 'product_cat') {
            $term = get_term($item->object_id, 'product_cat');
            if ($term && !is_wp_error($term)) {
                $item->title .= ' (' . $term->count . ')';
            }
        }
    }

    return $items;
}

add_filter( 'posts_search', 'search_products_by_title_or_sku', 10, 2 );

function search_products_by_title_or_sku( $search, $query ) {

    global $wpdb;

    // Only modify search for WooCommerce product post type
    if ( ! is_admin() && isset( $query->query_vars['post_type'] ) && 'product' === $query->query_vars['post_type'] ) {

        $search_term = $query->get( 's' );

        if ( ! empty( $search_term ) ) {
            $query->set( 's', '' ); // Clear the default search

            $search = " AND (
                ({$wpdb->prefix}posts.post_title LIKE '%" . esc_sql( $search_term ) . "%')
                OR EXISTS (
                    SELECT 1 FROM {$wpdb->prefix}postmeta
                    WHERE {$wpdb->prefix}postmeta.post_id = {$wpdb->prefix}posts.ID
                    AND {$wpdb->prefix}postmeta.meta_key = '_sku'
                    AND {$wpdb->prefix}postmeta.meta_value LIKE '%" . esc_sql( $search_term ) . "%'
                )
            )";
        }
    }

    return $search;
}




/**
 * Safely repair Swedish (and general UTF-8) mojibake without damaging normal text.
 */

/**
 * Fixes broken Swedish mojibake and bad UTF-8 safely using simple str_replace.
 */
function wp_safe_utf8_fix($text) {
    if (empty($text) || !is_string($text)) {
        return $text;
    }

    // Step 1: Remove invisible BOM bytes if any
    if (substr($text, 0, 3) === "\xEF\xBB\xBF") {
        $text = substr($text, 3);
    }

    // Step 2: Remove artifacts from import or Excel (_x000D_)
    $text = str_replace('_x000D_', "\n", $text);

    // Step 3: Replace common mojibake sequences and smart-quote garbage
    $replace_map = [
        // Common mojibake or corrupted smart quotes
        '�??' => '”',
        '�?�' => '”',
        '�?'  => '”',
        '�'   => '',
        // Sometimes broken en/em dashes
        'â€“' => '–',
        'â€”' => '—',
        // Common misencodings for Swedish letters
        'Ã¤' => 'ä',
        'Ã¥' => 'å',
        'Ã¶' => 'ö',
        'Ã„' => 'Ä',
        'Ã…' => 'Å',
        'Ã–' => 'Ö',
        // Fix smart quotes (optional)
        'â€œ' => '“',
        'â€' => '”',
        'â€™' => '’',
        'â€˜' => '‘',
        // Fix ellipsis
        'â€¦' => '…',
        'â€¦' => '…',
        'â„¢' => '™',
    ];

    $text = str_replace(array_keys($replace_map), array_values($replace_map), $text);

    // Step 4: Decode HTML entities (like &amp;)
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');

    // Step 5: Clean extra whitespace or stray characters
    $text = trim($text);

    return $text;
}