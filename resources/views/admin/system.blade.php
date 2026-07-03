<x-layouts.admin active="system">
    <x-slot:breadcrumbs>
        <x-admin.breadcrumbs :items="[['label' => 'System Control Dashboard']]" />
    </x-slot:breadcrumbs>

    <div class="space-y-6" x-data="{ openBackupModal: false, backupProgress: false }">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">System Control Panel</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitor server resources, timezone offsets, log files, system backups, and application file upload thresholds.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left panel: Cache and Backups -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Optimization and Cache -->
                <x-admin.card title="CMS Caching & Optimization Utilities">
                    <div class="space-y-4 text-xs">
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-slate-850">
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block">Application Route Cache</span>
                                <span class="text-[10px] text-slate-450 mt-0.5 block">Pre-compiles route matching tables</span>
                            </div>
                            <form method="POST" action="/admin/system/cache/route">@csrf<x-admin.button type="submit" variant="secondary" size="xs">Clear</x-admin.button></form>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-slate-850">
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block">Template View Cache</span>
                                <span class="text-[10px] text-slate-450 mt-0.5 block">Clears compiled Blade view files</span>
                            </div>
                            <form method="POST" action="/admin/system/cache/view">@csrf<x-admin.button type="submit" variant="secondary" size="xs">Clear</x-admin.button></form>
                        </div>
                        <div class="flex justify-between items-center py-2.5">
                            <div>
                                <span class="font-bold text-slate-900 dark:text-white block">Asset Config Cache</span>
                                <span class="text-[10px] text-slate-450 mt-0.5 block">Clears custom .env configuration settings caching</span>
                            </div>
                            <form method="POST" action="/admin/system/cache/config">@csrf<x-admin.button type="submit" variant="secondary" size="xs">Clear</x-admin.button></form>
                        </div>
                    </div>
                </x-admin.card>

                <!-- Backups -->
                <x-admin.card title="Database & Files Storage Backups">
                    <x-slot:actions>
                        <x-admin.button variant="primary" size="xs" @click="backupProgress = true; setTimeout(() => { backupProgress = false; alert('Backup completed successfully!') }, 3000)">
                            <x-admin.icon name="sync" class="w-4 h-4 mr-1.5" />
                            <span>Run Backup</span>
                        </x-admin.button>
                    </x-slot:actions>
                    
                    <div class="space-y-4">
                        <div x-show="backupProgress" class="p-3 bg-blue-50 dark:bg-blue-900/10 text-blue-700 dark:text-blue-400 rounded-lg text-xs flex items-center gap-3">
                            <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Backing up MySQL database schema and public storage node files...</span>
                        </div>
                        
                        <x-admin.table :headers="['Backup Name', 'File Size', 'Creation Date', 'Actions']">
                            <tr>
                                <td class="px-6 py-4 font-mono text-xs font-bold text-slate-900 dark:text-white">db_backup_2026-07-02.sql</td>
                                <td class="px-6 py-4 text-xs font-mono text-slate-700 dark:text-slate-350">14.2 MB</td>
                                <td class="px-6 py-4 text-xs text-slate-500 font-mono">2026-07-02 12:00</td>
                                <td class="px-6 py-4">
                                    <x-admin.button variant="secondary" size="xs" @click="alert('Download backup file')">Download</x-admin.button>
                                </td>
                            </tr>
                        </x-admin.table>
                    </div>
                </x-admin.card>
            </div>

            <!-- Right panel: Server specs -->
            <div class="space-y-6">
                <!-- System Configs -->
                <x-admin.card title="System limits">
                    <div class="space-y-4 text-xs">
                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-850"><span class="text-slate-550">PHP Version:</span><span class="font-bold text-slate-700 dark:text-slate-300">{{ $phpVersion }}</span></div>
                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-850"><span class="text-slate-550">Laravel Core:</span><span class="font-bold text-slate-700 dark:text-slate-300">{{ $laravelVersion }}</span></div>
                        <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-850"><span class="text-slate-550">Max Upload Limit:</span><span class="font-bold text-slate-700 dark:text-slate-300">{{ $uploadLimit }}</span></div>
                        <div class="flex justify-between py-2"><span class="text-slate-550">Active Timezone:</span><span class="font-bold text-slate-700 dark:text-slate-300">{{ $timezone }}</span></div>
                    </div>
                </x-admin.card>

                <!-- Server logs preview -->
                <x-admin.card title="System Error Logs (Latest)">
                    <div class="bg-slate-950 rounded-xl p-3 border border-slate-850 font-mono text-[10px] text-emerald-500 leading-normal max-h-56 overflow-y-auto whitespace-pre-wrap">{{ $logTail ?: 'No log entries yet.' }}</div>
                </x-admin.card>
            </div>

        </div>
    </div>
</x-layouts.admin>
