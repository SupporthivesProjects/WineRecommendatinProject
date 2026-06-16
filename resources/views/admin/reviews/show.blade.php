
@extends('layouts.bootdashboard')
@push('styles')
    <style>
        
    </style>
@endpush

@section('admindashboardcontent')
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right mt-2">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.reviews.index') }}">Reviews</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title mt-2">Review Details</h4>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="header-title mb-3">Review Information&nbsp;/&nbsp;#{{ $review->id }}</h4>
                                    <div class="mb-3 d-flex">
                                        <h5 class="mb-1">User:&nbsp;</h5>
                                        <p class="text-muted">
                                            <a href="{{ route('admin.users.edit', $review->user_id) }}">
                                                {{ $review->user->first_name }} {{ $review->user->last_name }}
                                            </a>
                                        </p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="mb-1">Product:&nbsp;</h5>
                                        <p class="text-muted">
                                            <a href="{{ route('admin.products.edit', $review->product_id) }}">
                                                {{ $review->product->wine_name }}
                                            </a>
                                        </p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="mb-1">Rating:&nbsp;</h5>
                                        <div class="text-warning mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                            <span class="text-muted ms-1">({{ $review->rating }}/5)</span>
                                        </div>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="mb-1">Status:&nbsp;</h5>
                                        <span class="badge newbadge
                                            @if($review->status === 'approved') bg-success
                                            @elseif($review->status === 'rejected') bg-danger
                                            @else bg-warning @endif">
                                            {{ ucfirst($review->status) }}
                                        </span>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="mb-1">Created At:&nbsp;</h5>
                                        <p class="text-muted">{{ $review->created_at->format('M d, Y h:i A') }}</p>
                                    </div>

                                    <div class="mb-3 d-flex">
                                        <h5 class="mb-1">Last Updated:&nbsp;</h5>
                                        <p class="text-muted">{{ $review->updated_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4 class="header-title mb-3">Review Comment</h4>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h4 class="header-title mb-3">Quick Actions</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-primary">
                                                <i class="fas fa-edit me-1"></i> Edit Review
                                            </a>

                                            @if($review->status !== 'approved')
                                                {{-- <form action="{{ route('admin.reviews.status', ['review' => $review->id, 'status' => 'approved']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form> 
                                                <form action="#" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form>--}}
                                            @endif

                                            @if($review->status !== 'rejected')
                                                {{-- <form action="{{ route('admin.reviews.status', ['review' => $review->id, 'status' => 'rejected']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                </form> 
                                                <form action="#" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times me-1"></i> Reject
                                                    </button>
                                                </form>--}}
                                            @endif

                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('admin.reviews.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Reviews
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
