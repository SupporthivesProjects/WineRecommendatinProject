@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')
<style>
  .dataTables_filter input {
        width: 300px !important; /* increase search box length */
    }

    .dataTables_filter {
        margin-left: 20px;
    }


</style>

@endpush

<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Checkouts') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkouts</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('store-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
        <!-- End::Page Header -->

        <!-- Start::Content -->
            <div class="">
                <div class="container-lg">
                    {{-- Product Details Card --}}
                        <div class="col-md-12 col-xl-12 mt-5">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-header border-bottom-0 d-flex pb-0 justify-content-between">
                                    <div>
                                        <label class="main-content-label mb-2 pt-1">Checkout Details</label>
                                        <p class="fs-12 mb-3 text-muted mb-0">
                                            Daily Checkout Details
                                        </p>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                    <table id="CheckoutTable" class="table table-vcenter border mb-0">
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Order ID</th>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Total</th>
                                                <th>Created</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($orders as $key => $order)

                                            @php
                                                $products = $order->products;
                                                $total = 0;

                                                foreach($products as $p){
                                                    $total += $p['retail_price'] * $p['quantity'];
                                                }
                                            @endphp

                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->username }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>₹&nbsp;{{ number_format($total,2) }}</td>
                                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>

                                                <td>
                                                    <button 
                                                        class="btn btn-primary btn-sm viewOrder"
                                                        data-products='@json($products)'
                                                        data-id="{{ $order->id }}"
                                                    >
                                                        View
                                                    </button>
                                                </td>
                                            </tr>

                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        <!-- End::Content -->

        <!-- Modal Starts -->

        <div class="modal fade" id="orderModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr.No</th>
                                    <th>Image</th>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody id="orderProducts"></tbody>

                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Grand Total</th>
                                    <th id="orderTotal"></th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Ends -->
        <!-- Pagination Code Starts -->
        

        <!-- Pagination Code ends -->
    </div>
</div>

@endsection

@push('scripts')

    <script>
        $(document).on('click','.viewOrder',function(){

            let products = $(this).data('products');
            let html = '';
            let total = 0;

            products.forEach((p,index)=>{

                let rowTotal = p.retail_price * p.quantity;
                total += rowTotal;

                let image = p.image 
                ? p.image 
                : '/default.png';


                html += `
                <tr>
                    <td>${index+1}</td>
                     <td>
                        <img src="${image}" width="200" height="200" class="me-2"/>
                    </td>
                    <td>${p.name}</td>
                    <td>${p.quantity}</td>
                    <td>₹${p.retail_price}</td>
                    <td>₹&nbsp;${rowTotal}</td>
                </tr>
                `;

            });

            $('#orderProducts').html(html);
            $('#orderTotal').text('₹'+total);

            $('#orderModal').modal('show');

        });

    </script>


    <script>
        $(document).ready(function() {
            $('#CheckoutTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [10, 20, 50, 100],
                dom: '<"d-flex align-items-center gap-3"l f>rtip',
                "language": {
                search: "Search Orders:",
                searchPlaceholder: "Type to filter..."
            }
            });
        });
    </script>



    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to show toastr messages based on the response
            function showToastr(response, action) {
                response.json().then(data => {
                    console.log(`Response for ${action}:`, data); // Debug output

                    if (response.ok && data.success) {
                        toastr.success(`Product ${action} updated successfully.`);
                    } else {
                        toastr.error(`Failed to update product ${action}.`);
                    }
                }).catch(err => {
                    console.error(`JSON parsing failed for ${action}:`, err); // JSON error debug
                    toastr.error(`Unexpected error for product ${action}.`);
                });
            }
        });
    </script>


@endpush