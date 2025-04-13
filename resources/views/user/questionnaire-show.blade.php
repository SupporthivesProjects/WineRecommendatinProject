<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('user.dashboard') }}" class="mr-2">
                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $questionnaire->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($questionnaire->level == 'first_sip') bg-green-100 text-green-800
                            @elseif($questionnaire->level == 'savy_sipper') bg-blue-100 text-blue-800
                            @else bg-purple-100 text-purple-800 @endif">
                            @if($questionnaire->level == 'first_sip')
                                First Sip
                            @elseif($questionnaire->level == 'savy_sipper')
                                Savvy Sipper
                            @else
                                Wine Pro
                            @endif
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-6">{{ $questionnaire->description }}</p>
                    
                    <form method="POST" action="{{ route('questionnaires.submit', $questionnaire) }}">
                        @csrf
                        
                        @php
                            $questions = json_decode($questionnaire->questions, true);
                        @endphp
                        
                        @if(is_array($questions) && count($questions) > 0)
                            @foreach($questions as $index => $question)
                                <div class="mb-8 pb-6 border-b border-gray-200 last:border-0">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">{{ $index + 1 }}. {{ $question['question'] }}</h3>
                                    
                                    @if($question['type'] == 'multiple_choice')
                                        <div class="mt-4 space-y-4">
                                            @foreach($question['options'] as $optionKey => $option)
                                                <div class="flex items-center">
                                                    <input id="question_{{ $index }}_{{ $optionKey }}" name="answers[{{ $index }}]" type="radio" value="{{ $optionKey }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                                    <label for="question_{{ $index }}_{{ $optionKey }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($question['type'] == 'checkbox')
                                        <div class="mt-4 space-y-4">
                                            @foreach($question['options'] as $optionKey => $option)
                                                <div class="flex items-center">
                                                    <input id="question_{{ $index }}_{{ $optionKey }}" name="answers[{{ $index }}][]" type="checkbox" value="{{ $optionKey }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                                    <label for="question_{{ $index }}_{{ $optionKey }}" class="ml-3 block text-sm font-medium text-gray-700">
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($question['type'] == 'slider')
                                        <div class="mt-4">
                                            <input type="range" id="question_{{ $index }}" name="answers[{{ $index }}]" min="{{ $question['min'] ?? 1 }}" max="{{ $question['max'] ?? 10 }}" step="1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                            <div class="flex justify-between text-xs text-gray-600 px-2 mt-1">
                                                <span>{{ $question['min_label'] ?? 'Low' }}</span>
                                                <span>{{ $question['max_label'] ?? 'High' }}</span>
                                            </div>
                                        </div>
                                    @elseif($question['type'] == 'text')
                                        <div class="mt-4">
                                            <textarea id="question_{{ $index }}" name="answers[{{ $index }}]" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="{{ $question['placeholder'] ?? 'Your answer...' }}"></textarea>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            
                            <div class="flex items-center justify-end mt-6">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Submit Answers
                                </button>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            This questionnaire doesn't have any questions yet.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>