
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
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Popup Enquiry</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Popup Enquiries</li>
                    </ol>
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
                            <div class="table-responsive">
                                <table id="file-export" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR No.</th>
                                            <th class="text-start">Name</th>
                                            <th class="text-start">Gender</th>
                                            <th class="text-start">Mobile</th>
                                            <th class="text-start">Description</th>
                                            <th class="text-start">Product Name</th>
                                            <th class="text-start">Date</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($enquiries as $index => $enquiry)
                                            <tr>
                                                <td class="align-middle">{{ $index + 1 }}</td>
                                                <td class="align-middle">{{ $enquiry->name }}</td>
                                                <td class="align-middle">{{ $enquiry->gender }}</td>
                                                <td class="align-middle">{{ $enquiry->mobile }}</td>
                                                <td class="align-middle">{{ $enquiry->description }}</td>
                                                <td class="align-middle">{{ $enquiry->product_name }}</td>
                                                <td class="align-middle">{{ $enquiry->created_at }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No products found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        // Initialize DataTable first
        $('#Enquiry').DataTable();
</script>
    
@endpush
