
@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
        <style>
            .dataTables_filter input[type="search"] {
                width: 300px !important;
                margin-bottom: 20px;
            }

            .ticket-message {
                min-width: 250px;
                max-width: 450px;
                white-space: normal;
                overflow-wrap: anywhere;
            }

            .ticket-status {
                min-width: 145px;
            }
        </style>
    @endpush

    <div class="main-content app-content">
        <div class="container-fluid">

            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">
                        Support Tickets
                    </h2>

                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Support Tickets
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">All Support Tickets</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="SupportTickets"
                                       class="table table-bordered"
                                       style="width:100%">

                                    <thead>
                                        <tr>
                                            <th>Ticket ID</th>
                                            <th>Store Name</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Submission Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->id }}</td>

                                                <td>{{ $ticket->store_name }}</td>

                                                <td class="ticket-message">
                                                    {{ $ticket->message }}
                                                </td>

                                                <td>
                                                    <select
                                                        class="form-select form-select-sm ticket-status"
                                                        data-id="{{ $ticket->id }}"
                                                        data-previous-status="{{ $ticket->status }}">

                                                        <option value="submitted"
                                                            {{ $ticket->status === 'submitted' ? 'selected' : '' }}>
                                                            Submitted
                                                        </option>

                                                        <option value="inprogress"
                                                            {{ $ticket->status === 'inprogress' ? 'selected' : '' }}>
                                                            In Progress
                                                        </option>

                                                        <option value="closed"
                                                            {{ $ticket->status === 'closed' ? 'selected' : '' }}>
                                                            Closed
                                                        </option>
                                                    </select>
                                                </td>

                                                <td>
                                                    {{ $ticket->created_at->format('d M Y, h:i A') }}
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
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        // Initialize DataTable only once
        $('#SupportTickets').DataTable({
            pageLength: 10,
            order: [[0, 'desc']]
        });

        // Update ticket status using AJAX
        $(document).on('change', '.ticket-status', function () {
            const select = $(this);
            const ticketId = select.data('id');
            const previousStatus = select.data('previous-status');
            const newStatus = select.val();

            select.prop('disabled', true);

            $.ajax({
                url: '/admin/support-tickets/' + ticketId + '/status',
                type: 'PATCH',
                data: {
                    status: newStatus,
                    _token: '{{ csrf_token() }}'
                },

                success: function (response) {
                    if (response.success) {
                        select.data('previous-status', response.status);

                        Swal.fire({
                            icon: 'success',
                            title: 'Status Updated',
                            text: 'Support ticket status updated successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    } else {
                        select.val(previousStatus);
                    }
                },

                error: function (xhr) {
                    select.val(previousStatus);

                    let message = 'Unable to update ticket status. Please try again.';

                    if (xhr.status === 422) {
                        message = 'Invalid status selected.';
                    } else if (xhr.status === 403) {
                        message = 'You are not authorized to update this ticket.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: message,
                        confirmButtonText: 'OK'
                    });
                },

                complete: function () {
                    select.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
