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

        <!-- Accordions lists -->
        <x-admin.card :padding="false">
            <x-admin.table :headers="['Question Title', 'Answer Content', 'Category Group', 'Status', 'Actions']">
                @forelse ($faqs as $faq)
                    <tr
                        x-show="activeCategory === 'all' || activeCategory === '{{ $faq->category }}'"
                        class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors"
                    >
                        <td class="px-6 py-4 font-bold text-xs text-slate-850 dark:text-white max-w-xxs truncate">
                            {{ $faq->question }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-550 dark:text-slate-400 max-w-xs truncate">
                            {{ $faq->answer }}
                        </td>
                        <td class="px-6 py-4 text-2xs font-semibold capitalize text-slate-500">
                            {{ $faq->category }}
                        </td>
                        <td class="px-6 py-4">
                            <x-admin.toggle-form :action="'/admin/faqs/'.$faq->id.'/toggle-active'" :active="$faq->is_active" />
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-1.5">
                                <x-admin.button type="button" variant="ghost" size="xs" @click="$dispatch('open-modal', 'faq-edit-modal-{{ $faq->id }}')" title="Edit FAQ"><x-admin.icon name="pencil" class="w-4 h-4 text-slate-500" /></x-admin.button>
                                <x-admin.delete-form :action="'/admin/faqs/'.$faq->id" confirm="Delete this FAQ permanently?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer" title="Delete FAQ"><x-admin.icon name="trash" class="w-4 h-4" /></button>
                                </x-admin.delete-form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-xs text-slate-400">No FAQs created yet.</td>
                    </tr>
                @endforelse
            </x-admin.table>
        </x-admin.card>

        <!-- FAQ Modal Form (Create) -->
        <x-admin.modal name="faq-modal" title="Add FAQ Item" maxW="md">
            <form id="faq-create-form" action="/admin/faqs" method="POST" class="space-y-4">
                @csrf
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
            </form>
            <x-slot:footer>
                <x-admin.button type="submit" form="faq-create-form" variant="primary" size="sm">Save FAQ</x-admin.button>
                <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.modal>

        <!-- Edit Modals -->
        @foreach ($faqs as $faq)
            <x-admin.modal name="faq-edit-modal-{{ $faq->id }}" title="Edit FAQ Item" maxW="md">
                <form id="faq-edit-form-{{ $faq->id }}" action="/admin/faqs/{{ $faq->id }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-admin.form.input name="faq_question" label="FAQ Question" :value="$faq->question" :required="true" />

                    <x-admin.form.select name="faq_cat" label="FAQ Category" :required="true">
                        <option value="general" @selected($faq->category === 'general')>General Queries</option>
                        <option value="pricing" @selected($faq->category === 'pricing')>Pricing & Refunds</option>
                        <option value="technical" @selected($faq->category === 'technical')>Technical / SEO specs</option>
                    </x-admin.form.select>

                    <x-admin.form.textarea name="faq_answer" label="FAQ Answer" :rows="4" :value="$faq->answer" :required="true" />

                    <div class="flex items-center gap-3">
                        <x-admin.form.toggle name="faq_visible" label="Enabled / Visible" :value="$faq->is_active" />
                    </div>
                </form>
                <x-slot:footer>
                    <x-admin.button type="submit" form="faq-edit-form-{{ $faq->id }}" variant="primary" size="sm">Save Changes</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </x-admin.modal>
        @endforeach
    </div>
</x-layouts.admin>
