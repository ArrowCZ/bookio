<x-layouts.app>

<div class="min-h-screen text-gray-900 dark:text-gray-100">
    <div>
        <div class="mb-6 flex items-center justify-between gap-3">
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ __('Your books') }}
            </h1>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('Total:') }} {{ $books->count() }}
            </span>
        </div>

        <div
            class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mb-6">
                <form method="GET" action="{{ route('books.index') }}" class="col-span-1 grid grid-cols-3">
                    <label class="sr-only" for="search">{{ __('Search') }}</label>

                    <div class="relative col-span-2">
                        <input
                            id="search"
                            name="search"
                            type="text"
                            placeholder="{{ __('Search books...')}}"
                            value="{{ $search ?? '' }}"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 dark:border-gray-800 dark:bg-gray-900"
                        />
                        <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <x-fas-magnifying-glass class="w-4 h-4" />
                        </span>
                    </div>

                    <input
                        value="{{ __('Search books...') }}"
                        type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 ml-4 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:bg-indigo-500 dark:hover:bg-indigo-600" />
                </form>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @forelse($books as $book)
                <div
                    class="group relative flex flex-col rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
                    <div class="absolute right-3 top-3 flex items-center gap-2 opacity-0 transition group-hover:opacity-100">
                        <a href="{{ route('books.edit', $book) }}"
                            class="inline-flex items-center rounded-lg border border-gray-200 bg-white/80 p-2 text-gray-600 shadow-sm backdrop-blur hover:bg-white dark:border-gray-700 dark:bg-gray-800/80 dark:text-gray-300 dark:hover:bg-gray-800"
                            title="{{ __('Edit') }}">
                            <x-fas-pencil-alt class="h-3 w-3" />
                        </a>
                        <form method="POST" action="{{ route('books.destroy', $book) }}" class="inline-flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center rounded-lg border border-red-200/60 bg-white/80 p-2 text-red-600 shadow-sm backdrop-blur hover:bg-red-50 dark:border-red-900/50 dark:bg-gray-800/80 dark:text-red-400 dark:hover:bg-red-900/20"
                                title="{{ __('Delete') }}">
                                <x-fas-trash class="h-3 w-3" />
                            </button>
                        </form>
                    </div>

                    <h3 class="mb-1 line-clamp-1 text-base font-semibold tracking-tight">
                        {{ $book->title }}
                    </h3>
                    <p class="mb-4 line-clamp-3 text-sm text-gray-600 dark:text-gray-400">
                        {{ \Illuminate\Support\Str::limit($book->description, 15) }}
                    </p>

                    <div class="mt-auto flex items-center justify-between pt-3">
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('Created:') }}
                            <time datetime="{{ $book->created_at }}">
                                {{ \Carbon\Carbon::parse($book->created_at)->isoFormat('LL') }}
                            </time>
                        </div>
                        <div class="text-sm font-semibold tabular-nums">
                            {{ number_format($book->price, 0, ',', ' ') }} Kč
                            <span class="text-xs">({{ $book->getPriceInEuros() }})</span>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-gray-300 p-8 text-center text-gray-500 dark:border-gray-800 dark:text-gray-400">
                        <x-fas-sad-cry class="mb-3 h-10 w-10" />
                    <p class="text-sm font-medium">{{ __('No books found') }}</p>
                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                        {{ __('Try adjusting your filters or create a new one.') }}
                    </p>
                    <a
                        href="{{ route('books.create') }}"
                        class="mt-4 inline-flex items-center rounded-xl bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500/30 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                            <x-fas-plus class="mr-2 h-4 w-4" />
                            {{ __('New book') }}
                    </a>
                </div>
            @endforelse
            <a href="{{ route('books.create') }}"
                class="group flex items-center justify-center rounded-2xl border border-dashed border-gray-300 p-6 text-gray-500 transition hover:border-indigo-400 hover:bg-indigo-50/50 dark:border-gray-800 dark:text-gray-400 dark:hover:border-indigo-500/40 dark:hover:bg-indigo-500/5">
                <div class="flex flex-col items-center">
                    <div
                        class="mb-3 flex h-12 w-12 items-center justify-center rounded-full border border-gray-300 transition group-hover:border-indigo-400 dark:border-gray-700 dark:group-hover:border-indigo-500">
                        <x-fas-plus class="h-6 w-6" />
                    </div>
                    <span class="text-sm font-medium">
                        {{ __('Add new book') }}
                    </span>
                </div>
            </a>
        </div>
        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
</div>
</x-layouts.app>