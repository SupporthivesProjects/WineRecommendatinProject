<!-- Questionnaires Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Questionnaires</h3>
            <!-- Removed the Create Questionnaire button -->
        </div>
        
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
                    @if(isset($templates) && count($templates) > 0)
                        @foreach($templates as $template)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left">{{ $template->id }}</td>
                            <td class="py-3 px-6 text-left">{{ $template->name }}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="bg-{{ $template->level === 'first_sip' ? 'green' : ($template->level === 'savy_sipper' ? 'blue' : 'purple') }}-200 text-{{ $template->level === 'first_sip' ? 'green' : ($template->level === 'savy_sipper' ? 'blue' : 'purple') }}-800 py-1 px-3 rounded-full text-xs">
                                    {{ $template->level === 'first_sip' ? 'Basic' : ($template->level === 'savy_sipper' ? 'Intermediate' : 'Advanced') }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-left">{{ count($template->questions) }}</td>
                            <td class="py-3 px-6 text-left">
                                <span class="bg-{{ $template->is_active ? 'green' : 'red' }}-200 text-{{ $template->is_active ? 'green' : 'red' }}-800 py-1 px-3 rounded-full text-xs">
                                    {{ $template->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <a href="{{ route('admin.questionnaires.show', $template) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center">No questionnaires found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Questionnaire Analytics Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
    <div class="p-6">
        <h3 class="text-lg font-semibold mb-4">Questionnaire Analytics</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- First Sip Analytics -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="text-md font-medium mb-4">First Sip (Basic)</h4>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Responses</p>
                        <p class="text-2xl font-bold">{{ $firstSipCount ?? 0 }}</p>
                    </div>
                    <div class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Savy Sipper Analytics -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="text-md font-medium mb-4">Savy Sipper (Intermediate)</h4>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Responses</p>
                        <p class="text-2xl font-bold">{{ $savySipperCount ?? 0 }}</p>
                    </div>
                    <div class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Pro Analytics -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h4 class="text-md font-medium mb-4">Pro (Advanced)</h4>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Responses</p>
                        <p class="text-2xl font-bold">{{ $proCount ?? 0 }}</p>
                    </div>
                    <div class="text-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Responses Chart -->
        <div class="mt-6 bg-white p-4 rounded-lg shadow">
            <h4 class="text-md font-medium mb-4">Recent Responses (Last 7 Days)</h4>
            <canvas id="responsesChart" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Recent Responses Chart
        const responsesCtx = document.getElementById('responsesChart').getContext('2d');
        const responsesChart = new Chart(responsesCtx, {
            type: 'line',
            data: {
                labels: @json($dateLabels ?? []),
                datasets: [
                    {
                        label: 'First Sip',
                        data: @json($firstSipData ?? []),
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Savy Sipper',
                        data: @json($savySipperData ?? []),
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pro',
                        data: @json($proData ?? []),
                        borderColor: 'rgba(139, 92, 246, 1)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>