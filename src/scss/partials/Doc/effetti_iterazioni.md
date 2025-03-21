# Documentazione dei Mixin SCSS - Effetti e Interazioni

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS utilizzati per creare effetti visivi e interazioni all'interno del sito. I mixin descritti consentono di applicare stili dinamici, come l'effetto zoom sulle immagini, l'animazione dei pulsanti e la gestione del contenuto al passaggio del mouse.

## Indice

1. [@mixin style-testo-overlay](#1-mixin-style-testo-overlay)
2. [@mixin style-style-testo-overlay-realizzazioni](#2-mixin-style-style-testo-overlay-realizzazioni)
3. [@mixin style-label-hide-on-over](#3-mixin-style-label-hide-on-over)
4. [@mixin style-image-zoom-on-over](#4-mixin-style-image-zoom-on-over)
5. [@mixin style-menu-item](#5-mixin-style-menu-item)

## 1. `@mixin style-testo-overlay`

**Descrizione:** Applica uno stile di overlay al testo, utilizzato per sovrapporre il testo su immagini o altri contenuti.

**Parametri:**

- `$background-color`: Colore di sfondo dell'overlay.
- `$text-color`: Colore del testo.
- `$padding`: Padding dell'overlay.

**Sintassi:**

```scss
@mixin style-testo-overlay($background-color, $text-color, $padding) {
  background-color: $background-color;
  color: $text-color;
  padding: $padding;
}
```

## 2. `@mixin style-style-testo-overlay-realizzazioni`

**Descrizione:** Variante dell'overlay di testo, specifica per le sezioni di realizzazioni o portfolio.

**Parametri:**

- `$background-color`: Colore di sfondo dell'overlay.
- `$text-color`: Colore del testo.
- `$padding`: Padding dell'overlay.

**Sintassi:**

```scss
@mixin style-style-testo-overlay-realizzazioni($background-color, $text-color, $padding) {
  background-color: $background-color;
  color: $text-color;
  padding: $padding;
  text-transform: uppercase;
}
```

## 3. `@mixin style-label-hide-on-over`

**Descrizione:** Nasconde un'etichetta al passaggio del mouse.

**Parametri:**

- `$opacity`: Opacità dell'etichetta quando nascosta.

**Sintassi:**

```scss
@mixin style-label-hide-on-over($opacity) {
  &:hover {
    opacity: $opacity;
  }
}
```

## 4. `@mixin style-image-zoom-on-over`

**Descrizione:** Applica un effetto di zoom su un'immagine al passaggio del mouse.

**Parametri:**

- `$scale`: Fattore di scala per l'ingrandimento dell'immagine.
- `$transition`: Durata della transizione.

**Sintassi:**

```scss
@mixin style-image-zoom-on-over($scale, $transition) {
  transition: transform $transition;
  &:hover {
    transform: scale($scale);
  }
}
```

## 5. `@mixin style-menu-item`

**Descrizione:** Stile per gli elementi del menu di navigazione con effetto al passaggio del mouse.

**Parametri:**

- `$hover-color`: Colore del testo al passaggio del mouse.
- `$padding`: Padding per gli elementi del menu.

**Sintassi:**

```scss
@mixin style-menu-item($hover-color, $padding) {
  padding: $padding;
  &:hover {
    color: $hover-color;
  }
}
```

Questa è la documentazione per i mixin dedicati agli effetti visivi e alle interazioni. Fammi sapere se desideri ulteriori modifiche o aggiustamenti per migliorare l'organizzazione e la chiarezza dei documenti.

