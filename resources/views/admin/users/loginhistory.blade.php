
@extends('layouts.bootdashboard')
@section('admindashboardcontent')

    @push('styles')
    <style>
        .dataTables_filter input[type="search"] {
            width: 300px !important; 
            margin-bottom: 20px;
            
        }
    </style>
    @endpush


    <!-- Stores Section -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Start::page-header -->
            <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
                <div>
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Users Login Histroy</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login History</li>
                    </ol>
                </div>
            </div>

            <!-- End::page-header -->

            <!-- Start::row -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                   
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Table -->
                                <div class="table-responsive">
                                    <table id="file-export" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-start">SR No.</th>
                                                <th class="text-start">User ID</th>
                                                <th class="text-start">User Name</th>
                                                <th class="text-start">Email</th>
                                                <th class="text-start">Previous Login</th>
                                                <th class="text-start">Current Login</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($users as $index => $user)
                                                <tr>
                                                    <td class="align-middle">
                                                        {{ $index + 1 }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $user->id }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $user->first_name }} {{ $user->last_name }}
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ $user->email }}
                                                    </td>
                                                    <td class="align-middle">

                                                        {{ $user->previous_login_at
                                                            ? $user->previous_login_at->format('d M Y, h:i A')
                                                            : 'First Login' }}

                                                    </td>
                                                    <td class="align-middle">

                                                        {{ $user->last_login_at
                                                            ? $user->last_login_at->format('d M Y, h:i A')
                                                            : '-' }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">
                                                        No users found
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
            <!-- End::row -->    
            

@endsection

@push('scripts')
   
@endpush

