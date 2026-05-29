
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
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Products Master API</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login History</li>
                    </ol>
                </div>
                <form method="POST" action="{{ route('admin.api.master.pull') }}" class="pull-form">
                    @csrf
                    <button type="submit" class="btn btn-primary pull-btn">
                        Pull Data
                    </button>
                </form>
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
                                                <th>SR No.</th>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Size</th>
                                                <th>Pack Size</th>
                                                <th>Type</th>
                                                <th>Created</th>
                                                <th>Modified</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($products as $index => $product)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $product->product_id }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->product_category }}</td>
                                                <td>{{ $product->size }}</td>
                                                <td>{{ $product->pack_size }}</td>
                                                <td>{{ $product->type }}</td>
                                                <td>{{ $product->product_created_time }}</td>
                                                <td>{{ $product->product_modified_time }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    No records found
                                                </td>
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

@endsection

@push('scripts')

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session("success") }}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    <script>
        document.querySelectorAll('.pull-form').forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('.pull-btn');
                btn.disabled = true;
                btn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span> Pulling...';
            });
        });

    </script>

   
@endpush

