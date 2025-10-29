<x-app-layout :title="'Settings'" :navType="'admin'">
    <x-slot name="header">
        <h2 class="font-bold text-3xl sm:text-4xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 me-1" fill="none" viewBox="0 0 24 24"
                stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.594 3.94a1.125 1.125 0 011.11-.94h2.593a1.125 1.125 0 011.11.94l.213 1.281a1.125 1.125 0 00.645.87l.22.127a1.125 1.125 0 001.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827a1.125 1.125 0 00-.43.992c.008.378.137.75.43.991l1.004.827a1.125 1.125 0 01.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456a1.125 1.125 0 00-1.076.124l-.22.128a1.125 1.125 0 00-.644.869l-.213 1.281a1.125 1.125 0 01-1.11.94h-2.594a1.125 1.125 0 01-1.11-.94l-.213-1.281a1.125 1.125 0 00-.644-.87l-.22-.127a1.125 1.125 0 00-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827a1.125 1.125 0 00-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456a1.125 1.125 0 001.076-.124l.22-.128a1.125 1.125 0 00.644-.869l.214-1.28z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            {{ __('Settings') }}
        </h2>
        <p class="text-gray-600 text-base mt-1">
            Manage profile, account settings, records, and audit logs
        </p>
    </x-slot>

    <x-settings-tab></x-settings-tab>

    <x-white-card class="p-6 mb-4">
        <h3 class="text-2xl font-bold">Audit Logs</h3>
        <p class="text-base text-gray-700 mb-4">
            Showing {{ $auditLogs->count() }} of {{ $auditLogs->total() }} results
        </p>

        <table class="w-full text-left">
            <thead class="text-xs text-gray-600 uppercase">
                <tr>
                    <th class="p-2">Audit ID</th>
                    <th class="p-2">Full Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Action</th>
                    <th class="p-2">Action Time</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse ($auditLogs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">{{ $log->audit_id }}</td>
                        <td class="p-2">
                            {{ optional($log->user)->first_name }} {{ optional($log->user)->last_name }}
                        </td>
                        <td class="p-2">{{ optional($log->user)->email ?? 'N/A' }}</td>
                        <td class="p-2 text-green-600">{{ $log->action }}</td>
                        <td class="p-2">
                            {{ \Carbon\Carbon::parse($log->action_time)->format('Y-m-d h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">No audit logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex justify-end mt-4">
            <x-pagination :paginator="$auditLogs" />
        </div>
    </x-white-card>
</x-app-layout>
