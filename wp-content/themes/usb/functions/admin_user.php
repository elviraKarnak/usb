<?php
/*******code for comapny and comany no add,update start************/
function custom_user_profile_fields($user){
  ?>
   <!-- <h3>Extra profile information</h3>-->
    <table class="form-table">
        <tr>
            <th><label for="company">Company</label></th>
            <td>
                <input type="text" class="regular-text" name="company" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" id="company" /><br />
                <!--<span class="description">Where are you?</span>-->
            </td>
        </tr>
		
		<tr>
            <th><label for="customer_no">Customer No</label></th>
            <td>
                <input type="text" class="regular-text" name="customer_no" value="<?php echo esc_attr( get_the_author_meta( 'customer_no', $user->ID ) ); ?>" id="company" /><br />
                <!--<span class="description">Where are you?</span>-->
            </td>
        </tr>
		
    </table>
  <?php
}
add_action( 'show_user_profile', 'custom_user_profile_fields' );
add_action( 'edit_user_profile', 'custom_user_profile_fields' );
add_action( "user_new_form", "custom_user_profile_fields" );

function save_custom_user_profile_fields($user_id){
    # again do this only if you can
    if(!current_user_can('manage_options'))
        return false;

    # save my custom field
  //  update_usermeta($user_id, 'company', $_POST['company']);
		  $metas = array( 
			'company'   => $_POST['company'],			
			'customer_no'     => $_POST['customer_no']
		);

		foreach($metas as $key => $value) {
			update_user_meta( $user_id, $key, $value );
		}
}
add_action('user_register', 'save_custom_user_profile_fields');
add_action('profile_update', 'save_custom_user_profile_fields');

/*******code for comapny and comany no add,update End ************/
 ?>
 
<?php
/*******code for view company column in user table start ************/
 //add columns to User panel list page
function add_user_columns($column) {
    $column['company'] = 'company';

    return $column;
}
add_filter( 'manage_users_columns', 'add_user_columns' );

//add the data
function add_user_column_data( $val, $column_name, $user_id ) {
    $user = get_userdata($user_id);

    switch ($column_name) {
        case 'company' :
            return $user->company;
            break;
        default:
    }
    return;
}
add_filter( 'manage_users_custom_column', 'add_user_column_data', 10, 3 );

/*******code for view company column in user end ************/ 
?>

<?php
/******************* Shorting of company  start ****************/
function user_sortable_columns( $columns ) {
    $columns['company'] = 'Company';
    return $columns;
}
add_filter( 'manage_users_sortable_columns', 'user_sortable_columns' );

function user_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'company' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'company',
            'orderby' => 'meta_value',
            'order'     => 'asc'
        ) );
    }
    return $vars;
}
add_filter( 'request', 'user_column_orderby' );

/******************* Shorting of company  End ****************/

/******************* Filter by company name  start ****************/
function add_company_filter() {
    if ( isset( $_GET[ 'company' ]) ) {
        $section = $_GET[ 'company' ];
		$selected=$section[0];
		
		//print_r($section);
		//print($section[0]);
        //$section = !empty( $section[ 0 ] ) ? $section[ 0 ] : $section[ 1 ];
    } else {
        $section = -1;
		//$selected="";
    } 
    echo '<select name="company[]" style="float:none;"><option value="">Company List</option>';
      
	    global $wpdb;

  $table_name = $wpdb->prefix . "users";

  $users_list = $wpdb->get_results( "SELECT ID FROM $table_name" );
	  
	  
	  $company_list_array = array();
	  $j=0;
          foreach($users_list as $user_id){
          $company_name_list = get_user_meta( $user_id->ID,'company', true);
		  
	    //Store company list in array with avoid empty value
		 if($company_name_list != null){
			 $company_list_array[$j] = $company_name_list;
		        $j++;
		  }	  
         }
   
		// Remove repetation of same comapny list
	    $company_list_array=array_unique($company_list_array);
	   
	    // Dropdown of all company list without repetation
		for($k=0; $k< sizeof($company_list_array); $k++) {
		  $company_name= $company_list_array[$k];

          if($company_name!=''){
       
        echo '<option value="'.$company_name .'"  >'.$company_name.'</option>';
       }
		  
    //        if( $selected == $company_name){
			 // echo '<option value="'.$company_name .'" selected >'.$company_name.'</option>';   
		  //  }else{
			 // echo '<option value="'.$company_name .'"  >'.$company_name.'</option>';   
		  //  } 
		  //  echo '<option value="'.$company_name .'"  >'.$company_name.'</option>';  
			  
		   
          			 
		}

    echo '<input type="submit" class="button" value="Filter">';
	
		
}
add_action( 'restrict_manage_users', 'add_company_filter' );


function filter_users_by_company( $query ) {
    global $pagenow;


    if ( is_admin() &&  'users.php' == $pagenow &&  isset( $_GET[ 'company' ] ) &&  is_array( $_GET[ 'company' ] ) && !empty($_GET[ 'company' ][0]) ) {
        $section = $_GET[ 'company' ];
      //  $section = !empty( $section[ 0 ] ) ? $section[ 0 ] : $section[ 1 ];
        $meta_query = array(
            array(
                'key' => 'company',
                'value' => $section[0]
            )
        );
        $query->set( 'meta_key', 'company' );
        $query->set( 'meta_query', $meta_query );
    }
}
add_filter( 'pre_get_users', 'filter_users_by_company' );

/******************* filter by company name  end ****************/

/***************To stop Display name validation code start**********************/
add_filter('woocommerce_save_account_details_required_fields', 'display_name_account_details_required_fields_stop' );
function display_name_account_details_required_fields_stop( $required_fields ){
    unset( $required_fields['account_display_name'] );
    return $required_fields;
}
/***************To stop Display name validation code end**********************/