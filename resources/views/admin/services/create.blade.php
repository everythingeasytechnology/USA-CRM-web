<x-layouts.admin active="services">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[
            ['label' => 'Services Management', 'url' => '/admin/services'],
            ['label' => $service ? 'Edit Service' : 'Create Service']
        ]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $service ? 'Edit Service' : 'Create Service' }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure service descriptions, media showcases, checklists, and search engine structures.</p>
        </div>

        <form action="{{ $service ? '/admin/services/'.$service->id : '/admin/services' }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @if ($service)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main columns -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Core Details -->
                    <x-admin.card title="Core Details">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="name" label="Service Name" placeholder="e.g. Mobile App Development" :value="old('name', $service->name ?? '')" :required="true" />
                                <x-admin.form.input name="slug" label="URL Slug" placeholder="e.g. mobile-app-development" :value="old('slug', $service->slug ?? '')" :required="true" help="URL path segment, lower-case with hyphens" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.select name="category" label="Service Category" :required="true">
                                    @php $currentCategory = old('category', $service->category ?? ''); @endphp
                                    @foreach (['web-dev' => 'Web Development', 'app-dev' => 'Mobile Application Development', 'digital-marketing' => 'Digital Marketing & Growth', 'seo-marketing' => 'SEO & Search Optimization', 'design-branding' => 'UI/UX Design & Branding', 'ai-automation' => 'AI Automation & Integration', 'cloud-hosting' => 'Cloud Hosting & Infrastructure', 'crm-erp' => 'Corporate CRM/ERP Solutions', 'strategy-consultancy' => 'Consultancy & Agency Strategy'] as $value => $label)
                                        <option value="{{ $value }}" @selected($currentCategory === $value)>{{ $label }}</option>
                                    @endforeach
                                </x-admin.form.select>

                                <x-admin.form.input name="display_order" label="Display Order" type="number" :value="old('display_order', $service->display_order ?? 1)" help="Sorting index for public cards grids" />
                            </div>

                            <x-admin.form.textarea name="short_description" label="Short Description" placeholder="Summarize what this service delivers in 2-3 lines (shows on listing cards)..." :rows="2" :value="old('short_description', $service->short_description ?? '')" :required="true" />
                            <!-- Rich Content Builder Box -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5 font-medium">Long Description / Details *</label>
                                <div class="border border-slate-200 dark:border-slate-800 rounded-lg overflow-hidden bg-white dark:bg-slate-900 focus-within:ring-2 focus-within:ring-blue-600/20 focus-within:border-blue-600">
                                    <!-- Toolbar -->
                                    <div class="bg-slate-50 dark:bg-slate-900/50 px-3 py-2 border-b border-slate-200 dark:border-slate-800 flex flex-wrap gap-2 text-slate-500">
                                        <button type="button" class="px-2 py-0.5 rounded text-xs font-bold hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" @click="alert('Bold')">B</button>
                                        <button type="button" class="px-2 py-0.5 rounded text-xs italic hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" @click="alert('Italic')">I</button>
                                        <button type="button" class="px-2 py-0.5 rounded text-xs underline hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" @click="alert('Underline')">U</button>
                                        <span class="border-r border-slate-200 dark:border-slate-800 mx-1"></span>
                                        <select class="py-0.5 px-2 text-xs border border-slate-200 dark:border-slate-800 rounded bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300" style="width: auto;">
                                            <option value="p">Paragraph</option>
                                            <option value="h1">Heading 1</option>
                                            <option value="h2">Heading 2</option>
                                            <option value="h3">Heading 3</option>
                                        </select>
                                        <span class="border-r border-slate-200 dark:border-slate-800 mx-1"></span>
                                        <button type="button" class="px-2 py-0.5 rounded text-xs hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" @click="alert('Bullet List')">• Bullet List</button>
                                        <button type="button" class="px-2 py-0.5 rounded text-xs hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" @click="alert('Insert Link')">Insert Link</button>
                                        <button type="button" class="px-2 py-0.5 rounded text-xs hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer" @click="alert('Add Asset')">Add Media Image</button>
                                    </div>
                                    <!-- Edit space -->
                                    <textarea name="long_description" rows="8" class="block w-full border-0 px-3.5 py-3 text-xs focus:ring-0 bg-transparent text-slate-900 dark:text-slate-100 placeholder-slate-450 focus:outline-none" placeholder="Write full details with formatted lists and custom paragraphs here..." required>{{ old('long_description', $service->long_description ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Features & Benefits checklists -->
                    <x-admin.card title="Features, Benefits & FAQs">
                        <div class="space-y-4">
                            <x-admin.form.textarea name="benefits" label="Key Service Benefits" placeholder="Enter one benefit per line, e.g.&#10;🚀 Boost search conversion ratios&#10;🔒 Enterprise-grade data protection" :rows="3" />
                            <x-admin.form.textarea name="features" label="Deliverable Features Checklist" placeholder="Enter one deliverable feature per line, e.g.&#10;• Fully responsive layouts&#10;• Dark mode integration" :rows="3" />
                            <x-admin.form.textarea name="faqs" label="Service Specific FAQs" placeholder="e.g.&#10;Q: How long does delivery take?&#10;A: Delivery timelines range from 2 to 4 weeks depending on specs." :rows="4" />
                        </div>
                    </x-admin.card>

                    <!-- Programmatic SEO & Location Targeting -->
                    <x-admin.card title="Programmatic SEO & Location Targeting">
                        <div class="space-y-4" x-data="{ pseoEnabled: {{ old('pseo_enabled', $service->pseo_enabled ?? false) ? 'true' : 'false' }} }">
                            <x-admin.form.toggle name="pseo_enabled" label="Enable Programmatic Location Targeting" :value="$service->pseo_enabled ?? false" x-model="pseoEnabled" @click="pseoEnabled = !pseoEnabled" help="Generate programmatic search-landing pages mapped to countries, states, and cities." />

                            <div class="space-y-4 pt-2 border-t border-slate-100 dark:border-slate-800" x-show="pseoEnabled" x-transition :style="pseoEnabled ? '' : 'display: none;'">
                                <div class="p-3 bg-blue-50 dark:bg-blue-950/20 text-blue-800 dark:text-blue-300 rounded-lg text-xs leading-relaxed">
                                    <x-admin.icon name="seo" class="w-4 h-4 inline-block mr-1" />
                                    <strong>Template Placeholders:</strong> Use <code>{service}</code>, <code>{country}</code>, <code>{state}</code>, and <code>{city}</code> in templates below. The system will dynamically generate URLs and meta tags for every targeted location.
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <x-admin.form.textarea name="target_countries" label="Target Countries" placeholder="e.g. India, United States, United Kingdom" :rows="2" :value="$service->target_countries ?? ''" help="Comma-separated country list" />
                                    <x-admin.form.textarea name="target_states" label="Target States (Optional)" placeholder="e.g. California, Delhi, Texas, Maharashtra" :rows="2" :value="$service->target_states ?? ''" help="Comma-separated state list" />
                                    <x-admin.form.textarea name="target_cities" label="Target Cities (Optional)" placeholder="e.g. Mumbai, New York, Houston, London" :rows="2" :value="$service->target_cities ?? ''" help="Comma-separated city list" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-admin.form.input name="pseo_slug_template" label="URL Slug Template" :value="$service->pseo_slug_template ?? '{slug}-in-{city}'" :required="true" />
                                    <x-admin.form.input name="pseo_title_template" label="Meta Title Template" :value="$service->pseo_title_template ?? 'Best {service} in {city}, {state} | {brand_name}'" :required="true" />
                                </div>

                                <x-admin.form.textarea name="pseo_desc_template" label="Meta Description Template" :value="$service->pseo_desc_template ?? 'Looking for professional {service} in {city}? Contact {brand_name} for affordable, top-rated agency services in {city}, {state}.'" :rows="2" :required="true" />
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- SEO Schema and Meta tags -->
                    <x-admin.card title="SEO Settings & Custom Metadata">
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-admin.form.input name="seo_title" label="Meta Title Tag" placeholder="Title text for Google snippets" :value="$service->seo_title ?? ''" />
                                <x-admin.form.input name="canonical" label="Canonical URL Override" placeholder="e.g. https://everythingeasy.in/services/app-dev" :value="$service->canonical ?? ''" />
                            </div>
                            <x-admin.form.textarea name="meta_description" label="Meta Description Tag" placeholder="Short description shown beneath Title in search result listings (keep under 160 characters)..." :rows="2" :value="$service->meta_description ?? ''" />
                            <x-admin.form.input name="meta_keywords" label="Meta Keywords (Comma-separated)" placeholder="e.g. app development, custom android applications" :value="$service->meta_keywords ?? ''" />
                            
                            <hr class="border-slate-200 dark:border-slate-800" />
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Multiple Structured Schemas Injection</span>
                            
                            <x-admin.form.textarea name="schema_custom" label="Custom JSON-LD Schema Blocks (Optional)" placeholder="Paste one or multiple <script type=&quot;application/ld+json&quot;> tags consecutively:&#10;&#10;<script type=&quot;application/ld+json&quot;>&#10;{&#10;  &quot;@context&quot;: &quot;https://schema.org&quot;,&#10;  &quot;@type&quot;: &quot;Service&quot;,&#10;  ...&#10;}&#10;</script>&#10;&#10;<script type=&quot;application/ld+json&quot;>&#10;{&#10;  &quot;@context&quot;: &quot;https://schema.org&quot;,&#10;  &quot;@type&quot;: &quot;FAQPage&quot;,&#10;  ...&#10;}&#10;</script>" :rows="8" :value="$service->schema_custom ?? ''" help="Supports pasting multiple separate JSON-LD script blocks one after the other to inject multiple schemas simultaneously." />
                        </div>
                    </x-admin.card>

                    <!-- Generated Programmatic Landing Pages (Visual Logs) -->
                    <x-admin.card title="Generated Location Landing Pages (Programmatic Preview)" subtitle="Preview and audit the dynamically generated URL routes and meta tags compiled for target locations.">
                        <x-slot:actions>
                            <x-admin.button variant="secondary" size="xs" @click="alert('Export all location URLs')">Export URL Map</x-admin.button>
                        </x-slot:actions>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between gap-4 flex-wrap text-xs">
                                <div class="w-full sm:max-w-xs relative">
                                    <input 
                                        type="text" 
                                        placeholder="Search locations (e.g. Dehradun)..." 
                                        class="w-full pl-9 pr-4 py-1.5 border border-slate-200 dark:border-slate-800 rounded-lg text-xs bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100"
                                    />
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-admin.icon name="search" class="w-3.5 h-3.5 text-slate-400" />
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400 font-semibold font-mono">120 locations generated automatically</span>
                            </div>

                            <x-admin.table :headers="['Target Location', 'Dynamic Route URL', 'Meta Title Snippet', 'SEO Score', 'Actions']">
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-850 dark:text-slate-205 text-xs block leading-tight">Dehradun</span>
                                        <span class="text-[9px] text-slate-450 block mt-0.5">Uttarakhand, India 🇮🇳</span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-2xs text-slate-650 dark:text-slate-400">/services/website-development-in-dehradun</td>
                                    <td class="px-6 py-4 text-xs text-slate-500 max-w-xxs truncate">Best Website Development in Dehradun, Uttarakhand | EverythingEasy</td>
                                    <td class="px-6 py-4"><span class="px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 font-bold text-3xs font-mono">96%</span></td>
                                    <td class="px-6 py-4">
                                        <x-admin.button variant="secondary" size="xs" @click="alert('Preview Dehradun landing page')">Preview Page</x-admin.button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-850 dark:text-slate-205 text-xs block leading-tight">Mumbai</span>
                                        <span class="text-[9px] text-slate-450 block mt-0.5">Maharashtra, India 🇮🇳</span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-2xs text-slate-650 dark:text-slate-400">/services/website-development-in-mumbai</td>
                                    <td class="px-6 py-4 text-xs text-slate-500 max-w-xxs truncate">Best Website Development in Mumbai, Maharashtra | EverythingEasy</td>
                                    <td class="px-6 py-4"><span class="px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 font-bold text-3xs font-mono">94%</span></td>
                                    <td class="px-6 py-4">
                                        <x-admin.button variant="secondary" size="xs" @click="alert('Preview Mumbai landing page')">Preview Page</x-admin.button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-850 dark:text-slate-205 text-xs block leading-tight">New York</span>
                                        <span class="text-[9px] text-slate-450 block mt-0.5">New York, United States 🇺🇸</span>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-2xs text-slate-650 dark:text-slate-400">/services/website-development-in-new-york</td>
                                    <td class="px-6 py-4 text-xs text-slate-500 max-w-xxs truncate">Best Website Development in New York, New York | EverythingEasy</td>
                                    <td class="px-6 py-4"><span class="px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-950/20 text-emerald-700 dark:text-emerald-400 font-bold text-3xs font-mono">92%</span></td>
                                    <td class="px-6 py-4">
                                        <x-admin.button variant="secondary" size="xs" @click="alert('Preview New York landing page')">Preview Page</x-admin.button>
                                    </td>
                                </tr>
                            </x-admin.table>
                        </div>
                    </x-admin.card>
                </div>

                <!-- Right sidebar: Status & Images -->
                <div class="space-y-6">
                    <!-- Status Control -->
                    <x-admin.card title="Visibility & Status">
                        <div class="space-y-4">
                            <x-admin.form.toggle name="is_active" label="Published / Active" :value="$service->is_active ?? true" help="Immediately displays on public portfolios and sitemaps." />
                            <x-admin.form.toggle name="is_featured" label="Featured / Highlight" :value="$service->is_featured ?? false" help="Highlighted on homepage sliders." />
                        </div>
                    </x-admin.card>

                    <!-- Images Upload Card -->
                    <x-admin.card title="Media Showcase">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Featured Image (Cover)</label>
                                @if (($service->cover_image ?? null))
                                    <img src="{{ asset($service->cover_image) }}" class="h-20 w-full object-cover rounded-lg border border-slate-200 dark:border-slate-800 mb-2" />
                                @endif
                                <label class="block border-2 border-dashed border-slate-250 dark:border-slate-800 rounded-lg p-4 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                                    <x-admin.icon name="upload" class="w-8 h-8 text-slate-400 mx-auto" />
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-350 block mt-2">Click to upload cover image</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">JPEG, WebP, or PNG (Max 2MB)</span>
                                    <input type="file" name="cover_image" accept="image/*" class="hidden" onchange="this.closest('label').querySelector('span').textContent = this.files[0]?.name || 'Click to upload cover image'">
                                </label>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Project Gallery Showcase</label>
                                @if (!empty($service->gallery_images))
                                    <div class="grid grid-cols-3 gap-1.5 mb-2">
                                        @foreach ($service->gallery_images as $img)
                                            <img src="{{ asset($img) }}" class="h-14 w-full object-cover rounded-md border border-slate-200 dark:border-slate-800" />
                                        @endforeach
                                    </div>
                                @endif
                                <label class="block border-2 border-dashed border-slate-250 dark:border-slate-800 rounded-lg p-4 text-center cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-850 transition-colors">
                                    <x-admin.icon name="media" class="w-8 h-8 text-slate-400 mx-auto" />
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-350 block mt-2">Upload multiple files</span>
                                    <span class="text-[10px] text-slate-400 block mt-0.5">Images (adds to gallery)</span>
                                    <input type="file" name="gallery_images[]" accept="image/*" multiple class="hidden" onchange="this.closest('label').querySelector('span').textContent = this.files.length + ' file(s) selected'">
                                </label>
                            </div>
                        </div>
                    </x-admin.card>

                    <!-- Submission -->
                    <div class="sticky top-20 flex gap-3">
                        <x-admin.button type="submit" variant="primary" class="flex-1">
                            {{ $service ? 'Update Service' : 'Create Service' }}
                        </x-admin.button>
                        <x-admin.button type="button" variant="secondary" href="/admin/services">
                            Cancel
                        </x-admin.button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</x-layouts.admin>
