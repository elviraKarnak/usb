<?php
/*add_action('wp_enqueue_scripts', 'toprpm_ajax_scripts');

function toprpm_ajax_scripts() {
	wp_enqueue_script('jquery-form');
	$ajaxurl = admin_url('admin-ajax.php');
	wp_localize_script( 'jquery-core', 'ajaxVars', array( 'ajaxurl' => $ajaxurl,  ) );
}

// Enable the user with no privileges to run ajax_login() in AJAX
add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
  	// Call auth_user_login
  	
	auth_user_login($_POST['username'], $_POST['password'], $_POST['remember']); 
	
    die();
}

function auth_user_login($user_login, $password, $login=null)
{
	$info = array();
    $info['user_login'] = $user_login;
    $info['user_password'] = $password;
    $info['remember'] = !empty($login)? true : false;
	
	$user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
		echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
		wp_set_current_user($user_signon->ID); 
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful')));
    }
	
	die();
}

// determine the topmost parent of a term
function get_term_top_most_parent($term_id, $taxonomy){
    // start from the current term
    $parent  = get_term_by( 'id', $term_id, $taxonomy);
    // climb up the hierarchy until we reach a term with parent = '0'
    while ($parent->parent != '0'){
        $term_id = $parent->parent;

        $parent  = get_term_by( 'id', $term_id, $taxonomy);
    }
    return $parent;
}*/

        /**
         * Create custom taxonomy for products
         */    
        function usb_quantity_taxonomy() {
            $labels = array(
                'name'              => _x( 'Usb Quantity', 'taxonomy general name' ),
                'singular_name'     => _x( 'Usb Quantity', 'taxonomy singular name' ),
                'search_items'      => __( 'Search Usb Quantity' ),
                'all_items'         => __( 'All Usb Quantity' ),
                'parent_item'       => __( 'Parent Usb Quantity' ),
                'parent_item_colon' => __( 'Parent Usb Quantity' ),
                'edit_item'         => __( 'Edit Usb Quantity' ), 
                'update_item'       => __( 'Update Usb Quantity' ),
                'add_new_item'      => __( 'Add New Usb Quantity' ),
                'new_item_name'     => __( 'New Usb Quantity' ),
                'menu_name'         => __( 'Usb Quantity' ),
            );
        
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => true,
            'show_admin_column' => true
        );
        
        register_taxonomy( 'usb_quantity', 'product', $args );
                
    }
    add_action( 'init', 'usb_quantity_taxonomy', 0 );

