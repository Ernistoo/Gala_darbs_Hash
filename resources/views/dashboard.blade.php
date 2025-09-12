<x-app-layout>
    <div class="flex items-center justify-center min-h-screen bg-transparent">
        <div class="text-center animate-fade-in-up">
            <h1 class="text-6xl font-extrabold text-purple-700 drop-shadow-lg animate-pulse transition-transform duration-300 hover:scale-105 group">
                Hash
            </h1>
            <p class="mt-4 text-xl text-purple-500 ">
                Share your love for a craft without limitations
            </p>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 1s ease-out forwards;
        }
    </style>
</x-app-layout>
