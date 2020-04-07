<?php
/*
 * Plugin Name: Hotel Booking Styles
 * Description: Manage your hotel booking styles.
 * Version: 0.0.1
 * Author: MotoPress
 * Author URI: https://motopress.com/
 * License: GPLv2 or later
 * Text Domain: mphb-styles
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('MPHB\Styles\VERSION')) {
    define('MPHB\Styles\VERSION', '0.0.1');

    include 'includes/settings-tab.php';

    add_action('wp_enqueue_scripts', 'mphbs_enqueue_scripts');
    function mphbs_enqueue_scripts(){

        wp_enqueue_style('mphbs-style', plugins_url('/style.css', __FILE__), [], MPHB\Styles\VERSION);

    }

    add_filter('mphb_sc_booking_form_wrapper_classes', 'mphbs_filter_booking_form_classes');
    function mphbs_filter_booking_form_classes($class){

        if(MPHB()->settings()->main()->isDirectBooking()){
            return $class.' is-direct-booking';
        }

        return $class;
    }
}
