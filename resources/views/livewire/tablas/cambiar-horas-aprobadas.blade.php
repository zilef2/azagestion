<div>
    <input class="w-16 rounded-lg border border-slate-400 p-2 text-slate-900 placeholder-slate-400 transition-colors duration-300 focus:border-sky-400 focus:outline-none"
        type="number" name="" id="" min="0"
        wire:model.defer="horasAprob.{{ $id }}"
        wire:keydown.enter="changeHoras({{ $id }})"
    >
</div>
