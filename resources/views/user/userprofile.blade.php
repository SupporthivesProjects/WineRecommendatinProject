@extends('layouts.bootdashboard')

@section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">

            <!-- Enhanced Header -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="px-3 py-2 rounded shadow-sm d-flex align-items-center"
                    style="background: linear-gradient(90deg, #007bff 0%, #4a90e2 100%); color: #fff; border-left: 5px solid #0056b3;">
                    <i class="fe fe-user me-2 fs-20"></i>
                    <h4 class="mb-0 fw-semibold">User Profile</h4>
                </div>
            </div>

            <div class="card custom-card shadow-sm">
                <div class="card-body p-0">

                    <!-- Top Banner with Image -->
                    <div
                        style="
                    background-image: url('https://images.alphacoders.com/529/thumb-1920-529303.jpg');
                    background-size: cover;
                    background-position: center;
                    height: 250px;
                    border-top-left-radius: 6px;
                    border-top-right-radius: 6px;">
                    </div>

                    <!-- Profile Section -->
                    <div class="p-4 bg-white" style="margin-top: -60px; border-radius: 6px;">
                        <div class="row align-items-start">

                            <!-- Left Section -->
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-4">
                                    <!-- Profile Image / Initial Circle -->
                                    <div class="me-3 position-relative" style="width:100px; height:100px;">
                                        @if ($user->profile_picture)
                                            <img src="{{ asset($user->profile_picture) }}"
                                                class="rounded-circle border border-3 border-white shadow w-100 h-100 object-fit-cover"
                                                alt="Profile Picture">
                                        @else
                                            <div class="d-flex justify-content-center align-items-center rounded-circle border border-3 border-white shadow"
                                                style="width:100px; height:100px; background-color:#f44336; color:#fff; font-size:36px; font-weight:bold;">
                                                {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <h4 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h4>
                                        <p class="text-muted mb-0">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <!-- Edit Profile Fields (Display Only) -->
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="mb-3">Edit Profile</h5>

                                        <!-- Success / Error Messages -->
                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif


                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label"><strong>First Name</strong></label>
                                                <p class="form-control">{{ $user->first_name }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label"><strong>Last Name</strong></label>
                                                <p class="form-control">{{ $user->last_name }}</p>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong>Email Address</strong></label>
                                            <p class="form-control">{{ $user->email }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong>Phone Number</strong></label>
                                            <p class="form-control">{{ $user->mobile }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong>Username</strong></label>
                                            <p class="form-control">{{ $user->username }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><strong></strong></label>
                                            <p class="form-control">*********</p>
                                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#passwordFields" aria-expanded="false"
                                                aria-controls="passwordFields">
                                                Update Password
                                            </button>
                                        </div>

                                        <div class="collapse mt-3" id="passwordFields">
                                            <form method="POST" action="{{ route('profile.update.password') }}">
                                                @csrf

                                                <!-- Current Password -->
                                                <div class="mb-2 position-relative">
                                                    <input type="password" name="current_password"
                                                        class="form-control password-field"
                                                        placeholder="Enter current password">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary show-hide-btn"
                                                        style="position:absolute; right:5px; top:50%; transform:translateY(-50%);">Show</button>
                                                </div>

                                                <!-- New Password -->
                                                <div class="mb-2 position-relative">
                                                    <input type="password" name="new_password"
                                                        class="form-control password-field"
                                                        placeholder="Enter new password">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary show-hide-btn"
                                                        style="position:absolute; right:5px; top:50%; transform:translateY(-50%);">Show</button>
                                                </div>

                                                <!-- Confirm Password -->
                                                <div class="mb-2 position-relative">
                                                    <input type="password" name="new_password_confirmation"
                                                        class="form-control password-field"
                                                        placeholder="Confirm new password">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary show-hide-btn"
                                                        style="position:absolute; right:5px; top:50%; transform:translateY(-50%);">Show</button>
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-sm mt-2">Submit New
                                                    Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Right Section (Account Info) -->
                            <div class="col-md-4 mt-4 mt-md-0">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="mb-3">Account Information</h5>
                                        <p class="mb-2"><strong>Member since:</strong>
                                            {{ $user->created_at->format('F d, Y') }}</p>
                                        <p class="mb-2"><strong>Last updated:</strong>
                                            {{ $user->updated_at->format('F d, Y h:i A') }}</p>

                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Back Button (Bottom Center) -->
                        <div class="text-center mt-4">
                            <a href="{{ route('dashboard') }}" class="btn text-white px-4 py-2"
                                style="background: linear-gradient(90deg, #ff4da6 0%, #ff6fcf 100%); border:none;">
                                <i class="fe fe-arrow-left me-1"></i> Back to Dashboard
                            </a>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <script>
        document.querySelectorAll('.show-hide-btn').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    this.textContent = 'Hide';
                } else {
                    input.type = 'password';
                    this.textContent = 'Show';
                }
            });
        });
    </script>

@endsection
