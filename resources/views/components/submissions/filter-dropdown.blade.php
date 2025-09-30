@props(['challenge', 'sort' => null])
<form method="GET" action="{{ route('submissions.index', $challenge) }}">
    <select name="sort" onchange="this.form.submit()"
        class="bg-transparent dark:bg-black border-2 border-purple-500
               text-gray-900 dark:text-gray-200 rounded-lg px-3 py-2
               focus:outline-none focus:ring-2 focus:ring-purple-400
               transition-colors duration-300 ease-in-out">

        <option value="">Default</option>
        <option value="most_voted" {{ request('sort') == 'most_voted' ? 'selected' : '' }}>Visvairāk balsu</option>
        <option value="least_voted" {{ request('sort') == 'least_voted' ? 'selected' : '' }}>Vismazāk balsu</option>
        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Jaunākie</option>
    </select>
</form>
