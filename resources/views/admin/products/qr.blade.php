@extends('layouts.bootdashboard')

@section('admindashboardcontent')
<style>
    @media print {

        @page {
            margin: 0;
        }

        body * {
            visibility: hidden !important;
        }

        .qr-print-area,
        .qr-print-area * {
            visibility: visible !important;
        }

        .qr-print-area {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            text-align: center !important;
        }

        .no-print {
            display: none !important;
        }
    }
</style>

<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb mb-4">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Product QR Code</h2>

                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.products.index') }}">Products</a>
                    </li>

                    <li class="breadcrumb-item active">
                        {{ $product->wine_name }}
                    </li>
                </ol>
            </div>

            <div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    Back to Products
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body text-center">

                <div class="qr-print-area">

                    <h3 class="mb-3">
                        {{ $product->wine_name }}
                    </h3>

                    <p class="text-muted">
                        Product ID: {{ $product->id }}
                    </p>

                    <div class="my-4">
                        {!! QrCode::size(300)->generate($url) !!}
                    </div>

                    <p class="mb-1">
                        <strong>QR URL:</strong>
                    </p>

                    <p class="text-muted">
                        {{ $url }}
                    </p>

                </div>

                <button
                    type="button"
                    class="btn btn-primary mt-3 no-print"
                    onclick="window.print()"
                >
                    <i class="fe fe-printer me-2"></i>
                    Print QR
                </button>

            </div>
        </div>

    </div>
</div>

@endsection