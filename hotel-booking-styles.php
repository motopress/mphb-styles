<?php
/*
 * Plugin Name: Hotel Booking Styles
 * Description: Manage your hotel booking styles.
 * Version: 0.0.1
 * Author: MotoPress
 * Author URI: https://motopress.com/
 * License: GPLv2 or later
 * Text Domain: hotel-booking-styles
 * Domain Path: /languages
 */

add_action('wp_enqueue_scripts', 'hbs_enqueue_scripts');
function hbs_enqueue_scripts(){

	wp_enqueue_style('hbs-style', plugins_url('/style.css', __FILE__), [], '0.0.1');

}

add_filter('mphb_sc_booking_form_wrapper_classes', 'hbs_filter_booking_form_classes');
function hbs_filter_booking_form_classes($class){

	if(MPHB()->settings()->main()->isDirectBooking()){
		return $class.' is-direct-booking';
	}

	return $class;
}