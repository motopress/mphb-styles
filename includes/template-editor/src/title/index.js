import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Placeholder, PanelBody, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import AccommodationSelect from '../controls/accommodation-select';

registerBlockType( 'motopress-hotel-booking/title', {
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Accommodation Type Title', 'mphb-styles' ) }
                    icon={ 'admin-home' }
                />
            );
        }

        return (
            <div { ...blockProps }>
                <InspectorControls>
                    <PanelBody title={ __( 'Settings', 'mphb-styles' ) }>
                        <AccommodationSelect
                            value={ attributes.id }
                            onChange={ (value) => {
                                setAttributes({id: value})
                            } }
                        />
                        <ToggleControl
                            label={ __( 'Link to post', 'mphb-styles' ) }
                            checked={ attributes.linkToPost }
                            onChange={ ( value ) => setAttributes( { linkToPost: value } ) }
                        />
                    </PanelBody>
                </InspectorControls>
                { !attributes.id && renderPlaceholder() }
                { attributes.id &&
                <Disabled>
                    <ServerSideRender
                        block="motopress-hotel-booking/title"
                        attributes={ attributes }
                    />
                </Disabled> }
            </div>
        );
    }
} );