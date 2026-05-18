<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('School Visitor Logbook') }}
            </h2>
            <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-visitor')">
                {{ __('Add Visitor') }}
            </x-primary-button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-700 text-sm rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="p-4 bg-red-50 border-l-4 border-red-400 text-red-700 text-sm rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Panel -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-white border border-gray-200 shadow-sm sm:rounded-lg">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Visitors Today') }}</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['total_today'] }}</div>
                </div>
                <div class="p-6 bg-white border border-gray-200 shadow-sm sm:rounded-lg">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Currently Checked In') }}</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['currently_in'] }}</div>
                </div>
                <div class="p-6 bg-white border border-gray-200 shadow-sm sm:rounded-lg">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Checked Out Today') }}</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['checked_out_today'] }}</div>
                </div>
            </div>

            <!-- Visitors Table Card -->
            <div class="bg-white border border-gray-200 shadow-sm sm:rounded-lg">
                <!-- Control/Filter Panel -->
                <div class="p-6 border-b border-gray-200 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <x-input-label for="date-filter" :value="__('Filter by Date:')" class="whitespace-nowrap font-medium" />
                        <x-text-input type="date" id="date-filter" name="date" value="{{ $selectedDateStr }}" onchange="this.form.submit()" />
                        @if($selectedDateStr !== \Carbon\Carbon::today()->toDateString())
                            <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium ml-2">
                                {{ __('Reset to Today') }}
                            </a>
                        @endif
                    </form>
                    
                    <div class="text-sm text-gray-600">
                        {{ __('Showing entries for:') }} <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($selectedDateStr)->format('Y-m-d') }}</span>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Purpose of Visit') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Time In') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Time Out') }}</th>
                                <th scope="col" class="relative px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($visitors as $visitor)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $visitor->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $visitor->purpose }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($visitor->status === 'In')
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ __('In') }}
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                {{ __('Out') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visitor->time_in->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $visitor->time_out ? $visitor->time_out->format('Y-m-d H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($visitor->status === 'In')
                                                <!-- Quick Checkout -->
                                                <form action="{{ route('visitors.checkout', $visitor) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <x-primary-button type="submit" class="text-xs py-1 px-3">
                                                        {{ __('Check Out') }}
                                                    </x-primary-button>
                                                </form>
                                            @endif

                                            <!-- Edit Action -->
                                            <x-secondary-button 
                                                x-data=""
                                                x-on:click="$dispatch('open-modal', 'edit-visitor'); $dispatch('fill-edit-form', { 
                                                    id: '{{ $visitor->id }}', 
                                                    name: '{{ addslashes($visitor->name) }}', 
                                                    purpose: '{{ addslashes($visitor->purpose) }}', 
                                                    time_in: '{{ $visitor->time_in->format('Y-m-d\TH:i') }}', 
                                                    time_out: '{{ $visitor->time_out ? $visitor->time_out->format('Y-m-d\TH:i') : '' }}' 
                                                })"
                                                class="text-xs py-1 px-3">
                                                {{ __('Edit') }}
                                            </x-secondary-button>

                                            <!-- Delete Action -->
                                            <form action="{{ route('visitors.destroy', $visitor) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this visitor entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button type="submit" class="text-xs py-1 px-3">
                                                    {{ __('Delete') }}
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                        {{ __('No visitor records found for this date.') }}
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
    <x-modal name="add-visitor" focusable>
        <form method="POST" action="{{ route('visitors.store') }}" class="p-6">
            @csrf
            
            <h2 class="text-lg font-semibold text-gray-900 mb-5">
                {{ __('Register New Visitor') }}
            </h2>

            <div class="space-y-4">
                <div>
                    <x-input-label for="add-name" :value="__('Visitor\'s Name')" />
                    <x-text-input id="add-name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="add-purpose" :value="__('Purpose of Visit')" />
                    <x-text-input id="add-purpose" name="purpose" type="text" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="add-time-in" :value="__('Time In')" />
                        <x-text-input id="add-time-in" name="time_in" type="datetime-local" class="mt-1 block w-full" value="{{ now()->format('Y-m-d\TH:i') }}" required />
                        <x-input-error :messages="$errors->get('time_in')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="add-time-out" :value="__('Time Out (Optional)')" />
                        <x-text-input id="add-time-out" name="time_out" type="datetime-local" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('time_out')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button>
                    {{ __('Save Entry') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <!-- EDIT VISITOR MODAL -->
    <x-modal name="edit-visitor" focusable>
        <div x-data="{ id: '', name: '', purpose: '', time_in: '', time_out: '' }"
             x-on:fill-edit-form.window="
                 id = $event.detail.id;
                 name = $event.detail.name;
                 purpose = $event.detail.purpose;
                 time_in = $event.detail.time_in;
                 time_out = $event.detail.time_out;
             ">
            <form method="POST" :action="'{{ url('visitors') }}/' + id" class="p-6">
                @csrf
                @method('PUT')

                <h2 class="text-lg font-semibold text-gray-900 mb-5">
                    {{ __('Edit Visitor Entry') }}
                </h2>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="edit-name" :value="__('Visitor\'s Name')" />
                        <x-text-input id="edit-name" name="name" type="text" class="mt-1 block w-full" x-model="name" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit-purpose" :value="__('Purpose of Visit')" />
                        <x-text-input id="edit-purpose" name="purpose" type="text" class="mt-1 block w-full" x-model="purpose" required />
                        <x-input-error :messages="$errors->get('purpose')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="edit-time-in" :value="__('Time In')" />
                            <x-text-input id="edit-time-in" name="time_in" type="datetime-local" class="mt-1 block w-full" x-model="time_in" required />
                            <x-input-error :messages="$errors->get('time_in')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="edit-time-out" :value="__('Time Out (Optional)')" />
                            <x-text-input id="edit-time-out" name="time_out" type="datetime-local" class="mt-1 block w-full" x-model="time_out" />
                            <x-input-error :messages="$errors->get('time_out')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button>
                        {{ __('Update Entry') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
