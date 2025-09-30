<x-app-layout>
<x-header>        
    {{ __('My collections') }}
</x-header>
    

    <div class="max-w-6xl mx-auto py-6 space-y-6">

        <x-collections.create-dropdown />

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-4">
            @foreach($collections as $collection)
                <x-collections.collection-card :collection="$collection" />
            @endforeach
        </div>

    </div>
</x-app-layout>
