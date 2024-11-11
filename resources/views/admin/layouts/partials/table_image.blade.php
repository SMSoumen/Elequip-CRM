@php
    $media = $data?->getFirstMedia($collection);
@endphp

<div class="">
    <img srcset="{{ $media?->getSrcset($conversion) }}" src="{{ $media?->getUrl($conversion) }}"
        alt={{$media?->getCustomProperty('alt')}} class="img-fluid" style="max-width: 80px;">
</div>
