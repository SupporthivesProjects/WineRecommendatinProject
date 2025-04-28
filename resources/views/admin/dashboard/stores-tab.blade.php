
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


    <!-- Stores Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Stores Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Stores</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text" data-bs-toggle="modal" data-bs-target="#addStoreModal">
                    <i class="fe fe-plus me-2"></i>Add Store
                    </button>
                </div>
            </div>

            <!-- End::page-header -->

            <!-- Start::row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                   
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Table -->
                                <div class="table-responsive">
                                    <table id="file-export" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start">SR No.</th>
                                                <th class="text-start">Store Name</th>
                                                <th class="text-start">Location</th>
                                                <th class="text-start">Contact</th>
                                                <th class="text-start">Status</th>
                                                <th class="text-start">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($stores as $index => $store)
                                                <tr>
                                                    <td class="align-middle">{{ $index + 1 }}</td>
                                                    <td class="align-middle">{{ $store->store_name }}</td>
                                                    <td class="align-middle">{{ $store->state }}</td>
                                                    <td class="align-middle">{{ $store->contact_number }}</td>
                                                    <td class="align-middle">
                                                        <span class="badge rounded-pill border border-{{ $store->status === 'active' ? 'success' : 'danger' }} text-{{ $store->status === 'active' ? 'success' : 'danger' }} py-1 px-3">
                                                            {{ ucfirst($store->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <a href="{{ route('admin.stores.show', $store) }}" class="text-primary">View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No stores found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- End::row -->    

            <!-- Add Store Modal -->
            <!-- Add Store Modal -->
            <div class="modal fade" id="addStoreModal" data-bs-effect="effect-fall" tabindex="-1" aria-labelledby="addStoreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addStoreModalLabel">Add Store</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.stores.store') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="store_name" class="form-label">Store Name</label>
                                        <input type="text" class="form-control" id="store_name" name="store_name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gst_vat" class="form-label">GST/VAT</label>
                                        <input type="text" class="form-control" id="gst_vat" name="gst_vat">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="contact_number" class="form-label">Contact</label>
                                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="group" class="form-label">Group</label>
                                        <input type="text" class="form-control" id="group" name="group">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" class="form-control" id="state" name="state" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email ID</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="business_type" class="form-label">Business Type</label>
                                        <input type="text" class="form-control" id="business_type" name="business_type" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="licence_type" class="form-label">License Type</label>
                                        <input type="text" class="form-control" id="licence_type" name="licence_type" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="license_number" class="form-label">License Number</label>
                                        <input type="text" class="form-control" id="license_number" name="license_number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Store</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@push('scripts')
    <script>
        function openAddStoreModal() 
        {
            var myModal = new bootstrap.Modal(document.getElementById('addStoreModal'));
            myModal.show();
        }
    </script>
@endpush

