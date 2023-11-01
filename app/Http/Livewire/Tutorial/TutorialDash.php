<?php

namespace App\Http\Livewire\Tutorial;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TutorialDash extends Component
{
    public $isAsignador;

    public $links;

    public function mount()
    {
        $this->isAsignador = Auth::user()->rol_id == 2;
        $this->links=[
             'Subir usuarios y OC' => 'https://www.youtube-nocookie.com/embed/RPxsMMPejuY',
             'Usuarios desconocidos' => 'https://www.youtube-nocookie.com/embed/E--pZSzSwY4', 
             'Aceptar y rechazar OC' => 'https://www.youtube-nocookie.com/embed/-M3e6rk8dlc', 
             'Descarar soportes' =>    'https://www.youtube-nocookie.com/embed/3EAbAPcbnf0',
             'Rol de administrador' => 'https://www.youtube-nocookie.com/embed/iyOL-v4Z6h8',
        ];
    }
    public function render()
    {
        return view('livewire.tutorial.tutorial-dash');
    }
}
