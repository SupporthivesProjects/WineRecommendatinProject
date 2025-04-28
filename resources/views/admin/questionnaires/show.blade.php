@extends('layouts.bootdashboard')

@section('admindashboardcontent')
@push('styles')
<style>
    .dataTables_filter input[type="search"] {
        width: 300px !important; 
        margin-bottom: 20px;
    }
</style>
@endpush

<!-- Questionnaire Template Details Section -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Questionnaire Template Details</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Questionnaire Templates</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('admin.questionnaires.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left me-2"></i> Back to Templates
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start::row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">

                        <!-- Template Overview -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="mb-0">{{ $questionnaire->name }}</h3>
                            <span class="badge rounded-pill bg-{{ $questionnaire->is_active ? 'success' : 'danger' }}">
                                {{ $questionnaire->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Level</p>
                                <p>
                                    <span class="badge rounded-pill bg-{{ $questionnaire->level === 'first_sip' ? 'success' : ($questionnaire->level === 'savy_sipper' ? 'primary' : 'purple') }}">
                                        {{ $questionnaire->level === 'first_sip' ? 'First Sip (Basic)' : ($questionnaire->level === 'savy_sipper' ? 'Savy Sipper (Intermediate)' : 'Pro (Advanced)') }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Description</p>
                                <p>{{ $questionnaire->description ?? 'No description provided' }}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Created At</p>
                                <p>{{ $questionnaire->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted">Last Updated</p>
                                <p>{{ $questionnaire->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Questions Section -->
                        <div class="border-top pt-4">
                            <h4 class="mb-4">Questions ({{ count($questionnaire->questions) }})</h4>

                            @if(count($questionnaire->questions) > 0)
                                <div class="accordion" id="questionsAccordion">
                                    @foreach($questionnaire->questions as $index => $question)
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading{{ $index }}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}">
                                                    Question {{ $index + 1 }}: {{ $question['text'] }}
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#questionsAccordion">
                                                <div class="accordion-body">
                                                    <p class="text-muted mb-2">Type: {{ ucfirst($question['type']) }}</p>
                                                    @if($question['type'] === 'slider')
                                                        <div class="bg-light p-3 rounded">
                                                            <p>Range: {{ $question['min'] ?? 0 }} to {{ $question['max'] ?? 100 }}</p>
                                                            <p>Step: {{ $question['step'] ?? 1 }}</p>
                                                            <p>Default: {{ $question['default'] ?? 50 }}</p>
                                                        </div>
                                                    @else
                                                        <div class="bg-light p-3 rounded">
                                                            <p class="fw-bold mb-2">Options:</p>
                                                            <ul class="list-unstyled">
                                                                @foreach($question['options'] as $option)
                                                                    <li>• {{ $option }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted fst-italic">No questions defined for this template.</p>
                            @endif
                        </div>

                        <!-- User Responses Section -->
                        <div class="border-top pt-4 mt-5">
                            <h4 class="mb-4">Recent User Responses</h4>

                            @if(count($responses) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User</th>
                                                <th>Date</th>
                                                <th>Recommended Products</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($responses as $response)
                                                <tr>
                                                    <td>{{ $response->user->first_name }} {{ $response->user->last_name }}</td>
                                                    <td>{{ $response->created_at->format('M d, Y H:i') }}</td>
                                                    <td>{{ count($response->recommended_products ?? []) }}</td>
                                                    <td class="text-center">
                                                        <a href="#" class="text-primary">View Details</a>
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
                                <p class="text-muted fst-italic">No user responses for this questionnaire template yet.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End::row -->
    </div>
</div>
<!-- End::Questionnaire Template Details Section -->

@push('scripts')
<script>
    // You can add any specific JS related to this page here
</script>
@endpush

@endsection
