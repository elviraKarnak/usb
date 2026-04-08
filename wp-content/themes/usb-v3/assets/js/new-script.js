function usbSaveProductSummary(productID) {
    var productsummary = jQuery('.standar_product_summary').html() || '';

    console.log('pdf summary save start');
    console.log('productID:', productID);
    console.log(productsummary);

    return jQuery.ajax({
        url: ajaxVars.ajaxurl,
        type: 'POST',
        data: {
            action: 'usb_product_summary',
            summary: productsummary,
            product_id: productID
        }
    });
}

jQuery(document).on('click', '.down_pdf_summary', function (e) {
    e.preventDefault();

    var $link = jQuery(this);
    var productID = $link.data('productid');
    var pdfUrl = $link.attr('href');
    var target = $link.attr('target');
    var newWindow = null;

    if (target === '_blank') {
        newWindow = window.open('', '_blank');
    }

    usbSaveProductSummary(productID)
        .done(function (res) {
            console.log('pdf summary save success:', res);
            console.log('redirect pdf url:', pdfUrl);

            if (newWindow) {
                newWindow.location = pdfUrl;
            } else {
                window.location.href = pdfUrl;
            }
        })
        .fail(function (xhr, status, error) {
            console.log('pdf summary save failed:', status, error);
            console.log(xhr.responseText);

            if (newWindow) {
                newWindow.close();
            }
        });
});

jQuery(document).on('click', '.optionclick', function () {
    setTimeout(function () {
        var productID = jQuery(".down_pdf_summary").attr("data-productid");
        usbSaveProductSummary(productID)
            .done(function (res) {
                console.log('option summary save success:', res);
            })
            .fail(function (xhr, status, error) {
                console.log('option summary save failed:', status, error);
                console.log(xhr.responseText);
            });
    }, 1000);
});