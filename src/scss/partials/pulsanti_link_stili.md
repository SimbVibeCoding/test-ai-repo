# Documentazione dei Mixin SCSS - Pulsanti e Link

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS utilizzati per gestire lo stile di pulsanti e link all'interno del sito. I mixin descritti consentono di creare pulsanti accattivanti e uniformi, nonché di gestire i link per azioni come call to action e navigazione.

## Indice

1. [@mixin style-button-calltoaction](#1-mixin-style-button-calltoaction)
2. [@mixin style-button_rounded](#2-mixin-style-button-rounded)
3. [@mixin style-button](#3-mixin-style-button)
4. [@mixin style-button-sticky](#4-mixin-style-button-sticky)
5. [@mixin style-link](#5-mixin-style-link)

## 1. `@mixin style-button-calltoaction`

**Descrizione:** Applica uno stile per i pulsanti di call to action.

**Parametri:**

- `$background-color`: Colore di sfondo del pulsante.
- `$text-color`: Colore del testo.
- `$padding`: Padding del pulsante.

**Sintassi:**

```scss
@mixin style-button-calltoaction($background-color, $text-color, $padding) {
  background-color: $background-color;
  color: $text-color;
  padding: $padding;
  border: none;
  text-transform: uppercase;
}
```

## 2. `@mixin style-button_rounded`

**Descrizione:** Definisce uno stile arrotondato per i pulsanti.

**Parametri:**

- `$border-radius`: Raggio dell'angolo del pulsante.
- `$background-color`: Colore di sfondo.
- `$text-color`: Colore del testo.

**Sintassi:**

```scss
@mixin style-button_rounded($border-radius, $background-color, $text-color) {
  border-radius: $border-radius;
  background-color: $background-color;
  color: $text-color;
}
```

## 3. `@mixin style-button`

**Descrizione:** Stile generale per pulsanti.

**Parametri:**

- `$background-color`: Colore di sfondo del pulsante.
- `$text-color`: Colore del testo.
- `$padding`: Padding del pulsante.

**Sintassi:**

```scss
@mixin style-button($background-color, $text-color, $padding) {
  background-color: $background-color;
  color: $text-color;
  padding: $padding;
  border: none;
}
```

## 4. `@mixin style-button-sticky`

**Descrizione:** Applica uno stile "sticky" per pulsanti che restano visibili durante lo scorrimento della pagina.

**Parametri:**

- `$position`: Posizione del pulsante (es. `fixed`).
- `$bottom`: Distanza dal fondo della finestra.
- `$background-color`: Colore di sfondo.

**Sintassi:**

```scss
@mixin style-button-sticky($position, $bottom, $background-color) {
  position: $position;
  bottom: $bottom;
  background-color: $background-color;
}
```

## 5. `@mixin style-link`

**Descrizione:** Stile per i link all'interno del sito.

**Parametri:**

- `$color`: Colore del link.
- `$hover-color`: Colore del link al passaggio del mouse.

**Sintassi:**

```scss
@mixin style-link($color, $hover-color) {
  color: $color;
  &:hover {
    color: $hover-color;
  }
}
```

Procederò ora a creare i documenti per l'ultima funzione individuata: Effetti e Interazioni.

