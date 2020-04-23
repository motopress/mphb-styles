<?php

use MPHB\Admin\Fields\FieldFactory;
use MPHB\Admin\Groups\SettingsGroup;
use MPHB\Admin\Tabs\SettingsSubTab;
use MPHB\Admin\Tabs\SettingsTab;

if (!defined('ABSPATH')) {
    exit;
}

add_action('mphb_generate_extension_settings', '_mphb_add_extension_settings_tab');

/**
 * @param SettingsTab $tab
 *
 * @since 0.0.1
 */
function _mphb_add_extension_settings_tab($tab)
{
    $subtab = new SettingsSubTab('mphb_styles', esc_html__('Styles', 'mphb-styles'), $tab->getPageName(), $tab->getName());

    $classesGroup = new SettingsGroup(
		'mphbs_classes',
		esc_html__('Available Classes'),
		$subtab->getOptionGroupName(),
		wp_kses(
			sprintf( __('Use spaces to add several classes. Example of using styles with shortcodes: %s.', 'mphb-styles'),
			'<code>[mphb_availability_search class="is-style-horizontal-form"]</code>'), ['code' => []]
		)
	);

    $classes = [
        FieldFactory::create('mphbs_horizontal_form', [
            'type'        => 'placeholder',
            'label'       => 'is-style-horizontal-form',
            'default'     => esc_html__('Make the form horizontal.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form, Booking Form and Search Availability Widget.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_hide_labels', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-hide-labels',
            'default'     => esc_html__('Remove all labels from the form fields.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Booking Form.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_no_paddings', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-no-paddings',
            'default'     => esc_html__('Remove paddings between the form fields.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Booking Form.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_hide_tips', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-hide-rf-tip',
            'default'     => esc_html__('Hide message about required fields. Applied automatically on the horizontal form.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Booking Form.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_wrap', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-wrap',
            'default'     => esc_html__('Wrap form fields onto multiple lines.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Search Availability Widget.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_fluid_button', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-fluid-button',
            'default'     => esc_html__('Stretch the button to the maximum available width.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Search Availability Widget.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_columns', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-fw-*',
            'default'     => wp_kses( '<code>mphbs-fw-20</code>, <code>mphbs-fw-25</code>, <code>mphbs-fw-33</code>, <code>mphbs-fw-50</code>, <code>mphbs-fw-100</code><br>' .
				__('Limit the maximum width of the form fields.', 'mphb-styles'), ['code' => [], 'br' => []]),
            'description' => esc_html__('Available for Availability Search Form and Search Availability Widget.', 'mphb-styles')
        ])
    ];

    $classesGroup->addFields($classes);
    $subtab->addGroup($classesGroup);
    $tab->addSubTab($subtab);
}
