# Documentazione dei Mixin SCSS - Griglie e Contenuti

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che facilitano la creazione di griglie e la gestione dei contenuti. I mixin descritti consentono di definire configurazioni di layout a griglia e di gestire la visualizzazione degli elementi in modo coerente e flessibile.

## Indice

1. [@mixin elenco-categorie()](#1-mixin-elenco-categorie)
2. [@mixin grid-articoli-salvattore()](#2-mixin-grid-articoli-salvattore)
3. [@mixin generate-random-content()](#3-mixin-generate-random-content)
4. [@mixin extend-atomic-gutemberg-container()](#4-mixin-extend-atomic-gutemberg-container)
5. [@mixin gutemberg-block-copertina-testo-maxheight()](#5-mixin-gutemberg-block-copertina-testo-maxheight)
6. [@mixin fix-gutemberg-block-columns-responsive()](#6-mixin-fix-gutemberg-block-columns-responsive)

## 1. `@mixin elenco-categorie()`

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

## 2. `@mixin grid-articoli-salvattore($gridselector, $columnselector)`

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

## 3. `@mixin generate-random-content($gridselector, $itemSelector, $itemsnumber, $subsnumber)`

**Descrizione:** Genera contenuto casuale per una griglia e i suoi elementi.

**Parametri:**

- `$gridselector` (default: `'.grid'`): Selettore della griglia.
- `$itemSelector` (default: `'.item'`): Selettore dell'elemento.
- `$itemsnumber` (default: `12`): Numero di elementi nella griglia.
- `$subsnumber` (default: `3`): Numero di sottosezioni per ogni elemento.

**Sintassi:**

```scss
@mixin generate-random-content($gridselector: '.grid', $itemSelector: '.item', $itemsnumber: 12, $subsnumber: 3) {
  $items: $itemsnumber;

  @while $items > 0 {
    #{$gridselector}#{$items} {
      $subs: $subsnumber;

      @while $subs > 0 {
        #{$itemSelector}#{$subs} {
          min-height: 50px;
        }

        $subs: $subs - 1;
      }
    }

    $items: $items - 1;
  }
}
```

## 4. `@mixin extend-atomic-gutemberg-container()`

**Descrizione:** Estende un container specifico di Gutemberg per migliorare la compatibilità con Atomic Blocks.

**Sintassi:**

```scss
@mixin extend-atomic-gutemberg-container() {
  @include extend-container2(".wp-block-atomic-blocks-ab-container", ".ab-container-inside");
}
```

## 5. `@mixin gutemberg-block-copertina-testo-maxheight()`

**Descrizione:** Imposta l'altezza massima per i blocchi di copertina di Gutemberg su diverse colonne.

**Sintassi:**

```scss
@mixin gutemberg-block-copertina-testo-maxheight() {
  @media screen and (max-width: $tablet) {
    &.has-2-columns {
      .wp-block-column {
        .wp-block-cover {
          min-height: 400px;
        }
      }

      &.even {
        .wp-block-column {
          .wp-block-cover {}

          order: 2;

          &:nth-child(2) {
            order: 1;
          }
        }
      }
    }
  }

  .wp-block-column {
    .wp-block-cover {
      min-height: 100%;
    }
  }
}
```

## 6. `@mixin fix-gutemberg-block-columns-responsive()`

**Descrizione:** Corregge il comportamento delle colonne di Gutemberg per garantire la responsività sui vari breakpoint.

**Sintassi:**

```scss
@mixin fix-gutemberg-block-columns-responsive() {
  // fix comportamento colonne in bootstrap
  @media (min-width: $mobile) {
    // resetto i breakpont di gutemberg
    .wp-block-column:not(:last-child) {
      margin-right: 0;
    }

    .wp-block-column {
      flex-basis: 100%;
      flex-grow: 0;
    }

    .wp-block-column:not(:first-child),
    .wp-block-column:nth-child(2n) {
      margin-left: 0;
    }
  }

  // imposto i breakpoint di bootstrap
  @media (min-width: $tablet) {
    .wp-block-column:not(:last-child) {
      margin-right: 32px;
    }

    .wp-block-column {
      flex-basis: 50%;
      flex-grow: 0;
    }

    .wp-block-column:not(:first-child),
    .wp-block-column:nth-child(2n) {
      margin-left: 32px;
    }
  }
}
```

