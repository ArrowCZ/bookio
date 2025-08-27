<x-layouts.app>

<div class="min-h-screen text-gray-900 dark:text-gray-100">
    <div>
        <div class="mb-6 flex items-center justify-between gap-3">
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ __('Create Book') }}
            </h1>
            <a href="{{ route('books.index') }}"
               class="inline-flex items-center rounded-xl border border-gray-300 bg-white px-3 py-2 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-gray-800 dark:bg-gray-900 dark:hover:bg-gray-800">
                {{ __('Back') }}
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-xl border border-red-300 bg-red-50 p-4 text-sm text-red-900 dark:border-red-900/50 dark:bg-red-950/40 dark:text-red-200">
                <p class="font-semibold">{{ __('Please fix the following:') }}</p>
                <ul class="mt-2 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($book) ? route('books.update', $book) : route('books.store') }}" class="space-y-4">
            @csrf
            @if (isset($book))
                @method('PATCH')
            @endif

            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div class="col-span-2 xl:col-span-2">
                        <x-forms.input required label="Title" name="title" type="text" placeholder="Enter title" value="{{ old('title', $book->title ?? '') }}" />
                    </div>

                    <div>
                        <x-forms.input required label="Author" name="author" type="text" placeholder="Enter author" value="{{ old('author', $book->author ?? '') }}" />
                    </div>

                    <div>
                        <x-forms.input required label="Price" name="price" type="number" placeholder="Enter price" value="{{ old('price', $book->price ?? '') }}" />
                    </div>

                    <div>
                        <x-forms.input required label="Stock" name="stock" type="number" placeholder="Enter stock" value="{{ old('stock', $book->stock ?? '') }}" />
                    </div>

                    <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4">
                        <label for="description" class="mb-1 block text-sm font-medium">{{ __('Short description') }}</label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full rounded-xl border border-gray-300 bg-white px-3 py-2.5 text-sm shadow-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 dark:border-gray-800 dark:bg-gray-950"
                            placeholder="{{ __('Brief summary…') }}">{{ old('description', $book->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2">
                <a href="{{ route('books.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-gray-800 dark:bg-gray-900 dark:hover:bg-gray-800">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    {{ __('Save Book') }}
                </button>
            </div>
        </form>
    </div>
</div>
</x-layouts.app>