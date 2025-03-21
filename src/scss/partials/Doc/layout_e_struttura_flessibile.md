# Documentazione dei Mixin SCSS - Layout e Struttura Flessibile

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che facilitano la gestione del layout e della struttura flessibile degli elementi. I mixin descritti consentono di creare layout responsive e di strutturare gli elementi in modo efficiente utilizzando Flexbox e altre tecniche.

## Indice

1. [@mixin flex-wall-single-col()](#1-mixin-flex-wall-single-col)
2. [@mixin flex-wall()](#2-mixin-flex-wall)
3. [@mixin flex-items()](#3-mixin-flex-items)
4. [@mixin flex-default()](#4-mixin-flex-default)
5. [@mixin flex-columns()](#5-mixin-flex-columns)
6. [@mixin flex-fill-subitem()](#6-mixin-flex-fill-subitem)
7. [@mixin respond-to()](#7-mixin-respond-to)
8. [@mixin make-container-max-widths()](#8-mixin-make-container-max-widths)
9. [@mixin extend-all()](#9-mixin-extend-all)
10. [@mixin bootstrap-media-breakpoint-up()](#10-mixin-bootstrap-media-breakpoint-up)
11. [@mixin bootstrap-make-row()](#11-mixin-bootstrap-make-row)
12. [@mixin media-breakpoint-up-map-class()](#12-mixin-media-breakpoint-up-map-class)
13. [@mixin media-breakpoint-up-unique-class()](#13-mixin-media-breakpoint-up-unique-class)
14. [@mixin make-bootstrap-col-structure-responsive()](#14-mixin-make-bootstrap-col-structure-responsive)
15. [@mixin make-bootstrap-col-structure()](#15-mixin-make-bootstrap-col-structure)

## 1. `@mixin flex-wall-single-col()`

**Descrizione:** Crea una singola colonna utilizzando Flexbox per organizzare il contenuto.

**Sintassi:**

```scss
@mixin flex-wall-single-col() {
  @include flex-wall(wrap, row, flex-start, flex-start, flex-start);
}
```

## 2. `@mixin flex-wall($flex-wrap, $flex-direction, $justify-content, $align-items, $align-content)`

**Descrizione:** Crea un layout flessibile utilizzando Flexbox con parametri personalizzabili.

**Parametri:**

- `$flex-wrap`: Comportamento del wrap degli elementi.
- `$flex-direction`: Direzione del layout.
- `$justify-content`: Allineamento degli elementi lungo l'asse principale.
- `$align-items`: Allineamento degli elementi lungo l'asse trasversale.
- `$align-content`: Allineamento del contenuto quando sono presenti più righe.

**Sintassi:**

```scss
@mixin flex-wall($flex-wrap: wrap, $flex-direction: row, $justify-content: space-between, $align-items: center, $align-content: flex-start) {
  display: flex;
  flex-direction: $flex-direction;
  flex-wrap: $flex-wrap;
  justify-content: $justify-content;
  align-items: $align-items;
  align-content: $align-content;
}
```

## 3. `@mixin flex-items($itemSelector, $flex-grow, $flex-shrink, $flex-basis, $justify-content, $align-items, $align-self)`

**Descrizione:** Stile per singoli elementi all'interno di un contenitore Flexbox.

**Parametri:**

- `$itemSelector`: Selettore dell'elemento.
- `$flex-grow`: Fattore di crescita dell'elemento.
- `$flex-shrink`: Fattore di riduzione dell'elemento.
- `$flex-basis`: Base flessibile dell'elemento.
- `$justify-content`: Allineamento del contenuto dell'elemento.
- `$align-items`: Allineamento degli elementi.
- `$align-self`: Allineamento dell'elemento specifico.

**Sintassi:**

```scss
@mixin flex-items($itemSelector: item, $flex-grow: 0, $flex-shrink: 0, $flex-basis: auto, $justify-content: space-between, $align-items: center, $align-self: null) {
  .#{$itemSelector} {
    flex: $flex-grow $flex-shrink $flex-basis;

    @if($align-self) {
      align-self: $align-self;
    }
  }
}
```

## 4. `@mixin flex-default($justify-content, $align-items)`

**Descrizione:** Crea un layout flessibile con valori predefiniti per giustificare e allineare gli elementi.

**Parametri:**

- `$justify-content`: Allineamento degli elementi lungo l'asse principale.
- `$align-items`: Allineamento degli elementi lungo l'asse trasversale.

**Sintassi:**

```scss
@mixin flex-default($justify-content: space-between, $align-items: center) {
  display: flex;
  flex-flow: row wrap;
  justify-content: $justify-content;
  align-items: $align-items;
}
```

## 5. `@mixin flex-columns($columns, $gap)`

**Descrizione:** Crea un layout a colonne utilizzando Flexbox con un numero specificato di colonne e uno spazio tra le colonne.

**Parametri:**

- `$columns`: Numero di colonne.
- `$gap`: Spaziatura tra le colonne.

**Sintassi:**

```scss
@mixin flex-columns($columns: 1, $gap: 1rem) {
  display: flex;
  flex-wrap: wrap;
  gap: $gap;

  & > * {
    flex: 1 1 calc(100% / $columns - #{$gap});
    max-width: calc(100% / $columns - #{$gap});
  }
}
```

## 6. `@mixin flex-fill-subitem($gridselector, $itemSelector)`

**Descrizione:** Crea un layout flessibile per sub-elementi all'interno di una griglia specificata.

**Parametri:**

- `$gridselector`: Selettore della griglia.
- `$itemSelector`: Selettore dell'elemento.

**Sintassi:**

```scss
@mixin flex-fill-subitem($gridselector: '.grid', $itemSelector: '.item') {
  #{$gridselector} {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    align-items: stretch;
    @include flex-items(item, 1, 0);

    #{$itemSelector} {
      @include flex-items(sub, 0, 0, 100%);
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      align-items: stretch;
      min-width: 200px;
    }
  }
}
```

## 7. `@mixin respond-to($breakpoint)`

**Descrizione:** Definisce un punto di interruzione (`breakpoint`) per la responsività.

**Parametri:**

- `$breakpoint`: Punto di interruzione.

**Sintassi:**

```scss
@mixin respond-to($breakpoint) {
  @if map-has-key($grid-breakpoints, $breakpoint) {
    @media (min-width: #{map-get($grid-breakpoints, $breakpoint)}) {
      @content;
    }
  } @else {
    @warn "Unfortunately, no value could be retrieved from `#{$breakpoint}`. Please make sure it is defined in `$breakpoints` map.";
  }
}
```

## 8. `@mixin make-container-max-widths($max-widths, $breakpoints)`

**Descrizione:** Definisce le larghezze massime per i contenitori per ciascun breakpoint.

**Parametri:**

- `$max-widths`: Mappa delle larghezze massime da applicare.
- `$breakpoints`: Mappa dei punti di interruzione da usare.

**Sintassi:**

```scss
@mixin make-container-max-widths($max-widths: $container-max-widths, $breakpoints: $grid-breakpoints) {
  @each $breakpoint, $container-max-width in $max-widths {
    @include media-breakpoint-up($breakpoint, $breakpoints) {
      max-width: $container-max-width;
    }
  }
}
```

## 9. `@mixin extend-all($container)`

**Descrizione:** Estende un container su tutto lo schermo, applicando margini negativi per centrarsi.

**Parametri:**

- `$container`: Contenitore da estendere.

**Sintassi:**

```scss
@mixin extend-all($container) {
  @if #{$container} {
    @media screen and (min-width: $bootstrap-grid-breakpoint-xl) {
      margin-left: calc(-100vw / 2 + #{map-get($container-max-widths, "xl") - $grid-gutter-width / 2} / 2);
      margin-right: calc(-100vw / 2 + #{map-get($container-max-widths, "xl") - $grid-gutter-width / 2} / 2);
    }
  }
}
```

## 10. `@mixin bootstrap-media-breakpoint-up()`

**Descrizione:** Utilizza i breakpoint di Bootstrap per applicare media query.

**Sintassi:**

```scss
@mixin bootstrap-media-breakpoint-up() {
  @include media-breakpoint-up($breakpoint, $breakpoints) {}
}
```

## 11. `@mixin bootstrap-make-row()`

**Descrizione:** Crea una riga Bootstrap utilizzando il mixin `make-row`.

**Sintassi:**

```scss
@mixin bootstrap-make-row {
  @include make-row;
}
```

## 12. `@mixin media-breakpoint-up-map-class($colSelectormap, $colSelectorSizesMap)`

**Descrizione:** Applica classi uniche ai breakpoint specifici per selettori mappati.

**Parametri:**

- `$colSelectormap`: Mappa dei selettori di colonne.
- `$colSelectorSizesMap`: Mappa delle dimensioni delle colonne.

**Sintassi:**

```scss
@mixin media-breakpoint-up-map-class($colSelectormap, $colSelectorSizesMap) {
  @each $selector, $colsnumberListMap in $colSelectormap {
    @include media-breakpoint-up-unique-class($selector, $colsnumberListMap);
  }
}
```

## 13. `@mixin media-breakpoint-up-unique-class($colSelector, $colSelectorSizesMap)`

**Descrizione:** Applica classi uniche a un selettore specifico in base alle dimensioni definite.

**Parametri:**

- `$colSelector`: Selettore della colonna.
- `$colSelectorSizesMap`: Mappa delle dimensioni delle colonne.

**Sintassi:**

```scss
@mixin media-breakpoint

