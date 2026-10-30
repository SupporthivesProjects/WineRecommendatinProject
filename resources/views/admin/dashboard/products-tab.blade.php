@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
        }
        #wineimage {
            overflow: visible !important;
        }

        .wine-hover-image {
            width: 100px !important;
            height: 100px !important;
            object-fit: cover;
            position: relative;
            z-index: 100;
            transform: scale(1);
            transform-origin: left center;
            transition: transform 0.5s ease-in-out;
        }

        .wine-hover-image:hover {
            transform: scale(4);
            z-index: 9999;
        }
        


    </style>
    @endpush

    <!-- Products Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Products Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.print-info') }}" type="button" class="btn btn-wave btn-primary my-2 btn-icon-text">
                            <i class="fe fe-printer me-2"></i>Print Product Info
                    </a>
                    <a  href="{{ route('admin.products.bulk-upload') }}" type="button" class="btn btn-wave btn-primary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Bulk Upload
                    </a>
                    <a  href="{{ route('admin.products.create') }}" type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text">
                        <i class="fe fe-plus me-2"></i> Add Product
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
                            <div class="d-flex justify-content-end mb-3">
                                <div style="width: 250px;">
                                    <label for="statePriceSelect" class="form-label fw-semibold">
                                        Select State
                                    </label>

                                    <select id="statePriceSelect" class="form-select">
                                        <option value="retail_price">Default Price</option>
                                        <option value="retail_price_maharashtra">Maharashtra</option>
                                        <option value="retail_price_kolkata">kolkata</option>
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="products-table" class="table table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-start">SR No.</th>
                                            <th class="text-start">Wine Name</th>
                                            <th class="text-start">Image</th>
                                            <th class="text-start">Type</th>
                                            <th class="text-start">Winery</th>
                                            <th class="text-start">Country</th>
                                            <th class="text-start">Price</th>
                                            <th class="text-start">Featured</th>
                                            <th class="text-start">Status</th>
                                            <th class="text-start">Action</th>
                                        </tr>
                                    </thead>
                                    {{-- Rows are loaded page by page by AdminProductController@index --}}
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
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

        // Then add delegated event listener
        // $(document).on('change', '.featured-toggle', function () {
        //     const productId = $(this).data('product-id');
        //     const isFeatured = $(this).is(':checked') ? 1 : 0;
        //     const url = '{{ route("admin.products.toggle-featured", [""]) }}/' + productId;

        //     $.ajax({
        //         url: url,
        //         type: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             is_featured: isFeatured
        //         },
        //         success: function(response) {
        //             if (response.success) {
        //                 toastr.success('Featured status updated successfully');
        //             } else {
        //                 toastr.error('Failed to update featured status');
        //             }
        //         },
        //         error: function(xhr) {
        //             toastr.error('An error occurred');
        //         }
        //     });

        // });
        
        $(document).on('change', '.featured-toggle', function () {

        const productId = $(this).data('product-id');
        const isFeatured = $(this).is(':checked') ? 1 : 0;
        const url = '{{ route("admin.products.toggle-featured", [""]) }}/' + productId;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_featured: isFeatured
            },
            success: function (response) {
                if (response.success) {
                    toastr.success('Featured status updated successfully');
                } else {
                    toastr.error('Failed to update featured status');
                }
            },
            error: function (xhr) {
                console.error('Featured update failed:', xhr.status, xhr.responseText);
                toastr.error('An error occurred while updating featured status');
            }
        });
        });


    </script>
    <!-- JS Function to preview images -->
    <script>
        function previewImages(input) {
            var previewContainer = document.getElementById('image-preview-container');
            var primarySelect = document.getElementById('primary_image');
            var primarySection = document.getElementById('primary-image-selection');

            previewContainer.innerHTML = "";
            primarySelect.innerHTML = "<option value=''>Select Primary Image</option>";

            if (input.files) {
                primarySection.classList.remove('d-none');
                Array.from(input.files).forEach(function (file, index) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var col = document.createElement('div');
                        col.className = "col-6 mb-2";
                        col.innerHTML = '<img src="' + e.target.result + '" class="img-fluid rounded" alt="Product Image">';
                        previewContainer.appendChild(col);

                        var option = document.createElement('option');
                        option.value = index;
                        option.text = file.name;
                        primarySelect.appendChild(option);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
    <script>
        function limitImageUpload(input) {
            const maxFiles = 5;
            const files = input.files;
            if (files.length > maxFiles) {
                alert("You can upload up to 5 images only.");
                input.value = ""; // Clear input
            }
        }
    </script>
    <script>
        // Export buttons fetch every row from the server (length -1), export, then restore the current page
        function exportAllRows(e, dt, button, config) {
            const self = this;
            const oldStart = dt.settings()[0]._iDisplayStart;

            dt.one('preXhr', function (e, s, data) {
                data.start = 0;
                data.length = -1;

                dt.one('preDraw', function (e, settings) {
                    const buttons = $.fn.dataTable.ext.buttons;
                    const className = button[0].className;

                    if (className.indexOf('buttons-copy') >= 0) {
                        buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (className.indexOf('buttons-csv') >= 0) {
                        buttons.csvHtml5.action.call(self, e, dt, button, config);
                    } else if (className.indexOf('buttons-excel') >= 0) {
                        buttons.excelHtml5.action.call(self, e, dt, button, config);
                    } else if (className.indexOf('buttons-pdf') >= 0) {
                        buttons.pdfHtml5.action.call(self, e, dt, button, config);
                    } else if (className.indexOf('buttons-print') >= 0) {
                        buttons.print.action(e, dt, button, config);
                    }

                    dt.one('preXhr', function (e, s, data) {
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });

                    setTimeout(dt.ajax.reload, 0);

                    return false;
                });
            });

            dt.ajax.reload();
        }

        $(document).ready(function () {
            $('#products-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '{{ route('admin.products.index') }}',
                order: [[0, 'asc']],
                columns: [
                    { className: 'align-middle' },
                    { className: 'align-middle' },
                    { orderable: false },
                    { className: 'align-middle' },
                    { className: 'align-middle' },
                    { className: 'align-middle' },
                    { className: 'align-middle' },
                    { className: 'align-middle text-center' },
                    { className: 'align-middle' },
                    { className: 'align-middle', orderable: false }
                ],
                createdRow: function (row) {
                    $('td', row).eq(2).attr('id', 'wineimage');
                },

                dom:
                    '<"dt-top-row"<"dt-left"lB><"dt-search"f>>' +
                    '<"dt-top-pagination"p>' +
                    'rt' +
                    '<"dt-bottom-row"<"dt-info"i><"dt-bottom-pagination"p>>',

                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'].map(function (type) {
                    return { extend: type, action: exportAllRows };
                }),

                pageLength: 10,

                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],

                lengthChange: true,
                stateSave: true,
                searchDelay: 400,

                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: 'Show _MENU_ entries'
                }
            }).on('draw', function () {
                // Default price rows already arrive formatted; only re-apply a chosen state
                if (document.getElementById('statePriceSelect').value !== 'retail_price') {
                    applyStatePrice();
                }
            });
        });

        // Show each row's price for the selected state (re-applied whenever a new page is drawn)
        function applyStatePrice() {

                const selectedState = document.getElementById('statePriceSelect').value;

                document.querySelectorAll('.product-price').forEach(function (priceCell) {

                    let price = priceCell.dataset.defaultPrice;

                    if (selectedState === 'retail_price_maharashtra') {
                        price = priceCell.dataset.maharashtraPrice;
                    }

                    if (selectedState === 'retail_price_kolkata') {
                        price = priceCell.dataset.kolkataPrice;
                    }

                    // If state-specific price is empty/null, fall back to default price
                    if (!price || price === 'null' || price === 'undefined') {
                        price = priceCell.dataset.defaultPrice;
                    }

                    priceCell.innerHTML = '₹&nbsp;' + Number(price).toLocaleString('en-IN', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                });

        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('statePriceSelect').addEventListener('change', applyStatePrice);
        });
    </script>
    

@endpush
