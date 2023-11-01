<div class="mt-2 p-0">
    <a wire:key="item-{{ $id }}" wire:click="aceptarReporte({{ $id }})"
        class="{{$estilo1}}">
        <x-vistoBueno-tooltip>Aceptar</x-vistoBueno-tooltip>
    </a>
    {{-- <a wire:key="item-{{ $id }}" wire:click="aceptarAmediasReporte({{ $id }})"
        class="{{$estilo1}}">
        <x-vistoBuenoGris-tooltip>Pendiente</x-vistoBuenoGris-tooltip>
    </a> --}}
</div>
