import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Placeholder, Button, PanelBody, CheckboxControl, Disabled } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import AccommodationSelect from '../controls/accommodation-select';

registerBlockType( 'motopress-hotel-booking/attributes', {
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;

        let hiddenAttributes = attributes.hiddenAttributes ? attributes.hiddenAttributes.split(',') : [];

        const availableAttributes = [
            {
                label: __( 'Capacity', 'mphb-styles' ),
                slug: 'capacity'
            },
            {
                label: __( 'Amenities', 'mphb-styles' ),
                slug: 'amenities'
            },
            {
                label: __( 'View', 'mphb-styles' ),
                slug: 'view'
            },
            {
                label: __( 'Size', 'mphb-styles' ),
                slug: 'size'
            },
            {
                label: __( 'Bed Types', 'mphb-styles' ),
                slug: 'bed-types'
            },
            {
                label: __( 'Categories', 'mphb-styles' ),
                slug: 'categories'
            },
        ];

        window.MPHBTemplates.roomTypeAttributes.map(attr => {
            if(attr.visible) {
                availableAttributes.push({
                    label: attr.title,
                    slug: attr.attributeName
                });
            };
        });

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Accommodation Type Attributes', 'mphb-styles' ) }
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
                        {
                            availableAttributes.map((attribute) => {
                                return (
                                    <CheckboxControl
                                        label={attribute.label}
                                        checked={!hiddenAttributes.includes(attribute.slug)}
                                        onChange={(isVisible) => {
                                            if(!isVisible) {
                                                hiddenAttributes.push(attribute.slug);
                                            } else {
                                                hiddenAttributes = hiddenAttributes.filter(slug => slug != attribute.slug);
                                            }

                                            setAttributes({hiddenAttributes: hiddenAttributes.join(',')});
                                        }}
                                    />
                                )
                            })
                        }
                    </PanelBody>
                </InspectorControls>
                { !attributes.id && renderPlaceholder() }
                { attributes.id &&
                <Disabled>
                    <ServerSideRender
                        block="motopress-hotel-booking/attributes"
                        attributes={ attributes }
                    />
                </Disabled> }
            </div>
        );
    }
} );