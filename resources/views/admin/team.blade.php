<x-layouts.admin active="team">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Team Roster Control']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ openModal: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Team Members</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure company profiles, designations, employee bios, and active social coordinates.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <x-admin.button variant="primary" size="sm" @click="$dispatch('open-modal', 'team-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4 mr-1.5" />
                    <span>Add Member</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Team profiles grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $team = [
                    ['name' => 'Akhil Golu', 'role' => 'Senior Architect & Founder', 'bio' => '15+ years experience building Laravel CMS engines and premium dashboard solutions.', 'social' => 'linkedin.com/in/akhil'],
                    ['name' => 'Sarah Connor', 'role' => 'Principal SEO Engineer', 'bio' => 'Specializes in schema organization indexing and sitemaps performance audits.', 'social' => 'x.com/connor'],
                    ['name' => 'Diana Prince', 'role' => 'Lead UI/UX Designer', 'role_desc' => 'Crafts Stripe and Shopify inspired user workflows.', 'bio' => 'Focused on clean layouts and interactive micro-animations.', 'social' => 'instagram.com/diana'],
                ];
            @endphp

            @foreach ($team as $member)
                <x-admin.card :padding="true" class="text-center flex flex-col justify-between h-full">
                    <div class="space-y-4">
                        <!-- Avatar placeholder -->
                        <div class="mx-auto h-20 w-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center font-bold text-slate-700 dark:text-slate-200 text-lg border border-slate-200 dark:border-slate-750">
                            {{ $member['name'][0] }}
                        </div>
                        
                        <div>
                            <span class="text-sm font-bold text-slate-900 dark:text-white block">{{ $member['name'] }}</span>
                            <span class="text-2xs font-semibold text-blue-600 dark:text-blue-400 block mt-1">{{ $member['role'] }}</span>
                        </div>

                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed px-2">
                            {{ $member['bio'] }}
                        </p>
                    </div>

                    <!-- Social coordinates links -->
                    <div class="flex justify-center gap-3 border-t border-slate-100 dark:border-slate-800 pt-4 mt-6">
                        <a href="#lnk" class="text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                            <x-admin.icon name="social" class="w-4.5 h-4.5" />
                        </a>
                        <span class="text-slate-300 dark:text-slate-800">|</span>
                        <x-admin.button variant="link" size="xs" @click="$dispatch('open-modal', 'team-modal')" class="no-underline">Edit Profile</x-admin.button>
                    </div>
                </x-admin.card>
            @endforeach
        </div>

        <!-- Team Modal Form -->
        <x-admin.modal name="team-modal" title="Manage Team Member" maxW="md">
            <form action="#save-member" class="space-y-4" @submit.prevent="$dispatch('close-modal')">
                <x-admin.form.input name="member_name" label="Member Name" placeholder="e.g. Clark Kent" :required="true" />
                <x-admin.form.input name="member_role" label="Designation / Role" placeholder="e.g. Senior Copywriter" :required="true" />
                
                <x-admin.form.textarea name="member_bio" label="Short Biography" placeholder="Summarize professional bio in 2-3 lines..." :rows="3" />
                
                <x-admin.form.input name="member_social" label="Social Profile URL (LinkedIn / X)" placeholder="e.g. https://linkedin.com/in/username" />
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Avatar Image</label>
                    <div class="border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-lg p-4 text-center cursor-pointer hover:bg-slate-50 transition-colors">
                        <x-admin.icon name="upload" class="w-8 h-8 text-slate-400 mx-auto" />
                        <span class="text-xs font-semibold text-slate-650 dark:text-slate-350 block mt-2">Upload Profile picture</span>
                    </div>
                </div>

                <x-slot:footer>
                    <x-admin.button type="submit" variant="primary" size="sm">Save Profile</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </form>
        </x-admin.modal>
    </div>
</x-layouts.admin>
