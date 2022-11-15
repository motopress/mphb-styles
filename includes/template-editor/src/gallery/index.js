import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { Placeholder, TextControl, SelectControl, PanelBody, Disabled, ToggleControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import AccommodationSelect from '../controls/accommodation-select';

registerBlockType( 'motopress-hotel-booking/gallery', {
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;

        const imageSizes = useSelect( ( select ) => {
            const imageSizes = select( 'core/block-editor' )
                .getSettings()
                .imageSizes
                .map((size) => {
                    return {
                        value: size.slug,
                        label: size.name
                    }
                });

            [{value: '', label: __( 'Default', 'mphb-styles' )}].concat(imageSizes);

            return imageSizes;
        }, []);

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Accommodation Type Gallery', 'mphb-styles' ) }
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
                        <SelectControl
                            label={ __( 'Image size', 'mphb-styles' ) }
                            value={ attributes.size }
                            options={ imageSizes ? imageSizes : [] }
                            onChange={ ( size ) => {
                                setAttributes( { size: size } );
                            } }
                        />
                        <ToggleControl
                            label={ __( 'Display as slider', 'mphb-styles' ) }
                            checked={ attributes.slider }
                            onChange={ ( value ) => setAttributes( { slider: value } ) }
                            help={ __( 'Check it out on the frontend once applied.', 'mphb-styles' ) }
                        />
                        <TextControl
                            label={ __( 'Columns', 'mphb-styles' ) }
                            value={ attributes.columns }
                            type='number'
                            min={1}
                            onChange={ ( value ) => setAttributes( { columns: value } ) }
                        />
                        <SelectControl
                            label={ __( 'Link to', 'mphb-styles' ) }
                            value={ attributes.link }
                            options={ [
                                { value: '', label: __( 'Default', 'mphb-styles' ) },
                                { value: 'none', label: __( 'None', 'mphb-styles' ) },
                                { value: 'file', label: __( 'File', 'mphb-styles' ) }
                            ] }
                            onChange={ ( link ) => {
                                setAttributes( { link: link } );
                            } }
                        />
                        <SelectControl
                            label={ __( 'Open in lightbox', 'mphb-styles' ) }
                            value={ attributes.slider ? 'no' : attributes.lightbox }
                            disabled={ attributes.slider || attributes.link == 'none'}
                            options={ [
                                { value: '', label: __( 'Default', 'mphb-styles' ) },
                                { value: 'yes', label: __( 'Yes', 'mphb-styles' ) },
                                { value: 'no', label: __( 'No', 'mphb-styles' ) }
                            ] }
                            onChange={ ( lightbox ) => {
                                setAttributes( { lightbox: lightbox } );
                            } }
                        />
                    </PanelBody>
                </InspectorControls>
                { !attributes.id && renderPlaceholder() }
                { attributes.id &&
                <Disabled>
                    <ServerSideRender
                        block="motopress-hotel-booking/gallery"
                        attributes={ { ...attributes, slider: false } }
                    />
                </Disabled> }
            </div>
        );
    }
} );