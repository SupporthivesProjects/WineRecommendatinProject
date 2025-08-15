@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Edit Review #{{ $review->id }}</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h6 class="card-title">Review Information</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST" id="reviewForm">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                                <option value="">Select User</option>
                                                @foreach($users as $id => $name)
                                                    <option value="{{ $id }}" {{ old('user_id', $review->user_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                                            <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                                                <option value="">Select Product</option>
                                                @foreach($products as $id => $name)
                                                    <option value="{{ $id }}" {{ old('product_id', $review->product_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                                <option value="">Select Rating</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}" {{ old('rating', $review->rating) == $i ? 'selected' : '' }}>
                                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('rating')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="pending" {{ old('status', $review->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ old('status', $review->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ old('status', $review->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="comment" class="form-label">Comment <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                                    id="comment" 
                                                    name="comment" 
                                                    rows="4" 
                                                    required>{{ old('comment', $review->comment) }}</textarea>
                                            @error('comment')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-light">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Update Review</button>
                                            
                                            <!-- Quick status update buttons -->
                                            <div class="btn-group ms-2">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-success" 
                                                        onclick="updateStatus('approved')"
                                                        data-bs-toggle="tooltip"
                                                        title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-warning"
                                                        onclick="updateStatus('pending')"
                                                        data-bs-toggle="tooltip"
                                                        title="Set as Pending">
                                                    <i class="fas fa-clock"></i>
                                                </button>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        onclick="updateStatus('rejected')"
                                                        data-bs-toggle="tooltip"
                                                        title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .card {
            border: 1px solid #e2e8f0;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
        }

        .card-header h6 {
            margin-bottom: 0;
            font-weight: 600;
            font-size: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.25rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize select2 if available
            if (typeof $.fn.select2 !== 'undefined') {
                $('#user_id, #product_id').select2({
                    placeholder: 'Select an option',
                    allowClear: true,
                    width: '100%'
                });
            }

            // Initialize tooltips
            if (typeof $().tooltip === 'function') {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }

            // Form validation
            const form = document.getElementById('reviewForm');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            }
        });

        // Function to update status via quick buttons
        function updateStatus(status) {
            const statusLabels = {
                'approved': 'Approve',
                'pending': 'Set as Pending',
                'rejected': 'Reject'
            };
            
            const statusIcons = {
                'approved': 'success',
                'pending': 'warning',
                'rejected': 'error'
            };
            
            const statusMessages = {
                'approved': 'This review will be visible to all users.',
                'pending': 'This review will be set as pending for review.',
                'rejected': 'This review will be rejected and hidden from public view.'
            };

            Swal.fire({
                title: `${statusLabels[status]} Review`,
                text: `Are you sure you want to ${status} this review? ${statusMessages[status]}`,
                icon: statusIcons[status],
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${status} it!`,
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-primary me-2',
                    cancelButton: 'btn btn-outline-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Update the status dropdown
                    document.getElementById('status').value = status;
                    // Submit the form
                    document.getElementById('reviewForm').submit();
                    
                    // Show loading state
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we update the review status.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }
            });
        }
        
        // Show success message if there's a success flash message
        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush
