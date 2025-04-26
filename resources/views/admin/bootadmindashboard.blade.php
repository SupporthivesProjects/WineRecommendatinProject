@extends('layouts.bootdashboard')
@section('admindashboardcontent')
<!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Dashboard</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <div class="justify-content-center">
                        <button type="button" class="btn btn-white btn-icon-text my-2 me-2 d-inline-flex align-items-center">
                            <i class="fe fe-download me-2 fs-14"></i> Import
                        </button>
                        <button type="button" class="btn btn-white btn-icon-text my-2 me-2 d-inline-flex align-items-center">
                            <i class="fe fe-filter me-2 fs-14"></i> Filter
                        </button>
                        <button type="button" class="btn btn-primary my-2 btn-icon-text d-inline-flex align-items-center">
                            <i class="fe fe-download-cloud me-2 fs-14"></i> Download Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- End::page-header -->

            <!-- Start::row-1 -->
            <div class="row row-sm">
                <div class="col-sm-12 col-lg-12 col-xl-12">
                    <!-- Start::First Row Cards -->
                    <div class="row row-sm">
                        <!-- <div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="card-item">
                                        <div class="card-item-icon card-icon">
                                            <svg class="text-primary" xmlns="http://www.w3.org/2000/svg"
                                                enable-background="new 0 0 24 24" height="24"
                                                viewBox="0 0 24 24" width="24">
                                                <g>
                                                    <rect height="14" opacity=".3" width="14" x="5" y="5" />
                                                    <g>
                                                        <rect fill="none" height="24" width="24" />
                                                        <g>
                                                            <path
                                                                d="M19,3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M19,19H5V5h14V19z" />
                                                            <rect height="5" width="2" x="7" y="12" />
                                                            <rect height="10" width="2" x="15" y="7" />
                                                            <rect height="3" width="2" x="11" y="14" />
                                                            <rect height="2" width="2" x="11" y="10" />
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="card-item-title mb-2">
                                            <label class="main-content-label fs-13 fw-bold mb-1">Total
                                                Revenue</label>
                                            <span class="d-block fs-12 mb-0 text-muted">Previous month vs this
                                                months</span>
                                        </div>
                                        <div class="card-item-body">
                                            <div class="card-item-stat">
                                                <h4 class="fw-bold">$5,900.00</h4>
                                                <small><b class="text-success">55%</b> higher</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Wine type pie chart starts -->
                        <div class="col-xl-4">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">Wine Types</div>
                                </div>
                                <div class="card-body">
                                    <canvas id="chartjs-pie" class="chartjs-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- wine type pie chart ends -->
                        <!-- country wise donought chart starts -->
                        <div class="col-xl-8">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">Country Wise Wines</div>
                                </div>
                                <div class="card-body">
                                    <canvas id="chartjs-bar" class="chartjs-chart"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- country wise donought chart ends -->


                    </div>
                    <!-- End::row -->
                    
                    <!-- Start::row -->
                    <div class="row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="card custom-card overflow-hidden">
                                <div class="card-header border-bottom-0">
                                    <div>
                                        <label class="card-title">Questionnaire </label> <span
                                            class="d-block fs-12 mb-0 text-muted">Number of times the Questionnaire was used in last 7 days</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="project"></div>
                                </div>
                            </div>
                        </div><!-- col end -->
                        
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card">
                                    <div class="card-header">
                                        <div class="card-title">File Export Datatable</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="file-export" class="table table-bordered text-nowrap" style="width:100%">
                                                <thead>
                                                <tr>
                                                            <th class="text-left">SR No.</th>
                                                            <th class="text-left">Wine Name</th>
                                                            <th class="text-left">Type</th>
                                                            <th class="text-left">Winery</th>
                                                            <th class="text-left">Price</th>
                                                            <th class="text-left">Status</th>
                                                            <th class="text-left">Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($products as $index => $product)
                                                    <tr>
                                                        <td class="align-middle">{{ $index + 1 }}</td>
                                                        <td class="align-middle">{{ $product->wine_name }}</td>
                                                        <td class="align-middle">{{ ucfirst($product->type) }}</td>
                                                        <td class="align-middle">{{ $product->winery }}</td>
                                                        <td class="align-middle">${{ number_format($product->retail_price, 2) }}</td>
                                                        <td class="align-middle">
                                                        <span class="badge rounded-pill border border-{{ $product->status === 'active' ? 'success' : 'danger' }} text-{{ $product->status === 'active' ? 'success' : 'danger' }} py-1 px-3">
                                                            {{ ucfirst($product->status) }}
                                                        </span>

                                                        </td>
                                                        <td class="align-middle">
                                                            <a href="{{ route('admin.products.show', $product) }}" class="text-primary">View</a>
                                                        </td>
                                                    </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center">No products found</td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div><!-- col end -->
                    </div>
                    <!-- End::row -->

                </div><!-- col end -->
            </div>
            <!-- End::row-1 -->
        </div>
    </div>
<!-- End::app-content -->

@endsection
