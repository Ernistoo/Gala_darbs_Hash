<x-app-layout>
<x-slot name="header"></x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
        <h2 class="text-2xl font-bold mb-6">Iesniegumi uzdevumam: {{ $challenge->title }}</h2>

        <div class="mb-6">
            @include('submissions.partials.filter-dropdown')
        </div>

       
        @if($submissions->count())
            <div class="columns-2 sm:columns-3 md:columns-4 lg:columns-5 gap-4 space-y-4">
                @foreach($submissions as $submission)
                    <x-submission-card :submission="$submission" :challenge="$challenge" />
                @endforeach
            </div>
        @else
            <p class="text-gray-500 dark:text-gray-400">Pagaidām nav neviena iesnieguma.</p>
        @endif
    </div>
</x-app-layout>
