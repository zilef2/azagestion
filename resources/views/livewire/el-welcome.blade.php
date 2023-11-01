<div class="">
{{-- contenido admin --}}
@if(auth()->user()->is_admin > 1)
    <div class="flex flex-wrap lg:w-full sm:mx-auto sm:mb-2 -mx-2 border-t-2 border-b-2 border-blue-100">
        @foreach($contenidoAdmin as $item)
            <div class="grid p-2 sm:w-1/2 w-full place-content-center hover:bg-sky-50">
                <div class="bg-white hover:bg-sky-100 rounded flex p-4 h-full items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"> <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path> <path d="M22 4L12 14.01l-3-3"></path> </svg>
                    <a href="{{route($item['link'])}}" class="title-font font-medium">{{$item['titulo']}}</a>
                </div>
            </div>
        @endforeach
    </div>
@endif

@if (Session::has('message'))
    <div class="bg-green-100 rounded-lg py-5 px-6 md:px-2 sm:px-1 text-base text-green-800 mb-3 text-center"
        role="alert">
        {{ session('message') }}
    </div>
    @endif
@if (session()->has('messageError'))
    <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-red-700 mb-3 text-center" role="alert">
        {{ session('messageError') }}
    </div>
@endif

@if(auth()->user()->rol_id == 1 || auth()->user()->rol_id == 2 || auth()->user()->is_admin)
    <livewire:vistas.welcome-asignador />
@endif
@if(auth()->user()->rol_id == 3 || auth()->user()->is_admin)
    <livewire:vistas.welcome-asesor />
@endif

@if(auth()->user()->is_admin > 1)
    <div class="flex flex-wrap lg:w-full sm:mx-auto sm:mb-2 -mx-2">
        @foreach($contenido as $item)
        <div class="grid p-2 sm:w-1/2 w-full place-content-center">
            <div class="bg-white hover:bg-sky-100 rounded flex p-4 h-full items-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"> <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path> <path d="M22 4L12 14.01l-3-3"></path> </svg>
                <a href="{{route($item['link'])}}" class="title-font font-medium">{{$item['titulo']}}</a>
            </div>
        </div>
        @endforeach
    </div>
@endif

@if(auth()->user()->is_admin >= 2)
    <div class="flex flex-wrap lg:w-full border-t-2 border-blue-300 sm:mx-auto sm:mb-2 -mx-2">
        @foreach($contenidoAlejo as $item)
        <div class="grid p-2 sm:w-1/2 w-full place-content-center">
            <div class="bg-white hover:bg-sky-100 rounded flex p-4 h-full items-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24"> <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path> <path d="M22 4L12 14.01l-3-3"></path> </svg>
                <a href="{{route($item['link'])}}" class="title-font font-medium">{{$item['titulo']}}</a>
            </div>
        </div>
        @endforeach
    </div>
@endif
</div>