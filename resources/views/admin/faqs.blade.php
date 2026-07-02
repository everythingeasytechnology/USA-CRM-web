<x-layouts.admin active="faqs">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Accordion FAQ Manager']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ activeCategory: 'all', openCreate: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">FAQ Management</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure accordion FAQ segments, search answers, and sort their public listing sequence.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'faq-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4 mr-1.5" />
                    <span>Create FAQ</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Filter categories toolbar -->
        <x-admin.card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2 flex-wrap text-xs font-semibold">
                    <button type="button" @click="activeCategory = 'all'" :class="activeCategory === 'all' ? 'bg-blue-600/15 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 font-bold' : 'text-slate-500 hover:bg-slate-100'" class="px-3.5 py-2 rounded-lg transition-colors cursor-pointer">All Categories</button>
                    <button type="button" @click="activeCategory = 'general'" :class="activeCategory === 'general' ? 'bg-blue-600/15 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 font-bold' : 'text-slate-500 hover:bg-slate-100'" class="px-3.5 py-2 rounded-lg transition-colors cursor-pointer">General</button>
                    <button type="button" @click="activeCategory = 'pricing'" :class="activeCategory === 'pricing' ? 'bg-blue-600/15 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 font-bold' : 'text-slate-500 hover:bg-slate-100'" class="px-3.5 py-2 rounded-lg transition-colors cursor-pointer">Pricing & Refund</button>
                    <button type="button" @click="activeCategory = 'technical'" :class="activeCategory === 'technical' ? 'bg-blue-600/15 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 font-bold' : 'text-slate-500 hover:bg-slate-100'" class="px-3.5 py-2 rounded-lg transition-colors cursor-pointer">Technical / SEO</button>
                </div>
            </div>
        </x-admin.card>

        @php
            $faqs = [
                ['q' => 'What payment methods do you support for checkouts?', 'a' => 'We integrate Stripe, PayPal, Razorpay, and direct UPI transfers with sandbox toggles.', 'cat' => 'pricing', 'status' => true],
                ['q' => 'How does the sitemap regeneration operate?', 'a' => 'Anti Gravity CMS generates sitemaps weekly or automatically index-pushes via IndexNow API.', 'cat' => 'technical', 'status' => true],
                ['q' => 'Can I customize the primary and secondary branding colors?', 'a' => 'Yes. Admin Settings allows toggling accent colors via full spectrum color pickers.', 'cat' => 'general', 'status' => true],
                ['q' => 'Are legal policies compliance-ready?', 'a' => 'We support rich text revisions history logs for privacy and return policies.', 'cat' => 'general', 'status' => false],
            ];
        @endphp

        <!-- Accordions lists -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Question Title', 'Answer Content', 'Category Group', 'Status', 'Actions']">
                @foreach ($faqs as $faq)
                    <tr 
                        x-show="activeCategory === 'all' || activeCategory === '{{ $faq['cat'] }}'" 
                        class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors"
                    >
                        <td class="px-6 py-4 font-bold text-xs text-slate-850 dark:text-white max-w-xxs truncate">
                            {{ $faq['q'] }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400 max-w-xs truncate">
                            {{ $faq['a'] }}
                        </td>
                        <td class="px-6 py-4 text-2xs font-semibold capitalize text-slate-500">
                            {{ $faq['cat'] }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.form.toggle name="faq_active_{{ $loop->index }}" :value="$faq['status']" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1.5">
                                <x-admin.button variant="ghost" size="xs" @click="$dispatch('open-modal', 'faq-modal')" title="Edit FAQ"><x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" /></x-admin.button>
                                <x-admin.button variant="ghost" size="xs" class="text-red-500 hover:bg-red-50" @click="alert('Delete')" title="Delete FAQ"><x-admin.icon name="trash" class="w-4 h-4" /></x-admin.button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-admin.table>
        </x-admin.card>

        <!-- FAQ Modal Form -->
        <x-admin.modal name="faq-modal" title="Manage FAQ Item" maxW="md">
            <form action="#save-faq" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
                <x-admin.form.input name="faq_question" label="FAQ Question" placeholder="e.g. What is your refund policy?" :required="true" />
                
                <x-admin.form.select name="faq_cat" label="FAQ Category" :required="true">
                    <option value="general">General Queries</option>
                    <option value="pricing">Pricing & Refunds</option>
                    <option value="technical">Technical / SEO specs</option>
                </x-admin.form.select>

                <x-admin.form.textarea name="faq_answer" label="FAQ Answer" placeholder="Write full explanatory answer details..." :rows="4" :required="true" />
                
                <div class="flex items-center gap-3">
                    <x-admin.form.toggle name="faq_visible" label="Enabled / Visible" :value="true" />
                </div>
                
                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Save FAQ</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>
    </div>
</x-layouts.admin>
