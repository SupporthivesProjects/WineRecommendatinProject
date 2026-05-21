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

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header border-bottom-0 d-flex pb-0 justify-content-between">
                        <div>
                            <label class="main-content-label mb-2 pt-1">Uploaded Records</label>
                            <p class="fs-12 mb-3 text-muted mb-0">
                                Your uploaded & manual entries
                            </p>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table id="UploadsTable" class="table table-vcenter border mb-0">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Invoice</th>
                                        <th>Customer</th>
                                        <th>Mobile</th>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($records as $key => $row)

                                        @php
                                            $isEditable = \Carbon\Carbon::parse($row->created_at)->gt(now()->subHours(48));
                                        @endphp

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->invoice_no }}</td>
                                            <td>{{ $row->customer_name }}</td>
                                            <td>{{ $row->customer_mobile }}</td>
                                            <td>{{ $row->product_name }}</td>
                                            <td>₹&nbsp;{{ number_format($row->product_price,2) }}</td>
                                            <td>{{ $row->created_at->format('d M Y H:i') }}</td>

                                            <td>
                                                @if($isEditable)
                                                <button 
                                                    class="btn btn-sm btn-primary editRecord"
                                                    data-id="{{ $row->id }}"
                                                    data-invoice="{{ $row->invoice_no }}"
                                                    data-name="{{ $row->customer_name }}"
                                                    data-mobile="{{ $row->customer_mobile }}"
                                                    data-product="{{ $row->product_name }}"
                                                    data-price="{{ $row->product_price }}"
                                                >
                                                    Edit
                                                </button>
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>
                                                        Edit Disabled
                                                    </button>
                                                @endif
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
</div>
<!-- edit modal starts-->

<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Record</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm">
                @csrf

                <div class="modal-body">

                    <input type="hidden" id="edit_id">

                    <div class="mb-2">
                        <label>Invoice</label>
                        <input type="text" id="edit_invoice" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Customer Name</label>
                        <input type="text" id="edit_name" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Mobile</label>
                        <input type="text" id="edit_mobile" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Product</label>
                        <input type="text" id="edit_product" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Price</label>
                        <input type="number" id="edit_price" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- edit modal ends -->


@endsection
@push('scripts')

<script>
    $(document).ready(function() {

        // Destroy if already initialized (prevents silent bugs)
        if ($.fn.DataTable.isDataTable('#UploadsTable')) {
            $('#UploadsTable').DataTable().destroy();
        }

        $('#UploadsTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 20, 50, 100],
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            dom: '<"d-flex align-items-center gap-3"l f>rtip',
            "language": {
                search: "Search Records:",
                searchPlaceholder: "Type to filter..."
            }
        });

    });
</script>
<script>
    $(document).on('click', '.editRecord', function(){

        $('#edit_id').val($(this).data('id'));
        $('#edit_invoice').val($(this).data('invoice'));
        $('#edit_name').val($(this).data('name'));
        $('#edit_mobile').val($(this).data('mobile'));
        $('#edit_product').val($(this).data('product'));
        $('#edit_price').val($(this).data('price'));

        $('#editModal').modal('show');
    });
</script>
<script>
    $('#editForm').submit(function(e){
        e.preventDefault();

        let id = $('#edit_id').val();

        $.ajax({
            url: `/store-manager/uploads/update/${id}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                invoice_no: $('#edit_invoice').val(),
                customer_name: $('#edit_name').val(),
                customer_mobile: $('#edit_mobile').val(),
                product_name: $('#edit_product').val(),
                product_price: $('#edit_price').val()
            },
            success: function(res){

                $('#editModal').modal('hide');

                Swal.fire({
                    title: 'Updated!',
                    text: 'Record updated successfully',
                    icon: 'success'
                }).then(()=>{
                    location.reload(); // simple + reliable
                });

            },
            error: function(){
                Swal.fire('Error','Something went wrong','error');
            }
        });
    });
</script>
@endpush

