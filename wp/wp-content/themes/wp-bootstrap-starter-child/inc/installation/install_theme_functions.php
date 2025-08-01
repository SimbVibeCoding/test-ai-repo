<?php

add_action('after_switch_theme', 'mytheme_import_patterns_on_activation');
add_action('admin_notices', 'mytheme_debug_import_messages');

global $mytheme_debug_messages;
$mytheme_debug_messages = [];

/**
 * Importa i pattern al primo attivazione del tema
 */
function mytheme_import_patterns_on_activation() {
    global $mytheme_debug_messages;

    // Controlla se Gutenberg è attivo
    if (!function_exists('register_block_pattern')) {
        $mytheme_debug_messages[] = 'Gutenberg non è attivo. I pattern non possono essere registrati.';
        return;
    }

    $patterns_dir = get_stylesheet_directory() . '/patterns';

    // Controlla se la directory dei pattern esiste
    if (!is_dir($patterns_dir)) {
        $mytheme_debug_messages[] = "La directory dei pattern non esiste: $patterns_dir";
        return;
    }

    // Trova i file JSON
    $pattern_files = glob($patterns_dir . '/*.json');
    if (!$pattern_files) {
        $mytheme_debug_messages[] = "Nessun file JSON trovato nella directory: $patterns_dir";
        return;
    }

    // Registra la categoria "Simbiosi" se non esiste
    register_block_pattern_category('simbiosi', ['label' => __('Simbiosi', 'mytheme')]);
    $mytheme_debug_messages[] = 'Categoria "Simbiosi" registrata con successo.';

    foreach ($pattern_files as $file_path) {
        $pattern_content = file_get_contents($file_path);
        if (!$pattern_content) {
            $mytheme_debug_messages[] = "Impossibile leggere il file: $file_path";
            continue;
        }

        $pattern_data = json_decode($pattern_content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $mytheme_debug_messages[] = "Errore nel decodificare il JSON: " . json_last_error_msg() . " in $file_path";
            continue;
        }

        $title = $pattern_data['title'] ?? null;
        $content = $pattern_data['content'] ?? null;

        if (empty($title) || empty($content)) {
            $mytheme_debug_messages[] = "Dati mancanti (titolo o contenuto) nel file: $file_path";
            continue;
        }

        // Controlla se un blocco con lo stesso titolo esiste già
        $existing_block = get_page_by_title($title, OBJECT, 'wp_block');
        if ($existing_block) {
            $mytheme_debug_messages[] = "Il pattern '$title' esiste già. Ignorato.";
            continue;
        }

        // Salva il pattern come blocco riutilizzabile (post di tipo wp_block)
        $post_id = wp_insert_post([
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'wp_block',
        ]);

        if ($post_id) {
            $mytheme_debug_messages[] = "Pattern importato e salvato come blocco riutilizzabile: $title";

            // Registra il pattern anche come pattern visibile in Gutenberg (editor dei blocchi)
            $pattern_slug = sanitize_title($title);

            register_block_pattern(
                $pattern_slug,
                [
                    'title'       => $title,
                    'description' => $pattern_data['description'] ?? '',
                    'content'     => $content,
                    'categories'  => ['simbiosi'], // Associa alla categoria Simbiosi
                ]
            );
        } else {
            $mytheme_debug_messages[] = "Errore durante l'importazione del pattern: $title";
        }
    }

    $mytheme_debug_messages[] = 'Importazione completata.';
}

/**
 * Mostra i messaggi di debug nell'admin
 */
function mytheme_debug_import_messages() {
    global $mytheme_debug_messages;

    if (!empty($mytheme_debug_messages)) {
        echo '<div class="notice notice-success is-dismissible">';
        echo '<h3>Debug Importazione Pattern:</h3>';
        echo '<ul>';
        foreach ($mytheme_debug_messages as $message) {
            echo '<li>' . esc_html($message) . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
}

/**
 * Registra la categoria "Simbiosi" per i pattern
 */
add_action('init', 'mytheme_register_simbiosi_category');

function mytheme_register_simbiosi_category() {
    register_block_pattern_category(
        'simbiosi',
        ['label' => __('Simbiosi', 'mytheme')]
    );
}



/**
 * Integra i pattern nel codice
 */

function display_block_pattern( $pattern_title ) {
    $args = array(
        'post_type'      => 'wp_block',
        'post_status'    => 'publish',
        'title'          => $pattern_title, // Cerca in base al titolo
        'posts_per_page' => 1,
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) {
        $query->the_post();
        echo do_blocks(the_content() );
        wp_reset_postdata();
    } else {
        echo '<p>Il pattern "' . esc_html( $pattern_title ) . '" non è stato trovato.</p>';
    }
}
