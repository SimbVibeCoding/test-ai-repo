<?php

// Array predefinito di argomenti per la registrazione di un tipo di post.
$defaultPostTypeArgs = array(
  'label' => ('slider'),
  'public' => true,
  'has_archive' => true,
  'supports' => array('title', 'thumbnail', 'excerpt', 'editor', 'revisions', 'custom-fields'),
  'show_in_rest' => true,
  'rewrite' => array('slug' => sprintf('elenco_%s', 'slider')),
  'taxonomy' => 'cat'
);

/**
 * Registra un tipo di post personalizzato.
 *
 * @param string $type Nome del tipo di post.
 * @param array $postTypeArgs Argomenti per la registrazione del tipo di post.
 */
function retina_create_posttype($type, $postTypeArgs) {
  $type = sanitize_key($type);
  $args = $postTypeArgs;
  $args['label'] = $type;
  $args['rewrite']['slug'] = sprintf($args['rewrite']['slug'], $type);
  
  $args = apply_filters('retina_custom_posttype_args_filter', $args, $type);
  
  register_post_type($type, $args);
  
  $taxonomy = $args['taxonomy'] ?: 'cat';
  retina_register_taxonomy($taxonomy, $type);
}

/**
 * Registra più tipi di post personalizzati.
 *
 * @param array $post_types Elenco dei tipi di post da registrare.
 * @param array|null $postTypeArgs Argomenti opzionali per la registrazione dei tipi di post.
 */
function create_posttype_multi($post_types, $postTypeArgs = null) {
  global $defaultPostTypeArgs;
  if (is_null($postTypeArgs)) {
    $postTypeArgs = $defaultPostTypeArgs;
  }
  foreach ($post_types as $type) {
    retina_create_posttype($type, $postTypeArgs);
  }
}

/**
 * Registra una tassonomia personalizzata e la associa a un tipo di post.
 *
 * @param string $taxonomy Nome della tassonomia.
 * @param string $type Tipo di post a cui associare la tassonomia.
 * @param boolean|string $label Etichetta personalizzata per la tassonomia.
 */
function retina_register_taxonomy($taxonomy, $type, $label = false) {
  $label = $label ?: sprintf('Categorie %s', $type);
  $args_tax = array(
    'label' => $label,
    'show_in_quick_edit' => true,
    'hierarchical' => true,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array('slug' => sprintf('lista-prodotti-%s', $taxonomy)),
  );

  $taxonomy = generate_taxonomy_name($taxonomy, $type);
  $args_tax = apply_filters('retina_custom_posttype_tax_args_filter', $args_tax, $taxonomy);

  if (!taxonomy_exists($taxonomy)) {
    register_taxonomy($taxonomy, $type, $args_tax);
  } else {
    register_taxonomy($taxonomy . "-2", $type, $args_tax);
  }
}

/**
 * Genera un nome per una tassonomia basato su un nome base e un tipo di post.
 *
 * @param string $baseName Nome base della tassonomia.
 * @param string|null $postType Tipo di post, se presente.
 * @return string Nome generato per la tassonomia.
 */
function generate_taxonomy_name($baseName, $postType = null) {
  return $postType ? $baseName . '-' . $postType : $baseName;
}

/**
 * Associa nuove tassonomie a un tipo di post esistente.
 *
 * @param array|string $taxonomies Tassonomie da associare.
 * @param string $post_type Tipo di post a cui associare le tassonomie.
 * @param boolean|string $customlabel Etichetta personalizzata per le tassonomie.
 */
function retina_add_taxonomies_to_posttype($taxonomies, $post_type, $customlabel = false) {
  if (!is_array($taxonomies)) {
    $taxonomies = explode(',', $taxonomies);
  }
  foreach ($taxonomies as $taxonomy) {
    retina_register_taxonomy($taxonomy, $post_type, $customlabel);
  }
}

/**
 * Associa una tassonomia esistente a un tipo di post esistente.
 *
 * @param string|null $sourceTax Tassonomia sorgente da associare.
 * @param string|null $targetPostType Tipo di post target per l'associazione.
 * @param string|null $sourcePostType Tipo di post sorgente per il nome modificato della tassonomia.
 */
function retina_assoc_taxonomies_to_posttype($sourceTax = null, $targetPostType = null, $sourcePostType = null) {
  if (empty($sourceTax) || empty($targetPostType)) {
    // Mostra un avviso di errore nell'admin se i parametri sono mancanti.
    return;
  }

  $modifiedTaxName = generate_taxonomy_name($sourceTax, $sourcePostType);

  if (!taxonomy_exists($modifiedTaxName) || !post_type_exists($targetPostType)) {
    // Mostra un avviso di errore nell'admin se la tassonomia o il tipo di post non esistono.
    return;
  }

  register_taxonomy_for_object_type($modifiedTaxName, $targetPostType);
}