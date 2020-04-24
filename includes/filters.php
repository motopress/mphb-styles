<?php

if (!defined('ABSPATH')) {
    exit;
}

// Booking Form classes
add_filter('mphb_sc_booking_form_wrapper_classes', '_mphbs_filter_booking_form_classes');

// Search Availability and Booking Form blocks
add_filter('mphb_block_attributes', '_mphbs_filter_block_attributes', 10, 2);
add_filter('mphb_render_block_attributes', '_mphbs_filter_block_classes', 10, 2);

// Search Availability widget
add_action('mphb_search_availability_widget_after_controls', '_mphbs_add_search_widget_controls', 10, 2);
add_filter('mphb_search_availability_widget_before_update', '_mphbs_filter_search_widget_update_args', 10, 2);
add_filter('mphb_search_availability_widget_template_args', '_mphbs_filter_search_widget_template_args', 10, 2);
add_filter('mphb_widget_search_form_class', '_mphbs_filter_search_widget_classes', 10, 2);

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
        $attributes['fluid_button'] = ['type' => 'boolean', 'default' => false];
        $attributes['fields_width'] = ['type' => 'string',  'default' => 'auto'];

        if ($blockName == 'motopress-hotel-booking/availability-search') {
            $attributes['enable_wrap']  = ['type' => 'boolean', 'default' => false];
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
 * @param array $args
 * @param \MPHB\Widgets\BaseWidget $widget
 *
 * @since 0.0.2
 */
function _mphbs_add_search_widget_controls($args, $widget)
{
    $horizontalForm = isset($args['horizontal_form']) && $args['horizontal_form'];
    $enableWrap     = isset($args['enable_wrap'])     && $args['enable_wrap'];
    $fluidButton    = isset($args['fluid_button'])    && $args['fluid_button'];
    $fieldsWidth    = isset($args['fields_width']) ? sanitize_text_field($args['fields_width']) : 'auto';

    $widthVariants = [
        'auto' => esc_html__('Auto', 'mphb-styles'),
        '20'   => '20%',
        '25'   => '25%',
        '33'   => '33%',
        '50'   => '50%',
        '100'  => '100%'
    ];

    ?>
    <p>
        <input class="checkbox" type="checkbox" id="<?php echo esc_attr($widget->get_field_id('horizontal_form')); ?>" name="<?php echo esc_attr($widget->get_field_name('horizontal_form')); ?>" <?php checked($horizontalForm); ?> style="margin-top: 0;">
        <label for="<?php echo esc_attr($widget->get_field_id('horizontal_form')); ?>"><?php esc_html_e('Horizontal Form', 'mphb-styles'); ?></label>
        <br>
        <small><?php _e('Make the form horizontal.', 'mphb-styles'); ?></small>
    </p>
    <p>
        <input class="checkbox" type="checkbox" id="<?php echo esc_attr($widget->get_field_id('enable_wrap')); ?>" name="<?php echo esc_attr($widget->get_field_name('enable_wrap')); ?>" <?php checked($enableWrap); ?> style="margin-top: 0;">
        <label for="<?php echo esc_attr($widget->get_field_id('enable_wrap')); ?>"><?php esc_html_e('Multiple Lines', 'mphb-styles'); ?></label>
        <br>
        <small><?php _e('Wrap form fields onto multiple lines.', 'mphb-styles'); ?></small>
    </p>
    <p>
        <input class="checkbox" type="checkbox" id="<?php echo esc_attr($widget->get_field_id('fluid_button')); ?>" name="<?php echo esc_attr($widget->get_field_name('fluid_button')); ?>" <?php checked($fluidButton); ?> style="margin-top: 0;">
        <label for="<?php echo esc_attr($widget->get_field_id('fluid_button')); ?>"><?php esc_html_e('Stretch Button', 'mphb-styles'); ?></label>
        <br>
        <small><?php _e('Stretch the button to the maximum available width.', 'mphb-styles'); ?></small>
    </p>
    <p>
        <label for="<?php echo esc_attr($widget->get_field_id('fields_width')); ?>"><?php esc_html_e('Fields Width', 'mphb-styles'); ?></label>
        <select id="<?php echo esc_attr($widget->get_field_id('fields_width')); ?>" name="<?php echo esc_attr($widget->get_field_name('fields_width')); ?>">
            <?php foreach ($widthVariants as $width => $label) { ?>
                <option value="<?php echo $width; ?>" <?php selected($fieldsWidth, $width); ?>><?php echo $label; ?></option>
            <?php } ?>
        </select>
        <br>
        <small><?php _e('Limit the maximum width of the form fields.', 'mphb-styles'); ?></small>
    </p>
    <?php
}

/**
 * @param array $values
 * @param array $newValues
 * @return array
 *
 * @since 0.0.2
 */
function _mphbs_filter_search_widget_update_args($values, $newValues)
{
    $values = array_merge($values, [
        'horizontal_form' => '',
        'enable_wrap'     => '',
        'fluid_button'    => '',
        'fields_width'    => ''
    ]);

    if (isset($newValues['horizontal_form']) && $newValues['horizontal_form'] !== '') {
        $values['horizontal_form'] = (bool)$newValues['horizontal_form'];
    }

    if (isset($newValues['enable_wrap']) && $newValues['enable_wrap'] !== '') {
        $values['enable_wrap'] = (bool)$newValues['enable_wrap'];
    }

    if (isset($newValues['fluid_button']) && $newValues['fluid_button'] !== '') {
        $values['fluid_button'] = (bool)$newValues['fluid_button'];
    }

    if (isset($newValues['fields_width']) && $newValues['fields_width'] !== '') {
        $fieldsWidth = sanitize_text_field($newValues['fields_width']);

        if (
            $fieldsWidth === 'auto'
            || (is_numeric($fieldsWidth) && in_array($fieldsWidth, ['20', '25', '33', '50', '100']))
        ) {
            $values['fields_width'] = $fieldsWidth;
        } else {
            $values['fields_width'] = 'auto';
        }
    }

    return $values;
}

/**
 * @param array $tempalteArgs
 * @param array $widgetArgs
 * @return array
 *
 * @since 0.0.2
 */
function _mphbs_filter_search_widget_template_args($tempalteArgs, $widgetArgs)
{
    $customClasses = '';

    if (isset($widgetArgs['horizontal_form']) && $widgetArgs['horizontal_form']) {
        $customClasses .= 'is-style-horizontal-form';
    }

    if (isset($widgetArgs['enable_wrap']) && $widgetArgs['enable_wrap']) {
        $customClasses .= ' mphbs-wrap';
    }

    if (isset($widgetArgs['fluid_button']) && $widgetArgs['fluid_button']) {
        $customClasses .= ' mphbs-fluid-button';
    }

    if (!empty($widgetArgs['fields_width']) && $widgetArgs['fields_width'] !== 'auto') {
        $customClasses .= ' mphbs-fw-' . $widgetArgs['fields_width'];
    }

    if (!empty($customClasses)) {
        $tempalteArgs['mphbsClasses'] = trim($customClasses);
    }

    return $tempalteArgs;
}

/**
 * @param string $classes
 * @param array $args
 * @return string
 *
 * @since 0.0.2
 */
function _mphbs_filter_search_widget_classes($classes, $args)
{
    if (isset($args['mphbsClasses'])) {
        $classes .= ' ' . $args['mphbsClasses'];
    }

    return $classes;
}
