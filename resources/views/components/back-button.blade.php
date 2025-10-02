@props(['route' => url()->previous()])

<a href="{{ $route }}"
   class="inline-flex items-center justify-center w-12 h-12
          bg-purple-600 text-white rounded-full shadow
          hover:bg-purple-700 transition">
    <img src="{{ asset('images/back.svg') }}" class="w-6 h-6">
</a>
