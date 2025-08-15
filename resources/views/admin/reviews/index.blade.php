@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
            margin: 0 2px;
        }
        .rating-stars {
            color: #ffc107;
            white-space: nowrap;
        }
        .status-badge {
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
        }
        .btn-approve {
            color: #198754;
            border-color: #198754;
        }
        .btn-approve:hover {
            background-color: #198754;
            color: white;
        }
        .btn-reject {
            color: #dc3545;
            border-color: #dc3545;
        }
        .btn-reject:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>
    @endpush

    <!-- Reviews Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Product Reviews Management</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Reviews</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.reviews.create') }}" type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Add New Review
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Table -->
                            <div class="table-responsive">
                                <table id="reviews-datatable" class="table table-bordered w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-start">ID</th>
                                            <th class="text-start">Product</th>
                                            <th class="text-start">User</th>
                                            <th class="text-start">Rating</th>
                                            <th class="text-start">Comment</th>
                                            <th class="text-start">Status</th>
                                            <th class="text-start">Date</th>
                                            <th class="text-start">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($reviews as $review)
                                            <tr>
                                                <td class="align-middle">{{ $review->id }}</td>
                                                <td class="align-middle">
                                                    <a href="{{ route('admin.products.edit', $review->product_id) }}">
                                                        {{ Str::limit($review->product->wine_name, 30) }}
                                                    </a>
                                                </td>
                                                <td class="align-middle">{{ $review->user->first_name }} {{ $review->user->last_name }}</td>
                                                <td class="align-middle">
                                                    <div class="rating-stars">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                        <span class="text-muted ms-1">({{ $review->rating }})</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ Str::limit($review->comment, 50) }}</td>
                                                <td class="align-middle">
                                                    <span class="badge rounded-pill py-1 px-3 
                                                        @if($review->status === 'approved') border border-success text-success
                                                        @elseif($review->status === 'rejected') border border-danger text-danger
                                                        @else border border-warning text-warning @endif">
                                                        {{ ucfirst($review->status) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">{{ $review->created_at->format('M d, Y') }}</td>
                                                <td class="align-middle action-btns">
                                                    <div class="d-flex">
                                                        <form action="{{ route('admin.reviews.update-status', $review->id) }}" method="POST" class="d-inline me-1">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="approved">
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-success border-0 btn-approve"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Approve Review"
                                                                    onclick="return confirmStatusChange('approve', '{{ $review->id }}')">
                                                                <i class="fe fe-check"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <form action="{{ route('admin.reviews.update-status', $review->id) }}" method="POST" class="d-inline me-1">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger border-0 btn-reject"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Reject Review"
                                                                    onclick="return confirmStatusChange('reject', '{{ $review->id }}')">
                                                                <i class="fe fe-x"></i>
                                                            </button>
                                                        </form>
                                                        
                                                        <a href="{{ route('admin.reviews.show', $review->id) }}" 
                                                           class="btn btn-sm btn-outline-info border-0" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('admin.reviews.edit', $review->id) }}" 
                                                           class="btn btn-sm btn-outline-primary border-0"
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        
                                                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirmDelete('{{ $review->id }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger border-0"
                                                                    data-bs-toggle="tooltip" 
                                                                    title="Delete">
                                                                <i class="fe fe-trash-2"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">No reviews found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                            
                            @if($reviews->hasPages())
                            <div class="mt-3">
                                {{ $reviews->links() }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Reviews Section -->
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize DataTable if needed
            if ($.fn.DataTable) {
                $('#reviews-datatable').DataTable({
                    responsive: true,
                    pageLength: 25,
                    order: [[0, 'desc']],
                    dom: '<"top"f>rt<"bottom"lip><"clear">',
                    language: {
                        search: "",
                        searchPlaceholder: "Search reviews...",
                        paginate: {
                            next: '<i class="fe fe-chevron-right"></i>',
                            previous: '<i class="fe fe-chevron-left"></i>'
                        }
                    },
                    initComplete: function() {
                        $('.dataTables_filter input').addClass('form-control');
                    }
                });
            }
        });

        // Confirm status change
        function confirmStatusChange(action, reviewId) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            Swal.fire({
                title: `${action === 'approve' ? 'Approve' : 'Reject'} Review`,
                text: `Are you sure you want to ${action} this review?`,
                icon: action === 'approve' ? 'success' : 'warning',
                showCancelButton: true,
                confirmButtonColor: action === 'approve' ? '#198754' : '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${action} it!`,
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: `btn btn-${action === 'approve' ? 'success' : 'danger'} me-2`,
                    cancelButton: 'btn btn-outline-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                            form.submit();
                        }
                    });
                }
            });
            
            return false;
        }

        // Confirm delete
        function confirmDelete(reviewId) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            Swal.fire({
                title: 'Delete Review',
                text: 'Are you sure you want to delete this review? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-outline-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                            form.submit();
                        }
                    });
                }
            });
            
            return false;
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
