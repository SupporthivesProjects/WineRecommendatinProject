@extends('layouts.bootdashboard')
@section('admindashboardcontent')

    @push('styles')
    @endpush

    <div class="main-content app-content">
        <div class="container-fluid">
        <!-- Start::page-header -->
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
                <a href="{{ route('admin.stores.index') }}" class="btn btn-wave btn-secondary my-2 btn-icon-text ms-2"> <!-- Add ms-2 here -->
                    <i class="fe fe-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>

        <!-- End : page-heaer -->

        <!-- Start row -->
            <div class="py-5">
                <div class="container-lg">
                    <div class="bg-white overflow-hidden shadow-sm rounded p-4">
                        <div class="p-4 bg-white border-bottom">
                            <div class="row row-cols-1  g-4">
                                <div class="col-md-12">
                                    <h3 class="h5 text-dark">{{ $store->store_name }}</h3>
                                    <p class="mt-1 text-muted">
                                        {{ $store->business_type ?? 'No business type specified' }}
                                    </p>
                                </div>

                                <div class="border-top">
                                    <dl>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">Store Name</dt>
                                            <dd class="col-sm-9">{{ $store->store_name }}</dd>
                                        </div>
                                        <div class="bg-white p-3 row">
                                            <dt class="col-sm-3 text-muted">Business Type</dt>
                                            <dd class="col-sm-9">{{ $store->business_type ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">Address</dt>
                                            <dd class="col-sm-9">{{ $store->address ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-white p-3 row">
                                            <dt class="col-sm-3 text-muted">Contact Number</dt>
                                            <dd class="col-sm-9">{{ $store->contact_number ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">Email</dt>
                                            <dd class="col-sm-9">{{ $store->email ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-white p-3 row">
                                            <dt class="col-sm-3 text-muted">State</dt>
                                            <dd class="col-sm-9">{{ $store->state ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">License Type</dt>
                                            <dd class="col-sm-9">{{ $store->licence_type ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-white p-3 row">
                                            <dt class="col-sm-3 text-muted">License Number</dt>
                                            <dd class="col-sm-9">{{ $store->license_number ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">Group</dt>
                                            <dd class="col-sm-9">{{ $store->group ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-white p-3 row">
                                            <dt class="col-sm-3 text-muted">GST/VAT</dt>
                                            <dd class="col-sm-9">{{ $store->gst_vat ?? 'N/A' }}</dd>
                                        </div>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">Status</dt>
                                            <dd class="col-sm-9">
                                                <span class="badge {{ $store->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($store->status) }}
                                                </span>
                                            </dd>
                                        </div>
                                        <div class="bg-white p-3 row">
                                            <dt class="col-sm-3 text-muted">Created At</dt>
                                            <dd class="col-sm-9">{{ $store->created_at->format('F j, Y, g:i a') }}</dd>
                                        </div>
                                        <div class="bg-light p-3 row">
                                            <dt class="col-sm-3 text-muted">Last Updated</dt>
                                            <dd class="col-sm-9">{{ $store->updated_at->format('F j, Y, g:i a') }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Store Users Section -->
                    <div class="mt-4 bg-white overflow-hidden shadow-sm rounded">
                        <div class="p-4 bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h5 text-dark">Store Users</h3>
                                <button onclick="openAssignUserModal()" class="btn btn-danger">
                                    <i class="bi bi-person-plus"></i> Add User
                                </button>
                            </div>
                            <!-- Users Table -->
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
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
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

                    <!-- Store Products Section -->
                    <div class="mt-4 bg-white overflow-hidden shadow-sm rounded">
                        <div class="p-4 bg-white border-bottom">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="h5 text-dark">Store Products</h3>
                            </div>
                            <!-- Products Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Wine Name</th>
                                            <th>Type</th>
                                            <th>Vintage</th>
                                            <th>Price</th>
                                            <!-- Other columns here -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Products rows go here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- End Row -->
        </div>
    </div>

    <!-- Assign User Modal -->
    <div id="assignUserModal" class="modal fade" tabindex="-1" aria-labelledby="assignUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignUserModalLabel">Assign User to Store</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_search" class="form-label">Search Users</label>
                        <input type="text" class="form-control" id="user_search" placeholder="Search by name or email">
                    </div>
                    
                    <div class="mb-3 max-h-60 overflow-auto">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="users_table_body">
                                <!-- Users will be loaded here via JavaScript -->
                                <tr>
                                    <td colspan="3" class="text-center">Loading users...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @push('scripts')
        <script>
            // Store ID for use in JavaScript
            const storeId = {{ $store->id }};
            
            // Function to open the assign user modal
            function openAssignUserModal() {
                const modal = new bootstrap.Modal(document.getElementById('assignUserModal'));
                modal.show();
                loadAvailableUsers();
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
    @endpush


