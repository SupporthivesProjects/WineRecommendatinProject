
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

        .kiosk-label {
            display: block;
            font-weight: 600;
        }

        .kiosk-id-small {
            font-size: 11px;
            color: #6c757d;
            word-break: break-all;
        }

        .kiosk-stale {
            margin-left: 4px;
            padding: 3px 7px;
            border-radius: 5px;
            font-size: 11px;
            color: #6c757d;
            background: #e9ecef;
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
                            <h3 class="kiosk-stat-number" id="kiosk-total-stores">
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
                            <h3 class="kiosk-stat-number" id="kiosk-total-kiosks">
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
                            <h3 class="kiosk-stat-number text-success" id="kiosk-online-kiosks">
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
                            <h3 class="kiosk-stat-number text-danger" id="kiosk-offline-kiosks">
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
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody id="kiosk-rows">
                                        @foreach ($kiosks as $kiosk)
                                            @php
                                                $isOnline = $kiosk->last_seen_at
                                                    && $kiosk->last_seen_at->gte($cutoff);
                                                $isStale = !$kiosk->last_seen_at
                                                    || $kiosk->last_seen_at->lt($staleCutoff);
                                                $userName = $kiosk->user
                                                    ? (trim($kiosk->user->first_name . ' ' . $kiosk->user->last_name) ?: $kiosk->user->email)
                                                    : null;
                                            @endphp

                                            <tr data-kiosk-row="{{ $kiosk->id }}">
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    {{ $kiosk->store->store_name
                                                        ?? 'Store unavailable' }}
                                                </td>

                                                <td>
                                                    @if ($kiosk->label)
                                                        <span class="kiosk-label">{{ $kiosk->label }}</span>
                                                        <span class="kiosk-id-small">{{ $kiosk->kiosk_id }}</span>
                                                    @else
                                                        {{ $kiosk->kiosk_id }}
                                                    @endif
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
                                                        @if ($isStale)
                                                            <span class="kiosk-stale" title="Not seen for {{ \App\Http\Controllers\KioskMonitoringController::STALE_DAYS }}+ days">Stale</span>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                {{-- Login state is only known while the kiosk is reporting --}}
                                                @if ($isOnline && $kiosk->user_id !== null)
                                                    <span class="badge bg-success">Logged In</span>
                                                @elseif ($kiosk->user_id !== null)
                                                    <span class="badge bg-warning text-dark" title="Logged in when the kiosk was last seen">Last user (offline)</span>
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
                                                    {{ $userName ?? '—' }}
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

                                                <td class="text-nowrap">
                                                    <button type="button"
                                                            class="btn btn-sm btn-outline-secondary kiosk-rename"
                                                            data-url="{{ route('admin.kiosks.label', $kiosk) }}"
                                                            data-label="{{ $kiosk->label }}"
                                                            title="Name this kiosk">
                                                        <i class="fe fe-edit-2"></i>
                                                    </button>
                                                    @if (!$isOnline && $isStale)
                                                        <button type="button"
                                                                class="btn btn-sm btn-outline-danger kiosk-remove"
                                                                data-url="{{ route('admin.kiosks.destroy', $kiosk) }}"
                                                                data-name="{{ $kiosk->label ?: $kiosk->kiosk_id }}"
                                                                title="Remove this stale kiosk">
                                                            <i class="fe fe-trash-2"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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
        const table = $('#kiosk-table').DataTable({
            stateSave: true,
            pageLength: 25,
            order: [],
            columnDefs: [{ targets: -1, orderable: false, searchable: false }],
            language: { emptyTable: 'No kiosks have been registered yet.' }
        });

        const csrf = $('meta[name="csrf-token"]').attr('content');

        // Refresh the counts and rows every minute without reloading (keeps page, search and sort)
        function refreshDashboard(force) {
            if (!force && (document.visibilityState !== 'visible' || (window.Swal && Swal.isVisible()))) {
                return;
            }
            fetch(window.location.href, { credentials: 'same-origin', headers: { 'Accept': 'text/html' } })
                .then(response => response.ok ? response.text() : Promise.reject())
                .then(html => {
                    const page = new DOMParser().parseFromString(html, 'text/html');
                    ['kiosk-total-stores', 'kiosk-total-kiosks', 'kiosk-online-kiosks', 'kiosk-offline-kiosks'].forEach(id => {
                        const fresh = page.getElementById(id);
                        const current = document.getElementById(id);
                        if (fresh && current) {
                            current.textContent = fresh.textContent;
                        }
                    });
                    const rows = page.querySelectorAll('#kiosk-rows > tr');
                    table.clear();
                    table.rows.add($(Array.from(rows)));
                    table.draw(false);
                })
                .catch(() => {
                    // Keep showing the last data; the next refresh will try again
                });
        }
        setInterval(() => refreshDashboard(false), 60 * 1000);

        // Name a kiosk
        $(document).on('click', '.kiosk-rename', function () {
            const url = this.dataset.url;
            Swal.fire({
                title: 'Kiosk name',
                input: 'text',
                inputValue: this.dataset.label || '',
                inputPlaceholder: 'e.g. Entrance tablet',
                inputAttributes: { maxlength: 100 },
                showCancelButton: true,
                confirmButtonText: 'Save'
            }).then(result => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: url,
                    type: 'PATCH',
                    data: { _token: csrf, label: result.value },
                    success: () => refreshDashboard(true),
                    error: () => Swal.fire('Error', 'The name could not be saved.', 'error')
                });
            });
        });

        // Remove a stale kiosk (the server also refuses kiosks seen within the last week)
        $(document).on('click', '.kiosk-remove', function () {
            const url = this.dataset.url;
            Swal.fire({
                title: 'Remove this kiosk?',
                text: this.dataset.name + ' has not been seen for over a week. It will be registered again automatically if someone logs in on it.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Remove'
            }).then(result => {
                if (!result.isConfirmed) {
                    return;
                }
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: { _token: csrf },
                    success: () => refreshDashboard(true),
                    error: xhr => Swal.fire('Not removed', (xhr.responseJSON && xhr.responseJSON.message) || 'The kiosk could not be removed.', 'error')
                });
            });
        });
    });
</script>
@endpush
