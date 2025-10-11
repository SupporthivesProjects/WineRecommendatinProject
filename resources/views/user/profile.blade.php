@extends('layouts.bootdashboard')

@section('admindashboardcontent')
<div class="main-content app-content">
    <div class="container-fluid">
        <h2 class="main-content-title fs-24 mb-3">My Profile</h2>

        <div class="card custom-card">
            <div class="card-body">

                <div class="text-center mb-4">
                    @if($user->profile_picture)
                        <img src="{{ asset($user->profile_picture) }}" class="rounded-circle" width="120" height="120" alt="Profile Picture">
                    @else
                        <img src="{{ asset('uploads/profile_pictures/default.png') }}" class="rounded-circle" width="120" height="120" alt="Profile Picture">
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>First Name:</strong></label>
                    <p class="form-control">{{ $user->first_name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Last Name:</strong></label>
                    <p class="form-control">{{ $user->last_name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Email:</strong></label>
                    <p class="form-control">{{ $user->email }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Phone Number:</strong></label>
                    <p class="form-control">{{ $user->mobile }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Username:</strong></label>
                    <p class="form-control">{{ $user->username }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Password:</strong></label>
                    <p class="form-control">{{ $user->password }}</p>
                    <!-- Masked password for security -->
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
