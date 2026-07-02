<x-layouts.admin active="packages">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[
            ['label' => 'Pricing Packages', 'url' => '/admin/packages'],
            ['label' => 'Create Package']
        ]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Create Package</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure individual service pricing configurations, feature listings, and call-to-action buttons.</p>
        </div>

        <form action="/admin/packages" method="POST" class="space-y-6" @submit.prevent="alert('Package created successfully!'); window.location='/admin/packages'">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main columns -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Core Details -->
                    <x-admin.card title="Core Details">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="name" label="Package Name" placeholder="e.g. Premium E-Commerce Setup" :required="true" />
                                <x-admin.form.input name="slug" label="URL Slug" placeholder="e.g. premium-ecommerce-setup" :required="true" />
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.select name="service_id" label="Related Service" :required="true">
                                    <option value="1">Website Development</option>
                                    <option value="2">Search Engine Optimization</option>
                                    <option value="3">Mobile App Development</option>
                                    <option value="4">Graphic Design</option>
                                </x-admin.form.select>
                                
                                <x-admin.form.input name="badge" label="Highlight Badge / Tag" placeholder="e.g. Popular, 20% OFF, Limited" />
                            </div>

                            <x-admin.form.textarea name="short_desc" label="Short Summary" placeholder="Brief outline of who this package is suitable for (shows on pricing tables)..." :rows="2" :required="true" />
                            <x-admin.form.textarea name="full_desc" label="Full Package Details" placeholder="Thoroughly details what is included and excluded in this service package..." :rows="4" />
                        </div>
                    </x-admin.card>

                    <!-- Pricing & Terms -->
                    <x-admin.card title="Pricing & SLA Terms">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="price_starting" label="Starting Price ($)" type="number" placeholder="e.g. 1299" :required="true" />
                                <x-admin.form.input name="price_original" label="Original Price ($)" type="number" placeholder="e.g. 1599" help="Show crossed-out price" />
                                <x-admin.form.input name="price_discount" label="Discount Price ($)" type="number" help="Calculate active savings value" />
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-admin.form.input name="delivery_time" label="Delivery Time" placeholder="e.g. 14 Days" :required="true" />
                                <x-admin.form.input name="revisions" label="Revision Count Limit" type="number" placeholder="e.g. 5" help="Set '0' for Unlimited" />
                                <x-admin.form.input name="support_duration" label="Support SLA Duration" placeholder="e.g. 30 Days Free Support" />
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Tech Stack & suitability -->
                    <x-admin.card title="Specifications & Checklist">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="tech_stack" label="Technology Stack Specs" placeholder="e.g. Laravel, Alpine.js, Tailwind CSS" />
                                <x-admin.form.input name="suitable_for" label="Suitable For Clients" placeholder="e.g. Medium Agencies, E-commerce Brands" />
                            </div>
                            <x-admin.form.textarea name="features" label="Features Checklist (One per line)" placeholder="🔒 SSL Security Setup&#10;🚀 Cloudflare CDN Routing&#10;📦 Payment Gateways" :rows="4" :required="true" />
                        </div>
                    </x-admin.card>

                    <!-- CTA Settings -->
                    <x-admin.card title="Action Buttons Configuration">
                        <div class="space-y-4">
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Set Default Action Trigger URL</span>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.select name="cta_type" label="CTA Action Button Mode">
                                    <option value="buy_now">Buy Now (Standard Redirect)</option>
                                    <option value="quote">Request a Quote (Form Trigger)</option>
                                    <option value="payment">Pay Online (Direct Invoice)</option>
                                    <option value="contact">Contact support (WhatsApp / Skype)</option>
                                </x-admin.form.select>
                                <x-admin.form.input name="cta_url" label="CTA Destination URL" placeholder="e.g. /contact or Stripe Checkout link" />
                            </div>
                        </div>
                    </x-admin.card>
                </div>

                <!-- Right sidebar: Status & Documents -->
                <div class="space-y-6">
                    <!-- Status & Order -->
                    <x-admin.card title="Status & Sorting">
                        <div class="space-y-4">
                            <x-admin.form.input name="display_order" label="Display Priority Order" type="number" value="1" />
                            <x-admin.form.toggle name="status" label="Active / Visible" :value="true" />
                            <x-admin.form.toggle name="is_featured" label="Highlight Package" help="Apply highlighted border and 'Best Value' layouts on tables." />
                        </div>
                    </x-admin.card>

                    <!-- Media and files -->
                    <x-admin.card title="Documents & Cover">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Package Cover / Image</label>
                                <div class="border-2 border-dashed border-slate-250 dark:border-slate-800 rounded-lg p-4 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                                    <x-admin.icon name="upload" class="w-8 h-8 text-slate-400 mx-auto" />
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-350 block mt-2">Upload cover picture</span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Brochure Details PDF</label>
                                <div class="border-2 border-dashed border-slate-250 dark:border-slate-800 rounded-lg p-4 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                                    <x-admin.icon name="media" class="w-8 h-8 text-slate-400 mx-auto" />
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-350 block mt-2">Upload Brochure document</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">Accepts PDF files up to 10MB</span>
                                </div>
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Submission buttons -->
                    <div class="sticky top-20 flex gap-3">
                        <x-admin.button type="submit" variant="primary" class="flex-1">
                            Save Package
                        </x-admin.button>
                        <x-admin.button type="button" variant="secondary" href="/admin/packages">
                            Cancel
                        </x-admin.button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</x-layouts.admin>
