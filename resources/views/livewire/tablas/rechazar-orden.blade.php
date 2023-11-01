<div class="mb-4 relative -pt-2">
    <a wire:key="item-{{ $id }}" href="{{ route('ActionRechazadosAceptadosRevisor', ['id' => $id]) }}"
        class="{{$estilo1}}">
        <x-lapiz-tooltip>Corregir</x-lapiz-tooltip>
    </a>
</div>