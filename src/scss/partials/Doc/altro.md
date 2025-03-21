# Documentazione dei Mixin SCSS - Altro

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che non rientrano nelle altre categorie specifiche. Questi mixin includono stili generali, sfumature di colore e altre funzionalità che possono essere utilizzate per migliorare l'aspetto visivo del progetto.

## Indice

1. [@mixin sfumatura()](#1-mixin-sfumatura)
2. [@mixin embed-responsive()](#2-mixin-embed-responsive)
3. [@mixin image-background()](#3-mixin-image-background)

## 1. `@mixin sfumatura($color1, $color2)`

**Descrizione:** Crea una sfumatura di colore lineare tra due colori.

**Parametri:**

- `$color1` (default: `$color-main1`): Colore iniziale della sfumatura.
- `$color2` (default: `$color-main2`): Colore finale della sfumatura.

**Sintassi:**

```scss
@mixin sfumatura($color1: $color-main1, $color2: $color-main2) {
  background-color: $color1;
  background-image: linear-gradient(to bottom, $color1, $color2);
}
```

## 2. `@mixin embed-responsive($container)`

**Descrizione:** Crea un contenitore responsivo per contenuti embeddati come video o iframe.

**Parametri:**

- `$container` (default: `'.wp-block-embed__wrapper'`): Selettore del contenitore per il contenuto embeddato.

**Sintassi:**

```scss
@mixin embed-responsive($container: '.wp-block-embed__wrapper') {
  #{$container} {
    position: relative;
    padding-bottom: 56.25%;
    overflow: hidden;
    max-width: 100%;
    height: auto;
  }

  #{$container} embed,
  #{$container} iframe,
  #{$container} object {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
}
```

## 3. `@mixin image-background($min-height, $background-position, $background-size, $background-repeat)`

**Descrizione:** Definisce uno sfondo per un'immagine con una serie di proprietà personalizzabili.

**Parametri:**

- `$min-height` (default: `25vh`): Altezza minima dell'immagine di sfondo.
- `$background-position` (default: `center center`): Posizione dell'immagine di sfondo.
- `$background-size` (default: `cover`): Dimensione dell'immagine di sfondo.
- `$background-repeat` (default: `no-repeat`): Ripetizione dell'immagine di sfondo.

**Sintassi:**

```scss
@mixin image-background($min-height: 25vh, $background-position: center center, $background-size: cover, $background-repeat: no-repeat) {
  min-height: $min-height;
  background-repeat: $background-repeat;
  background-position: $background-position;
  background-size: $background-size;
}
```

