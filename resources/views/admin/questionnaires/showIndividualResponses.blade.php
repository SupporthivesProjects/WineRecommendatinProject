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
    @php
            function mapQuestionKeyToIndex($key) {
                return intval(substr($key, 8)) - 1;  // "question1" → 0, "question2" → 1, etc.
            }
    @endphp

    <!-- Products Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To User Responses</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User Responses</li>
                    </ol>
                </div>
                <div class="d-flex">
                <a href="{{ route('admin.questionnaire.responses') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
                    <i class="fe fe-arrow-left me-2"></i>Back
                </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Information</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $customer->cust_name }}</p>
                            <p><strong>Email:</strong> {{ $customer->cust_email }}</p>
                            <p><strong>Phone:</strong> {{ $customer->cust_phone }}</p>
                            <p><strong>Template:</strong> {{ $templateName }}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Store Information</h4>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $store->store_name }}</p>
                            <p><strong>Email:</strong> {{ $store->address }}</p>
                            <p><strong>Phone:</strong> {{ $store->state }}</p>
                            
                        </div>
                    </div>
                    <div class="card custom-card">
                        <div class="card-body">
                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($responses as $response)
                                            
                                            @php
                                                $index = intval(substr($response->question_key, 8)) - 1;
                                                $questionText = $questions[$index] ?? $response->question_key;
                                            @endphp
                                            <tr>
                                                <td>{{ $questionText }}</td>
                                                <td>{{ is_array(json_decode($response->answer, true)) ? implode(', ', json_decode($response->answer)) : $response->answer }}</td>
                                            </tr>
         
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Products Section -->
@endsection

@push('scripts')
   

@endpush


