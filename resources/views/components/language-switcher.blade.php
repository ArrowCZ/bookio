@props([
    'locales' => ['en' => 'English', 'cs' => 'Čeština'],
    'current' => app()->getLocale(),
])

<form method="POST" action="{{ route('locale.set') }}" {{ $attributes->class('inline-block') }}>
    @csrf

    <fieldset class="rounded-2xl border border-gray-200 bg-white p-1 shadow-sm dark:border-gray-800 dark:bg-gray-900">
        <legend class="sr-only">{{ __('Language') }}</legend>

        <div class="grid grid-cols-2 gap-1 sm:auto-cols-max sm:inline-grid sm:grid-flow-col">
            @foreach ($locales as $code => $label)
                @php $active = $current === $code; @endphp

                <button
                    type="submit"
                    name="locale"
                    value="{{ $code }}"
                    aria-current="{{ $active ? 'true' : 'false' }}"
                    class="
                        group inline-flex items-center justify-center rounded-xl px-3 py-2 text-sm font-medium
                        transition focus:outline-none focus:ring-2 focus:ring-indigo-500/30
                        {{ $active
                            ? 'bg-indigo-600 text-white dark:bg-indigo-500'
                            : 'text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800'
                        }}
                    "
                >
                    <span class="mr-2 rounded-md border px-1.5 py-0.5 text-[11px] tabular-nums
                        {{ $active
                            ? 'border-white/30 bg-white/10 text-white'
                            : 'border-gray-300 bg-gray-100 text-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300'
                        }}">
                        {{ strtoupper($code) }}
                    </span>

                    <span>{{ __($label) }}</span>
                </button>
            @endforeach
        </div>
    </fieldset>
</form>
