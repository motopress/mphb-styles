import { ComboboxControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

export default (props) => {

    let accommodations = useSelect( ( select ) => {
        let accommodations = select( 'core' ).getEntityRecords( 'postType', 'mphb_room_type' );
        accommodations = accommodations?.map(accommodation => {
            return {
                label: accommodation.title.raw + ' #' + accommodation.id.toString(),
                value: accommodation.id.toString(),
            }
        });
        return accommodations;
    }, [] );

    if(!accommodations) {
        accommodations = [];
    }

    return (
        <ComboboxControl
            label={ __( 'Accommodation Type', 'mphb-styles' ) }
            value={ props.value }
            options={ accommodations }
            onChange={ props.onChange }
            help={ __( 'Leave blank to use current.', 'mphb-styles' ) }
            disabled={ !accommodations }
        />
    )
}