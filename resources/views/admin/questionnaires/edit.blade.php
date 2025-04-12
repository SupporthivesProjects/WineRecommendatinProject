<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Questionnaire Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <a href="{{ route('admin.questionnaires.index') }}" class="text-indigo-600 hover:text-indigo-900">
                            ← Back to Questionnaire Templates
                        </a>
                    </div>

                    @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('admin.questionnaires.update', $questionnaire) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="name">Template Name</label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" value="{{ old('name', $questionnaire->name) }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="level">Level</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="level" name="level" required>
                                <option value="">Select Level</option>
                                @foreach($levels as $value => $label)
                                    <option value="{{ $value }}" {{ old('level', $questionnaire->level) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left" for="description">Description</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" rows="3">{{ old('description', $questionnaire->description) }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left">Status</label>
                            <div class="flex items-center">
                                <input type="checkbox" id="is_active" name="is_active" class="mr-2" {{ old('is_active', $questionnaire->is_active) ? 'checked' : '' }}>
                                <label for="is_active">Active</label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2 text-left">Questions</label>
                            <div id="questions-container">
                                <!-- Questions will be loaded here dynamically -->
                            </div>
                            <button type="button" id="add-question" class="mt-2 bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600 transition">
                                Add Question
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between mt-6">
                            <a href="{{ route('admin.questionnaires.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-gray-600">
                                Cancel
                            </a>
                            <button class="bg-indigo-600 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-indigo-700" type="submit">
                                Update Template
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionsContainer = document.getElementById('questions-container');
            const addQuestionBtn = document.getElementById('add-question');
            let questionCount = 0;
            
            // Load existing questions
            const existingQuestions = @json($questionnaire->questions);
            
            if (existingQuestions && existingQuestions.length > 0) {
                existingQuestions.forEach(question => {
                    addQuestion(question);
                });
            } else {
                // Add initial empty question if no questions exist
                addQuestion();
            }
            
            // Function to add a new question
            function addQuestion(questionData = null) {
                const questionDiv = document.createElement('div');
                questionDiv.className = 'question-item border rounded p-4 mb-4';
                questionDiv.dataset.questionId = questionCount;
                
                const questionType = questionData ? questionData.type : 'single';
                const questionText = questionData ? questionData.text : '';
                const options = questionData && questionData.options ? questionData.options : [''];
                const min = questionData && questionData.min !== undefined ? questionData.min : 0;
                const max = questionData && questionData.max !== undefined ? questionData.max : 100;
                const step = questionData && questionData.step !== undefined ? questionData.step : 1;
                const defaultValue = questionData && questionData.default !== undefined ? questionData.default : 50;
                
                questionDiv.innerHTML = `
                    <div class="flex justify-between mb-2">
                        <h4 class="font-bold">Question ${questionCount + 1}</h4>
                        <button type="button" class="remove-question text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    <div class="mb-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Question Text</label>
                        <input type="text" name="questions[${questionCount}][text]" value="${questionText}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-2">
                        <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Question Type</label>
                        <select name="questions[${questionCount}][type]" class="question-type shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="single" ${questionType === 'single' ? 'selected' : ''}>Single Choice</option>
                            <option value="multiple" ${questionType === 'multiple' ? 'selected' : ''}>Multiple Choice</option>
                            <option value="slider" ${questionType === 'slider' ? 'selected' : ''}>Slider</option>
                        </select>
                    </div>
                    <div class="options-container ${questionType === 'slider' ? 'hidden' : ''}">
                        <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Options</label>
                        <div class="options-list">
                            ${options.map(option => `
                                <div class="option-item flex mb-1">
                                    <input type="text" name="questions[${questionCount}][options][]" value="${option}" placeholder="Option text" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" required>
                                    <button type="button" class="remove-option text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                        <button type="button" class="add-option mt-1 text-sm text-blue-500 hover:text-blue-700">
                            + Add Option
                        </button>
                    </div>
                    <div class="slider-container ${questionType !== 'slider' ? 'hidden' : ''}">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Min Value</label>
                                <input type="number" name="questions[${questionCount}][min]" value="${min}" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Max Value</label>
                                <input type="number" name="questions[${questionCount}][max]" value="${max}" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Step</label>
                                <input type="number" name="questions[${questionCount}][step]" value="${step}" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1 text-left">Default</label>
                                <input type="number" name="questions[${questionCount}][default]" value="${defaultValue}" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>
                    </div>
                `;
                
                questionsContainer.appendChild(questionDiv);
                
                // Add event listeners for the new question
                const questionTypeSelect = questionDiv.querySelector('.question-type');
                const optionsContainer = questionDiv.querySelector('.options-container');
                const sliderContainer = questionDiv.querySelector('.slider-container');
                
                // Handle question type change
                questionTypeSelect.addEventListener('change', function() {
                    if (this.value === 'slider') {
                        optionsContainer.classList.add('hidden');
                        sliderContainer.classList.remove('hidden');
                    } else {
                        optionsContainer.classList.remove('hidden');
                        sliderContainer.classList.add('hidden');
                    }
                });
                
                // Add option button
                const addOptionBtn = questionDiv.querySelector('.add-option');
                const optionsList = questionDiv.querySelector('.options-list');
                
                addOptionBtn.addEventListener('click', function() {
                    const optionItem = document.createElement('div');
                    optionItem.className = 'option-item flex mb-1';
                    optionItem.innerHTML = `
                        <input type="text" name="questions[${questionCount}][options][]" placeholder="Option text" class="shadow appearance-none border rounded w-full py-1 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mr-2" required>
                        <button type="button" class="remove-option text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    `;
                    optionsList.appendChild(optionItem);
                    
                    // Remove option button
                    const removeOptionBtn = optionItem.querySelector('.remove-option');
                    removeOptionBtn.addEventListener('click', function() {
                        optionItem.remove();
                    });
                });
                
                // Remove option buttons
                const removeOptionBtns = questionDiv.querySelectorAll('.remove-option');
                removeOptionBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        this.closest('.option-item').remove();
                    });
                });
                
                // Remove question button
                const removeQuestionBtn = questionDiv.querySelector('.remove-question');
                removeQuestionBtn.addEventListener('click', function() {
                    questionDiv.remove();
                    updateQuestionNumbers();
                });
                
                questionCount++;
                updateQuestionNumbers();
            }
            
            // Function to update question numbers
            function updateQuestionNumbers() {
                const questions = questionsContainer.querySelectorAll('.question-item');
                questions.forEach((question, index) => {
                    const heading = question.querySelector('h4');
                    heading.textContent = `Question ${index + 1}`;
                });
            }
            
            // Add question button click event
            addQuestionBtn.addEventListener('click', function() {
                addQuestion();
            });
        });
    </script>
</x-admin-layout>
