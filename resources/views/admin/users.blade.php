<x-layouts.admin active="users">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'Users & Roles Settings']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ activeTab: 'users' }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Users, Roles & Permissions</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage staff user profiles, permission matrices, custom security roles, and review audit logs.</p>
            </div>

            <div class="flex items-center gap-2.5">
                <div class="flex items-center gap-1 border border-slate-200 dark:border-slate-800 rounded-lg p-1 bg-slate-50 dark:bg-slate-900/50 text-xs">
                    <button type="button" @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                        Staff Users
                    </button>
                    <button type="button" @click="activeTab = 'matrix'" :class="activeTab === 'matrix' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                        Roles Matrix
                    </button>
                </div>
                <x-admin.button type="button" variant="primary" size="sm" @click="$dispatch('open-modal', 'user-create-modal')">
                    <x-admin.icon name="plus" class="w-4 h-4 mr-1.5" />
                    <span>Add User</span>
                </x-admin.button>
            </div>
        </div>

        <!-- Tab 1: Staff Users list -->
        <div x-show="activeTab === 'users'" class="space-y-6">
            <x-admin.card :padding="false">
                <x-admin.table :headers="['User / Email', 'Designation Role', 'Created Date', 'Status', 'Actions']">
                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 dark:text-white text-xs block leading-tight">{{ $user->name }}</span>
                                <span class="text-[10px] text-slate-500 block mt-0.5">{{ $user->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                                {{ $user->role }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                                {{ $user->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.badge variant="{{ $user->is_active ? 'success' : 'neutral' }}">
                                    {{ $user->is_active ? 'Active' : 'Suspended' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-6 py-4 flex gap-1.5">
                                <x-admin.button type="button" variant="secondary" size="xs" @click="$dispatch('open-modal', 'user-edit-modal-{{ $user->id }}')">Edit</x-admin.button>
                                <x-admin.delete-form :action="'/admin/users/'.$user->id" confirm="Remove this staff user?">
                                    <button type="submit" class="inline-flex items-center justify-center p-1.5 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 cursor-pointer"><x-admin.icon name="trash" class="w-4 h-4" /></button>
                                </x-admin.delete-form>
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table>
            </x-admin.card>
        </div>

        <!-- Create User Modal -->
        <x-admin.modal name="user-create-modal" title="Add Staff User" maxW="md">
            <form id="user-create-form" action="/admin/users" method="POST" class="space-y-4">
                @csrf
                <x-admin.form.input name="name" label="Full Name" :required="true" />
                <x-admin.form.input name="email" type="email" label="Email Address" :required="true" />
                <x-admin.form.select name="role" label="Role">
                    <option value="Administrator">Administrator</option>
                    <option value="Editor">Editor</option>
                    <option value="SEO Manager">SEO Manager</option>
                    <option value="Content Writer">Content Writer</option>
                    <option value="Sales Team">Sales Team</option>
                </x-admin.form.select>
                <x-admin.form.input name="password" type="password" label="Initial Password" :required="true" />
                <x-admin.form.toggle name="is_active" label="Active" :value="true" />
            </form>
            <x-slot:footer>
                <x-admin.button type="submit" form="user-create-form" variant="primary" size="sm">Create User</x-admin.button>
                <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
            </x-slot:footer>
        </x-admin.modal>

        <!-- Edit User Modals -->
        @foreach ($users as $user)
            <x-admin.modal name="user-edit-modal-{{ $user->id }}" title="Edit Staff User" maxW="md">
                <form id="user-edit-form-{{ $user->id }}" action="/admin/users/{{ $user->id }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <x-admin.form.input name="name" label="Full Name" :value="$user->name" :required="true" />
                    <x-admin.form.input name="email" type="email" label="Email Address" :value="$user->email" :required="true" />
                    <x-admin.form.select name="role" label="Role">
                        @foreach (['Administrator', 'Editor', 'SEO Manager', 'Content Writer', 'Sales Team'] as $roleOption)
                            <option value="{{ $roleOption }}" @selected($user->role === $roleOption)>{{ $roleOption }}</option>
                        @endforeach
                    </x-admin.form.select>
                    <x-admin.form.input name="password" type="password" label="New Password" help="Leave blank to keep current password" />
                    <x-admin.form.toggle name="is_active" label="Active" :value="$user->is_active" />
                </form>
                <x-slot:footer>
                    <x-admin.button type="submit" form="user-edit-form-{{ $user->id }}" variant="primary" size="sm">Save Changes</x-admin.button>
                    <x-admin.button type="button" variant="secondary" size="sm" @click="$dispatch('close-modal')">Cancel</x-admin.button>
                </x-slot:footer>
            </x-admin.modal>
        @endforeach

        <!-- Tab 2: Permission Matrix -->
        <div x-show="activeTab === 'matrix'" class="space-y-6" style="display: none;">
            <x-admin.card title="System Security Permissions Matrix">
                <form action="#save-matrix" @submit.prevent="alert('Roles permissions updated!')">
                    <x-admin.table :headers="['Permission Node', 'Admin', 'Editor', 'SEO Mgr', 'Writer']">
                        <tr>
                            <td class="px-6 py-4 font-bold text-xs text-slate-900 dark:text-white">Flush System Cache</td>
                            <td class="px-6 py-4"><input type="checkbox" checked disabled /></td>
                            <td class="px-6 py-4"><input type="checkbox" /></td>
                            <td class="px-6 py-4"><input type="checkbox" /></td>
                            <td class="px-6 py-4"><input type="checkbox" disabled /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-bold text-xs text-slate-900 dark:text-white">Edit robots.txt & Redirects</td>
                            <td class="px-6 py-4"><input type="checkbox" checked disabled /></td>
                            <td class="px-6 py-4"><input type="checkbox" /></td>
                            <td class="px-6 py-4"><input type="checkbox" checked /></td>
                            <td class="px-6 py-4"><input type="checkbox" disabled /></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-bold text-xs text-slate-900 dark:text-white">Publish Blog Articles</td>
                            <td class="px-6 py-4"><input type="checkbox" checked disabled /></td>
                            <td class="px-6 py-4"><input type="checkbox" checked /></td>
                            <td class="px-6 py-4"><input type="checkbox" /></td>
                            <td class="px-6 py-4"><input type="checkbox" checked /></td>
                        </tr>
                    </x-admin.table>

                    <div class="flex justify-end mt-4">
                        <x-admin.button type="submit" variant="primary">
                            Save Matrix Settings
                        </x-admin.button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>
</x-layouts.admin>
