
# Documentazione Mixin SCSS

Questo file contiene la documentazione per i mixin SCSS, formattata per una facile navigazione. Puoi cliccare sui nomi dei mixin nell'indice per saltare direttamente ai dettagli specifici di ciascun mixin.

## Indice
- [Mixin: fill_container](#mixin-fill_container)
- [Mixin: pseudoelement_block_content](#mixin-pseudoelement_block_content)
- [Mixin: before_block_icon](#mixin-before_block_icon)
- [Mixin: after_block_icon](#mixin-after_block_icon)

## Mixin: fill_container

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

### Descrizione:
Questo mixin imposta l'elemento affinché riempia completamente il suo contenitore, applicando il posizionamento assoluto ai valori `top`, `left`, `right` e `bottom`. Inoltre, puoi controllare l'opacità dell'elemento passando un parametro. L'opacità predefinita è impostata a 1.

### Parametri:
- `$opacity`: (Opzionale) Un valore numerico che controlla l'opacità del contenitore. Il valore predefinito è `1`.

### Esempio di utilizzo:

```scss
.container {
  @include fill_container(0.5);
}
```

## Mixin: pseudoelement_block_content

```scss
@mixin pseudoelement_block_content($content: " ", $display: inline-block) {
  content: $content;
  width: auto;
  display: $display;
}
```

### Descrizione:
Questo mixin viene utilizzato per generare contenuto per i pseudo-elementi, come `::before` e `::after`. Puoi specificare il contenuto e il tipo di display del pseudo-elemento.

### Parametri:
- `$content`: (Opzionale) Il contenuto del pseudo-elemento. Predefinito è uno spazio vuoto `" "`.
- `$display`: (Opzionale) Definisce il tipo di display. Predefinito è `inline-block`.

### Esempio di utilizzo:

```scss
.element:before {
  @include pseudoelement_block_content("→");
}
```

## Mixin: before_block_icon

```scss
@mixin before_block_icon($content: $var-icon-arrowleft, $padding: 10px, $font-size: $font-size-testo, $clear: true) {
  @if $clear ==true {
    &:after {
      content: "";
    }
  }

  &:before {
    @include pseudoelement_block_content($content);
    font-family: $var-iconsfamily;
    content: $content;
    font-size: $font-size;
    padding: 0 $padding 0 0;
  }
}
```

### Descrizione:
Questo mixin crea un'icona prima dell'elemento principale, utilizzando il pseudo-elemento `::before`. È possibile specificare il contenuto dell'icona, la dimensione del font e la quantità di padding.

### Parametri:
- `$content`: (Opzionale) Il contenuto dell'icona. Il valore predefinito è `$var-icon-arrowleft`.
- `$padding`: (Opzionale) La quantità di padding. Il valore predefinito è `10px`.
- `$font-size`: (Opzionale) La dimensione del font. Il valore predefinito è `$font-size-testo`.
- `$clear`: (Opzionale) Se `true`, aggiunge un contenuto vuoto all'elemento `::after`. Predefinito è `true`.

### Esempio di utilizzo:

```scss
.button {
  @include before_block_icon($var-icon-home);
}
```

## Mixin: after_block_icon

```scss
@mixin after_block_icon($content: $var-icon-arrowright, $padding: 10px, $font-size: $font-size-testo, $clear: true) {
  @if $clear ==true {
    &:before {
      content: "";
    }
  }

  &:after {
    @include pseudoelement_block_content($content);
    font-family: $var-iconsfamily;
    font-size: $font-size;
    padding: 0 0 0 $padding;
  }
}
```

### Descrizione:
Questo mixin crea un'icona dopo l'elemento principale, utilizzando il pseudo-elemento `::after`. È possibile specificare il contenuto dell'icona, la dimensione del font e la quantità di padding.

### Parametri:
- `$content`: (Opzionale) Il contenuto dell'icona. Il valore predefinito è `$var-icon-arrowright`.
- `$padding`: (Opzionale) La quantità di padding. Il valore predefinito è `10px`.
- `$font-size`: (Opzionale) La dimensione del font. Il valore predefinito è `$font-size-testo`.
- `$clear`: (Opzionale) Se `true`, aggiunge un contenuto vuoto all'elemento `::before`. Predefinito è `true`.

### Esempio di utilizzo:

```scss
.button {
  @include after_block_icon($var-icon-user);
}
```
