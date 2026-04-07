<?php 
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
class Zip_LIST extends WP_List_Table
{

    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'Zipcode',
            'plural'   => 'Zipcode',
        ));
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    function column_zipcode($item)
    {
        return '<em>' . $item['zipcode'] . '</em>';
    }


    function column_id($item)
    {

        $actions = array(
           // 'edit' => sprintf('<a href="?page=zipcode-manage&id=%s">%s</a>', $item['id'], __('Edit', 'usb-tab')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'usb-tab')),
        );

        return sprintf('%s %s',
            $item['id'],
            $this->row_actions($actions)
        );
    }


    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }


    function get_columns()
    {
        $columns = array(
            'cb'                  => '<input type="checkbox" />', //Render a checkbox instead of text
            'id'                  => __('Id', 'usb-tab'),
            'post_title'             => __('Post Title', 'usb-tab'),
            'assign_user_display_name'      => __('Assign User', 'usb-tab'),
            'translator_user_display_name'  => __('Translator User', 'usb-tab'),
            'status'              => __('Status', 'usb-tab'),
            
        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'id' => array('Id', true),
            'zipcode' => array('Zipcode', false)
           
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'translator_assign'; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'translator_assign'; 
        $per_page = 15; 
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();   
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->process_bulk_action();

        if (isset($_REQUEST['s'])) {
           $search_query = sanitize_text_field($_REQUEST['s']);
           $query = $wpdb->prepare("SELECT COUNT(id) FROM $table_name  WHERE post_id LIKE %s", '%' . $search_query . '%');         
           $total_items = $wpdb->get_var($query);
           //die;
        }else{
            $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");
        }
        
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

        // if (isset($_REQUEST['s'])) {
        //     $search_query = sanitize_text_field($_REQUEST['s']);
        //     $query = $wpdb->prepare("SELECT * FROM $table_name WHERE zipcode LIKE %s", '%' . ($search_query) . '%');
        //     $this->items = $wpdb->get_results($query,ARRAY_A);
        // }else{
        //     $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        // }

        $current_table_dt=$wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);
        $final_array=array();

        if($current_table_dt){
            foreach($current_table_dt as $tbale_as){
                $array_part=array();
                $array_part['id']=$tbale_as['id'];
                $array_part['post_id']=$tbale_as['post_id'];
                $post_id= $tbale_as['post_id'];

                $query = $wpdb->prepare("SELECT post_title FROM $wpdb->posts WHERE ID = %d AND post_status = 'publish' AND post_type = 'product'",$post_id);
                $post_title = $wpdb->get_var( $query );

                if($post_title){

                   // echo $post_title;
                   $array_part['post_title']=$post_title;

                }else{

                    $array_part['post_title']='';
                }
                 if($tbale_as['assign_user_id']){
                    $array_part['assign_user_id']=$tbale_as['assign_user_id'];
                    $assign_user = get_user_by( 'ID', $array_part['assign_user_id'] );
                    $assign_user_display_name = $assign_user->display_name;
                    $array_part['assign_user_display_name']=$assign_user_display_name;
                }

                if($tbale_as['translator_user_id']){
                    $array_part['translator_user_id']=$tbale_as['translator_user_id'];
                    $translator_user = get_user_by( 'ID', $array_part['translator_user_id'] );
                    $translator_user_display_name = $translator_user->display_name;
                    $array_part['translator_user_display_name']=$translator_user_display_name;
                }                


                if($tbale_as['status']==1){
                     $array_part['status']='Assigned';

                }
               
                $final_array[]=$array_part;

                $this->items = $final_array;
            }

        }

        // echo "<pre>";

        // print_r($final_array);

        // die;


        
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }

     public function search_box($text, $input_id) {
        $placeholder = 'Enter Zipcode'; // Customize the placeholder text here

        parent::search_box($text, $input_id, $placeholder);
    }


    public function display() {
        // Output the search box
         $placeholder = 'Enter Zipcode'; // Customize the placeholder text here
        $this->search_box('Search', 'search-box-id',$placeholder);

        // Output the table
        parent::display();
    }



}



function zipcode_page_handler()
{
    global $wpdb;

    $table = new Zip_LIST();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Translation Job deleted: %d', 'usb-tab'), $_REQUEST['id']) . '</p></div>';
        //echo "test";
    }
    ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Translation Management', 'usb-tab')?></h2>
        <?php echo $message; ?>
        <form id="persons-table" method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php $table->display() ?>
        </form>
    </div>
<?php
}

function zipcode_form_page_handler()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'translator_assign'; // do not forget about tables prefix
    $message = '';
    $notice = '';
    $default = array(
        'id'        => 0,
        'zipcode'   => '',
        'location'  => null     
    );

    // here we are verifying does this request is post back and have correct nonce
    if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        $item = shortcode_atts($default, $_REQUEST);
        $item_valid = validate_zipcode($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $wpdb->show_errors();
                $result = $wpdb->insert($table_name, $item);               
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Zipcode was successfully saved', 'usb-tab');
                } else {
                    $notice = __('There was an error while saving item', 'usb-tab');
                }
            } else {
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Zipcode was successfully updated', 'usb-tab');
                } else {
                    $notice = __('There was an error while updating item', 'usb-tab');
                }
            }
        } else {
            $notice = $item_valid;
        }
    }
    else {    
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'usb-tab');
            }
        }
    }
    add_meta_box('persons_form_meta_box', 'Zipcode Data', 'zipcode_form_meta_box_handler', 'person', 'normal', 'default');

    ?>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Zipcode', 'usb-tab')?><a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=zipcode-table');?>"><?php _e('back to list', 'usb-tab')?></a></h2>
    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

    <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        <?php /* NOTICE: here we storing id to determine will be item added or updated */ ?>
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    <?php /* And here we call our custom meta box */ ?>
                    <?php do_meta_boxes('person', 'normal', $item); ?>
                    <input type="submit" value="<?php _e('Save', 'usb-tab')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}


function zipcode_form_meta_box_handler($item)
{
    ?>

<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
    
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="email"><?php _e('Zipcode', 'usb-tab')?></label>
        </th>
        <td>
            <input id="text" name="zipcode" type="text" style="width: 95%" value="<?php echo esc_attr($item['zipcode'])?>"
                   size="50" class="code" placeholder="<?php _e('Zipcode', 'usb-tab')?>" required>
        </td>
    </tr>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="age"><?php _e('Location', 'usb-tab')?></label>
        </th>
        <td>
            <input id="location" name="location" type="text" style="width: 95%" value="<?php echo esc_attr($item['location'])?>"
                   size="50" class="code" placeholder="<?php _e('Location', 'usb-tab')?>" required>
        </td>
    </tr>
    </tbody>
</table>
<?php
}

    function validate_zipcode($item)
    {
        $messages = array();

        if (empty($item['zipcode'])) $messages[] = __('Zipcode is required', 'usb-tab');
        if (empty($item['location']) ) $messages[] = __('Location is required', 'usb-tab');
        if (empty($messages)) return true;
        return implode('<br />', $messages);
    }


    // Hook to add menu in the admin area
add_action('admin_menu', 'translator_job_admin_menu');

// Function to add a menu item
function translator_job_admin_menu() {
    // Add a top-level menu
    add_menu_page(
        'Translator Job',          // Page title
        'Translator Job',          // Menu title
        'manage_options',          // Capability
        'translator-job',          // Menu slug
        'translator_job_page',     // Callback function
        'dashicons-translation',   // Icon URL
        6                          // Position
    );
}

// Callback function to display the page content
function translator_job_page() {
    echo '<div class="wrap">';
    echo '<h1>Translator Job</h1>';
    echo '<p>Welcome to the Translator Job page!</p>';
    echo zipcode_page_handler();
 
    echo '</div>';
}