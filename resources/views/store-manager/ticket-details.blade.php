
@extends('layouts.bootdashboard')

@section('admindashboardcontent')

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">Support Ticket #{{ $ticket->id }} </h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Support</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('store-manager.tickets.index') }}"
                class="btn btn-secondary">
                    <i class="fe fe-arrow-left me-2"></i> Back to Tickets
                </a>
            </div>
        </div>
        <!-- End::page-header -->
        <div class="card custom-card">
            <div class="card-header">
                <h4 class="card-title">Ticket Details  </h4><br> 
                

            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Store Name</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $ticket->store_name }}"
                           readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Submission Date</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $ticket->created_at->format('d M Y, h:i A') }}"
                           readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control"
                              rows="5"
                              readonly>{{ $ticket->message }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <input type="text"
                           class="form-control"
                           value="{{ ucfirst($ticket->status === 'inprogress' ? 'In Progress' : $ticket->status) }}"
                           readonly>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
