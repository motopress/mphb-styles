<?php

if (!defined('ABSPATH')) {
    exit;
}

// Register scripts
add_action('init', '_mphbs_register_scripts');

// Enqueue scripts
add_action('wp_enqueue_scripts', '_mphbs_enqueue_public_scripts');
add_action('admin_enqueue_scripts', '_mphbs_enqueue_admin_scripts');

/**
 * @since 0.0.1
 */
function _mphbs_register_scripts()
{
    $pluginUrl = MPHB\Styles\PLUGIN_URL;
    $version   = MPHB\Styles\VERSION;

    wp_register_style('mphbs-styles', $pluginUrl . 'assets/css/style.css', [], $version);

    // JS for Hotel Booking 3.8.1+
    wp_register_script('mphbs-extend-blocks', $pluginUrl . 'assets/js/extend-blocks.js', ['wp-blocks', 'wp-i18n', 'wp-hooks', 'wp-element', 'wp-editor', 'wp-components'], $version);

    // JS for Hotel Booking 3.8.0- (only horizontal form style, no custom classes and controls)
    wp_register_script('mphbs-extend-block-styles', $pluginUrl . 'assets/js/extend-block-styles.js', ['wp-blocks', 'wp-i18n'], $version);
}

/**
 * @since 0.0.1
 */
function _mphbs_enqueue_public_scripts()
{
    wp_enqueue_style('mphbs-styles');
}

/**
 * @since 0.0.1
 */
function _mphbs_enqueue_admin_scripts()
{
    if (mphbs_is_edit_post_page() && function_exists('MPHB')) {
        wp_enqueue_style('mphbs-styles');

        if (mphb_version_at_least('3.8.1')) {
            wp_enqueue_script('mphbs-extend-blocks');
        } else {
            wp_enqueue_script('mphbs-extend-block-styles');
        }
    }
}
