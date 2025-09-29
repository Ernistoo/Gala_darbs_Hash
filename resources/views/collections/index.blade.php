<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">My Collections</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 space-y-6">

        <!-- Poga kolekcijas izveidei -->
        
        <x-create-dropdown />

        <!-- Kolekciju saraksts -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
            @foreach($collections as $collection)
                <x-collection-card :collection="$collection" />
            @endforeach
        </div>

    </div>
</x-app-layout>
