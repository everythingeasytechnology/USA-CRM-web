<x-layouts.admin active="social">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Social Media Profiles']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Social Media Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage brand URLs and display icons on landing footers, header contacts, or email signatures.</p>
        </div>

        <form action="#save-social" method="POST" class="space-y-6" @submit.prevent="alert('Social profile configurations saved successfully!')">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                @php
                    $platforms = [
                        ['id' => 'facebook', 'name' => 'Facebook', 'url' => 'https://facebook.com/everythingeasy', 'enabled' => true],
                        ['id' => 'instagram', 'name' => 'Instagram', 'url' => 'https://instagram.com/everythingeasy', 'enabled' => true],
                        ['id' => 'linkedin', 'name' => 'LinkedIn', 'url' => 'https://linkedin.com/company/everythingeasy', 'enabled' => true],
                        ['id' => 'twitter', 'name' => 'Twitter / X', 'url' => 'https://x.com/everythingeasy', 'enabled' => false],
                        ['id' => 'threads', 'name' => 'Threads', 'url' => 'https://threads.net/@everythingeasy', 'enabled' => false],
                        ['id' => 'pinterest', 'name' => 'Pinterest', 'url' => 'https://pinterest.com/everythingeasy', 'enabled' => false],
                        ['id' => 'youtube', 'name' => 'YouTube', 'url' => 'https://youtube.com/c/everythingeasy', 'enabled' => true],
                        ['id' => 'whatsapp', 'name' => 'WhatsApp Support Group', 'url' => 'https://chat.whatsapp.com/invite_code', 'enabled' => true],
                        ['id' => 'telegram', 'name' => 'Telegram channel', 'url' => 'https://t.me/everythingeasy', 'enabled' => false],
                        ['id' => 'discord', 'name' => 'Discord Server', 'url' => 'https://discord.gg/everythingeasy', 'enabled' => true],
                        ['id' => 'github', 'name' => 'GitHub Organization', 'url' => 'https://github.com/everythingeasy', 'enabled' => true],
                    ];
                @endphp

                @foreach ($platforms as $platform)
                    <x-admin.card :padding="true" class="flex flex-col justify-between">
                        <div class="space-y-4">
                            <!-- Platform Header: Icon + Toggle -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <span class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-650 dark:text-slate-350">
                                        <x-admin.icon name="social" class="w-5 h-5 text-slate-500" />
                                    </span>
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $platform['name'] }}</span>
                                </div>
                                <x-admin.form.toggle name="social_{{ $platform['id'] }}_enabled" :value="$platform['enabled']" />
                            </div>

                            <!-- URL Input -->
                            <x-admin.form.input 
                                name="social_{{ $platform['id'] }}_url" 
                                placeholder="{{ $platform['name'] }} Profile URL" 
                                value="{{ $platform['url'] }}" 
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
