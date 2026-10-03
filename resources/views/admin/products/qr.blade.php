@extends('layouts.bootdashboard')

@section('admindashboardcontent')
<style>
    .qr-print-area {
        text-align: center;
        padding: 15px;
    }

    .qr-logo {
        margin-bottom: 10px;
    }

    .qr-logo img {
        max-width: 100px;
        max-height: 50px;
        width: auto;
        height: auto;
        display: block;
        margin: 0 auto;
    }

    .qr-code svg {
        width: 1in !important;
        height: 1in !important;
        display: block;
        margin: 0 auto;
    }

    .qr-product-name {
        font-size: 16px;
        font-weight: bold;
        margin-top: 10px;
        text-align: center;
    }

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
                {{-- Logo --}}
                <div class="qr-logo">
                    <img
                        src="{{ asset('images/logoredwhite.jpg') }}"
                        alt="Logo"
                    >
                </div>

                {{-- QR Code --}}
                <div class="qr-code">
                    {!! QrCode::size(96)->generate($url) !!}
                </div>

                {{-- Product Name --}}
                <div class="qr-product-name">
                    {{ $product->wine_name }}
                </div>

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