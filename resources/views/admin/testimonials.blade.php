<x-layouts.admin active="testimonials">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Customer Reviews Settings']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ openModal: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Customer Testimonials</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage corporate reviews, rating scores, client roles, and home landing section features.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'testimonial-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4 mr-1.5" />
                    <span>Add Testimonial</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Testimonials Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $testimonials = [
                    ['name' => 'Sherlock Holmes', 'org' => 'Watson Consultancy Group', 'review' => 'Anti Gravity CMS is incredibly fast. The JSON-LD schema generators and instant sitemaps boosted our SEO ranking significantly. Excellent UX simple layout.', 'rating' => 5, 'status' => true],
                    ['name' => 'Adler Irene', 'org' => 'Opera Bohemia Inc.', 'review' => 'Managing services packages and coupon discount checkouts has never been this simple. Reusable blade configurations saved us hundreds of dev hours.', 'rating' => 5, 'status' => true],
                    ['name' => 'Mycroft Holmes', 'org' => 'Diogenes Government Registry', 'review' => 'Simple UI setup with class-based dark mode toggles. Meets all compliance security parameters. Highly stable CMS core.', 'rating' => 4, 'status' => false],
                ];
            @endphp

            @foreach ($testimonials as $review)
                <x-admin.card :padding="true" class="flex flex-col justify-between h-full relative group">
                    <x-slot:actions>
                        <x-admin.form.toggle name="tst_active_{{ $loop->index }}" :value="$review['status']" />
                    </x-slot:actions>
                    
                    <div class="space-y-4">
                        <!-- Rating Stars -->
                        <div class="flex items-center text-amber-400 gap-0.5">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-4.5 h-4.5 {{ $i <= $review['rating'] ? 'fill-current' : 'text-slate-200' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>

                        <!-- Review Text -->
                        <p class="text-xs text-slate-600 dark:text-slate-350 italic leading-relaxed">
                            "{{ $review['review'] }}"
                        </p>
                    </div>

                    <!-- Client Profile -->
                    <div class="flex items-center gap-3 border-t border-slate-100 dark:border-slate-800 pt-4 mt-6">
                        <div class="h-9 w-9 rounded-full bg-slate-100 dark:bg-slate-850 flex items-center justify-center font-bold text-xs text-slate-700 dark:text-slate-300">
                            {{ $review['name'][0] }}
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white block">{{ $review['name'] }}</span>
                            <span class="text-[10px] text-slate-500 block mt-0.5">{{ $review['org'] }}</span>
                        </div>
                    </div>
                </x-admin.card>
            @endforeach
        </div>

        <!-- Add Testimonial Modal -->
        <x-admin.modal name="testimonial-modal" title="Manage Client Review" maxW="md">
            <form action="#save-testimonial" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
                <x-admin.form.input name="client_name" label="Client Name" placeholder="e.g. John Watson" :required="true" />
                <x-admin.form.input name="client_company" label="Designation & Organization" placeholder="e.g. CEO, Watson Agency" :required="true" />
                
                <x-admin.form.select name="client_rating" label="Rating Score">
                    <option value="5">★★★★★ (5 Stars)</option>
                    <option value="4">★★★★☆ (4 Stars)</option>
                    <option value="3">★★★☆☆ (3 Stars)</option>
                </x-admin.form.select>

                <x-admin.form.textarea name="client_review" label="Review Content" placeholder="Paste client endorsement content..." :rows="4" :required="true" />
                
                <div class="flex items-center gap-3">
                    <x-admin.form.toggle name="client_status_active" label="Enabled / Visible" :value="true" />
                </div>
                
                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Save Review</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>
    </div>
</x-layouts.admin>
