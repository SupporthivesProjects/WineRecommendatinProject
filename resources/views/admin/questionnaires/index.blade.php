<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Questionnaire Templates') }}
            </h2>
            <a href="{{ route('admin.questionnaires.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition">
                Create Template
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Name</th>
                                    <th class="py-3 px-6 text-left">Level</th>
                                    <th class="py-3 px-6 text-left">Questions</th>
                                    <th class="py-3 px-6 text-left">Status</th>
                                    <th class="py-3 px-6 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm">
                                @if(count($templates) > 0)
                                    @foreach($templates as $template)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                                        <td class="py-3 px-6 text-left">{{ $template->id }}</td>
                                        <td class="py-3 px-6 text-left">{{ $template->name }}</td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="bg-{{ $template->level === 'first_sip' ? 'green' : ($template->level === 'savy_sipper' ? 'blue' : 'purple') }}-200 text-{{ $template->level === 'first_sip' ? 'green' : ($template->level === 'savy_sipper' ? 'blue' : 'purple') }}-800 py-1 px-3 rounded-full text-xs">
                                                {{ $template->level === 'first_sip' ? 'First Sip (Basic)' : ($template->level === 'savy_sipper' ? 'Savy Sipper (Intermediate)' : 'Pro (Advanced)') }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ count($template->questions) }}</td>
                                        <td class="py-3 px-6 text-left">
                                            <span class="bg-{{ $template->is_active ? 'green' : 'red' }}-200 text-{{ $template->is_active ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                                {{ $template->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-6 text-center">
                                            <div class="flex item-center justify-center">
                                                <a href="{{ route('admin.questionnaires.show', $template) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.questionnaires.edit', $template) }}" class="w-4 mr-2 transform hover:text-indigo-500 hover:scale-110">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.questionnaires.toggle-status', $template) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="w-4 mr-2 transform hover:text-{{ $template->is_active ? 'red' : 'green' }}-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.questionnaires.destroy', $template) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this questionnaire template?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-110">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="py-3 px-6 text-center">No questionnaire templates found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>