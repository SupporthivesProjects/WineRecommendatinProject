<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('user.dashboard') }}" class="mr-2">
                <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Wine Expertise Assessment') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Let's Determine Your Wine Expertise Level</h3>
                        <p class="text-gray-600">Answer these questions to help us personalize your wine recommendations.</p>
                    </div>
                    
                    <form method="POST" action="{{ route('questionnaires.submit-expertise') }}">
                        @csrf
                        
                        <div class="mb-8 pb-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 mb-3">1. How often do you drink wine?</h4>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="wine_consumption_rarely" name="wine_consumption" type="radio" value="rarely" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                    <label for="wine_consumption_rarely" class="ml-3 block text-sm font-medium text-gray-700">
                                        Rarely (a few times a year)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_consumption_monthly" name="wine_consumption" type="radio" value="monthly" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_consumption_monthly" class="ml-3 block text-sm font-medium text-gray-700">
                                        Occasionally (monthly)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_consumption_weekly" name="wine_consumption" type="radio" value="weekly" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_consumption_weekly" class="ml-3 block text-sm font-medium text-gray-700">
                                        Regularly (weekly)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_consumption_daily" name="wine_consumption" type="radio" value="daily" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_consumption_daily" class="ml-3 block text-sm font-medium text-gray-700">
                                        Frequently (several times a week or daily)
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8 pb-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 mb-3">2. How would you rate your knowledge of wine?</h4>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="wine_knowledge_beginner" name="wine_knowledge" type="radio" value="beginner" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                    <label for="wine_knowledge_beginner" class="ml-3 block text-sm font-medium text-gray-700">
                                        Beginner (I know the basics like red vs. white)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_knowledge_intermediate" name="wine_knowledge" type="radio" value="intermediate" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_knowledge_intermediate" class="ml-3 block text-sm font-medium text-gray-700">
                                        Intermediate (I know different grape varieties and regions)
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_knowledge_advanced" name="wine_knowledge" type="radio" value="advanced" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_knowledge_advanced" class="ml-3 block text-sm font-medium text-gray-700">
                                        Advanced (I understand vintages, terroir, and production methods)
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8 pb-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 mb-3">3. Do you participate in wine tastings?</h4>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="wine_tasting_no" name="wine_tasting" type="radio" value="no" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                    <label for="wine_tasting_no" class="ml-3 block text-sm font-medium text-gray-700">
                                        No, I've never been to a wine tasting
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_tasting_yes_sometimes" name="wine_tasting" type="radio" value="yes_sometimes" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_tasting_yes_sometimes" class="ml-3 block text-sm font-medium text-gray-700">
                                        Yes, occasionally
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_tasting_yes_regularly" name="wine_tasting" type="radio" value="yes_regularly" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_tasting_yes_regularly" class="ml-3 block text-sm font-medium text-gray-700">
                                        Yes, regularly
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-8 pb-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-900 mb-3">4. Do you pair wines with food?</h4>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="wine_pairing_no" name="wine_pairing" type="radio" value="no" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" required>
                                    <label for="wine_pairing_no" class="ml-3 block text-sm font-medium text-gray-700">
                                        No, I don't think about pairing
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_pairing_yes_sometimes" name="wine_pairing" type="radio" value="yes_sometimes" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_pairing_yes_sometimes" class="ml-3 block text-sm font-medium text-gray-700">
                                        Yes, sometimes I consider basic pairings
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="wine_pairing_yes_confidently" name="wine_pairing" type="radio" value="yes_confidently" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                    <label for="wine_pairing_yes_confidently" class="ml-3 block text-sm font-medium text-gray-700">
                                        Yes, I confidently pair wines with different dishes
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-end mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Submit Assessment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
