<x-app-layout>
    <x-header>        
            {{ __('Categories') }}
    </x-header>

    

            @if($categories->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('posts.byCategory', $category->id) }}"
                       class="block rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition transform hover:-translate-y-1">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" 
                                 alt="{{ $category->name }}" 
                                 class="w-full h-60 object-cover">
                        @else
                            <div class="w-full h-60 flex items-center justify-center bg-gray-200">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif
                        <div class="p-4 bg-gradient-to-r from-gray-100 via-gray-200 to-gray-100 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 text-center">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
            @else
                <p class="text-gray-500">No categories available.</p>
            @endif
        </div>
    </div>
</x-app-layout>
