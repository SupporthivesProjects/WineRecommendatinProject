@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
   
    @endpush

    <!-- Products Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Invoices Dashboard</h2>
                   
                </div>
                <div class="d-flex">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text">
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
                            <div class="table-responsive">
                                <table id="invoice-table" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SR No</th>
                                            <th>Store Name</th>
                                            <th>Total Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($invoices as $index => $invoice)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>

                                            <td>{{ $invoice->store_name }}</td>

                                            <td>
                                                ₹ {{ number_format($invoice->total_amount,2) }}
                                            </td>

                                            <td>
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}
                                            </td>

                                            <td>
                                                <button 
                                                    class="btn btn-sm btn-info viewInvoices"
                                                    data-store="{{ $invoice->store_id }}"
                                                    data-date="{{ $invoice->invoice_date }}"
                                                >
                                                    <i class="fe fe-eye"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                        @empty

                                        <tr>
                                            <td colspan="5" class="text-center">No invoices found</td>
                                        </tr>

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Modal code starts -->

                        <div class="modal fade" id="invoiceModal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">Invoice Details</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Invoice No</th>
                                                    <th>Customer</th>
                                                    <th>Mobile</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>

                                            <tbody id="invoiceDetailsBody">

                                            </tbody>

                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div>


                        <!-- Modal Code ends -->

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
            <!-- End::row -->




        </div>
    </div>
    <!-- End::Products Section -->

   


@endsection

@push('scripts')

<script>
    $(document).ready(function(){
        $('#invoice-table').DataTable();


        $(document).on('click','.viewInvoices',function(){

            let store_id = $(this).data('store');
            let date = $(this).data('date');

            $.ajax({
                url: "/admin/invoice-details/"+store_id+"/"+date,
                type: "GET",
                success:function(res){
                let rows = "";

                res.forEach(function(invoice){

                    let productDisplay = "";

                    if(invoice.exact_match){

                        productDisplay = `
                            ${invoice.product_name}
                            <span class="badge bg-success ms-1">
                                <i class="fe fe-check"></i>
                            </span>
                        `;

                    }else{

                        productDisplay = `
                            ${invoice.product_name}

                            <span 
                                class="badge bg-danger ms-2 fixProduct"
                                style="cursor:pointer"
                                data-id="${invoice.id}"
                                data-product="${invoice.closest_match}"
                            >
                                ${invoice.closest_match}
                            </span>
                        `;
                    }

                    rows += `
                        <tr>
                            <td>${invoice.invoice_no}</td>
                            <td>${invoice.customer_name}</td>
                            <td>${invoice.customer_mobile}</td>
                            <td>${productDisplay}</td>
                            <td>₹ ${invoice.product_price}</td>
                        </tr>
                    `;

                });

                $("#invoiceDetailsBody").html(rows);

                $("#invoiceModal").modal('show');

                }

            });

        });

        });
</script>
<script>
    $(document).on("click",".fixProduct",function(){
    let invoice_id = $(this).data("id");
    let product_name = $(this).data("product");

    $.ajax({

        url: "/admin/update-invoice-product",

        type: "POST",

        data:{
            _token: "{{ csrf_token() }}",
            invoice_id: invoice_id,
            product_name: product_name
        },

        success:function(){

            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Product updated successfully',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        }

    });

    });
</script>

  
@endpush
