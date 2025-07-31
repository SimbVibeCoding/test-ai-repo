
# Caricamento di un file JavaScript personalizzato in Gutenberg

Questo script carica un file JavaScript personalizzato nell'editor di blocchi Gutenberg di WordPress con commenti inline.

```php
function carica_custom_js() {
  // Verifica se siamo nell'area di amministrazione di WordPress
  if (is_admin()) {
      // Utilizza wp_enqueue_script per aggiungere il file JavaScript nell'editor Gutenberg
      wp_enqueue_script(
          'custom-column-background', // Nome identificativo dello script
          get_stylesheet_directory_uri() . '/assets/js/gutemberg.js', // Percorso dello script nel tema
          array('wp-blocks', 'wp-element', 'wp-editor'), // Dipendenze che assicurano il corretto funzionamento
          filemtime(get_stylesheet_directory() . '/assets/js/gutemberg.js'), // Versione dinamica basata sull'ultima modifica del file
          true // Carica lo script in fondo alla pagina per ottimizzare le prestazioni
      );
  }
}

// Collega la funzione carica_custom_js all'azione enqueue_block_editor_assets
add_action('enqueue_block_editor_assets', 'carica_custom_js');
```

## Dettagli della Funzione `wp_enqueue_script()`

La funzione `wp_enqueue_script()` è parte dell'API di WordPress e viene utilizzata per includere script nelle pagine in modo condizionato e con dipendenze corrette.

- Fonte: [wp_enqueue_script() - WordPress Codex](https://developer.wordpress.org/reference/functions/wp_enqueue_script/)

### Parametri:

- `'custom-column-background'`: Nome identificativo dello script.
- `get_stylesheet_directory_uri() . '/assets/js/gutemberg.js'`: Percorso dello script nella directory del tema corrente.
- `array('wp-blocks', 'wp-element', 'wp-editor')`: Dipendenze che assicurano il corretto funzionamento con l'editor Gutenberg.
- `filemtime(get_stylesheet_directory() . '/assets/js/gutemberg.js')`: Utilizza l'ultima modifica del file come versione per evitare problemi di cache.
    - Fonte: [filemtime() - PHP Manual](https://www.php.net/manual/en/function.filemtime.php)
- `true`: Indica che lo script deve essere caricato in fondo alla pagina per ottimizzare le prestazioni.

## Azione `add_action('enqueue_block_editor_assets', 'carica_custom_js')`

Questa linea aggiunge la funzione `carica_custom_js()` all'azione `enqueue_block_editor_assets`, che viene eseguita quando WordPress prepara gli asset per l'editor Gutenberg.

- Fonte: [enqueue_block_editor_assets - WordPress](https://developer.wordpress.org/reference/hooks/enqueue_block_editor_assets/)

## Commenti finali

Lo script segue le best practices di WordPress per il caricamento di script nell'editor Gutenberg. L'uso di `filemtime()` per il versionamento dinamico è una soluzione efficace per evitare problemi di cache durante lo sviluppo.
