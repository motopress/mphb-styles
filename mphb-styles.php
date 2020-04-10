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
    define('MPHB\Styles\PLUGIN_URL', plugin_dir_url(__FILE__)); // With trailing slash

    include 'includes/functions.php';
    include 'includes/filters.php';
    include 'includes/scripts.php';
    include 'includes/settings-tab.php';
}
