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
            
            <div class="flex items-center gap-1 border border-slate-200 dark:border-slate-800 rounded-lg p-1 bg-slate-50 dark:bg-slate-900/50 text-xs">
                <button type="button" @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Staff Users
                </button>
                <button type="button" @click="activeTab = 'matrix'" :class="activeTab === 'matrix' ? 'bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-2xs font-semibold' : 'text-slate-505'" class="px-3 py-1.5 rounded-md cursor-pointer">
                    Roles Matrix
                </button>
            </div>
        </div>

        <!-- Tab 1: Staff Users list -->
        <div x-show="activeTab === 'users'" class="space-y-6">
            <x-admin.card :padding="false">
                <x-admin.table :headers="['User / Email', 'Designation Role', 'Created Date', 'Status', 'Actions']">
                    @php
                        $users = [
                            ['name' => 'Akhil Golu', 'email' => 'akhil@everythingeasy.in', 'role' => 'Administrator', 'date' => '2026-07-02', 'status' => true],
                            ['name' => 'Sarah Connor', 'email' => 'sarah@sky.net', 'role' => 'SEO Manager', 'date' => '2026-07-01', 'status' => true],
                            ['name' => 'Diana Prince', 'email' => 'diana@themyscira.org', 'role' => 'Editor', 'date' => '2026-06-28', 'status' => true],
                            ['name' => 'Clark Kent', 'email' => 'clark@dailyplanet.co', 'role' => 'Content Writer', 'date' => '2026-06-15', 'status' => false],
                        ];
                    @endphp

                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-850/20 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900 dark:text-white text-xs block leading-tight">{{ $user['name'] }}</span>
                                <span class="text-[10px] text-slate-500 block mt-0.5">{{ $user['email'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">
                                {{ $user['role'] }}
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                                {{ $user['date'] }}
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.badge variant="{{ $user['status'] ? 'success' : 'neutral' }}">
                                    {{ $user['status'] ? 'Active' : 'Suspended' }}
                                </x-admin.badge>
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.button variant="secondary" size="xs" @click="alert('Edit user settings')">Edit</x-admin.button>
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table>
            </x-admin.card>
        </div>

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
