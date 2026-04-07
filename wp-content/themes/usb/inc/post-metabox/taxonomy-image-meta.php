<?php
function attr_add_new_meta_field() {
    wp_register_script('upload-img-product_cat', get_template_directory_uri() . '/inc/post-metabox/workout.js', array('jquery','wp-color-picker'),false, true );
    wp_enqueue_script('upload-img-product_cat');
    wp_enqueue_media();
    $all_attribute = get_term_meta( $term->term_id, '_product_cat_all_attribute',true);
    $price = get_term_meta( $term->term_id,'_price',true );
    $choption = get_term_meta( $term->term_id,'_choption',true );
    $price50 = get_term_meta( $term->term_id,'_price50',true );
    $price100 = get_term_meta( $term->term_id,'_price100',true );
    $price250 = get_term_meta( $term->term_id,'_price250',true );
    $price500 = get_term_meta( $term->term_id,'_price500',true );
    $price1000 = get_term_meta( $term->term_id,'_price1000',true );
    $price2500 = get_term_meta( $term->term_id,'_price2500',true );
    $price5000 = get_term_meta( $term->term_id,'_price5000',true );
?>
  

   <tr>
       <th scope="row" valign="top">
           <label for="term_meta"><?php _e( 'USB Option', 'usb' ); ?></label>
       </th>
       <td scope="row" valign="top">
          <?php _e( ' USB', 'usb' ); ?> <input class="regular-text" name="_choption" type="radio"  value="usb" <?php checked( $choption, 'usb' ); ?>>
            <?php _e( ' STANDARD', 'usb' ); ?> <input class="regular-text" name="_choption" type="radio"  value="standard" <?php checked( $choption, 'standard' ); ?>>
       </td>
   </tr>
   <tr>
       <th scope="row" valign="top">
           <label for="term_meta"><?php _e( 'Enter Usb Price', 'usb' ); ?></label>
       </th>
       <td scope="row" valign="top">
    <table>
    <tr>
    <th class="quantity_usb"><?php _e( 'Quantity', 'usb' ); ?></th>
    <th><?php _e( 'Price', 'usb' ); ?></th>
   </tr>

  <tr>
    <td>50</td>
    <td><input class="regular-text" name="_price50" type="text"  value="<?php echo $price50 ?>"></td>
  </tr>

  <tr>
    <td>100</td>
    <td><input class="regular-text" name="_price100" type="text"  value="<?php echo $price100 ?>"></td>
  </tr>

   <tr>
    <td>250</td>
    <td><input class="regular-text" name="_price250" type="text"  value="<?php echo $price250 ?>"></td>
  </tr>

  <tr>
    <td>500</td>
    <td><input class="regular-text" name="_price500" type="text"  value="<?php echo $price500 ?>"></td>
  </tr>

   <tr>
    <td>1000</td>
    <td><input class="regular-text" name="_price1000" type="text"  value="<?php echo $price1000 ?>"></td>
  </tr>

  <tr>
    <td>2500</td>
    <td><input class="regular-text" name="_price2500" type="text"  value="<?php echo $price2500 ?>"></td>
  </tr>

  <tr>
    <td>5000</td>
    <td><input class="regular-text" name="_price5000" type="text"  value="<?php echo $price5000 ?>"></td>
  </tr>
  </table>    
       </td>
   </tr>

 
   <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.attributesAllResult').select2();
        });
    </script>
    

    <!-- Select2 js start -->
    <?php
}
    function attr_edit_meta_field($term) {
    wp_register_script('upload-img-product_cat', get_template_directory_uri() . '/inc/post-metabox/workout.js', array('jquery','wp-color-picker'),false, true  );
    wp_enqueue_script('upload-img-product_cat');    
    wp_enqueue_media();
    $price = get_term_meta( $term->term_id,'_price',true );
    $choption = get_term_meta( $term->term_id,'_choption',true );
    $product_cat_all_attribute = json_decode(get_term_meta( $term->term_id,'_product_cat_all_attribute',true )) ;
    $price50 = get_term_meta( $term->term_id,'_price50',true );
    $price100 = get_term_meta( $term->term_id,'_price100',true );
    $price250 = get_term_meta( $term->term_id,'_price250',true );
    $price500 = get_term_meta( $term->term_id,'_price500',true );
    $price1000 = get_term_meta( $term->term_id,'_price1000',true );
    $price2500 = get_term_meta( $term->term_id,'_price2500',true );
    $price5000 = get_term_meta( $term->term_id,'_price5000',true );
    ?>


   <script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('.attributesAllResult2').select2();
        });
  </script>
    <!-- Select2 js start -->
   <tr>
       <th scope="row" valign="top">
           <label for="term_meta"><?php _e( 'USB Option', 'usb' ); ?></label>
       </th>
       <td scope="row" valign="top">
           <?php _e( 'USB', 'usb' ); ?> <input class="regular-text" name="_choption" type="radio"  value="usb" <?php checked( $choption, 'usb' ); ?>>
          <?php _e( ' STANDARD ', 'usb' ); ?><input class="regular-text" name="_choption" type="radio"  value="standard" <?php checked( $choption, 'standard' ); ?>>
       </td>
   </tr>

   <tr>
       <th scope="row" valign="top">
           <label for="term_meta"><?php _e( 'Enter Usb Price', 'usb' ); ?></label>
       </th>
       <td scope="row" valign="top">
    <table>
    <tr>
    <th class="quantity_usb"><?php _e( ' Quantity ', 'usb' ); ?></th>
    <th>Price</th>
   </tr>

  <tr>
    <td>50</td>
    <td><input class="regular-text" name="_price50" type="text"  value="<?php echo $price50 ?>"></td>
  </tr>

  <tr>
    <td>100</td>
    <td><input class="regular-text" name="_price100" type="text"  value="<?php echo $price100 ?>"></td>
  </tr>

   <tr>
    <td>250</td>
    <td><input class="regular-text" name="_price250" type="text"  value="<?php echo $price250 ?>"></td>
  </tr>

  <tr>
    <td>500</td>
    <td><input class="regular-text" name="_price500" type="text"  value="<?php echo $price500 ?>"></td>
  </tr>

   <tr>
    <td>1000</td>
    <td><input class="regular-text" name="_price1000" type="text"  value="<?php echo $price1000 ?>"></td>
  </tr>

  <tr>
    <td>2500</td>
    <td><input class="regular-text" name="_price2500" type="text"  value="<?php echo $price2500 ?>"></td>
  </tr>

  <tr>
    <td>5000</td>
    <td><input class="regular-text" name="_price5000" type="text"  value="<?php echo $price5000 ?>"></td>
  </tr>
  </table>    
       </td>
   </tr>
   <tr>
    <td>OEM TLC</td>
     <td>
        <?php 
         $usb_ocm_tlc = array();
        $usb_ocm_tlc = json_decode(get_term_meta($term->term_id,'_usb_ocm_tlc',true),true);
        $c = 0; 
        if ($usb_ocm_tlc) {
          $c = count($usb_ocm_tlc);
        }
        
        ?>
        <?php 
       
        if ($usb_ocm_tlc) {
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
                    $(this).parent().parent().remove();                
                    return false;
                });
            });
        </script>
        <p><strong><?php _e( 'OEM TLC', 'usb' ); ?></strong></p>
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
                  }else {
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
                                    <option value=""><?php _e( 'Select', 'usb' ); ?></option>                                
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option  value="<?php echo $usb_quantity->usb_quantity_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
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
                    <td><a class="button remove-row" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
                </tr>
                <?php } ?>
                
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
                                  <option value=""><?php _e( 'Select', 'usb' ); ?></option>                                  
                                    <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                      <option value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
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
                    <td><a class="button remove-row" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
                </tr>
            </tbody>
        </table>
        
        <p><a id="add-row" class="button" href="#"><?php _e( 'Add another', 'usb' ); ?></a></p> 
     </td>
   </tr>
   <tr>
    <td><?php _e( 'OEM MLC', 'usb' ); ?></td>
     <td>
    <?php 
    $usb_oem_mlc = array();
    $usb_oem_mlc = json_decode(get_term_meta($term->term_id,'_usb_oem_mlc',true),true); 
    $oem_mlc_count = 0;
    if ($usb_oem_mlc) {
      $oem_mlc_count = count($usb_oem_mlc);
    }
    
    ?>
    <?php 
    
    if ($usb_oem_mlc) {
    $usb_oem_mlc = array_map('array_filter', $usb_oem_mlc);
    $usb_oem_mlc = array_filter($usb_oem_mlc);
    }


    ?>
    <script type="text/javascript">
        jQuery(document).ready(function( $ ){
            var count = <?php echo $oem_mlc_count; ?>;
            $( '#add_row_oem_mlc' ).on('click', function() {
                count = count + 1;
                $( '.empty_row_oem_mlc.oem_mlc_text td input' ).attr('name','usb_oem_mlc['+count+'][]');
                $( '.empty_row_oem_mlc.oem_mlc_text td select' ).attr('name','usb_oem_mlc['+count+'][]');
                var row = $( '.empty_row_oem_mlc.oem_mlc_text' ).clone(true);
                row.removeClass( 'empty_row_oem_mlc oem_mlc_text' );
                row.insertBefore( '#repeatable-fieldset-two tbody>tr:last' ).show();
                return false;
            });
        
            $( '.remove_row_oem_mlc' ).on('click', function() {
                $(this).parent().parent().remove();                
                return false;
            });
        });
    </script>
    <p><strong><?php _e( 'OEM MLC', 'usb' ); ?></strong></p>
    <table id="repeatable-fieldset-two" >
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
              if ($usb_oem_mlc) {      
                foreach ($usb_oem_mlc as $key => $value) {
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
                        <td><a class="button remove_row_oem_mlc" href="#">Remove</a></td>
                    </tr>
                    <?php
                } 
              }else {
            ?>
        
        
            <tr>
                <td>
                    <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $oem_mlc_count;?>][]" value="" /> -->
                            <?php
                            $usb_quantities = get_terms( array(
                            'taxonomy' => 'usb_quantity',
                            'hide_empty' => false,
                            ) );
                            ?>
                            <select name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]">  
                              <option value="">Select</option>                                 
                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                  <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                <?php }?>
                              </select>
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />
                </td>
                
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />                    
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />                    
                </td>    
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count;?>][]" value="" />                    
                </td> 
                <td><a class="button remove_row_oem_mlc" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
            </tr>
            <?php } ?>
            
            <!-- empty hidden one for jQuery -->
            <tr class="empty_row_oem_mlc oem_mlc_text" style="display: none;">
                <td>
                    <!-- <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php //echo $oem_mlc_count;?>][]" value="" /> -->
                            <?php
                            $usb_quantities = get_terms( array(
                            'taxonomy' => 'usb_quantity',
                            'hide_empty' => false,
                            ) );
                            ?>
                            <select name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]">   
                              <option value=""><?php _e( 'Select', 'usb' ); ?></option>                                
                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                  <option value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                <?php }?>
                              </select>
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />
                </td>
                
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />                    
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />                    
                </td>    
                <td>
                    <input type="text" style="width: 100%;" name="usb_oem_mlc[<?php echo $oem_mlc_count+1;?>][]" value="" />                    
                </td> 
                <td><a class="button remove_row_oem_mlc" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
            </tr>
        </tbody>
    </table>
    
    <p><a id="add_row_oem_mlc" class="button" href="#"><?php _e( 'Add another', 'usb' ); ?></a></p> 
</td>                 
   </tr>
   <tr>
     <td><?php _e( 'Original', 'usb' ); ?></td>
     <td>
    <?php 
    $usb_original = array();
    $usb_original = json_decode(get_term_meta($term->term_id,'_usb_original_data',true),true); 
    $original_count = 0;
    if ($usb_original) {
      $original_count = count($usb_original);
    }
    
    ?>
    <?php 
    if ($usb_original) {
    $usb_original = array_map('array_filter', $usb_original);
    $usb_original = array_filter($usb_original);
    }


    // print "<pre>";
    // $usb_original_data = get_term_meta($term->term_id,'_usb_original_data',true);
    // $usb_original_data1 = json_decode($usb_original_data);
    // print_r($usb_original_data);
    // print "</pre>";

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function( $ ){
            var count = <?php echo $original_count; ?>;
            $( '#add_row_original' ).on('click', function() {
                count = count + 1;
                $( '.empty_row_oem_mlc.original_text td input' ).attr('name','usb_original['+count+'][]');
                $( '.empty_row_oem_mlc.original_text td select' ).attr('name','usb_original['+count+'][]');
                var row = $( '.empty_row_oem_mlc.original_text' ).clone(true);
                row.removeClass( 'empty_row_oem_mlc original_text' );
                row.insertBefore( '#repeatable-fieldset-three tbody>tr:last' ).show();
                return false;
            });
        
            $( '.remove_row_original' ).on('click', function() {
                $(this).parent().parent().remove();                
                return false;
            });
        });
    </script>
    <p><strong><?php _e( 'Original', 'usb' ); ?></strong></p>
    <table id="repeatable-fieldset-three" >
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
              if ($usb_original) {      
                foreach ($usb_original as $key => $value) {

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
                              <option value=""><?php _e( 'Select', 'usb' ); ?></option>                                
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
                        <td><a class="button remove_row_original" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
                    </tr>
                    <?php
                } 
              }else {
            ?>
        
        
            <tr>
                <td>
                    <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $original_count;?>][]" value="" /> -->
                            <?php
                            $usb_quantities = get_terms( array(
                            'taxonomy' => 'usb_quantity',
                            'hide_empty' => false,
                            ) );
                            ?>
                            <select name="usb_original[<?php echo $original_count;?>][]"> 
                                <option value="">Select</option>                                  
                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                  <option  value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                <?php }?>
                              </select>
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />                    
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />                    
                </td>    
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />                    
                </td> 
                <td><a class="button remove_row_original" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
            </tr>
            <?php } ?>
            
            <!-- empty hidden one for jQuery -->
            <tr class="empty_row_oem_mlc original_text" style="display: none;">
                <td>
                    <!-- <input type="text" style="width: 100%;" name="usb_original[<?php //echo $original_count;?>][]" value="" /> -->
                            <?php
                            $usb_quantities = get_terms( array(
                            'taxonomy' => 'usb_quantity',
                            'hide_empty' => false,
                            ) );
                            ?>
                            <select name="usb_original[<?php echo $original_count;?>][]">   
                                <option value=""><?php _e( 'Select', 'usb' ); ?></option>                                
                                <?php foreach ( $usb_quantities as $usb_quantity ) {?>
                                  <option value="<?php echo $usb_quantity->term_id;?>" ><?php echo esc_html( $usb_quantity->name );?></option>
                                <?php }?>
                              </select>
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />                    
                </td>
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />                    
                </td>    
                <td>
                    <input type="text" style="width: 100%;" name="usb_original[<?php echo $original_count;?>][]" value="" />                    
                </td> 
                <td><a class="button remove_row_original" href="#"><?php _e( 'Remove', 'usb' ); ?></a></td>
            </tr>
        </tbody>
    </table>
    
    <p><a id="add_row_original" class="button" href="#"><?php _e( 'Add another', 'usb' ); ?></a></p> 
</td>
   </tr>


    <?php
}

// Save extra taxonomy fields callback function.
 
function attr_save_taxonomy_meta( $term_id ) {


  $price = isset($_POST['_price'])?$_POST['_price']:'';  
  update_term_meta($term_id, '_price', $price);

  $choption = isset($_POST['_choption'])?$_POST['_choption']:'';  
  update_term_meta($term_id, '_choption', $price);

  $product_cat_all_attribute = json_encode($_POST['_product_cat_all_attribute']) ;
  update_term_meta($term_id, '_product_cat_all_attribute', $product_cat_all_attribute);

  $price50 = isset($_POST['_price50'])?$_POST['_price50']:'';  
  update_term_meta($term_id, '_price50', $price50);

  $price100 = isset($_POST['_price100'])?$_POST['_price100']:'';  
  update_term_meta($term_id, '_price100', $price100);

  $price250 = isset($_POST['_price250'])?$_POST['_price250']:'';  
  update_term_meta($term_id, '_price250', $price250);

  $price500 = isset($_POST['_price500'])?$_POST['_price500']:'';  
  update_term_meta($term_id, '_price500', $price500);

  $price1000 = isset($_POST['_price1000'])?$_POST['_price1000']:'';  
  update_term_meta($term_id, '_price1000', $price1000);

  $price2500 = isset($_POST['_price2500'])?$_POST['_price2500']:'';  
  update_term_meta($term_id, '_price2500', $price2500);

  $price5000 = isset($_POST['_price5000'])?$_POST['_price5000']:'';  
  update_term_meta($term_id, '_price5000', $price5000);

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



  update_term_meta($term_id, '_usb_ocm_tlc', json_encode($usb_ocm_tlc_arr));
  update_term_meta($term_id, '_usb_oem_mlc', json_encode($usb_oem_mlc_arr));
  update_term_meta($term_id, '_usb_original_data', json_encode($usb_original_arr));
}

global $wpdb;
$attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name != '' ORDER BY attribute_name ASC;" );
set_transient( 'wc_attribute_taxonomies', $attribute_taxonomies );

$attribute_taxonomies = array_filter( $attribute_taxonomies  ) ;
foreach ($attribute_taxonomies as $value) {
  $taxonomy_name = 'pa_'.$value->attribute_name;
  // add_action( $taxonomy_name.'_add_form_fields', 'attr_add_new_meta_field', 10, 2 );
  add_action( $taxonomy_name.'_edit_form_fields', 'attr_edit_meta_field', 10, 2 );
  add_action( 'edited_'.$taxonomy_name, 'attr_save_taxonomy_meta', 10, 2 );
  add_action( 'create_'.$taxonomy_name, 'attr_save_taxonomy_meta', 10, 2 );
}
