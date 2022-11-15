import { registerBlockType, parse } from '@wordpress/blocks';
import { useSelect, dispatch } from '@wordpress/data';
import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder, Spinner, SelectControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { addQueryArgs } from '@wordpress/url';
import { useState } from '@wordpress/element';
import { store as blockEditorStore } from '@wordpress/block-editor';

registerBlockType( 'motopress-hotel-booking/template', {
    edit: () => {
        const blockProps = useBlockProps();
        const templates = useSelect( ( select ) => {
            return select( 'core' ).getEntityRecords( 'postType', 'mphb_template' );
        }, [] );
        const clientId = useSelect( ( select ) => {
            return select( 'core/block-editor' ).getSelectedBlockClientId();
        });

        const createTemplateURL = addQueryArgs( 'edit.php', {
            post_type: 'mphb_template',
        } );

        const [ templateId, setTemplateId ] = useState( '' );

        const getTemplateOptionsList = () => {
            let defaultOption = [{value: '', label: __( 'Choose template', 'mphb-styles' ), disabled: true}]
            return defaultOption.concat(templates.map(template => {
                return {
                    label: template.title.raw,
                    value: template.id,
                }
            }));
        }

        const insertSelectedTemplate = () => {
            if (!templateId) {
                return;
            }

            const selectedTemplate = templates.find(template => {
                return parseInt(templateId) === template.id;
            })

            const blocks = parse(selectedTemplate.content.raw);

            dispatch(blockEditorStore).replaceBlocks(clientId, blocks);
        }

        const renderPlaceholder = () => {
            return (
                <Placeholder
                    label={ __( 'Choose template', 'mphb-styles' ) }
                    isColumnLayout={true}
                    icon={ 'admin-home' }
                >
                    {!templates && <Spinner/>}
                    {templates && templates.length === 0 && renderNoTemplates()}
                    {templates && templates.length > 0 && (
                        <>
                            <SelectControl
                                label={__( 'Template', 'mphb-styles' )}
                                value={templateId}
                                options={getTemplateOptionsList()}
                                onChange={ ( id ) => setTemplateId( id ) }
                            />
                            <div>
                                <Button
                                    isPrimary
                                    onClick={insertSelectedTemplate}
                                    disabled={templateId === ''}
                                    >
                                        {__( 'Insert', 'mphb-styles' )}
                                </Button>
                                <Button
                                    href={createTemplateURL}
                                    isSecondary
                                    target='_blank'
                                    >
                                        {__( 'Create template', 'mphb-styles' )}
                                </Button>
                            </div>
                        </>
                    )}

                </Placeholder>
            )
        }

        const renderNoTemplates = () => {
            return (
                <>
                    <p>{__( 'No templates found', 'mphb-styles' )}</p>
                    <Button
                        href={createTemplateURL}
                        variant='primary'
                        target='_blanc'
                        >
                            {__( 'Create template', 'mphb-styles' )}
                    </Button>
                </>
            )
        }

        return (
            <div { ...blockProps }>
                {renderPlaceholder()}
            </div>
        );
    }
} );