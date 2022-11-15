import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { SelectControl, PanelBody, Disabled, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import AccommodationSelect from '../controls/accommodation-select';

registerBlockType( 'motopress-hotel-booking/featured-image', {
    edit: (props) => {
        const blockProps = useBlockProps();
        const { attributes, setAttributes } = props;

        const imageSizes = useSelect( ( select ) => {
            let id = attributes.id ? attributes.id : select('core/editor').getCurrentPostId();
            const postEntity = select('core').getEntityRecord('postType', 'mphb_room_type', id);
            const mediaSizes = select('core').getMedia(postEntity?.featured_media)?.media_details.sizes;
            const mediaSizesSetting = select( 'core/block-editor' ).getSettings().imageSizes;

            let imageSizes = [{value: '', label: __( 'Default', 'mphb-styles' )}];

            if (mediaSizes) {
                Object.entries(mediaSizes).forEach(([size, details]) => {
                    let sizeSetting = mediaSizesSetting.find((sizeSetting) => {
                        return sizeSetting.slug == size;
                    });

                    imageSizes.push({
                        value: size,
                        label: sizeSetting ? sizeSetting?.name : size
                    });
                });
            }

            return imageSizes;
        }, []);

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Accommodation Type Image', 'mphb-styles' ) }
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
                        <SelectControl
                            label={ __( 'Image size', 'mphb-styles' ) }
                            value={ attributes.size }
                            options={ imageSizes }
                            onChange={ ( size ) => {
                                setAttributes( { size: size } );
                            } }
                        />
                    </PanelBody>
                </InspectorControls>
                { !attributes.id && renderPlaceholder() }
                { attributes.id &&
                    <Disabled>
                        <ServerSideRender
                            block="motopress-hotel-booking/featured-image"
                            attributes={ attributes }
                        />
                    </Disabled>
                }
            </div>
        );
    }
} );