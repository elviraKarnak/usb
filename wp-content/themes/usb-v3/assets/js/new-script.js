jQuery(document).on('click', '.down_pdf_summary', function () {
    var productsummary = jQuery('.standar_product_summary').html();
    var productID = jQuery(this).data("productid");

    console.log('test 04112020 test');
    console.log(productsummary);

    jQuery.ajax({
        url: ajaxVars.ajaxurl,
        type: 'POST',
        data: {
            action: 'usb_product_summary',
            summary: productsummary,
            product_id: productID
        },
        success: function (res) {
            console.log(res);
        }
    });
});

jQuery(document).on('click', '.optionclick', function () {
    setTimeout(function () {
        var productsummary = jQuery('.standar_product_summary').html();
        var productID = jQuery(".down_pdf_summary").attr("data-productid");

        console.log('test 04112020 test');
        console.log(productsummary);

        jQuery.ajax({
            url: ajaxVars.ajaxurl,
            type: 'POST',
            data: {
                action: 'usb_product_summary',
                summary: productsummary,
                product_id: productID
            },
            success: function (res) {
                console.log(res);
            }
        });
    }, 1000);
});