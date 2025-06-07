
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
                    <h2 class="main-content-title fs-24 mb-1">Welcome To Manager Board</h2>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manager</li>
                    </ol>
                </div>
                <div class="d-flex">
                    <button type="button" class="btn btn-wave btn-secondary my-2 btn-icon-text" data-bs-toggle="modal" data-bs-target="#addManagerModal">
                    <i class="fe fe-plus me-2"></i>Add Manager
                    </button>
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
                                                <th class="text-start">Name</th>
                                                <th class="text-start">Contact</th>
                                                <th class="text-start">Email</th>
                                                <th class="text-start">Status</th>
                                                <th class="text-start">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($mainManagers as $index => $manager)
                                            <tr>
                                                <td class="text-start">{{ $index + 1 }}</td>
                                                <td class="text-start">{{ $manager->first_name }} {{ $manager->last_name }}</td>
                                                <td class="text-start">{{ $manager->mobile }}</td>
                                                <td class="text-start">{{ $manager->email }}</td>
                                                <td class="text-start">
                                                    <span class="badge bg-{{ $manager->status == 'active' ? 'success' : 'danger' }}">
                                                        {{ ucfirst($manager->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-start">
                                                <a href="{{ route('admin.assign.stores', $manager->id) }}" class="btn btn-sm btn-primary">
                                                    Assign Stores
                                                </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No managers exist.</td>
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


        <!-- Add User Modal -->
        <div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.main_manager.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text" class="form-control" id="role" name="role" value="main_manager" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($errors->has('duplicate'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Duplicate User',
                    text: '{{ $errors->first('duplicate') }}'
                });
            </script>
        @endif

        @if ($errors->any() && !$errors->has('duplicate'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                });
            </script>
        @endif


@endsection

@push('scripts')
    <script>
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordField = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                eyeIcon.classList.toggle('bi-eye');
                eyeIcon.classList.toggle('bi-eye-slash');
            });
        </script>
   
@endpush

