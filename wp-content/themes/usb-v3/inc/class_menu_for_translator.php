<?php
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * Custom_Table_Example_List_Table class that will display our custom table
 * records in nice table
 */
class Custom_Table_Example_List_Table extends WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'person',
            'plural' => 'persons',
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    /**
     * [OPTIONAL] this is example, how to render specific column
     *
     * method name must be like this: "column_[column_name]"
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_age($item)
    {
        return '<em>' . $item['age'] . '</em>';
    }

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_post_title($item)
    {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
        $actions = array(
            'edit' => sprintf('<a href="?page=change_status_from&id=%s">%s</a>', $item['id'], __('Edit', 'cltd_example')),
            
        );

        return sprintf('%s %s',
            $item['post_title'],
            $this->row_actions($actions)
        );
    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns()
    {
         $columns = array(
            'cb'                  => '<input type="checkbox" />', //Render a checkbox instead of text
            'id'                  => __('Id', 'campaign_plugin'),
            'post_title'             => __('Post Title', 'campaign_plugin'),
            'assign_user_display_name'      => __('Assign User', 'campaign_plugin'),
            'translator_user_display_name'  => __('Translator User', 'campaign_plugin'),
            'status'              => __('Status', 'campaign_plugin'),
            
        );
        return $columns;
    }

    /**
     * [OPTIONAL] This method return columns that may be used to sort table
     * all strings in array - is column names
     * notice that true on name column means that its default sort
     *
     * @return array
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name' => array('name', true),
            'email' => array('email', false),
            'age' => array('age', false),
        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
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

       
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
}


function cltd_example_admin_menu()
{
    add_menu_page(__('Persons', 'cltd_example'), __('Translation Job', 'cltd_example'), 'read', 'persons', 'cltd_example_persons_page_handler');
    add_submenu_page('persons', __('Persons', 'cltd_example'), __('Translation Job', 'cltd_example'), 'read', 'persons', 'cltd_example_persons_page_handler');
    // add new will be described in next part
    add_submenu_page('persons', __('Add new', 'cltd_example'), __('Add new', 'cltd_example'), 'read', 'change_status_from', 'cltd_example_persons_form_page_handler');
}

add_action('admin_menu', 'cltd_example_admin_menu');

function cltd_example_persons_page_handler()
{
    global $wpdb;

    $table = new Custom_Table_Example_List_Table();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'cltd_example'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
<div class="wrap">

    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Translator Jobs', 'cltd_example')?></h2>
    <?php echo $message; ?>

    <form id="persons-table" method="GET">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
        <?php $table->display() ?>
    </form>

</div>
<?php
}



/**
 * Form page handler checks is there some data posted and tries to save it
 * Also it renders basic wrapper in which we are callin meta box render
 */
function cltd_example_persons_form_page_handler()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'translator_assign'; // do not forget about tables prefix

    $message = '';
    $notice = '';



    // this is default $item which will be used for new records
    $default = array(
        'id' => 0,
        'post_id' => '',
        'assign_user_id' => '',
        'translator_user_id' => '',
        'status' => '',
        'post_title' => '',
     
    );

    // here we are verifying does this request is post back and have correct nonce
    if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        // combine our default item with request params
        $item = shortcode_atts($default, $_REQUEST);
        // print_r($item);
        // die;
        // validate data, and if all ok save item to database
        // if id is zero insert otherwise update
        $item_valid = cltd_example_validate_translator($item);
        if ($item_valid === true) {
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_name, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'cltd_example');
                } else {
                    $notice = __('There was an error while saving item', 'cltd_example');
                }
            } else {

               
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'cltd_example');

                    $post_id=$item['post_id'];

                    $product_url=get_the_permalink($post_id);
                    $user = get_userdata($item['translator_user_id']);           
                    $user_email = $user->user_email;
                    $user_name = $user->display_name;


                   if($item['status']==2){ //Completed
                   
                    $subject = "Translation Job Completed for product";
                        // Email message
                    $mail_message = "Hi Admin,\n\n $user_email have completed translation job for product $product_url\n\n";
                        // Email headers (optional)
                    $headers = array('Content-Type: text/plain; charset=UTF-8');
                    $user_email='prasanta@elvirainfotech.com';
                    // Send the email
                    $sent = wp_mail($user_email, $subject, $mail_message, $headers);



                   }

                    if($item['status']==3){ //Rejected


                    $subject = "Translation Job Rejected by $user_email";
                        // Email message
                    $mail_message = "Hi Admin,\n\n $user_email have rejected translation job offer for product $product_url\n\n";
                        // Email headers (optional)
                    $headers = array('Content-Type: text/plain; charset=UTF-8');
                    $user_email='prasanta@elvirainfotech.com';
                    // Send the email
                    $sent = wp_mail($user_email, $subject, $mail_message, $headers);

                    update_post_meta($post_id,'_assign_translator','');



                   }



                } else {
                    $notice = __('There was an error while updating item', 'cltd_example');
                }
            }
        } else {
            // if $item_valid not true it contains error message(s)
            $notice = $item_valid;
        }
    }
    else {
        // if this is not post back we load item to edit or give new one to create
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'cltd_example');
            }
        }
    }

    // here we adding our custom meta box
    add_meta_box('persons_form_meta_box', 'Translation Job details', 'cltd_example_persons_form_meta_box_handler', 'person', 'normal', 'default');

    ?>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Translator', 'cltd_example')?></h2>

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
                    <input type="submit" value="<?php _e('Save', 'cltd_example')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}

/**
 * This function renders our custom meta box
 * $item is row
 *
 * @param $item
 */
function cltd_example_persons_form_meta_box_handler($item)
{
    ?>

<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="name"><?php _e('Product Title', 'cltd_example')?></label>
        </th>
        <td>
            <?php echo get_the_title($item['post_id']);?>
        </td>
    </tr>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="Job Status"><?php _e('Job Status', 'cltd_example')?></label>
        </th>
        <td>

        	<?php 

            // echo "<pre>";
            // print_r($item);
            // die;

        	$selected_value = isset($item['status']) ? $item['status'] : 1; 
            $item['post_title']=get_the_title($item['post_id']);

        	$options = array(
			    '1' => 'Assigned',
			    '2' => 'Completed',
			    '3' => 'Rejected',
			   
			);

			echo '<select name="status">';
			foreach ( $options as $value => $label ) {
			    // Check if the current option should be selected
			    $selected = ( $value == $selected_value ) ? 'selected' : '';
			    echo '<option value="' . esc_attr( $value ) . '" ' . $selected . '>' . esc_html( $label ) . '</option>';
			}
			echo '</select>';


            echo '<input type="hidden" id="assign_user_id" name="assign_user_id" value="'.$item['assign_user_id'].'">';
            echo '<input type="hidden" id="post_id" name="post_id" value="'.$item['post_id'].'">';
            echo '<input type="hidden" id="assign_user_id" name="translator_user_id" value="'.$item['translator_user_id'].'">';
            echo '<input type="hidden" id="assign_user_id" name="post_title" value="'.$item['post_title'].'">';


        	?>
            
        </td>
    </tr>
   
    </tbody>
</table>
<?php
}

/**
 * Simple function that validates data and retrieve bool on success
 * and error message(s) on error
 *
 * @param $item
 * @return bool|string
 */
function cltd_example_validate_translator($item)
{
    $messages = array();

    // if (empty($item['name'])) $messages[] = __('Name is required', 'cltd_example');
    // if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'cltd_example');
    // if (!ctype_digit($item['age'])) $messages[] = __('Age in wrong format', 'cltd_example');
    // //if(!empty($item['age']) && !absint(intval($item['age'])))  $messages[] = __('Age can not be less than zero');
    // //if(!empty($item['age']) && !preg_match('/[0-9]+/', $item['age'])) $messages[] = __('Age must be number');
    // //...

    if (empty($messages)) return true;
    return implode('<br />', $messages);
}