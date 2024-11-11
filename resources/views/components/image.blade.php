@php
    $media = $model?->getFirstMedia($collection);
    $alt = $media?->getCustomProperty('alt');
@endphp
<img srcset="{{ $media?->getSrcset($conversion) }}" src="{{ $media?->getUrl($conversion) }}" alt="{{ $alt }}"
    class="img-fluid {{$class}}">
