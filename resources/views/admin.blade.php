<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-transparent">
        <div class="text-center animate-fade-in-up">
            <h1 class="text-6xl font-extrabold text-purple-700 drop-shadow-lg animate-pulse transition-transform duration-300 hover:scale-105 group">
                Kā admin tu vari veidot uzdevumus parejiem!
            </h1>

            <div class="mt-8">
                <a href="{{ route('challenges.create') }}"
                    class="px-6 py-3 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition">
                    Create New Challenge
                </a>
            </div>
        </div>
    </div>
</x-app-layout>