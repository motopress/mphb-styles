<?php

namespace MPHBTemplates;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class MPHBTemplates {

    public function __construct() {

        define('MPHB_TEMPLATES_PATH', plugin_dir_path(__FILE__));
        define('MPHB_TEMPLATES_URL', plugin_dir_url(__FILE__));

        $this->includeFiles();
    }

    private function includeFiles() {
        include_once MPHB_TEMPLATES_PATH . 'includes/post-types/template.php';
        include_once MPHB_TEMPLATES_PATH . 'includes/templates.php';
        include_once MPHB_TEMPLATES_PATH . 'includes/blocks.php';
    }
}

if (!class_exists('MPHBTemplates') && class_exists('HotelBookingPlugin')) {
    new MPHBTemplates();
}