<form method="GET" action="{{ route('posts.index') }}">
    <select
        name="category_id"
        onchange="this.form.submit()"
        class="bg-transparent dark:bg-black border-2 border-purple-500 
               text-gray-900 dark:text-gray-200  
               rounded-lg px-3 py-2 w-auto min-w-[150px] 
               focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-purple-500
               transition-colors duration-300 ease-in-out">
        <option value="" class="text-gray-400 dark:text-gray-200">
            All Categories
        </option>

        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</form>
