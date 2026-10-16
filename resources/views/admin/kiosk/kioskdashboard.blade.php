
@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important;
            margin-bottom: 20px;
        }

        .kiosk-stat-card {
            height: 100%;
        }

        .kiosk-stat-number {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .kiosk-stat-label {
            color: #6c757d;
            margin-bottom: 8px;
        }

        .kiosk-status-badge {
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
        }

        .kiosk-online {
            color: #198754;
            background: #d1e7dd;
        }

        .kiosk-offline {
            color: #dc3545;
            background: #f8d7da;
        }

        #kiosk-table td {
            vertical-align: middle;
        }
    </style>
    @endpush

    <div class="main-content app-content">
        <div class="container-fluid">

            {{-- Page header --}}
            <div class="d-md-flex d-block align-items-center
                        justify-content-between page-header-breadcrumb mb-4">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">
                        Kiosk Monitoring Dashboard
                    </h2>

                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Kiosk Monitoring
                        </li>
                    </ol>
                </div>

                <div class="d-flex gap-2">
                    <button type="button"
                            class="btn btn-secondary"
                            onclick="window.location.reload()">
                        <i class="fe fe-refresh-cw me-1"></i>
                        Refresh
                    </button>
                </div>
            </div>

            {{-- Summary cards --}}
            <div class="row g-3 mb-4">

                <div class="col-xl-3 col-md-6">
                    <div class="card custom-card kiosk-stat-card">
                        <div class="card-body">
                            <p class="kiosk-stat-label">Total Stores</p>
                            <h3 class="kiosk-stat-number">
                                {{ number_format($totalStores) }}
                            </h3>
                            <small class="text-muted">
                                Stores in the database
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card custom-card kiosk-stat-card">
                        <div class="card-body">
                            <p class="kiosk-stat-label">Registered Kiosks</p>
                            <h3 class="kiosk-stat-number">
                                {{ number_format($totalKiosks) }}
                            </h3>
                            <small class="text-muted">
                                Registered physical devices
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card custom-card kiosk-stat-card">
                        <div class="card-body">
                            <p class="kiosk-stat-label">Online Kiosks</p>
                            <h3 class="kiosk-stat-number text-success">
                                {{ number_format($onlineKiosks) }}
                            </h3>
                            <small class="text-muted">
                                Heartbeat received within 5 minutes
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card custom-card kiosk-stat-card">
                        <div class="card-body">
                            <p class="kiosk-stat-label">Offline Kiosks</p>
                            <h3 class="kiosk-stat-number text-danger">
                                {{ number_format($offlineKiosks) }}
                            </h3>
                            <small class="text-muted">
                                No recent heartbeat
                            </small>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kiosk table --}}
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                Registered Kiosk Details
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="kiosk-table"
                                       class="table table-bordered table-striped"
                                       style="width:100%">

                                    <thead>
                                        <tr>
                                            <th>SR No.</th>
                                            <th>Store Name</th>
                                            <th>Kiosk ID</th>
                                            <th>Connection Status</th>
                                            <th>LOGIN STATUS</th>
                                            <th>Last Checked</th>
                                            <th>Recorded User</th>
                                            <th>Last Login</th>
                                            <th>Last Logout</th>
                                            <th>Last IP Address</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($kiosks as $kiosk)
                                            @php
                                                $isOnline = $kiosk->last_seen_at
                                                    && $kiosk->last_seen_at->gte($cutoff);
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    {{ $kiosk->store->store_name
                                                        ?? 'Store unavailable' }}
                                                </td>

                                                <td>
                                                    {{ $kiosk->kiosk_id }}
                                                </td>

                                                <td>
                                                    @if ($isOnline)
                                                        <span class="kiosk-status-badge kiosk-online">
                                                            Online
                                                        </span>
                                                    @else
                                                        <span class="kiosk-status-badge kiosk-offline">
                                                            Offline
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                @if($kiosk->user_id !== null)
                                                    <span class="badge bg-success">Logged In</span>
                                                @else
                                                    <span class="badge bg-secondary">Logged Out</span>
                                                @endif
                                            </td>

                                                <td>
                                                    {{ $kiosk->last_seen_at
                                                        ? $kiosk->last_seen_at->format('d M Y, h:i:s A')
                                                        : 'Never' }}
                                                </td>

                                                <td>
                                                    @if ($kiosk->user)
                                                        {{ $kiosk->user->name }}
                                                    @else
                                                        —
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $kiosk->logged_in_at
                                                        ? $kiosk->logged_in_at->format('d M Y, h:i:s A')
                                                        : '—' }}
                                                </td>

                                                <td>
                                                    {{ $kiosk->logged_out_at
                                                        ? $kiosk->logged_out_at->format('d M Y, h:i:s A')
                                                        : '—' }}
                                                </td>

                                                <td>
                                                    {{ $kiosk->ip_address ?? '—' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9"
                                                    class="text-center text-muted">
                                                    No kiosks have been registered yet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>

                            <small class="text-muted">
                                Online means a heartbeat was received within
                                the last 5 minutes. User and login timestamps
                                show recorded database values and are not
                                independently verified by this dashboard.
                            </small>
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
        $('#kiosk-table').DataTable({
            stateSave: true,
            pageLength: 25,
            order: []
        });
    });
</script>
@endpush
