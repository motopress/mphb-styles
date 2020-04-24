'use strict';

var __                = wp.i18n.__;
var add_filter        = wp.hooks.addFilter;
var createHOC         = wp.compose.createHigherOrderComponent;
var createElement     = wp.element.createElement
var Fragment          = wp.element.Fragment;
var editor            = wp.blockEditor || wp.editor; // New version deprecates wp.editor
var InspectorControls = editor.InspectorControls;
var PanelBody         = wp.components.PanelBody;
var ToggleControl     = wp.components.ToggleControl;
var SelectControl     = wp.components.SelectControl;

// Register horizontal form style
wp.blocks.registerBlockStyle('motopress-hotel-booking/availability-search', {
    name: 'horizontal-form',
    label: __('Horizontal Form', 'mphb-styles')
});

wp.blocks.registerBlockStyle('motopress-hotel-booking/availability', {
    name: 'horizontal-form',
    label: __('Horizontal Form', 'mphb-styles')
});

// Extend block attributes
add_filter('blocks.registerBlockType', 'MPHB/Styles/Attributes', _mphbs_add_custom_attributes);

/**
 * @param {Object} settings
 * @returns {Object}
 *
 * @since 0.0.1
 */
function _mphbs_add_custom_attributes(settings)
{
    // Add attributes
    if (
        settings.name == 'motopress-hotel-booking/availability-search'
        || settings.name == 'motopress-hotel-booking/availability')
    {
        if (settings.attributes != undefined) {
            Object.assign(settings.attributes, {
                hide_labels: {type: 'boolean', default: false},
                no_paddings: {type: 'boolean', default: false},
                hide_tips:   {type: 'boolean', default: false},
                fluid_button: {type: 'boolean', default: false},
                fields_width: {type: 'string',  default: 'auto'}
            });

            if (settings.name == 'motopress-hotel-booking/availability-search') {
                Object.assign(settings.attributes, {
                    enable_wrap:  {type: 'boolean', default: false}
                });
            }
        }
    }

    return settings;
}

// Extend block controls
var withCustomBookindStyles = createHOC(function (edit) {
    return function (props) {
        if (
            props.name != 'motopress-hotel-booking/availability-search'
            && props.name != 'motopress-hotel-booking/availability'
        ) {
            return createElement(edit, props);
        }

        var attributes    = props.attributes;
        var setAttributes = props.setAttributes;
        var isSelected    = !!props.isSelected;
        var isSearch      = props.name == 'motopress-hotel-booking/availability-search';

        var hideLabels  = attributes.hide_labels;
        var noPaddings  = attributes.no_paddings;
        var hideTips    = attributes.hide_tips;
        var enableWrap  = attributes.enable_wrap;
        var fluidButton = attributes.fluid_button;
        var fieldsWidth = attributes.fields_width;

        props = Object.assign({}, props, {
            key: 'mphbs-default-settings'
        });

        return createElement(
            Fragment,
            {
                key: 'mphbs-controls-fragment'
            },
            [
                createElement(edit, props),
                isSelected && createElement(
                    InspectorControls,
                    {
                        key: 'mphbs-inspector-controls'
                    },
                    createElement(
                        PanelBody,
                        {
                            title: __('Customization', 'mphb-sytles'),
                            initialOpen: false
                        },
                        [
                            createElement(
                                ToggleControl,
                                {
                                    label: __('Hide Labels', 'mphb-styles'),
                                    help: __('Remove all labels from the form fields.', 'mphb-styles'),
                                    checked: hideLabels,
                                    onChange: function (value) {
                                        setAttributes({hide_labels: value});
                                    },
                                    key: 'hide_labels-control'
                                }
                            ),
                            createElement(
                                ToggleControl,
                                {
                                    label: __('No Paddings', 'mphb-styles'),
                                    help: __('Remove paddings between the form fields.', 'mphb-styles'),
                                    checked: noPaddings,
                                    onChange: function (value) {
                                        setAttributes({no_paddings: value});
                                    },
                                    key: 'no_paddings-control'
                                }
                            ),
                            createElement(
                                ToggleControl,
                                {
                                    label: __('Hide Tips', 'mphb-styles'),
                                    help: __('Hide message about required fields. Applied automatically on the horizontal form.', 'mphb-styles'),
                                    checked: hideTips,
                                    onChange: function (value) {
                                        setAttributes({hide_tips: value});
                                    },
                                    key: 'hide_tips-control'
                                }
                            ),
                            isSearch && createElement(
                                ToggleControl,
                                {
                                    label: __('Multiple Lines', 'mphb-styles'),
                                    help: __('Wrap form fields onto multiple lines.', 'mphb-styles'),
                                    checked: enableWrap,
                                    onChange: function (value) {
                                        setAttributes({enable_wrap: value});
                                    },
                                    key: 'enable_wrap-control'
                                }
                            ),
                            createElement(
                                ToggleControl,
                                {
                                    label: __('Stretch Button', 'mphb-styles'),
                                    help: __('Stretch the button to the maximum available width.', 'mphb-styles'),
                                    checked: fluidButton,
                                    onChange: function (value) {
                                        setAttributes({fluid_button: value});
                                    },
                                    key: 'fluid_button-control'
                                }
                            ),
                            createElement(
                                SelectControl,
                                {
                                    label: __('Fields Width', 'mphb-styles'),
                                    help: __('Limit the maximum width of the form fields.', 'mphb-styles'),
                                    value: fieldsWidth,
                                    options: [
                                        {value: 'auto', label: __('Auto', 'mphb-styles')},
                                        {value: '20',   label: '20%'},
                                        {value: '25',   label: '25%'},
                                        {value: '33',   label: '33%'},
                                        {value: '50',   label: '50%'},
                                        {value: '100',  label: '100%'}
                                    ],
                                    onChange: function (value) {
                                        setAttributes({fields_width: value});
                                    },
                                    key: 'fields_width-control'
                                }
                            )
                        ] // Panel elements
                    ) // Create PanelBody
                ) // Create InspectorControls
            ] // Fragment elements
        ); // Return element
    };
}, 'withCustomBookindStyles');

add_filter('editor.BlockEdit', 'MPHB/Styles/Controls', withCustomBookindStyles);
