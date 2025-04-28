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

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start::page-header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">System Settings</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start::row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">

                        <form action="#" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- General Settings -->
                                <div class="col-md-6">
                                    <h4 class="mb-3">General Settings</h4>
                                    <div class="p-4 bg-light rounded">
                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">Site Name</label>
                                            <input type="text" class="form-control" id="site_name" name="site_name" value="WineRecommender">
                                        </div>
                                        <div class="mb-3">
                                            <label for="contact_email" class="form-label">Contact Email</label>
                                            <input type="email" class="form-control" id="contact_email" name="contact_email" value="contact@winerecommender.com">
                                        </div>
                                        <div class="mb-3">
                                            <label for="timezone" class="form-label">Timezone</label>
                                            <select class="form-select" id="timezone" name="timezone">
                                                <option value="UTC">UTC</option>
                                                <option value="Asia/Kolkata" selected>Asia/Kolkata</option>
                                                <option value="America/New_York">America/New_York</option>
                                                <option value="Europe/London">Europe/London</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Settings -->
                                <div class="col-md-6">
                                    <h4 class="mb-3">Email Settings</h4>
                                    <div class="p-4 bg-light rounded">
                                        <div class="mb-3">
                                            <label for="mail_driver" class="form-label">Mail Driver</label>
                                            <select class="form-select" id="mail_driver" name="mail_driver">
                                                <option value="smtp">SMTP</option>
                                                <option value="sendmail">Sendmail</option>
                                                <option value="mailgun">Mailgun</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_host" class="form-label">Mail Host</label>
                                            <input type="text" class="form-control" id="mail_host" name="mail_host" value="smtp.mailtrap.io">
                                        </div>
                                        <div class="mb-3">
                                            <label for="mail_port" class="form-label">Mail Port</label>
                                            <input type="text" class="form-control" id="mail_port" name="mail_port" value="2525">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fe fe-save me-2"></i> Save Settings
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- End::row -->

    </div>
</div>

@endsection
