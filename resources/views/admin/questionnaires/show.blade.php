<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Questionnaire Template Details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('admin.questionnaires.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Questionnaire Templates
                        </a>
                    </div>

                    <!-- Template Details Card -->
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <!-- Header with Status -->
                        <div class="border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $questionnaire->name }}
                            </h3>
                            <span class="bg-{{ $questionnaire->is_active ? 'green' : 'red' }}-200 text-{{ $questionnaire->is_active ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                {{ $questionnaire->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <!-- Template Details -->
                        <div class="px-6 py-4">
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Level</p>
                                <p class="font-medium text-gray-900">
                                    <span class="bg-{{ $questionnaire->level === 'first_sip' ? 'green' : ($questionnaire->level === 'savy_sipper' ? 'blue' : 'purple') }}-200 text-{{ $questionnaire->level === 'first_sip' ? 'green' : ($questionnaire->level === 'savy_sipper' ? 'blue' : 'purple') }}-800 py-1 px-3 rounded-full text-xs">
                                        {{ $questionnaire->level === 'first_sip' ? 'First Sip (Basic)' : ($questionnaire->level === 'savy_sipper' ? 'Savy Sipper (Intermediate)' : 'Pro (Advanced)') }}
                                    </span>
                                </p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Description</p>
                                <p class="font-medium text-gray-900">{{ $questionnaire->description ?? 'No description provided' }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Created</p>
                                <p class="font-medium text-gray-900">{{ $questionnaire->created_at->format('M d, Y') }}</p>
                            </div>
                            
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-1">Last Updated</p>
                                <p class="font-medium text-gray-900">{{ $questionnaire->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        
                        <!-- Questions Section -->
                        <div class="border-t border-gray-200 px-6 py-4">
                            <h4 class="text-md font-medium mb-4">Questions ({{ count($questionnaire->questions) }})</h4>
                            
                            @if(count($questionnaire->questions) > 0)
                                <div class="space-y-4">
                                    @foreach($questionnaire->questions as $index => $question)
                                        <div class="border rounded p-4">
                                            <h5 class="font-bold mb-2">Question {{ $index + 1 }}: {{ $question['text'] }}</h5>
                                            <p class="text-sm text-gray-600 mb-2">Type: {{ ucfirst($question['type']) }}</p>
                                            
                                            @if($question['type'] === 'slider')
                                                <div class="bg-gray-100 p-3 rounded">
                                                    <p class="text-sm">Range: {{ $question['min'] ?? 0 }} to {{ $question['max'] ?? 100 }}</p>
                                                    <p class="text-sm">Step: {{ $question['step'] ?? 1 }}</p>
                                                    <p class="text-sm">Default: {{ $question['default'] ?? 50 }}</p>
                                                </div>
                                            @else
                                                <div class="bg-gray-100 p-3 rounded">
                                                    <p class="text-sm font-medium mb-1">Options:</p>
                                                    <ul class="list-disc pl-5">
                                                        @foreach($question['options'] as $option)
                                                            <li class="text-sm">{{ $option }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">No questions defined for this template.</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- User Responses Section -->
                    <div class="mt-8">
                        <h4 class="text-lg font-medium mb-4">Recent User Responses</h4>
                        
                        @if(count($responses) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">User</th>
                                            <th class="py-3 px-6 text-left">Date</th>
                                            <th class="py-3 px-6 text-left">Recommended Products</th>
                                            <th class="py-3 px-6 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 text-sm">
                                        @foreach($responses as $response)
                                            <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                <td class="py-3 px-6 text-left">
                                                    {{ $response->user->first_name }} {{ $response->user->last_name }}
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    {{ $response->created_at->format('M d, Y H:i') }}
                                                </td>
                                                <td class="py-3 px-6 text-left">
                                                    {{ count($response->recommended_products ?? []) }}
                                                </td>
                                                <td class="py-3 px-6 text-center">
                                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $responses->links() }}
                            </div>
                        @else
                            <p class="text-gray-500 italic">No user responses for this questionnaire template yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>