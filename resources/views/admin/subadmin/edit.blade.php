
@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        .product-thumbnail {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }
        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            line-height: 1.5;
        }
    </style>
    @endpush

    <!-- Templates Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="card mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-1">{{ $subAdmin->first_name }} {{ $subAdmin->last_name }}</h4>
                        <p class="mb-0">{{ $subAdmin->email }}</p>
                    </div>

                    <a href="{{ route('admin.subadmin.home') }}"
                    class="btn btn-secondary btn-icon-text">
                        <i class="fe fe-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-body">
                            <!-- Table -->
                            <div class="table-responsive">
                                <form method="POST" action="{{ route('admin.subadmin.features.update', $subAdmin->id) }}">
                                    @csrf
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th width="80">#</th>
                                                <th>Feature</th>
                                                <th>Feature Key</th>
                                                <th width="150">Enabled</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($features as $index => $feature)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $feature->feature_name }}</td>
                                                    <td>{{ $feature->feature_key }}</td>
                                                    <td class="text-center">
                                                    <input
                                                        type="checkbox"
                                                        name="features[]"
                                                        value="{{ $feature->id }}"
                                                        {{ in_array($feature->id, $assignedFeatures) ? 'checked' : '' }}>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <button class="btn btn-primary mt-3">
                                        Save Permissions
                                    </button>
                                </form>
                            </div>
                            <!-- End Table -->
                            
                            {{-- @if($features->hasPages())
                            <div class="mt-3">
                                {{ $features->links() }}
                            </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>
    <!-- End::Cheese Products Section -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        </script>
    @endif
@endsection

@push('scripts')
    
@endpush
