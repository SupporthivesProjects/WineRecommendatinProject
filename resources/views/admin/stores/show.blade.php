@extends('layouts.bootdashboard')
@section('admindashboardcontent')

@push('styles')



@endpush

<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb">
            <div>
                <h2 class="main-content-title fs-24 mb-1">{{ __('Store Details') }}</h2>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Stores</li>
                </ol>
            </div>
            <div class="d-flex">
                <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-wave btn-primary my-2 btn-icon-text">
                    <i class="fe fe-edit me-2"></i>Edit Store
                </a>
                <a href="{{ route('admin.stores.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2">
                    <i class="fe fe-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <!-- Tabs Navigation -->
         <div class="">
            <ul class="nav nav-tabs mb-3" id="storeTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details"
                        type="button" role="tab" aria-controls="details" aria-selected="true" style="background-color:transparent!important;border:0px solid black!imporant;">
                        Store Details
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="users-tab" data-bs-toggle="tab" data-bs-target="#users"
                        type="button" role="tab" aria-controls="users" aria-selected="false" style="background-color:transparent!important;border:0px!imporant;">
                        Store Users
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products"
                        type="button" role="tab" aria-controls="products" aria-selected="false" style="background-color:transparent!important;border:0px!imporant;">
                        Store Products
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tabs Content -->
        <div class="tab-content" id="storeTabContent">
            <!-- Store Details Tab -->
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <h3 class="h5 text-dark mb-4">{{ $store->store_name }}</h3>
                    <dl>
                        @php
                            $rows = [
                                'Store Name' => $store->store_name,
                                'Business Type' => $store->business_type ?? 'N/A',
                                'Address' => $store->address ?? 'N/A',
                                'Contact Number' => $store->contact_number ?? 'N/A',
                                'Email' => $store->email ?? 'N/A',
                                'State' => $store->state ?? 'N/A',
                                'License Type' => $store->licence_type ?? 'N/A',
                                'License Number' => $store->license_number ?? 'N/A',
                                'Group' => $store->group ?? 'N/A',
                                'GST/VAT' => $store->gst_vat ?? 'N/A',
                                'Status' => $store->status,
                                'Created At' => $store->created_at->format('F j, Y, g:i a'),
                                'Last Updated' => $store->updated_at->format('F j, Y, g:i a')
                            ];
                        @endphp

                        @foreach($rows as $label => $value)
                            <div class="row border-bottom py-2">
                                <dt class="col-sm-3 text-muted">{{ $label }}</dt>
                                <dd class="col-sm-9">
                                    @if ($label === 'Status')
                                        <span class="badge {{ $value === 'active' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($value) }}
                                        </span>
                                    @else
                                        {{ $value }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>

            <!-- Store Users Tab -->
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 text-dark">Store Users</h3>
                        <button onclick="openAssignUserModal()" class="btn btn-danger">
                            <i class="bi bi-person-plus"></i> Add User
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($store->users as $user)
                                    <tr>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-info btn-sm">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No users found for this store.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Store Products Tab -->
            <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                <div class="bg-white overflow-hidden shadow-sm rounded p-4 mb-4">
                    <h3 class="h5 text-dark mb-3">Store Products</h3>
                    <div class="table-responsive">
                        <table class="table table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Wine Name</th>
                                    <th>Type</th>
                                    <th>Vintage</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($store->products as $product)
                                    <tr>
                                        <td>{{ $product->wine_name }}</td>
                                        <td>{{ ucfirst($product->type) }}</td>
                                        <td>{{ $product->vintage_year }}</td>
                                        <td>{{ $product->retail_price }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

       
        <!-- Add user to a store -->

         <!-- Add User Modal -->
         <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.users.store') }}" method="POST">
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
                                    <input type="text" class="form-control" id="role" name="role" value="store_manager" readonly>
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
                                <div class="mb-3 col-md-6">
                                    <label for="store_id" class="form-label">Store Id</label>
                                    <input type="text" class="form-control" id="store_id" name="store_id" value="{{ $store->id }}">
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
            // Store ID for use in JavaScript
            const storeId = {{ $store->id }};
            
            // Function to open the assign user modal
            function openAssignUserModal() {
                const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
                modal.show();
                //loadAvailableUsers();
            }
            
            // Function to close the assign user modal
            function closeAssignUserModal() {
                const modal = bootstrap.Modal.getInstance(document.getElementById('assignUserModal'));
                modal.hide();
            }
            
            // Function to load available store managers
            function loadAvailableUsers() {
                fetch(`/admin/stores/${storeId}/available-managers`)
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.getElementById('users_table_body');
                        
                        if (data.length === 0) {
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="3" class="text-center">No available store managers found</td>
                                </tr>
                            `;
                            return;
                        }
                        
                        let html = '';
                        data.forEach(user => {
                            html += `
                                <tr>
                                    <td>${user.first_name} ${user.last_name}</td>
                                    <td>${user.email}</td>
                                    <td class="text-center">
                                        <button onclick="assignUserToStore(${user.id})" 
                                                class="btn btn-indigo btn-sm">
                                            Assign
                                        </button>
                                    </td>
                                </tr>
                            `;
                        });
                        
                        tableBody.innerHTML = html;
                        
                        // Add search functionality
                        document.getElementById('user_search').addEventListener('input', filterUsers);
                    })
                    .catch(error => {
                        console.error('Error loading users:', error);
                        document.getElementById('users_table_body').innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center text-danger">Error loading users</td>
                            </tr>
                        `;
                    });
            }
            
            // Function to filter users based on search input
            function filterUsers() {
                const searchTerm = document.getElementById('user_search').value.toLowerCase();
                const rows = document.querySelectorAll('#users_table_body tr');
                
                rows.forEach(row => {
                    const name = row.cells[0].textContent.toLowerCase();
                    const email = row.cells[1].textContent.toLowerCase();
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
            
            // Function to assign a user to the store
            function assignUserToStore(userId) {
                // Send a POST request to assign the user
                fetch(`/admin/stores/${storeId}/assign-user`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ user_id: userId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal
                        closeAssignUserModal();
                        
                        // Refresh the page to show the updated user list
                        window.location.reload();
                    } else {
                        alert(data.message || 'Failed to assign user to store');
                    }
                })
                .catch(error => {
                    console.error('Error assigning user:', error);
                    alert('An error occurred while assigning the user');
                });
            }
        </script>

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


