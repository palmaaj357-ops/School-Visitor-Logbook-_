<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center gap-2">
                    <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-16.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-16.25v14.25"></path>
                    </svg>
                    School Visitor Logbook
                </h2>
                <p class="text-sm text-gray-500 mt-1">Manage, monitor, and record all campus visitors efficiently.</p>
            </div>
            
            <!-- Quick Actions -->
            <div x-data="{}" class="flex items-center gap-3">
                <button @click="$dispatch('open-add-modal')" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-all duration-150 ease-in-out gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                    </svg>
                    Add Visitor
                </button>
            </div>
        </div>
    </x-slot>

    <!-- Notification Toast System -->
    @if(session('success') || session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2 md:translate-y-0 md:translate-x-2"
             x-transition:enter-end="opacity-100 translate-y-0 md:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed bottom-4 right-4 z-50 max-w-sm w-full bg-white rounded-xl shadow-lg border {{ session('success') ? 'border-green-100' : 'border-red-100' }} p-4 overflow-hidden">
            <div class="flex items-start gap-3">
                @if(session('success'))
                    <span class="p-1.5 bg-green-50 text-green-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"></path>
                        </svg>
                    </span>
                @else
                    <span class="p-1.5 bg-red-50 text-red-600 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path>
                        </svg>
                    </span>
                @endif
                <div class="flex-1">
                    <h4 class="font-semibold text-sm text-gray-900">{{ session('success') ? 'Success' : 'Error' }}</h4>
                    <p class="text-xs text-gray-500 mt-0.5">{{ session('success') ?? session('error') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="py-8 bg-gray-50/50 min-h-[calc(100vh-4rem)]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Statistics Panel -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition-all hover:shadow-md hover:border-gray-200">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Visitors Today</span>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['total_today'] }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.482 11.968 11.968 0 013 18.24V16.5a4.125 4.125 0 017.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M14.214 16.058A9.39 9.39 0 0018.82 14c1 .022 1.99.27 2.887.724a4.124 4.124 0 00-4.108-3.776M14.214 16.058A9.397 9.397 0 0110 14c-.098 0-.196 0-.294.002a4.127 4.127 0 00-4.116 3.778m14.214-1.724a9.34 9.34 0 00-3.32-4.194M14.214 16.058a9.397 9.397 0 00-3.32-4.194M14.25 7.5a3 3 0 11-6 0 3 3 0 016 0zM17.25 9.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition-all hover:shadow-md hover:border-gray-200">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Currently Checked In</span>
                        <h3 class="text-3xl font-extrabold text-gray-900 flex items-center gap-2">
                            {{ $stats['currently_in'] }}
                            @if($stats['currently_in'] > 0)
                                <span class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                </span>
                            @endif
                        </h3>
                    </div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between transition-all hover:shadow-md hover:border-gray-200">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Checked Out Today</span>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['checked_out_today'] }}</h3>
                    </div>
                    <div class="p-3 bg-gray-50 text-gray-500 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Control Panel -->
                <div class="p-6 border-b border-gray-100 bg-gray-50/30 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Date Filter -->
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-3 w-full sm:w-auto">
                        <label for="date-filter" class="text-sm font-semibold text-gray-700 whitespace-nowrap">Filter by Date:</label>
                        <div class="relative w-full sm:w-48">
                            <input type="date" 
                                   id="date-filter" 
                                   name="date" 
                                   value="{{ $selectedDateStr }}" 
                                   onchange="this.form.submit()"
                                   class="w-full pl-3 pr-10 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                        @if($selectedDateStr !== \Carbon\Carbon::today()->toDateString())
                            <a href="{{ route('dashboard') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-semibold whitespace-nowrap">
                                Reset to Today
                            </a>
                        @endif
                    </form>

                    <!-- Active Filter Badge -->
                    <div class="text-xs font-medium text-gray-500 flex items-center gap-1">
                        Showing entries for: 
                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 font-bold rounded-full">
                            {{ \Carbon\Carbon::parse($selectedDateStr)->format('M d, Y') }}
                        </span>
                    </div>
                </div>

                <!-- Table View -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Visitor Details</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Purpose of Visit</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Time In</th>
                                <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Time Out</th>
                                <th scope="col" class="relative px-6 py-3.5 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($visitors as $visitor)
                                <tr class="hover:bg-gray-50/30 transition-colors duration-150">
                                    <!-- Name & Date -->
                                    <td class="px-6 py-4.5 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-indigo-50 text-indigo-700 font-bold text-sm rounded-full flex items-center justify-center">
                                                {{ strtoupper(substr($visitor->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-sm text-gray-900">{{ $visitor->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $visitor->visit_date }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Purpose -->
                                    <td class="px-6 py-4.5">
                                        <p class="text-sm text-gray-600 line-clamp-2 max-w-xs">{{ $visitor->purpose }}</p>
                                    </td>
                                    <!-- Status -->
                                    <td class="px-6 py-4.5 whitespace-nowrap">
                                        @if($visitor->status === 'In')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-green-700 bg-green-50 rounded-full ring-1 ring-green-600/20">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Checked In
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold text-gray-600 bg-gray-50 rounded-full ring-1 ring-gray-500/10">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Checked Out
                                            </span>
                                        @endif
                                    </td>
                                    <!-- Time In -->
                                    <td class="px-6 py-4.5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-700">{{ $visitor->time_in->format('h:i A') }}</div>
                                    </td>
                                    <!-- Time Out -->
                                    <td class="px-6 py-4.5 whitespace-nowrap">
                                        @if($visitor->time_out)
                                            <div class="text-sm font-medium text-gray-700">{{ $visitor->time_out->format('h:i A') }}</div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Still inside</span>
                                        @endif
                                    </td>
                                    <!-- Actions -->
                                    <td class="px-6 py-4.5 whitespace-nowrap text-right text-sm font-medium">
                                        <div x-data="{}" class="flex items-center justify-end gap-2.5">
                                            @if($visitor->status === 'In')
                                                <!-- Quick Checkout -->
                                                <form action="{{ route('visitors.checkout', $visitor) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            title="Check Out Now"
                                                            class="inline-flex items-center justify-center p-1.5 text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Edit Action -->
                                            <button @click="$dispatch('open-edit-modal', { 
                                                        id: '{{ $visitor->id }}', 
                                                        name: '{{ addslashes($visitor->name) }}', 
                                                        purpose: '{{ addslashes($visitor->purpose) }}', 
                                                        time_in: '{{ $visitor->time_in->format('Y-m-d\TH:i') }}', 
                                                        time_out: '{{ $visitor->time_out ? $visitor->time_out->format('Y-m-d\TH:i') : '' }}' 
                                                    })"
                                                    title="Edit Entry"
                                                    class="inline-flex items-center justify-center p-1.5 text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                                </svg>
                                            </button>

                                            <!-- Delete Action -->
                                            <form action="{{ route('visitors.destroy', $visitor) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log entry? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        title="Delete Entry"
                                                        class="inline-flex items-center justify-center p-1.5 text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 20.482 11.968 11.968 0 013 18.24V16.5a4.125 4.125 0 017.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M14.214 16.058A9.39 9.39 0 0018.82 14c1 .022 1.99.27 2.887.724a4.124 4.124 0 00-4.108-3.776M14.214 16.058A9.397 9.397 0 0110 14c-.098 0-.196 0-.294.002a4.127 4.127 0 00-4.116 3.778m14.214-1.724a9.34 9.34 0 00-3.32-4.194M14.214 16.058a9.397 9.397 0 00-3.32-4.194M14.25 7.5a3 3 0 11-6 0 3 3 0 016 0zM17.25 9.75a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                            </svg>
                                            <h4 class="mt-4 font-bold text-sm text-gray-900">No visitors logged</h4>
                                            <p class="text-xs text-gray-400 mt-1 max-w-[240px] leading-normal">There are no records for this date. Click the "Add Visitor" button to create a new log.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD VISITOR MODAL -->
    <div x-data="{ isOpen: false, timeIn: '{{ now()->format('Y-m-d\TH:i') }}' }" 
         x-show="isOpen"
         @open-add-modal.window="isOpen = true"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" @click="isOpen = false"></div>

        <!-- Modal Wrapper -->
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-xl border border-gray-100 transition-all max-w-md w-full space-y-5">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="p-1 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        Register New Visitor
                    </h3>
                    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form action="{{ route('visitors.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Name Input -->
                    <div class="space-y-1">
                        <label for="add-name" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Visitor's Name</label>
                        <input type="text" 
                               id="add-name" 
                               name="name" 
                               required
                               placeholder="e.g. Jane Doe"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>

                    <!-- Purpose Input -->
                    <div class="space-y-1">
                        <label for="add-purpose" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Purpose of Visit</label>
                        <input type="text" 
                               id="add-purpose" 
                               name="purpose" 
                               required
                               placeholder="e.g. Parent-Teacher meeting"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Time In -->
                        <div class="space-y-1">
                            <label for="add-time-in" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Time In</label>
                            <input type="datetime-local" 
                                   id="add-time-in" 
                                   name="time_in" 
                                   required
                                   x-model="timeIn"
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>

                        <!-- Time Out (optional) -->
                        <div class="space-y-1">
                            <label for="add-time-out" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Time Out <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="datetime-local" 
                                   id="add-time-out" 
                                   name="time_out" 
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="isOpen = false" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                            Save Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT VISITOR MODAL -->
    <div x-data="{ isOpen: false, id: '', name: '', purpose: '', time_in: '', time_out: '' }" 
         x-show="isOpen"
         @open-edit-modal.window="
            isOpen = true;
            id = $event.detail.id;
            name = $event.detail.name;
            purpose = $event.detail.purpose;
            time_in = $event.detail.time_in;
            time_out = $event.detail.time_out;
         "
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" @click="isOpen = false"></div>

        <!-- Modal Wrapper -->
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <div x-show="isOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white p-6 text-left shadow-xl border border-gray-100 transition-all max-w-md w-full space-y-5">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="p-1 bg-indigo-50 text-indigo-600 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                            </svg>
                        </span>
                        Edit Visitor Entry
                    </h3>
                    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form :action="'{{ url('visitors') }}/' + id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <!-- Name Input -->
                    <div class="space-y-1">
                        <label for="edit-name" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Visitor's Name</label>
                        <input type="text" 
                               id="edit-name" 
                               name="name" 
                               required
                               x-model="name"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>

                    <!-- Purpose Input -->
                    <div class="space-y-1">
                        <label for="edit-purpose" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Purpose of Visit</label>
                        <input type="text" 
                               id="edit-purpose" 
                               name="purpose" 
                               required
                               x-model="purpose"
                               class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Time In -->
                        <div class="space-y-1">
                            <label for="edit-time-in" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Time In</label>
                            <input type="datetime-local" 
                                   id="edit-time-in" 
                                   name="time_in" 
                                   required
                                   x-model="time_in"
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>

                        <!-- Time Out -->
                        <div class="space-y-1">
                            <label for="edit-time-out" class="text-xs font-bold text-gray-500 uppercase tracking-wider">Time Out <span class="text-gray-400 font-normal">(Optional)</span></label>
                            <input type="datetime-local" 
                                   id="edit-time-out" 
                                   name="time_out" 
                                   x-model="time_out"
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-3">
                        <button type="button" @click="isOpen = false" class="px-4 py-2 border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-semibold rounded-lg transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors">
                            Update Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
