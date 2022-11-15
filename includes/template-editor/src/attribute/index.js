import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Placeholder, PanelBody, ComboboxControl, ToggleControl, Disabled } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import AccommodationSelect from '../controls/accommodation-select';

registerBlockType( 'motopress-hotel-booking/attribute', {
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;

        const availableAttributes = [
            {
                label: __( 'Adults', 'mphb-styles' ),
                value: 'adults'
            },
            {
                label: __( 'Children', 'mphb-styles' ),
                value: 'children'
            },
            {
                label: __( 'Total Capacity', 'mphb-styles' ),
                value: 'capacity'
            },
            {
                label: __( 'Amenities', 'mphb-styles' ),
                value: 'amenities'
            },
            {
                label: __( 'View', 'mphb-styles' ),
                value: 'view'
            },
            {
                label: __( 'Size', 'mphb-styles' ),
                value: 'size'
            },
            {
                label: __( 'Bed Types', 'mphb-styles' ),
                value: 'bed-types'
            },
            {
                label: __( 'Categories', 'mphb-styles' ),
                value: 'categories'
            },
        ];

        window.MPHBTemplates.roomTypeAttributes.map(attr => {
            if(attr.visible) {
                availableAttributes.push({
                    label: attr.title,
                    value: attr.attributeName
                });
            };
        });

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Accommodation Type Attribute', 'mphb-styles' ) }
                    icon={ 'admin-home' }
                />
            );
        }

        return (
            <div { ...blockProps }>
                <InspectorControls>
                    <PanelBody
                        label={ __( 'Settings', 'mphb-styles' ) }
                    >
                        <AccommodationSelect
                            value={ attributes.id }
                            onChange={ (value) => {
                                setAttributes({id: value})
                            } }
                        />
                        <ComboboxControl
                            label={ __( 'Attribute', 'mphb-styles' ) }
                            value={ attributes.attribute }
                            options={ availableAttributes }
                            onChange={ (selectedAttribute) => {
                                setAttributes({attribute: selectedAttribute})
                            } }
                        />
                        <ToggleControl
                            label={ __( 'Show label', 'mphb-styles' ) }
                            checked={ attributes.showLabel }
                            onChange={ ( value ) => setAttributes( { showLabel: value } ) }
                        />
                    </PanelBody>
                </InspectorControls>
                { !attributes.id && renderPlaceholder() }
                { attributes.id &&
                <Disabled>
                    <ServerSideRender
                        block="motopress-hotel-booking/attribute"
                        attributes={ attributes }
                    />
                </Disabled> }
            </div>
        );
    }
} );