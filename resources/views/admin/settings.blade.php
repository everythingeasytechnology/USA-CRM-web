<x-layouts.admin active="settings">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Website Settings']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Website Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure global branding, emails, analytics codes, search console verifications, and mail servers.</p>
        </div>

        <form action="/admin/settings" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left panel: Form fields -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Brand Branding details -->
                    <x-admin.card title="Branding & Identity">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="company_name" label="Company Name" :value="$settings['company_name']" :required="true" />
                                <x-admin.form.input name="brand_name" label="Brand Name" :value="$settings['brand_name']" :required="true" />
                            </div>
                            <x-admin.form.input name="tagline" label="Website Tagline" :value="$settings['tagline']" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="website_url" label="Website URL" :value="$settings['website_url']" :required="true" />
                                <x-admin.form.input name="copyright" label="Footer Copyright Text" :value="$settings['copyright']" />
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Contact details -->
                    <x-admin.card title="Support & Communication">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="support_email" label="Support Email Address" :value="$settings['support_email']" type="email" :required="true" />
                                <x-admin.form.input name="sales_email" label="Sales Email Address" :value="$settings['sales_email']" type="email" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="phone" label="Office Telephone" :value="$settings['phone']" />
                                <x-admin.form.input name="whatsapp" label="WhatsApp Chat Number" :value="$settings['whatsapp']" help="Include country code (e.g. +91)" />
                            </div>
                            <x-admin.form.textarea name="address" label="Office Headquarters Address" :value="$settings['address']" :rows="2" />
                            <x-admin.form.input name="gmaps" label="Google Maps Location Embed Link" :value="$settings['gmaps']" />
                        </div>
                    </x-admin.card>

                    <!-- Analytics and Integration -->
                    <x-admin.card title="Third-Party Tracking Integrations">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="ga_id" label="Google Analytics ID" :value="$settings['ga_id']" placeholder="G-XXXXXXXXXX" />
                                <x-admin.form.input name="gtm_id" label="Google Tag Manager ID" :value="$settings['gtm_id']" placeholder="GTM-XXXXXXX" />
                                <x-admin.form.input name="meta_pixel" label="Meta Pixel ID" :value="$settings['meta_pixel']" placeholder="Pixel ID" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="gsc_verification" label="Google Search Console verification" :value="$settings['gsc_verification']" />
                                <x-admin.form.input name="bing_verification" label="Bing Webmaster Verification" :value="$settings['bing_verification']" />
                                <x-admin.form.input name="yandex_verification" label="Yandex Verification" :value="$settings['yandex_verification']" />
                            </div>
                            <x-admin.form.input name="indexnow_key" label="IndexNow API Key" :value="$settings['indexnow_key']" help="Used for automated instant indexing of blogs and static nodes" />
                        </div>
                    </x-admin.card>

                    <!-- Scripts injected -->
                    <x-admin.card title="Custom Code Injectors">
                        <div class="space-y-4">
                            <x-admin.form.textarea name="header_scripts" label="Custom Header Scripts (<head>)" placeholder="<!-- Insert script tags here, e.g. custom styles or CDNs -->" :rows="3" :value="$settings['header_scripts']" />
                            <x-admin.form.textarea name="footer_scripts" label="Custom Footer Scripts (before </body>)" placeholder="<!-- Insert analytic tracking code or support chat scripts -->" :rows="3" :value="$settings['footer_scripts']" />
                        </div>
                    </x-admin.card>
                </div>

                <!-- Right panel: Quick Actions and Themes -->
                <div class="space-y-6">
                    <x-admin.card title="Theme Layout & Colors">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Primary Accent</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="theme_primary" value="{{ $settings['theme_primary'] ?? '#2563eb' }}" class="h-9 w-9 rounded-lg border border-slate-200 dark:border-slate-800 cursor-pointer" />
                                        <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200">{{ $settings['theme_primary'] ?? '#2563eb' }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Secondary Accent</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="theme_secondary" value="{{ $settings['theme_secondary'] ?? '#1e293b' }}" class="h-9 w-9 rounded-lg border border-slate-200 dark:border-slate-800 cursor-pointer" />
                                        <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200">{{ $settings['theme_secondary'] ?? '#1e293b' }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-slate-200 dark:border-slate-800 my-4" />

                            <!-- Maintenance state -->
                            <x-admin.form.toggle name="maintenance_mode" label="Global Maintenance Mode" :value="$settings['maintenance_mode'] === '1'" help="Lock the public frontend and display a styled 'Coming Soon' / Maintenance page to standard traffic." />
                        </div>
                    </x-admin.card>

                    <!-- Mail settings -->
                    <x-admin.card title="SMTP / Mail settings">
                        <div class="space-y-4">
                            <x-admin.form.input name="smtp_host" label="SMTP Host" :value="$settings['smtp_host']" />
                            <x-admin.form.input name="smtp_port" label="SMTP Port" :value="$settings['smtp_port']" />
                            <x-admin.form.input name="smtp_user" label="Username" :value="$settings['smtp_user']" />
                            <x-admin.form.input name="smtp_pass" type="password" label="Password" :value="$settings['smtp_pass']" />
                            <x-admin.form.select name="smtp_encryption" label="Encryption type">
                                <option value="tls" @selected($settings['smtp_encryption'] === 'tls')>STARTTLS (Recommended)</option>
                                <option value="ssl" @selected($settings['smtp_encryption'] === 'ssl')>SSL/TLS</option>
                                <option value="none" @selected($settings['smtp_encryption'] === 'none')>None</option>
                            </x-admin.form.select>
                        </div>
                    </x-admin.card>

                    <div class="sticky top-20">
                        <x-admin.button type="submit" variant="primary" class="w-full">
                            <x-admin.icon name="check" class="w-5 h-5" />
                            <span>Save General Settings</span>
                        </x-admin.button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</x-layouts.admin>
