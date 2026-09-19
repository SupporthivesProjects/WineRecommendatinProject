@extends('layouts.bootdashboard')

@section('admindashboardcontent')

    @push('styles')
        <style>
            .dataTables_filter input[type="search"] {
                width: 300px !important;
                margin-bottom: 20px;
            }

            .select-all-wrapper {
                white-space: nowrap;
            }

            .product-checkbox,
            #selectAll {
                cursor: pointer;
            }

            .product-name {
                cursor: pointer;
            }
        </style>
    @endpush


    <div class="main-content app-content">

        <div class="container-fluid">

            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">

                <div>
                    <h2 class="main-content-title fs-24 mb-1">
                        Bulk Product QR Codes
                    </h2>

                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Home</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">
                            Bulk QR
                        </li>
                    </ol>
                </div>

            </div>
            <!-- End Page Header -->


            <div class="row">

                <div class="col-xl-12">

                    <div class="card custom-card">

                        <div class="card-header">
                            <div class="card-title">
                                Select Products
                            </div>
                        </div>


                        <form
                            action="{{ route('admin.products.bulk-qr.generate') }}"
                            method="POST"
                            target="_blank"
                        >

                            @csrf


                            <div class="card-body">

                                <!-- DataTable -->
                                <div class="table-responsive">

                                    <table
                                        id="file-export"
                                        class="table table-bordered"
                                        style="width:100%"
                                    >

                                        <thead>

                                            <tr>

                                                <th width="50">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            id="selectAll"
                                                        >
                                                    </div>
                                                </th>

                                                <th>
                                                    SR No.
                                                </th>

                                                <th>
                                                    Product Name
                                                </th>

                                                <th>
                                                    Product ID
                                                </th>

                                            </tr>

                                        </thead>


                                        <tbody>

                                            @forelse($products as $index => $product)

                                                <tr>

                                                    <!-- Checkbox -->
                                                    <td class="align-middle">

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input product-checkbox"
                                                                type="checkbox"
                                                                name="product_ids[]"
                                                                value="{{ $product->id }}"
                                                                id="product_{{ $product->id }}"
                                                            >

                                                        </div>

                                                    </td>


                                                    <!-- SR No -->
                                                    <td class="align-middle">

                                                        {{ $index + 1 }}

                                                    </td>


                                                    <!-- Product Name -->
                                                    <td class="align-middle">

                                                        <label
                                                            for="product_{{ $product->id }}"
                                                            class="product-name mb-0"
                                                        >
                                                            {{ $product->wine_name }}
                                                        </label>

                                                    </td>


                                                    <!-- Product ID -->
                                                    <td class="align-middle">

                                                        {{ $product->id }}

                                                    </td>

                                                </tr>

                                            @empty

                                                <tr>

                                                    <td
                                                        colspan="4"
                                                        class="text-center"
                                                    >
                                                        No products found
                                                    </td>

                                                </tr>

                                            @endforelse

                                        </tbody>

                                    </table>

                                </div>
                                <!-- End DataTable -->

                            </div>


                            <!-- Footer -->
                            <div class="card-footer bg-white text-end">

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                    id="generateQrBtn"
                                >

                                    <i class="fe fe-file-text me-2"></i>

                                    Generate PDF

                                </button>

                            </div>
                            <!-- End Footer -->


                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


@endsection


@push('scripts')

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const selectAll = document.getElementById('selectAll');

        /*
        |--------------------------------------------------------------------------
        | Select All
        |--------------------------------------------------------------------------
        */

        if (selectAll) {

            selectAll.addEventListener('change', function () {

                document
                    .querySelectorAll('.product-checkbox')
                    .forEach(function (checkbox) {

                        checkbox.checked = selectAll.checked;

                    });

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Individual Checkbox
        |--------------------------------------------------------------------------
        */

        document.addEventListener('change', function (event) {

            if (!event.target.classList.contains('product-checkbox')) {
                return;
            }

            const checkboxes =
                document.querySelectorAll('.product-checkbox');

            const checked =
                document.querySelectorAll('.product-checkbox:checked');


            if (selectAll) {

                selectAll.checked =
                    checkboxes.length > 0 &&
                    checkboxes.length === checked.length;

            }

        });


        /*
        |--------------------------------------------------------------------------
        | Generate PDF Validation
        |--------------------------------------------------------------------------
        */

        const generateQrBtn =
            document.getElementById('generateQrBtn');


        if (generateQrBtn) {

            generateQrBtn.addEventListener('click', function (event) {

                const checked =
                    document.querySelectorAll(
                        '.product-checkbox:checked'
                    );


                if (checked.length === 0) {

                    event.preventDefault();

                    alert('Please select at least one product.');

                    return false;

                }

            });

        }

    });

</script>
<script>
$(document).ready(function () {

    $('#file-export').DataTable({
        destroy: true,
        dom: 'lfrtip', // l = Show Entries dropdown
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ]
    });

});
</script>

@endpush