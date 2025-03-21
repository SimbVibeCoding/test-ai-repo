# Documentazione Completa dei Mixin SCSS

## Descrizione Generale

Questa documentazione ha lo scopo di fornire una descrizione dettagliata delle funzionalità dei vari mixin SCSS utilizzati nel progetto, con particolare attenzione alla loro applicazione per facilitare il layout e la gestione degli elementi attraverso Flexbox.

[Vai all'Indice Generale](#indice) | [Vai all'Indice per Funzione](#indice-per-funzione)

Questa documentazione descrive le funzionalità e i parametri accettati dai vari mixin SCSS utilizzati nel progetto. Ogni mixin ha una specifica funzione per facilitare il layout e la gestione degli elementi attraverso Flexbox.



## Indice

1. [@mixin flex-wall-single-col()](#1-mixin-flex-wall-single-col)
2. [@mixin flex-wall()](#2-mixin-flex-wall)
3. [@mixin flex-items()](#3-mixin-flex-items)
4. [@mixin flex-default()](#4-mixin-flex-default)
5. [@mixin flex-columns()](#5-mixin-flex-columns)
6. [@mixin font-face()](#6-mixin-font-face)
7. [@mixin elenco-categorie()](#7-mixin-elenco-categorie)
8. [@mixin slickslider-arrow()](#8-mixin-slickslider-arrow)
9. [@mixin grid-articoli-salvattore()](#9-mixin-grid-articoli-salvattore)
10. [@mixin list-style()](#10-mixin-list-style)
11. [@mixin separatore()](#11-mixin-separatore)
12. [@mixin generate-random-content()](#12-mixin-generate-random-content)
13. [@mixin flex-fill-subitem()](#13-mixin-flex-fill-subitem)
14. [@mixin reset_box_model()](#14-mixin-reset_box_model)
15. [@mixin absolute_center()](#15-mixin-absolute_center)
16. [@mixin fill_container()](#16-mixin-fill_container)
17. [@mixin pseudoelement_block_content()](#17-mixin-pseudoelement_block_content)
18. [@mixin before_block_icon()](#18-mixin-before_block_icon)
19. [@mixin after_block_icon()](#19-mixin-after_block_icon)
20. [@mixin text-contrast()](#20-mixin-text-contrast)
21. [@mixin color_contrast()](#21-mixin-color_contrast)
22. [@mixin stile_header()](#22-mixin-stile_header)
23. [@mixin contact-box()](#23-mixin-contact-box)
24. [@mixin sfumatura()](#24-mixin-sfumatura)
25. [@mixin button()](#25-mixin-button)
26. [@mixin embed-responsive()](#26-mixin-embed-responsive)

## Indice per Funzione

### 1. Layout e Struttura Flessibile
- `@mixin flex-wall-single-col()`
- `@mixin flex-wall()`
- `@mixin flex-items()`
- `@mixin flex-default()`
- `@mixin flex-columns()`
- `@mixin flex-fill-subitem()`

### 2. Griglie e Contenuti
- `@mixin grid-articoli-salvattore()`
- `@mixin generate-random-content()`
- `@mixin elenco-categorie()`

### 3. Tipografia e Stile del Testo
- `@mixin font-face()`
- `@mixin stile_header()`
- `@mixin contact-box()`
- `@mixin list-style()`
- `@mixin text-contrast()`
- `@mixin color_contrast()`
- `@mixin separatore()`

### 4. Pulsanti e Navigazione
- `@mixin slickslider-arrow()`
- `@mixin button()`

### 5. Allineamento e Posizionamento
- `@mixin absolute_center()`
- `@mixin fill_container()`

### 6. Gestione degli Elementi (Pseudo-elementi, Box Model, Resettare Stili)
- `@mixin pseudoelement_block_content()`
- `@mixin before_block_icon()`
- `@mixin after_block_icon()`
- `@mixin reset_box_model()`

### 7. Altro
- `@mixin sfumatura()`
- `@mixin embed-responsive()`

**Descrizione:** Questo mixin utilizza il mixin `flex-wall` per creare una parete flessibile con una singola colonna. I parametri predefiniti definiscono il wrapping, la direzione della riga, l'allineamento all'inizio e la disposizione degli elementi.

**Sintassi:**
```scss
@mixin flex-wall-single-col() {
  @include flex-wall(wrap, row, flex-start, flex-start, flex-start);
}
```

**Parametri:**
- Nessun parametro esterno.

## 2. `@mixin flex-wall($flex-wrap, $flex-direction, $justify-content, $align-items, $align-content)`

**Descrizione:** Questo mixin crea un layout flessibile utilizzando Flexbox, consentendo di personalizzare il wrapping, la direzione degli elementi, l'allineamento orizzontale e verticale.

**Parametri:**
- `$flex-wrap` (default: `wrap`): Definisce come i contenitori flessibili si arrotolano. Può essere `wrap`, `nowrap`, ecc.
- `$flex-direction` (default: `row`): Definisce la direzione del layout (`row`, `column`, ecc.).
- `$justify-content` (default: `space-between`): Definisce l'allineamento degli elementi sulla linea principale (`flex-start`, `center`, `space-between`, ecc.).
- `$align-items` (default: `center`): Definisce l'allineamento degli elementi sulla linea trasversale (`flex-start`, `center`, ecc.).
- `$align-content` (default: `flex-start`): Definisce l'allineamento di più righe se c'è del wrapping (`flex-start`, `space-around`, ecc.).

## 3. `@mixin flex-items($itemSelector, $flex-grow, $flex-shrink, $flex-basis, $justify-content, $align-items, $align-self)`

**Descrizione:** Applica proprietà di flessibilità agli elementi selezionati.

**Parametri:**
- `$itemSelector` (default: `item`): Selettore dell'elemento per cui applicare le proprietà flex.
- `$flex-grow` (default: `0`): Specifica la crescita dell'elemento.
- `$flex-shrink` (default: `0`): Specifica la contrazione dell'elemento.
- `$flex-basis` (default: `auto`): Specifica la base flessibile.
- `$justify-content` (default: `space-between`): Definisce l'allineamento dei contenuti.
- `$align-items` (default: `center`): Allinea gli elementi al centro.
- `$align-self` (default: `null`): Se specificato, definisce l'allineamento dell'elemento.

## 4. `@mixin flex-default($justify-content, $align-items)`

**Descrizione:** Questo mixin crea una struttura flex di base con wrapping e una direzione di riga.

**Parametri:**
- `$justify-content` (default: `space-between`): Definisce l'allineamento degli elementi sulla linea principale.
- `$align-items` (default: `center`): Definisce l'allineamento degli elementi sulla linea trasversale.

**Nota:** Il mixin contiene un piccolo errore di sintassi (virgola superflua dopo `$align-items`).

## 5. `@mixin flex-columns($columns, $gap)`

**Descrizione:** Crea un layout flessibile che divide lo spazio in colonne uguali, con un determinato spazio tra gli elementi.

**Parametri:**
- `$columns` (default: `1`): Definisce il numero di colonne da creare.
- `$gap` (default: `1rem`): Definisce la distanza tra le colonne.

**Comportamento:** Gli elementi figli avranno una larghezza proporzionale in base al numero di colonne e il gap specificato.

## 6. `@mixin font-face($fontname, $filename)`

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
    font-size: $font-size-testo;
  }
}
```

## 7. `@mixin elenco-categorie()`

**Descrizione:** Crea un layout per l'elenco delle categorie con una struttura flex e stili per i titoli, le immagini e altri elementi.

**Sintassi:**
```scss
@mixin elenco-categorie() {
  width: 100%;
  max-width: $desktop;
  @include flex-default;
  margin: 0 auto 40px;

  .tax {
    flex: 1 1;
    margin: 0 10px;
    position: relative;

    h3.titolo {
      background-color: rgba($color-main2, 0.5);
      width: 100%;
      margin: 0;
      padding: 20px 0;
      color: $color-neutro4;
      text-align: center;

      &.absolute {
        position: absolute;
        bottom: 0;
      }

      &:hover {
        background-color: rgba($color-main1, 0.5);

        a {
          color: $color-neutro4;
        }
      }
    }

    .excerpt {
      display: none;
    }

    .img {
      padding: 0;
      margin: 0;

      img {
        width: 100%;
        display: block;
      }
    }
  }
}
```

## 8. `@mixin slickslider-arrow($size, $posleft, $posright, $background-color, $content-left, $content-right, $button-class)`

**Descrizione:** Crea stili per le frecce di navigazione di uno slider, personalizzando dimensioni, posizione, contenuto e colore.

**Parametri:**
- `$size` (default: `30px`): Dimensione delle frecce.
- `$posleft` (default: `0`): Posizione a sinistra.
- `$posright` (default: `0`): Posizione a destra.
- `$background-color` (default: `transparent`): Colore di sfondo delle frecce.
- `$content-left` (default: `$var-icon-arrowleft`): Contenuto per la freccia sinistra.
- `$content-right` (default: `$var-icon-arrowright`): Contenuto per la freccia destra.
- `$button-class` (default: `".slick-arrow"`): Classe del pulsante per le frecce.

## 9. `@mixin grid-articoli-salvattore($gridselector, $columnselector)`

**Descrizione:** Crea un layout a griglia utilizzando selettori personalizzati e classi per definire le dimensioni delle colonne.

**Parametri:**
- `$gridselector` (default: `'#grid'`): Selettore per la griglia.
- `$columnselector` (default: `'.column'`): Selettore per le colonne.

**Sintassi:**
```scss
@mixin grid-articoli-salvattore($gridselector: '#grid', $columnselector: '.column') {
  $map: (
    ".size-1of1": 100%,
    ".size-1of2": 50%,
    ".size-1of3": 33.333%,
    ".size-1of4": 25%,
    ".size-1of6": 16.666%,
  );

  #{$gridselector}[data-columns]::before {
    content: '6 .column.size-1of6';
  }

  #{$columnselector} {
    float: left;

    @each $class, $size in $map {
      &#{$class} {
        width: $size;
      }
    }

    article {
      @content;
    }
  }

  @media screen and (max-width: $mobile) {
    #{$gridselector}[data-columns]::before {
      content: '1 .column.size-1of1';
    }
  }

  @media screen and (min-width: $tablet) and (max-width: $desktop) {
    #{$gridselector}[data-columns]::before {
      content: '2 .column.size-1of2';
    }
  }

  @media screen and (min-width: $desktop) {
    #{$gridselector}[data-columns]::before {
      content: '4 .column.size-1of4';
    }
  }
}
```

## 10. `@mixin list-style($ontent, $color, $fontsize, $fontfamily)`

**Descrizione:** Definisce uno stile per una lista con un'icona personalizzata.

**Parametri:**
- `$ontent` (default: `$var-icon-arrowright`): Contenuto dell'icona.
- `$color` (default: `$color-main2`): Colore dell'icona.
- `$fontsize` (default: `10px`): Dimensione del font.
- `$fontfamily` (default: `$var-iconsfamily`): Famiglia del font.

## 11. `@mixin separatore($colorText, $colorLine, $fontSize, $fontFamily, $textTranform)`

**Descrizione:** Crea un elemento separatore con stili personalizzati per colore, dimensioni e trasformazione del testo.

**Parametri:**
- `$colorText` (default: `$color-main1`): Colore del testo.
- `$colorLine` (default: `$color-neutro3`): Colore della linea.
- `$fontSize` (default: `$titoli-secondari`): Dimensione del font.
- `$fontFamily` (default: `$font-family2`): Famiglia del font.
- `$textTranform` (default: `uppercase`): Trasformazione del testo.

**Sintassi:**
```scss
@mixin separatore($colorText: $color-main1, $colorLine: $color-neutro3, $fontSize: $titoli-secondari, $fontFamily: $font-family2, $textTranform: uppercase) {
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
  text-transform: $textTranform;
  font-size: $fontSize;
  font-family: $fontFamily;
  color: $colorText;
  white-space: nowrap;
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
    text-transform: $textTranform;
    font-size: $fontSize;
    font-family: $fontFamily;
    color: $colorText;
    white-space: nowrap;
    text-decoration: none;
    padding: 0 10px;
  }
}
```

## 12. `@mixin generate-random-content($gridselector, $itemSelector, $itemsnumber, $subsnumber)`

**Descrizione:** Genera contenuto casuale per una griglia e i suoi elementi.

**Parametri:**
- `$gridselector` (default: `'.grid'`): Selettore della griglia.
- `$itemSelector` (default: `'.item'`): Selettore dell'elemento.
- `$itemsnumber` (default: `12`): Numero di elementi nella griglia.
- `$subsnumber` (default: `3`): Numero di sottosezioni per ogni elemento