<?php

log::info('Entro a la vista' . get_class($this). '  Usuario logueado -> '.Auth::user()->name );

Log::info('Correo' . get_class($this) . '  _  Usuario logueado -> '.Auth::user()->name);


Log::alert('En la vista' . get_class($this) . ' hay un error. Usuario logueado -> '.Auth::user()->name);
