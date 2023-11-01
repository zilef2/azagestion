@php
    $estilo1 = 'basis-1/2 text-blue-600 h-10 rounded cursor-pointer center -pt-5';
@endphp
<div class="flex flex-row h-12 space-x-4 justify-around -pt-5">
    @if ($tabla === 'cambiarAsignacion')
        {{-- @if (Auth::user()->is_admin >= 4) --}}
        <a href="{{ route('ActionEditarAsignacion', ['id' => $id]) }}"
            class="{{$estilo1}}">
            <x-lapiz-tooltip>Editar</x-lapiz-tooltip>
        </a>
        {{-- @endif --}}
    @endif
    @if ($tabla === 'ActionRechazadosAsesor')
        <a href="{{ route('ActionRechazadosAsesor', ['id' => $id]) }}"
            class="{{$estilo1}}">
            <x-lapiz-tooltip>Editar</x-lapiz-tooltip>
        </a>
    @endif
    
    @if ($tabla === 'ultimosAceptados')
        <a wire:click="aceptarReporte({{ $id }})"
            class="{{$estilo1}}">
            <x-vistoBueno-tooltip>Aceptar</x-vistoBueno-tooltip>
        </a>
        <a href="{{ route('ActionRechazadosAceptadosRevisor', ['id' => $id]) }}"
            class="{{$estilo1}}">
            <x-rechazar-tooltip>Rechazar</x-rechazar-tooltip>
        </a>
    @endif
</div>
