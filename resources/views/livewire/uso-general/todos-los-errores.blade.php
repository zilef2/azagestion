<div>
    @if (Session::has('message'))
            <div class="grid place-content-center divide-y-2">
                <span
                    class="px-1 inline-flex text-xl leading-5 font-semibold bg-green-200 text-green-800 hover:uppercase">
                    {{ __(session('message')) }}
                </span>
            </div>
        @endif
        @if (Session::has('messageError'))
            <div class="">
                <span
                    class="px-1 text-lg inline-flex leading-5 font-semibold bg-red-100 text-red-800">
                    {{ __(session('messageError')) }}
                </span>
            </div>
        @endif
        @if($errors->any())
            @foreach ($errors as $err)
                <p class="px-1 inline-flex text-lg leading-5 font-semibold bg-amber-500 text-black">
                    {{ $err }}
                </p>
            @endforeach
        @endif
        @if (session()->has('messageError'))
            <div class="py-8 w-full">
                <div class="bg-red-100 rounded-lg py-5 px-6 text-base text-black mb-3" role="alert">
                    ¡{{ session('messageError') }}!
                </div>
            </div>
        @endif
</div>
