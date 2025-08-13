@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        .testimonial-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }
    </style>
    @endpush

    <!-- Testimonials Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Testimonials Management</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.testimonials.create') }}" type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Add Testimonial
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
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            <!-- Table -->
                            <div class="table-responsive">
                                <table id="testimonials-table" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start">#</th>
                                            <th class="text-start">Name</th>
                                            <th class="text-start">Position</th>
                                            <th class="text-start">Company</th>
                                            <th class="text-start">Rating</th>
                                            <th class="text-start">Status</th>
                                            <th class="text-start">Sort Order</th>
                                            <th class="text-start">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($testimonials as $index => $testimonial)
                                            <tr>
                                                <td class="align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">
                                                    <div class="d-flex align-items-center">
                                                        @if($testimonial->image_url)
                                                            <img src="{{ asset('storage/' . $testimonial->image_url) }}" 
                                                                 class="testimonial-avatar me-2" 
                                                                 alt="{{ $testimonial->name }}">
                                                        @else
                                                            <div class="testimonial-avatar bg-primary text-white d-flex align-items-center justify-content-center me-2">
                                                                {{ $testimonial->initials }}
                                                            </div>
                                                        @endif
                                                        <span>{{ $testimonial->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="align-middle">{{ $testimonial->position ?? 'N/A' }}</td>
                                                <td class="align-middle">{{ $testimonial->company ?? 'N/A' }}</td>
                                                <td class="align-middle">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge rounded-pill border border-{{ $testimonial->is_active ? 'success' : 'danger' }} text-{{ $testimonial->is_active ? 'success' : 'danger' }} py-1 px-3">
                                                        {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">{{ $testimonial->sort_order }}</td>
                                                <td class="align-middle action-btns">
                                                    <div class="d-flex">
                                                        <a href="{{ route('admin.testimonials.show', $testimonial->id) }}" 
                                                           class="btn btn-sm btn-info me-1" 
                                                           data-bs-toggle="tooltip" 
                                                           title="View">
                                                            <i class="fe fe-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" 
                                                           class="btn btn-sm btn-primary me-1"
                                                           data-bs-toggle="tooltip" 
                                                           title="Edit">
                                                            <i class="fe fe-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" 
                                                              method="POST" 
                                                              class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-danger"
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
                                                <td colspan="8" class="text-center">No testimonials found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Testimonials Section -->
@endsection

@push('scripts')
<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#testimonials-table').DataTable({
            responsive: true,
            language: {
                searchPlaceholder: 'Search testimonials...',
                sSearch: '',
                lengthMenu: '_MENU_ items/page',
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
