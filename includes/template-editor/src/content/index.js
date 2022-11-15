import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Placeholder, Button, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import AccommodationSelect from '../controls/accommodation-select';

registerBlockType( 'motopress-hotel-booking/content', {
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Accommodation Type Content', 'mphb-styles' ) }
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
                    </PanelBody>
                </InspectorControls>
                { !attributes.id && renderPlaceholder() }
                { attributes.id && <ServerSideRender
                     block="motopress-hotel-booking/content"
                     attributes={ attributes }
                /> }
            </div>
        );
    }
} );