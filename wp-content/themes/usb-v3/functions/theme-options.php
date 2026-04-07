<?php
add_action('init','elvirainfotech_ftn_options');
if(!function_exists('elvirainfotech_ftn_options')){
	function elvirainfotech_ftn_options(){
		// If using image radio buttons,define a directory path
		$imagepath = get_stylesheet_directory_uri().'/images/'; 
		$options = array(
		/* ---------------------------------------------------------------------------- */
		/* Header Setting */
		/* ---------------------------------------------------------------------------- */
		array("name" => "Header Section",
			  "type" => "heading"),

		array("name" => "Choose Site Logo",
                    "desc" => "Optimal size: 311px width by 84px height.",
                    "id"   => "usb_header_logo",
                    "std"  => "",
                    "type" => "upload"),

       array("name" => "Header Phone Number ",
                    "desc" => "Add header phone number here",
                    "id"   => "usb_header_phone_number",
                    "std"  => "",
                    "type" => "text"),

       array("name" => "Header Email Address ",
                    "desc" => "Add header Email Address here",
                    "id"   => "usb_header_email_address",
                    "std"  => "",
                    "type" => "text"),
        array("name" => "Menu Text",
                    "desc" => "Add menu text here",
                    "id"   => "usb_header_menu_text",
                    "std"  => "",
                    "type" => "text"),
        array("name" => "Menu Link",
                    "desc" => "Add menu link here",
                    "id"   => "usb_header_menu_link",
                    "std"  => "",
                    "type" => "text"),
        array("name" => "Menu Text Swedish",
                    "desc" => "Add menu text here",
                    "id"   => "usb_header_menu_text_sv",
                    "std"  => "",
                    "type" => "text"),
        array("name" => "Menu Link Swedish",
                    "desc" => "Add menu link here",
                    "id"   => "usb_header_menu_link_sv",
                    "std"  => "",
                    "type" => "text"),


          /* ---------------------------------------------------------------------------- */
            /*Home Page Company Promotion Section */
            /* ---------------------------------------------------------------------------- */

            array("name" => "Home Promotion Section",
                    "type" => "heading"),

            array("name" => "Topp 5 products Promotion Text",
                    "desc" => "Enter Topp 5 products Promotion Here",
                    "id"   => "top5product_promotion",
                    "std"  => "",
                    "type" => "text"),

            array("name" => "Left Image",
                    "desc" => "Optimal size: 385px width by 201px height.",
                    "id"   => "usb_Promotion_imageone",
                    "std"  => "",
                    "type" => "upload"),

           array("name" => "Left Button Text",
                    "desc" => "Enter Left Button Text Here",
                    "id"   => "usb_left_button_text",
                    "std"  => "",
                    "type" => "text"),

           array("name" => "Left Button Link",
                    "desc" => "Enter Left Button Link Here",
                    "id"   => "usb_left_button_link",
                    "std"  => "",
                    "type" => "text"),

           array("name" => "Right Image",
                    "desc" => "Optimal size: 385px width by 201px height.",
                    "id"   => "usb_Promotion_imagetwo",
                    "std"  => "",
                    "type" => "upload"),

           array("name" => "Right Button Text",
                    "desc" => "Enter Right Button Text Here",
                    "id"   => "usb_right_button_text",
                    "std"  => "",
                    "type" => "text"),
           
           array("name" => "Right Button Link",
                    "desc" => "Enter Right Button Link Here",
                    "id"   => "usb_right_button_link",
                    "std"  => "",
                    "type" => "text"),
              
           array("name" => "Upload Video",
                    "desc" => "Enter video embeded code Here </br><i>(Optimal size: 384px width by 199px height.)</i>",
                    "id"   => "usb_video_embeded_code",
                    "std"  => "",
                    "type" => "textarea"),


            /* ---------------------------------------------------------------------------- */
            /* Footer Setting */
            /* ---------------------------------------------------------------------------- */
            array("name" => "Footer Section",
                    "type" => "heading"),

            array("name" => "Contact Background Image",
                    "desc" => "Optimal size: 1920px width by 1015px height.",
                    "id"   => "usb_footer_bgimage",
                    "std"  => "",
                    "type" => "upload"),

            array("name" => "Contact Us Title",
                    "desc" => "Enter contact us title here",
                    "id"   => "usb_footer_contact",
                    "std"  => "",
                    "type" => "text"),

            array("name" => "Contact Us Address",
                    "desc" => "Enter contact us Address here",
                    "id"   => "usb_footer_address",
                    "std"  => "",
                    "type" => "textarea"),
      
           array("name" => "Bottom First Phone Number ",
                    "desc" => "Enter phone First Number",
                    "id"   => "usb_footer_phone_number_one",
                    "std"  => "",
                    "type" => "text"),

            array("name" => "Bottom Second Phone Number",
                    "desc" => "Enter phone Second Number",
                    "id"   => "usb_footer_phone_number_two",
                    "std"  => "",
                    "type" => "text"),

           array("name" => "Bottom Mail Id",
                    "desc" => "Enter Your Mail Id ",
                    "id"   => "usb_footer_mail_id",
                    "std"  => "",
                    "type" => "text"),
           

           /* ---------------------------------------------------------------------------- */
            /* Product Section */
            /* ---------------------------------------------------------------------------- */
            array("name" => "Product Section",
                    "type" => "heading"),

            array("name" => "OEM TLC Information (en)",
                    "desc" => "Enter OEM TLC Information here",
                    "id"   => "product_oem_tlc_info_en",
                    "std"  => "",
                    "type" => "textarea"),

            array("name" => "OEM MLC Information (en)",
                    "desc" => "Enter OEM MLC Information here",
                    "id"   => "product_oem_mlc_info_en",
                    "std"  => "",
                    "type" => "textarea"),

            array("name" => "Original Information (en)",
                    "desc" => "Enter Original Information here",
                    "id"   => "product_original_info_en",
                    "std"  => "",
                    "type" => "textarea"),

            array("name" => "OEM TLC Information (sw)",
                    "desc" => "Enter OEM TLC Information here",
                    "id"   => "product_oem_tlc_info_sw",
                    "std"  => "",
                    "type" => "textarea"),

            array("name" => "OEM MLC Information (sw)",
                    "desc" => "Enter OEM MLC Information here",
                    "id"   => "product_oem_mlc_info_sw",
                    "std"  => "",
                    "type" => "textarea"),

            array("name" => "Original Information (sw)",
                    "desc" => "Enter Original Information here",
                    "id"   => "product_original_info_sw",
                    "std"  => "",
                    "type" => "textarea"),

            array("name" => "Popular Product Color",
                    "desc" => "Enter Popular Product Color",
                    "id"   => "product_popular_color_code",
                    "std"  => "",
                    "type" => "text"),

            array("name" => "Nyhet Product Color",
                    "desc" => "Enter Nyhet Product Color",
                    "id"   => "product_novelty_color_code",
                    "std"  => "",
                    "type" => "text"),

            );

            elvirainfotech_ftn_update_option('of_template',$options);
            }
      }