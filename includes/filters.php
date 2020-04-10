<?php

if (!defined('ABSPATH')) {
    exit;
}

add_filter('mphb_block_attributes', '_mphbs_filter_block_attributes', 10, 2);
add_filter('mphb_render_block_attributes', '_mphbs_filter_block_classes', 10, 2);
add_filter('mphb_sc_booking_form_wrapper_classes', '_mphbs_filter_booking_form_classes');

/**
 * @param array $attributes
 * @param string $blockName
 * @return array
 *
 * @since 0.0.1
 */
function _mphbs_filter_block_attributes($attributes, $blockName)
{
    if (in_array($blockName, ['motopress-hotel-booking/availability-search', 'motopress-hotel-booking/availability'])) {
        $attributes['hide_labels'] = ['type' => 'boolean', 'default' => false];
        $attributes['no_paddings'] = ['type' => 'boolean', 'default' => false];
        $attributes['hide_tips']   = ['type' => 'boolean', 'default' => false];

        if ($blockName == 'motopress-hotel-booking/availability-search') {
            $attributes['enable_wrap']  = ['type' => 'boolean', 'default' => false];
            $attributes['fluid_button'] = ['type' => 'boolean', 'default' => false];
            $attributes['fields_width'] = ['type' => 'string',  'default' => 'auto'];
        }
    }

    return $attributes;
}

/**
 * @param array $attributes Attributes for shortcode.
 * @param string $shortcodeName
 * @return array
 *
 * @since 0.0.1
 */
function _mphbs_filter_block_classes($attributes, $shortcodeName)
{
    // Availability Search and Booking Form
    if (!in_array($shortcodeName, ['mphb_availability_search', 'mphb_availability'])) {
        return $attributes;
    }

    $mphbsClasses = [
        // Attribute name => Class name
        'hide_labels'  => 'mphbs-hide-labels',
        'no_paddings'  => 'mphbs-no-paddings',
        'hide_tips'    => 'mphbs-hide-rf-tip',
        'enable_wrap'  => 'mphbs-wrap',
        'fluid_button' => 'mphbs-fluid-button'
    ];

    $customClasses = '';

    // Add "boolean" classes
    foreach ($mphbsClasses as $attributeName => $className) {
        if (isset($attributes[$attributeName])) {
            // Add class
            if ($attributes[$attributeName]) {
                $customClasses .= ' ' . $className;
            }

            // Remove attribute (don't need that in the shortcode)
            unset($attributes[$attributeName]);
        }
    }

    // Add column class
    if (isset($attributes['fields_width'])) {
        if ($attributes['fields_width'] != 'auto') {
            $customClasses .= ' mphbs-fw-' . $attributes['fields_width'];
        }

        unset($attributes['fields_width']);
    }

    // Add classes
    if (!empty($className)) {
        if (isset($attributes['class'])) {
            $attributes['class'] .= $customClasses;
        } else {
            $attributes['class'] = trim($customClasses);
        }
    }

    return $attributes;
}

/**
 * @param string $class
 * @return string
 *
 * @since 0.0.1
 */
function _mphbs_filter_booking_form_classes($class)
{
    if (MPHB()->settings()->main()->isDirectBooking()) {
        return $class . ' is-direct-booking';
    }

    return $class;
}
