const { addFilter } = wp.hooks; 
const { Fragment } = wp.element;
const { InspectorControls, MediaUpload } = wp.blockEditor; 
const { PanelBody, Button } = wp.components; 
const { createHigherOrderComponent } = wp.compose;

// Aggiungi un nuovo attributo 'backgroundImage' al blocco 'core/column'
function addBackgroundAttribute(settings) {
    if (settings.name === 'core/column') {
        // Aggiungi l'attributo 'backgroundImage' solo se il blocco è 'core/column'
        settings.attributes = Object.assign(settings.attributes, {
            backgroundImage: {
                type: 'string', 
                default: '', // Imposta un valore predefinito vuoto
            },
        });
    }
    return settings; 
}

// Applica il filtro per aggiungere l'attributo al blocco 'core/column'
addFilter('blocks.registerBlockType', 'myplugin/column-background-attribute', addBackgroundAttribute);

// Aggiungi un controllo per l'immagine di sfondo nel pannello di ispezione (InspectorControls)
const withInspectorControls = createHigherOrderComponent((BlockEdit) => {
    return (props) => { 
        if (props.name === 'core/column') {
            const { attributes, setAttributes } = props; 
            const { backgroundImage } = attributes; 

            return wp.element.createElement(
                Fragment,
                null,
                // Mostra il blocco con le proprietà esistenti
                wp.element.createElement(BlockEdit, props), 
                // Aggiungi i controlli nel pannello laterale (InspectorControls)
                wp.element.createElement(
                    InspectorControls,
                    null,
                    wp.element.createElement(
                        PanelBody,
                        { title: "Background Image", initialOpen: true },
                        // Controllo per caricare o selezionare un'immagine
                        wp.element.createElement(MediaUpload, {
                            onSelect: (media) => setAttributes({ backgroundImage: media.url }), // Imposta l'URL dell'immagine selezionata
                            allowedTypes: ['image'],
                            value: backgroundImage, 
                            render: ({ open }) => wp.element.createElement(
                                Button,
                                { onClick: open, isPrimary: true }, 
                                !backgroundImage ? "Upload Image" : "Change Image" // Testo del pulsante
                            ),
                        }),
                        // Anteprima e opzione per rimuovere l'immagine di sfondo
                        backgroundImage && wp.element.createElement(
                            'div',
                            null,
                            wp.element.createElement(
                                'img',
                                { src: backgroundImage, style: { maxWidth: '100%', marginTop: '10px' } } // Anteprima immagine
                            ),
                            // Pulsante per rimuovere l'immagine
                            wp.element.createElement(Button, {
                                isSecondary: true,
                                onClick: () => setAttributes({ backgroundImage: '' }), // Rimuovi l'immagine
                                style: { marginTop: '10px' }
                            }, "Remove Image") // Testo del pulsante di rimozione
                        )
                    )
                )
            );
        }

        return wp.element.createElement(BlockEdit, props); // Restituisce il blocco originale se non è 'core/column'
    };
}, 'withInspectorControls');

// Applica il filtro per aggiungere i controlli personalizzati al pannello di ispezione per le colonne
addFilter('editor.BlockEdit', 'myplugin/with-inspector-controls', withInspectorControls);

// Applica lo stile di background al blocco 'core/column' durante il rendering
function applyBackgroundImage(extraProps, blockType, attributes) {
    if (blockType.name === 'core/column') {
        if (attributes.backgroundImage) { 
            // Aggiungi lo stile di sfondo
            extraProps.style = {
                ...extraProps.style, 
                backgroundImage: `url(${attributes.backgroundImage})`, 
                backgroundSize: 'cover', // Copre l'intero blocco
                backgroundPosition: 'center', // Posiziona l'immagine al centro
            };
        }
    }
    return extraProps; 
}

// Applica il filtro per salvare lo stile di background del blocco 'core/column'
addFilter('blocks.getSaveContent.extraProps', 'myplugin/apply-background-image', applyBackgroundImage);
