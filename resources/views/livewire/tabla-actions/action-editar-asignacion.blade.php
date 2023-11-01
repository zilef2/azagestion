<div class="p-12 mx-auto">
    <div class="p-2 w-1/3">
        <div class="relative">
            <p><b>{{ $usuario->name }}</b> tiene asociado la Orden <b>{{ $OrdenCompra->codigo }}</b></p>
        </div>
        <div class="relative">
            <label for="ordenCompraid" class="block text-sm font-medium text-gray-700 capitalize">orden de compra</label>
            <select id="ordenCompraid" name="ordenCompraid" aria-label=".form-select-lg example" wire:model="nuevaOrdenCompraid"
            class="form-select form-select-md mt-2
                    appearance-none block w-full px-4 py-2
                    text-lg font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0
                    focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                @forelse($ordenes_compra as $generico)
                    @if ($loop->first)
                        <option class="capitalize" value="" selected>Ordenes que no estan asignadas al usuario</option>
                    @endif
                    <option class="capitalize" value="{{$generico->id}}">{{$generico->codigo}}</option>
                @empty
                    <option class="capitalize" value="" selected>No hay registros que no esten asignados a este usuario</option>
                @endforelse
            </select>
        </div>
    </div>
</div>
