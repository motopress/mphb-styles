<?php

if (!defined('ABSPATH')) {
    exit;
}

get_header();

do_action('mphb-templates/templates/header-footer/before_content');

while (have_posts()) :
    the_post();

    the_content();

endwhile;

do_action('mphb-templates/templates/header-footer/after_content');

get_footer();
