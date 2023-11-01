@component('mail::message')
# ¡Hola!

Este es un correo electrónico de prueba con un fondo azul.

@component('mail::panel', ['color' => 'blue'])
Este es un panel con fondo azul y contiene algunos textos importantes.
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent