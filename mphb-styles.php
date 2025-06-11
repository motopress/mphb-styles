<?php

/*
 * Plugin Name: Hotel Booking Styles & Templates
 * Plugin URI: https://motopress.com/
 * Description: A set of tools to easily customize and style the booking forms, widgets, and accommodation type pages for the MotoPress Hotel Booking plugin.
 * Version: 1.1.2
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
    define('MPHB\Styles\VERSION', '1.1.2');
    define('MPHB\Styles\PLUGIN_URL', plugin_dir_url(__FILE__)); // With trailing slash

    include 'includes/functions.php';
    include 'includes/filters.php';
    include 'includes/scripts.php';
    include 'includes/settings-tab.php';
    include 'includes/template-editor/mphb-templates.php';
}
