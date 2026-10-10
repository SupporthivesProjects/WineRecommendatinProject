@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
        <style>
            .dt-buttons {
                display: none !important;
            }

            /* Keep DataTables controls on one line */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
            }

            .dataTables_wrapper .dataTables_length {
                float: left;
            }

            .dataTables_wrapper .dataTables_filter {
                float: right;
                justify-content: flex-end;
            }

            /* Increase search input size */
            .dataTables_wrapper .dataTables_filter input {
                width: 300px !important;
                min-width: 300px;
                height: 42px;
                margin-left: 10px;
            }

            /* Keep the search label and input aligned */
            .dataTables_wrapper .dataTables_filter label {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 0;
            }

            /* Clear floats after the controls */
            .dataTables_wrapper::after {
                content: "";
                display: block;
                clear: both;
            }

            /* Responsive layout for smaller screens */
            @media (max-width: 576px) {
                .dataTables_wrapper .dataTables_length,
                .dataTables_wrapper .dataTables_filter {
                    float: none;
                    width: 100%;
                    justify-content: space-between;
                    margin-bottom: 12px;
                }

                .dataTables_wrapper .dataTables_filter input {
                    width: 65% !important;
                    min-width: 0;
                }
            }


        </style>
    @endpush
    
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome to Support Dashboard</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Support</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <a href="{{ route('store-manager.dashboard') }}" class="btn btn-wave btn-secondary my-2">
                        <i class="fe fe-arrow-left me-2"></i> Back to Dashboard
                    </a>
                </div>
            </div>
            <!-- End::page-header -->

            <!-- Start::row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Submitted tickets</h4>

                            <a href="{{ route('store-manager.support') }}" class="btn btn-primary">
                                Raise Ticket
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="container mt-4">
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ticket ID</th>
                                                    <th>Submission Date</th>
                                                    <th>Message</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($tickets as $ticket)
                                                    <tr>
                                                        <td>{{ $ticket->id }}</td>
                                                        <td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                                                        <td>{{ \Illuminate\Support\Str::limit($ticket->message, 60) }}</td>
                                                        <td>
                                                            @if ($ticket->status === 'submitted')
                                                                <span class="badge bg-primary">Submitted</span>
                                                            @elseif ($ticket->status === 'inprogress')
                                                                <span class="badge bg-warning text-dark">In Progress</span>
                                                            @elseif ($ticket->status === 'closed')
                                                                <span class="badge bg-success">Closed</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('store-manager.tickets.show', $ticket->id) }}"
                                                            class="btn btn-sm btn-info">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            No support tickets found.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End::row -->
        </div>
    </div>

    @push('scripts')
    
    @endpush
@endsection



