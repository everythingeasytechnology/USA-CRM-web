<x-layouts.admin active="social">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Social Media Profiles']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Social Media Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage brand URLs and display icons on landing footers, header contacts, or email signatures.</p>
        </div>

        <form action="/admin/social" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($platforms as $platform)
                    <x-admin.card :padding="true" class="flex flex-col justify-between">
                        <div class="space-y-4">
                            <!-- Platform Header: Icon + Toggle -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-350">
                                        <x-admin.icon name="social" class="w-5 h-5 text-slate-500" />
                                    </span>
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $platform->label }}</span>
                                </div>
                                <x-admin.form.toggle name="social_{{ $platform->platform }}_enabled" :value="$platform->is_enabled" />
                            </div>

                            <!-- URL Input -->
                            <x-admin.form.input
                                name="social_{{ $platform->platform }}_url"
                                placeholder="{{ $platform->label }} Profile URL"
                                :value="$platform->url"
                            />
                        </div>
                    </x-admin.card>
                @endforeach

            </div>

            <!-- Sticky submit footer -->
            <div class="flex justify-end border-t border-slate-200 dark:border-slate-800 pt-6">
                <x-admin.button type="submit" variant="primary">
                    <x-admin.icon name="check" class="w-5 h-5" />
                    <span>Save Social Links</span>
                </x-admin.button>
            </div>

        </form>
    </div>
</x-layouts.admin>
