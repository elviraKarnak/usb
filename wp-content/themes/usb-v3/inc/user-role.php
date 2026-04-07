<?php // Function to copy capabilities from one role to another
function copy_role_capabilities($from_role, $to_role) {
    global $wp_roles;

    $from_caps = $wp_roles->get_role($from_role)->capabilities;
    $to_role_obj = $wp_roles->get_role($to_role);

    foreach ($from_caps as $cap => $grant) {
        $to_role_obj->add_cap($cap, $grant);
    }
}

// Create translator role and copy capabilities from editor role
function create_translator_role() {
    global $wp_roles;

    // Add new role
    add_role('translator', __('Translator'), $wp_roles->get_role('editor')->capabilities);

    // Copy capabilities from editor to translator
    copy_role_capabilities('editor', 'translator');
}
add_action('init', 'create_translator_role');

// create metabox for assign tranlator

// Function to add metabox for product post type
function add_product_metabox() {
    add_meta_box(
        'translator_metabox', // Metabox ID
        __('Assign Translator'), // Metabox Title
        'translator_assign_callback', // Callback function to render the metabox content
        'product', // Post type to add the metabox to
        'normal', // Context (normal, side, advanced)
        'high' // Priority (high, default, low)
    );
}
add_action('add_meta_boxes', 'add_product_metabox');

// Callback function to render the metabox content
function translator_assign_callback($post) {  

    $current_user_id=get_current_user_id();

    $_assign_translator=get_post_meta($post->ID,'_assign_translator',true);

    echo "<input type='hidden' id='current_post_id' name='current_post_id' value='{$post->ID}'>";
    echo "<input type='hidden' id='current_user_id' name='current_user_id' value='{$current_user_id}'>";
    // Output fields
    echo '<p for="assign_translator">' . __('Translator') . '</p>';
    custom_dropdown_users_by_role('translator',$_assign_translator);
    echo "<button class='assign_translator button button-primary button-large'>Assign </button>";
    echo "<p id='response_div'></p>";
}


function custom_dropdown_users_by_role($role,$assign_translator) {
    // Get users with the specified role
    $users = get_users(array(
        'role'    => $role,
        'orderby' => 'display_name',
    ));

    // If users exist, create the dropdown
    if (!empty($users)) {
        $options = array();
        foreach ($users as $user) {
            $options[$user->ID] = $user->display_name;
        }


        $_assign_translator=$assign_translator;
        // Generate dropdown
        $args = array(
            'name'             => 'user_dropdown',
            'id'               => 'translator_drp',
            'show_option_none' => __('Select User'),
            'option_none_value' => '',
            'selected'         => isset($_POST['user_dropdown']) ? $_POST['user_dropdown'] : '', // Set selected user if form submitted
            'class'            => 'user-dropdown', // Add a custom class if needed
            'echo'             => false, // We will echo it later
            'class'            => 'postform',
            'depth'            => 0,
            'tab_index'        => 0,
            'include_selected' => true, // Set to true to include the selected user in the dropdown options          
            'value_field'      => 'ID', // Which field to use for the option value
            'selected'         => isset($_assign_translator) ? $_assign_translator : '', // Set selected user if form submitted
            'option_none_value' => -1, // Custom value for "Select User"
            'role'             => $role, // Filter by role
        );

      
        // Generate the dropdown HTML
        $dropdown = wp_dropdown_users($args);

        // Output the dropdown
        echo $dropdown;
    } else {
        echo '<p>No users found with the specified role.</p>';
    }
}

function enqueue_custom_admin_script() {
    wp_enqueue_script('assign_user-script', get_stylesheet_directory_uri() . '/inc/backend_js/assign_user.js', array('jquery'), time(), true);
    wp_localize_script('assign_user-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_script');

function create_custom_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'translator_assign';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(25) NOT NULL AUTO_INCREMENT,
        post_id varchar(100) NOT NULL,
        assign_user_id varchar(100) NOT NULL,
        translator_user_id varchar(100) NOT NULL,
        status int(1)  NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('init', 'create_custom_table');


function assign_translator_ajax_function() {
    global $wpdb; // Make sure to use the global wpdb object
    $response='test';
    $translator_user_id=$_POST['form_data'];
    $current_user_id   =$_POST['current_user_id'];
    $post_id           =$_POST['current_post_id'];
    $status            =1;
    if($translator_user_id ):        
        // Define the custom table name
       update_post_meta($post_id,'_assign_translator',$translator_user_id);
       $table_name = $wpdb->prefix . 'translator_assign'; // Use the prefix to stay consistent with other WordPress tables

        // Prepare data to insert
        $data = array(
            'post_id'            => $post_id,
            'assign_user_id'     => $current_user_id,
            'translator_user_id' => $translator_user_id,
            'status'             => $status            
        ); 

        $where_clause = [];
        foreach ($data as $column => $value) {
            $where_clause[] = $wpdb->prepare("{$column} = %s", $value);
        }
        $where_clause = implode(' AND ', $where_clause);
        $query = "SELECT COUNT(*) FROM {$table_name} WHERE {$where_clause}";

        $record_exists = $wpdb->get_var($query);

        if ($record_exists > 0) {

            $response= "Translator assigned already";

        }else{


            $translated_post=get_translated_post_ids($post_id);

            $update_status = array(
       
                'ID' => $translated_post,
                'post_status' => 'draft'
            );
            $statusTest = wp_update_post($update_status);


            $product_url=get_the_permalink($post_id);


            $user = get_userdata($translator_user_id);
                // Retrieve necessary data
            $user_email = $user->user_email;
            $user_name = $user->display_name;

            $subject = "Hello, $user_name!";

                // Email message
            $message = "Hi $user_name,\n\nYou are assign a translation job for product $product_url\n\n";

                // Email headers (optional)
            $headers = array('Content-Type: text/plain; charset=UTF-8');
            $user_email='prasanta@elvirainfotech.com';
            // Send the email
            $sent = wp_mail($user_email, $subject, $message, $headers);

            // Check if the email was sent successfully
            if ($sent) {
                echo "Email sent successfully!";
            } else {
                echo "Failed to send email.";
            }
            $inserted = $wpdb->insert(
                $table_name, // The table name
                $data, // The data to insert     
            );

            if ($inserted === false) {
                // If insertion failed, handle the error
               $response= "Error ";
            } else {
                // If insertion succeeded, you can get the inserted ID
                $inserted_id = $wpdb->insert_id;
                $response= "Translator assigned ";
            }
        }

    endif;
  
    echo json_encode($response); // Return the response
    wp_die(); // Always include wp_die() at the end of your callback function
}
add_action('wp_ajax_assign_translator', 'assign_translator_ajax_function'); // For logged-in users
add_action('wp_ajax_nopriv_assign_translator', 'assign_translator_ajax_function'); // For non-logged-in users