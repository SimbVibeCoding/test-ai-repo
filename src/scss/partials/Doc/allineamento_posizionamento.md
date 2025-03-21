# Documentazione dei Mixin SCSS - Allineamento e Posizionamento

## Descrizione Generale

Questa sezione della documentazione descrive i mixin SCSS che facilitano l'allineamento e il posizionamento degli elementi. I mixin descritti consentono di posizionare elementi in modo assoluto o di riempire il contenitore, migliorando la flessibilità del layout e la coerenza del design.

## Indice

1. [@mixin absolute_center()](#1-mixin-absolute_center)
2. [@mixin fill_container()](#2-mixin-fill_container)

## 1. `@mixin absolute_center($top, $left, $translateTop, $translateLeft)`

**Descrizione:** Posiziona un elemento al centro del contenitore utilizzando la posizione assoluta e la trasformazione di traduzione.

**Parametri:**

- `$top` (default: `50%`): Valore della proprietà `top` per centrare verticalmente l'elemento.
- `$left` (default: `50%`): Valore della proprietà `left` per centrare orizzontalmente l'elemento.
- `$translateTop` (default: `-50%`): Valore di traduzione verticale per l'allineamento perfetto.
- `$translateLeft` (default: `-50%`): Valore di traduzione orizzontale per l'allineamento perfetto.

**Sintassi:**

```scss
@mixin absolute_center($top: 50%, $left: 50%, $translateTop: -50%, $translateLeft: -50%) {
  position: absolute;
  top: $top;
  left: $left;
  transform: translate($translateLeft, $translateTop);
}
```

## 2. `@mixin fill_container($opacity)`

**Descrizione:** Fa sì che un elemento riempia completamente il suo contenitore, utile per creare overlay o sfondi.

**Parametri:**

- `$opacity` (default: `1`): Opacità dell'elemento.

**Sintassi:**

```scss
@mixin fill_container($opacity: 1) {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  opacity: $opacity;
  display: block;
}
```

