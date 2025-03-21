# Documentazione dei Mixin SCSS - Gestione degli Elementi

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che facilitano la gestione degli elementi tramite l'uso di pseudo-elementi, il reset del modello box, e altre operazioni comuni. Questi mixin sono utili per mantenere consistenza visiva e per ridurre la ripetizione del codice durante lo sviluppo.

## Indice

1. [@mixin pseudoelement_block_content()](#1-mixin-pseudoelement_block_content)
2. [@mixin before_block_icon()](#2-mixin-before_block_icon)
3. [@mixin after_block_icon()](#3-mixin-after_block_icon)
4. [@mixin reset_box_model()](#4-mixin-reset_box_model)

## 1. `@mixin pseudoelement_block_content($content, $display, $content-image)`

**Descrizione:** Gestisce il contenuto di un pseudo-elemento come `:before` o `:after`, consentendo di inserire immagini o testo.

**Parametri:**

- `$content` (default: `" "`): Contenuto dell'elemento.
- `$display` (default: `inline-block`): Tipo di display dell'elemento.
- `$content-image` (default: `false`): Flag per determinare se il contenuto è un'immagine.

**Sintassi:**

```scss
@mixin pseudoelement_block_content($content: " ", $display: inline-block, $content-image: false) {
  @if $content-image {
    content: url("#{$content}");
  }
  @else {
    content: $content;
  }
  width: auto;
  display: $display;
}
```

## 2. `@mixin before_block_icon($content-image, $content, $padding, $font-size, $clear)`

**Descrizione:** Aggiunge un'icona o un contenuto prima di un elemento utilizzando lo pseudo-elemento `:before`.

**Parametri:**

- `$content-image` (default: `false`): Flag per determinare se il contenuto è un'immagine.
- `$content` (default: `$var-icon-arrowleft`): Contenuto dell'icona o del testo.
- `$padding` (default: `10px`): Padding a destra dell'icona.
- `$font-size` (default: `$font-size-testo`): Dimensione del font dell'icona.
- `$clear` (default: `true`): Se `true`, rimuove il contenuto di `:after`.

**Sintassi:**

```scss
@mixin before_block_icon($content-image: false, $content: $var-icon-arrowleft, $padding: 10px, $font-size: $font-size-testo, $clear: true) {
  @if $clear {
    &:after {
      content: "";
    }
  }
  &:before {
    @include pseudoelement_block_content($content, $content-image: $content-image);
    font-family: $var-iconsfamily;
    font-size: $font-size;
    padding: 0 $padding 0 0;
  }
}
```

## 3. `@mixin after_block_icon($content-image, $content, $padding, $font-size, $clear)`

**Descrizione:** Aggiunge un'icona o un contenuto dopo un elemento utilizzando lo pseudo-elemento `:after`.

**Parametri:**

- `$content-image` (default: `false`): Flag per determinare se il contenuto è un'immagine.
- `$content` (default: `$var-icon-arrowright`): Contenuto dell'icona o del testo.
- `$padding` (default: `10px`): Padding a sinistra dell'icona.
- `$font-size` (default: `$font-size-testo`): Dimensione del font dell'icona.
- `$clear` (default: `true`): Se `true`, rimuove il contenuto di `:before`.

**Sintassi:**

```scss
@mixin after_block_icon($content-image: false, $content: $var-icon-arrowright, $padding: 10px, $font-size: $font-size-testo, $clear: true) {
  @if $clear == true {
    &:before {
      content: "";
    }
  }
  &:after {
    @include pseudoelement_block_content($content, $content-image: $content-image);
    font-family: $var-iconsfamily;
    font-size: $font-size;
    padding: 0 0 0 $padding;
  }
}
```

## 4. `@mixin reset_box_model()`

**Descrizione:** Reset di base del modello box per un elemento, rimuovendo padding, margini e bordi.

**Parametri:**

- Nessun parametro.

**Sintassi:**

```scss
@mixin reset_box_model() {
  padding: 0;
  margin: 0;
  border: none;
}
```

