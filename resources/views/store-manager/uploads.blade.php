@extends('layouts.bootdashboard') @section('admindashboardcontent')

<div class="main-content app-content">
    <div class="container-fluid">

        <h3 class="mb-4">Store Manager Upload Panel</h3>

        <div class="row">

            <!-- BULK UPLOAD -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        Bulk Upload
                    </div>
                    <div class="card-body">
                        <a href="{{ route('store-manager.uploads.download') }}" class="btn btn-info mb-3">
                            Download Sample CSV
                        </a>
                        <form action="{{ route('store-manager.uploads.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <input type="file" name="csv_file" class="form-control" required>
                            </div>
                            <button class="btn btn-success">
                                Upload CSV
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            <!-- MANUAL ENTRY -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        Manual Entry
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('store-manager.uploads.store') }}">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="store_manager_name" value="{{ $user->first_name.' '.$user->last_name }}"  class="form-control" placeholder="Store Manager Name" readonly>
                            </div>

                            <div class="mb-2">
                                <input type="text" name="store_manager_id" value="{{ $user->id }}"  class="form-control" placeholder="Store Manager ID" readyonly>
                            </div>

                            <div class="mb-2">
                                <input type="text" name="invoice_no" class="form-control" placeholder="Invoice No" required>
                            </div>

                            <div class="mb-2">
                                <input type="text" name="customer_name" class="form-control" placeholder="Customer Name" required>
                            </div>

                            <div class="mb-2">
                                <input type="text" name="customer_mobile" class="form-control" placeholder="Customer Mobile" required>
                            </div>

                            <div class="mb-2">
                                <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                            </div>

                            <div class="mb-2">
                                <input type="number" step="0.01" name="product_price" class="form-control" placeholder="Product Price" required>
                            </div>

                            <div class="mb-2">
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <button class="btn btn-primary">
                                Save Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
                <script>
                    Swal.fire({
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    </script>
            </div>
        @endif


    </div>
</div>

@endsection