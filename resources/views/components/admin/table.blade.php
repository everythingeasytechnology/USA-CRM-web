@props([
    'headers' => [], // Array of column headers or labels
])

<div class="w-full overflow-x-auto select-text">
    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-left text-sm">
        <!-- Table Column Headers -->
        @if (!empty($headers))
            <thead class="bg-slate-50 dark:bg-slate-900/50">
                <tr>
                    @foreach ($headers as $header)
                        <th 
                            scope="col" 
                            class="px-6 py-3.5 font-semibold text-slate-700 dark:text-slate-300 first:pl-6 last:pr-6"
                        >
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <!-- Table Content Body -->
        <tbody class="divide-y divide-slate-200 dark:divide-slate-800 bg-white dark:bg-slate-900">
            {{ $slot }}
        </tbody>
    </table>
</div>
