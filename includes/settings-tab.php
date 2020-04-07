<?php

use MPHB\Admin\Fields\FieldFactory;
use MPHB\Admin\Groups\SettingsGroup;
use MPHB\Admin\Tabs\SettingsSubTab;
use MPHB\Admin\Tabs\SettingsTab;

add_action('mphb_generate_extension_settings', '_mphb_add_extension_settings_tab');

/**
 * @param SettingsTab $tab
 *
 * @since 0.0.1
 */
function _mphb_add_extension_settings_tab($tab)
{
    $subtab = new SettingsSubTab('mphb_styles', esc_html__('Styles', 'mphb-styles'), $tab->getPageName(), $tab->getName());

    $classesGroup = new SettingsGroup('mphbs_classes', esc_html__('Available Classes'), $subtab->getOptionGroupName());

    $classes = [
        FieldFactory::create('mphbs_horizontal_form', [
            'type'        => 'placeholder',
            'label'       => 'is-style-horizontal-form',
            'default'     => esc_html__('Makes the form horizontal.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form, Booking Form and Search Availability Widget.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_hide_labels', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-hide-labels',
            'default'     => esc_html__('Removes all labels from the form.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Booking Form.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_no_paddings', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-no-paddings',
            'default'     => esc_html__('Removes paddings between form elements.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Booking Form.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_hide_tips', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-hide-rf-tip',
            'default'     => esc_html__('Hides the tip "Required fields are followed by *". Applied automaticaly on the horizontal form.', 'mphb-styles'),
            'description' => esc_html__('Available for Availability Search Form and Booking Form.', 'mphb-styles')
        ]),
        FieldFactory::create('mphbs_wrap', [
            'type'        => 'placeholder',
            'label'       => 'mphbs-wrap',
            'default'     => esc_html__('Adds elements wrap.', 'mphb-styles'),
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
            'default'     => wp_kses(__('<code>mphbs-fw-20</code>, <code>mphbs-fw-25</code>, <code>mphbs-fw-33</code>, <code>mphbs-fw-50</code>, <code>mphbs-fw-100</code><br>Limits the maximum width of the form elements. Has no effect on the horizontal form.', 'mphb-styles'), ['code' => [], 'br' => []]),
            'description' => esc_html__('Available for Availability Search Form and Search Availability Widget.', 'mphb-styles')
        ])
    ];

    $classesGroup->addFields($classes);
    $subtab->addGroup($classesGroup);
    $tab->addSubTab($subtab);
}