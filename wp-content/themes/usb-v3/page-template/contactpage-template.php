<?php
/*Template Name:Contact Page*/
get_header();
$contact_us_content = get_field('contact_us_content');
$send_us_text = get_field('send_us_text');
$contact_us_shortcode = get_field('contact_us_shortcode');
$headquarters_title = get_field('headquarters_title');
$headquarters_text = get_field('headquarters_text');
$office_contact_details_text = get_field('office_contact_details_text');
$office_contact_details_list = get_field('office_contact_details_list');
?>
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="contact-title">
                    <h1><?php the_title(); ?></h1>
                    <p><?php _e($contact_us_content, 'usb'); ?></p>
                    <h4><?php echo $send_us_text; ?></h4>
                </div>
                <!-- <div class="contact-form-area">
                    <?php //echo do_shortcode($contact_us_shortcode); ?>
                </div> -->
                <!----form----->
                <div class="contact-content">
                    <?php echo do_shortcode($contact_us_shortcode); ?>
                </div>
            </div>
            <div class="col-lg-4 mt-lg-0 mt-3">
                <div class="sidebar-area">
                    <h5>
                        <?php echo $headquarters_title; ?>
                    </h5>
                    <p>
                        <?php echo $headquarters_text; ?>
                    </p>
                    <div class="location-area">
                        <h5>
                            <?php echo $office_contact_details_text; ?>
                        </h5>

                        <div class="accordion location-accordion" id="accordionExample">
                            <?php $i = 1;
                            foreach ($office_contact_details_list as $list) {
                                if ($i == 1) {
                                    $expanded = 'aria-expanded="true"';
                                } else {
                                    $expanded = 'aria-expanded="false"';
                                }
                                ?>
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="heading<?php echo $i; ?>">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse<?php echo $i; ?>" <?php echo $expanded; ?>
                                        aria-controls="collapse
                                        <?php echo $i; ?>">
                                        <?php echo $list['title']; ?>
                                    </button>
                                </h6>
                                <div id="collapse<?php echo $i; ?>"
                                    class="accordion-collapse collapse <?php if ($i == 1) { ?>show<?php } ?>"
                                    aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php echo $list['address']; ?>
                                    </div>
                                </div>
                            </div>
                            <?php $i++;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); 