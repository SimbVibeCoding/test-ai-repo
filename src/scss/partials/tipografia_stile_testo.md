# Documentazione dei Mixin SCSS - Tipografia e Stile del Testo

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che facilitano la gestione della tipografia e lo stile del testo. I mixin descritti consentono di definire font, stili di titoli, estratti e altri elementi testuali per migliorare la coerenza e la leggibilità del progetto.

## Indice

1. [@mixin font-face()](#1-mixin-font-face)
2. [@mixin stile-header()](#2-mixin-stile-header)
3. [@mixin contact-box()](#3-mixin-contact-box)
4. [@mixin list-style()](#4-mixin-list-style)
5. [@mixin text-contrast()](#5-mixin-text-contrast)
6. [@mixin color-contrast()](#6-mixin-color-contrast)
7. [@mixin separatore()](#7-mixin-separatore)
8. [@mixin stile-titoli()](#8-mixin-stile-titoli)
9. [@mixin stile-date()](#9-mixin-stile-date)
10. [@mixin stile-excerpt()](#10-mixin-stile-excerpt)

## 1. `@mixin font-face($fontname, $filename)`

**Descrizione:** Definisce una regola `@font-face` per l'inclusione di font personalizzati.

**Parametri:**

- `$fontname`: Nome del font.
- `$filename`: Nome del file del font (senza estensione).

**Sintassi:**

```scss
@mixin font-face($fontname, $filename) {
  @font-face {
    font-family: $fontname;
    src: url("fonts/#{$filename}.eot");
    src: url("fonts/#{$filename}.woff2") format('woff2'),
         url("fonts/#{$filename}.woff") format('woff'),
         url("fonts/#{$filename}.eot?#iefix") format('embedded-opentype'),
         url("fonts/#{$filename}.ttf") format('truetype'),
         url("fonts/#{$filename}.svg##{$fontname}") format('svg');
    font-weight: normal;
    font-style: normal;
  }
}
```

## 2. `@mixin stile-header($size, $font-family, $color, $weight)`

**Descrizione:** Definisce gli stili per i titoli.

**Parametri:**

- `$size`: Dimensione del font del titolo.
- `$font-family`: Famiglia del font del titolo.
- `$color`: Colore del titolo.
- `$weight`: Peso del carattere del titolo.

**Sintassi:**

```scss
@mixin stile-header($size, $font-family: $font-family1, $color: $nero, $weight: 400) {
  font-family: $font-family;
  font-size: $size;
  font-weight: $weight;
  color: $color;
}
```

## 3. `@mixin contact-box($size, $font-family, $color, $weight)`

**Descrizione:** Definisce gli stili per una casella di contatto.

**Parametri:**

- `$size`: Dimensione del font.
- `$font-family`: Famiglia del font.
- `$color`: Colore del testo.
- `$weight`: Peso del carattere.

**Sintassi:**

```scss
@mixin contact-box($size, $font-family: $font-family1, $color: $color-main1, $weight: 400) {
  font-family: $font-family;
  font-size: $size;
  font-weight: $weight;
  color: $color;
}
```

## 4. `@mixin list-style($content, $color, $fontsize, $fontfamily)`

**Descrizione:** Definisce uno stile per una lista con un'icona personalizzata.

**Parametri:**

- `$content` (default: `$var-icon-arrowright`): Contenuto dell'icona.
- `$color` (default: `$color-main2`): Colore dell'icona.
- `$fontsize` (default: `10px`): Dimensione del font.
- `$fontfamily` (default: `$var-iconsfamily`): Famiglia del font.

**Sintassi:**

```scss
@mixin list-style($content: $var-icon-arrowright, $color: $color-main2, $fontsize: 10px, $fontfamily: $var-iconsfamily) {
  &:before {
    display: inline-block;
    font-family: $fontfamily;
    font-size: $fontsize;
    content: $content;
    color: $color;
    padding: 0 10px;
  }
}
```

## 5. `@mixin text-contrast($n)`

**Descrizione:** Calcola il contrasto del testo rispetto al colore di sfondo per garantire una buona leggibilità.

**Parametri:**

- `$n`: Colore di sfondo.

**Sintassi:**

```scss
@mixin text-contrast($n) {
  $color-brightness: round((red($n) * 299) + (green($n) * 587) + (blue($n) * 114) / 1000);
  $light-color: round((red(#ffffff) * 299) + (green(#ffffff) * 587) + (blue(#ffffff) * 114) / 1000);

  @if abs($color-brightness) < ($light-color / 2) {
    color: white;
  } @else {
    color: black;
  }
}
```

## 6. `@mixin color-contrast($value)`

**Descrizione:** Imposta il colore di sfondo e il contrasto del testo per garantire la leggibilità.

**Parametri:**

- `$value`: Colore di sfondo.

**Sintassi:**

```scss
@mixin color-contrast($value) {
  background-color: $value;
  @include text-contrast($value);
  content: "" + $value;
}
```

## 7. `@mixin separatore($colorText, $colorLine, $fontSize, $fontFamily, $textTransform)`

**Descrizione:** Crea un elemento separatore con stili personalizzati per colore, dimensioni e trasformazione del testo.

**Parametri:**

- `$colorText` (default: `$color-main1`): Colore del testo.
- `$colorLine` (default: `$color-neutro3`): Colore della linea.
- `$fontSize` (default: `$titoli-secondari`): Dimensione del font.
- `$fontFamily` (default: `$font-family2`): Famiglia del font.
- `$textTransform` (default: `uppercase`): Trasformazione del testo.

**Sintassi:**

```scss
@mixin separatore($colorText: $color-main1, $colorLine: $color-neutro3, $fontSize: $titoli-secondari, $fontFamily: $font-family2, $textTransform: uppercase) {
  display: flex;
  flex-wrap: nowrap;
  justify-content: space-between;
  text-align: center;
  align-items: center;
  position: relative;
  color: $colorText;
  margin-top: 20px;
  width: 100%;
  white-space: nowrap;
  text-transform: $textTransform;
  font-size: $fontSize;
  font-family: $fontFamily;
  color: $colorText;
  text-decoration: none;
  padding: 0 10px;

  &:after,
  &:before {
    z-index: 0;
    display: block;
    content: "";
    width: 50%;
    top: 50%;
    height: 1px;
    background: $colorLine;
  }

  &.even {
    color: $colorText;
    padding-bottom: 40px;

    &:after,
    &:before {
      background-color: $colorLine;
    }

    a {
      color: $colorText;
    }
  }

  &:before {
    left: 0;
  }

  &:after {
    right: 0;
  }

  a {
    text-transform: $textTransform;
    font-size: $fontSize;
    font-family: $fontFamily;
    color: $colorText;
    text-decoration: none;
    padding: 0 10px;
  }
}
```

## 8. `@mixin stile-titoli($font-size)`

**Descrizione:** Definisce gli stili per i titoli con una dimensione personalizzata.

**Parametri:**

- `$font-size`: Dimensione del font del titolo.

**Sintassi:**

```scss
@mixin stile-titoli($font-size: $titoli-secondari) {
  font-size: $font-size;
  font-family: $font-family2;
  color: $color-neutro1;
}
```

## 9. `@mixin stile-date($font-size)`

**Descrizione:** Definisce gli stili per le date.

**Parametri:**

- `$font-size`: Dimensione del font delle date.

**Sintassi:**

```scss
@mixin stile-date($font-size: $font-size-testo) {
  font-size: $font-size;
  font-family: $font-family1;
  color: $color-neutro3;
}
```

## 10. `@mixin stile-excerpt($font-size)`

**Descrizione:** Definisce gli stili per gli estratti di testo.

**Parametri:**

- `$font-size`: Dimensione del font dell'estratto.

**Sintassi:**

```scss
@mixin stile-excerpt($font-size: $font-size-testo) {
  font-size: $font-size;
  font-family: $font-family1;
  color: $color-neutro1;
}
```

