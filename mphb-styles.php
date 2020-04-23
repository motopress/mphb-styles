<?php

/*
 * Plugin Name: Hotel Booking Styles
 * Description: Extra CSS styles to customize the MotoPress Hotel Booking plugin forms and widgets.
 * Version: 1.0.0
 * Author: MotoPress
 * Author URI: https://motopress.com/
 * License: GPLv2 or later
 * Text Domain: mphb-styles
 * Domain Path: /languages
 * Requires Hotel Booking: 3.0.3
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('MPHB\Styles\VERSION')) {
    define('MPHB\Styles\VERSION', '1.0.0');
    define('MPHB\Styles\PLUGIN_URL', plugin_dir_url(__FILE__)); // With trailing slash

    include 'includes/functions.php';
    include 'includes/filters.php';
    include 'includes/scripts.php';
    include 'includes/settings-tab.php';
}
