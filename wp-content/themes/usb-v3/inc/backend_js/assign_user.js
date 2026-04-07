// custom-ajax.js
jQuery(document).ready(function($) {
    $('.assign_translator').on('click', function(e) {
        e.preventDefault();
        // Perform AJAX call
        var translator_drp = $('#translator_drp').val(); // Serialize form data
        var current_post_id = $('#current_post_id').val(); // Serialize form data
        var current_user_id = $('#current_user_id').val(); // Serialize form data
        //alert(translator_drp);
        if(translator_drp && (translator_drp >1 )){
            $.ajax({
                url: ajax_object.ajax_url, // WordPress AJAX URL
                type: 'POST',
                data: {
                    action: 'assign_translator', // Action hook
                    form_data: translator_drp,
                    current_post_id: current_post_id,
                    current_user_id: current_user_id,
                    // Additional data if needed
                },
                success: function(response) {
                    // Handle successful AJAX call
                    console.log(response);

                    $('#translator_metabox #response_div').text(response);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);

                }
            });
        }else{
            $('#translator_metabox #response_div').text('Select Translator');
        }
    });
});
