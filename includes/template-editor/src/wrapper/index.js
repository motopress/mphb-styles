import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, InnerBlocks } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import './index.scss';
import './style.scss';

registerBlockType( 'motopress-hotel-booking/wrapper', {
    edit: (props) => {
        const { attributes, setAttributes } = props;
        const blockProps = useBlockProps({
            style: {
                maxWidth: attributes.maxWidth + 'px'
            }
        });

        return (
            <div { ...blockProps }>
                <InspectorControls>
                    <PanelBody title={ __( 'Settings', 'mphb-styles' ) }>
                        <TextControl
                            type='number'
                            label={ __( 'Wrapper width(in pixels)', 'mphb-styles' ) }
                            value={ attributes.maxWidth }
                            onChange={ ( value ) => setAttributes( { maxWidth: value } ) }
                        />
                    </PanelBody>
                </InspectorControls>
                <InnerBlocks />
            </div>
        );
    },
    save: (props) => {
        const blockProps = useBlockProps.save({
            style: {
                maxWidth: props.attributes.maxWidth + 'px'
            }
        });

        return (
            <div { ...blockProps }>
                <InnerBlocks.Content />
            </div>
        );
    }
} );