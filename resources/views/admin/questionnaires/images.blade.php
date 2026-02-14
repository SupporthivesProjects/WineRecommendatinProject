@extends('layouts.bootdashboard')

@section('admindashboardcontent')

<div class="main-content app-content">
    <div class="container-fluid">

        <!-- PAGE HEADER -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-header-breadcrumb mb-4">
            <h4>Questionnaire Modal Images</h4>
        </div>

        <!-- ROW 1 : EXISTING IMAGES -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5>Existing Images</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            @forelse($images as $image)
                                <div class="col-md-3 mb-4">
                                    <div class="card position-relative">

                                        <!-- Action Icons -->
                                        <div class="position-absolute top-0 end-0 p-2 d-flex gap-2">

                                            <!-- Toggle Active -->
                                            <form action="{{ route('admin.questionnaires.toggleImage', $image->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $image->is_active ? 'btn-success' : 'btn-secondary' }}">
                                                    <i class="bi {{ $image->is_active ? 'bi-eye' : 'bi-eye-slash' }}"></i>
                                                </button>
                                            </form>

                                            <!-- Delete -->
                                            <form action="{{ route('admin.questionnaires.deleteImage', $image->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Image -->
                                        <img src="{{ asset('storage/' . $image->image) }}"
                                             class="card-img-top"
                                             style="height:200px; object-fit:contain;">

                                        <!-- Status Badge -->
                                        <div class="card-body text-center">
                                            @if($image->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center">
                                    <p>No images uploaded yet.</p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ROW 2 : UPLOAD NEW IMAGE -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5>Upload New Image</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.questionnaires.storeImages') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="row g-3">

                            @csrf

                            <div class="col-md-6">
                                <input type="file"
                                       name="image"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <button type="submit"
                                        class="btn btn-primary">
                                    Upload Image
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
