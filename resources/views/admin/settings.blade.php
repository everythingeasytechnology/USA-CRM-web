<x-layouts.admin active="settings">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Website Settings']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Website Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure global branding, emails, analytics codes, search console verifications, and mail servers.</p>
        </div>

        <form action="#save-settings" method="POST" class="space-y-6" @submit.prevent="alert('Settings saved successfully!')">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left panel: Form fields -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Brand Branding details -->
                    <x-admin.card title="Branding & Identity">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="company_name" label="Company Name" value="EverythingEasy Solutions Pvt. Ltd." :required="true" />
                                <x-admin.form.input name="brand_name" label="Brand Name" value="EverythingEasy" :required="true" />
                            </div>
                            <x-admin.form.input name="tagline" label="Website Tagline" value="Enterprise Software Development & Marketing Made Simple" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="website_url" label="Website URL" value="https://everythingeasy.in" :required="true" />
                                <x-admin.form.input name="copyright" label="Footer Copyright Text" value="© 2026 EverythingEasy. All rights reserved." />
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Contact details -->
                    <x-admin.card title="Support & Communication">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="support_email" label="Support Email Address" value="support@everythingeasy.in" type="email" :required="true" />
                                <x-admin.form.input name="sales_email" label="Sales Email Address" value="sales@everythingeasy.in" type="email" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="phone" label="Office Telephone" value="+91 120 456 7890" />
                                <x-admin.form.input name="whatsapp" label="WhatsApp Chat Number" value="+91 98765 43210" help="Include country code (e.g. +91)" />
                            </div>
                            <x-admin.form.textarea name="address" label="Office Headquarters Address" value="Suite 404, Tech Park Sector 62, Noida, UP, India" :rows="2" />
                            <x-admin.form.input name="gmaps" label="Google Maps Location Embed Link" value="https://maps.google.com/?q=EverythingEasy" />
                        </div>
                    </x-admin.card>

                    <!-- Analytics and Integration -->
                    <x-admin.card title="Third-Party Tracking Integrations">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="ga_id" label="Google Analytics ID" value="G-V2XY98B2LA" placeholder="G-XXXXXXXXXX" />
                                <x-admin.form.input name="gtm_id" label="Google Tag Manager ID" value="GTM-N8X2V3L" placeholder="GTM-XXXXXXX" />
                                <x-admin.form.input name="meta_pixel" label="Meta Pixel ID" value="1098234891823" placeholder="Pixel ID" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="gsc_verification" label="Google Search Console verification" value="gsc_auth_verify_string_908" />
                                <x-admin.form.input name="bing_verification" label="Bing Webmaster Verification" />
                                <x-admin.form.input name="yandex_verification" label="Yandex Verification" />
                            </div>
                            <x-admin.form.input name="indexnow_key" label="IndexNow API Key" value="a98b2c45d3e210a459b8c" help="Used for automated instant indexing of blogs and static nodes" />
                        </div>
                    </x-admin.card>

                    <!-- Scripts injected -->
                    <x-admin.card title="Custom Code Injectors">
                        <div class="space-y-4">
                            <x-admin.form.textarea name="header_scripts" label="Custom Header Scripts (<head>)" placeholder="<!-- Insert script tags here, e.g. custom styles or CDNs -->" :rows="3" />
                            <x-admin.form.textarea name="footer_scripts" label="Custom Footer Scripts (before </body>)" placeholder="<!-- Insert analytic tracking code or support chat scripts -->" :rows="3" />
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
                                        <input type="color" name="theme_primary" value="#2563eb" class="h-9 w-9 rounded-lg border border-slate-200 dark:border-slate-800 cursor-pointer" />
                                        <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200">#2563eb</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Secondary Accent</label>
                                    <div class="flex items-center gap-2">
                                        <input type="color" name="theme_secondary" value="#1e293b" class="h-9 w-9 rounded-lg border border-slate-200 dark:border-slate-800 cursor-pointer" />
                                        <span class="text-xs font-mono font-bold text-slate-800 dark:text-slate-200">#1e293b</span>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="border-slate-200 dark:border-slate-800 my-4" />
                            
                            <!-- Maintenance state -->
                            <x-admin.form.toggle name="maintenance_mode" label="Global Maintenance Mode" help="Lock the public frontend and display a styled 'Coming Soon' / Maintenance page to standard traffic." />
                        </div>
                    </x-admin.card>

                    <!-- Mail settings -->
                    <x-admin.card title="SMTP / Mail settings">
                        <div class="space-y-4">
                            <x-admin.form.input name="smtp_host" label="SMTP Host" value="smtp.postmarkapp.com" />
                            <x-admin.form.input name="smtp_port" label="SMTP Port" value="587" />
                            <x-admin.form.input name="smtp_user" label="Username" value="user_pm_everything" />
                            <x-admin.form.input name="smtp_pass" type="password" label="Password" value="••••••••••••••••" />
                            <x-admin.form.select name="smtp_encryption" label="Encryption type">
                                <option value="tls" selected>STARTTLS (Recommended)</option>
                                <option value="ssl">SSL/TLS</option>
                                <option value="none">None</option>
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
