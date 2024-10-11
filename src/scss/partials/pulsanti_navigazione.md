# Documentazione dei Mixin SCSS - Pulsanti e Navigazione

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che facilitano la creazione di pulsanti e componenti di navigazione. I mixin descritti consentono di definire stili per pulsanti, frecce di navigazione e altre interazioni utente, migliorando l'usabilità e l'aspetto estetico del progetto.

## Indice

1. [@mixin slickslider-arrow()](#1-mixin-slickslider-arrow)
2. [@mixin button()](#2-mixin-button)
3. [@mixin style-form()](#3-mixin-style-form)

## 1. `@mixin slickslider-arrow($size, $posleft, $posright, $background-color, $content-left, $content-right, $button-class)`

**Descrizione:** Crea stili per le frecce di navigazione di uno slider, personalizzando dimensioni, posizione, contenuto e colore.

**Parametri:**

- `$size` (default: `30px`): Dimensione delle frecce.
- `$posleft` (default: `0`): Posizione a sinistra.
- `$posright` (default: `0`): Posizione a destra.
- `$background-color` (default: `transparent`): Colore di sfondo delle frecce.
- `$content-left` (default: `$var-icon-arrowleft`): Contenuto per la freccia sinistra.
- `$content-right` (default: `$var-icon-arrowright`): Contenuto per la freccia destra.
- `$button-class` (default: `".slick-arrow"`): Classe del pulsante per le frecce.

**Sintassi:**

```scss
@mixin slickslider-arrow($size: 30px, $posleft: 0, $posright: 0, $background-color: transparent, $content-left: $var-icon-arrowleft, $content-right: $var-icon-arrowright, $button-class: ".slick-arrow") {
  #{$button-class} {
    z-index: 1000;

    &:before {
      color: $color-main2;
      font-family: $var-iconsfamily;
      background-color: $background-color;
      width: $size;
      line-height: $size;
      padding: 0;
      margin: 0;
      display: block;
    }

    &.slick-next {
      right: $posright;

      &:before {
        content: $content-right;
      }
    }

    &.slick-prev {
      left: $posleft;

      &:before {
        content: $content-left;
      }
    }
  }
}
```

## 2. `@mixin button($bgcolor, $color, $padding-button)`

**Descrizione:** Definisce gli stili di base per un pulsante, inclusi il colore di sfondo, il colore del testo e la spaziatura interna.

**Parametri:**

- `$bgcolor` (default: `$color-main1`): Colore di sfondo del pulsante.
- `$color` (default: `$color-neutro1`): Colore del testo del pulsante.
- `$padding-button` (default: `20px`): Spaziatura interna del pulsante.

**Sintassi:**

```scss
@mixin button($bgcolor: $color-main1, $color: $color-neutro1, $padding-button: 20px) {
  background-color: $bgcolor;
  padding: $padding-button;
  color: $color;
  border-radius: 0;
  border-color: transparent;
  border: none;
}
```

## 3. `@mixin style-form($color, $font-family, $inputBackground, $submitBackground, $submitColor, $submitBackgroundHover)`

**Descrizione:** Definisce gli stili per un form, inclusi i campi input e il pulsante submit.

**Parametri:**

- `$color`: Colore delle etichette.
- `$font-family`: Famiglia del font per le etichette.
- `$inputBackground`: Colore di sfondo per i campi input.
- `$submitBackground`: Colore di sfondo per il pulsante submit.
- `$submitColor`: Colore del testo del pulsante submit.
- `$submitBackgroundHover`: Colore di sfondo del pulsante submit al passaggio del mouse.

**Sintassi:**

```scss
@mixin style-form($color: $color-neutro2, $font-family: $font-family2, $inputBackground: $color-neutro3-chiaro, $submitBackground: $color-main1, $submitColor: $color-neutro4, $submitBackgroundHover: $color-main2) {
  label {
    color: $color;
    font-family: $font-family;
    width: 100%;
  }

  input {
    width: 100%;
    border: 1px solid $color-neutro3;
    background: $inputBackground;
    padding: 10px;

    &[type="submit"] {
      background: $submitBackground;
      padding: 20px;
      color: $submitColor;

      &:hover {
        background: $submitBackgroundHover;
      }
    }
  }
}
```

