@php
    $isEdit = isset($testimonial);
    $route = $isEdit ? route('admin.testimonials.update', $testimonial->id) : route('admin.testimonials.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $title = $isEdit ? 'Edit Testimonial' : 'Add New Testimonial';
    $buttonText = $isEdit ? 'Update Testimonial' : 'Create Testimonial';
@endphp

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{ $title }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method($method)

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" 
                                       value="{{ old('name', $testimonial->name ?? '') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Initials <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="initials" 
                                       value="{{ old('initials', $testimonial->initials ?? '') }}" 
                                       maxlength="10" required>
                                <small class="form-text text-muted">Max 10 characters</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Testimonial <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="testimonial" rows="4" required>{{ old('testimonial', $testimonial->testimonial ?? '') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Position</label>
                                <input type="text" class="form-control" name="position" 
                                       value="{{ old('position', $testimonial->position ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Company</label>
                                <input type="text" class="form-control" name="company" 
                                       value="{{ old('company', $testimonial->company ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Rating <span class="text-danger">*</span></label>
                        <div class="rating">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" 
                                           id="rating-{{ $i }}" value="{{ $i }}"
                                           {{ old('rating', $testimonial->rating ?? 5) == $i ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="rating-{{ $i }}">
                                        @for($j = 1; $j <= $i; $j++)
                                            <i class="fas fa-star text-warning"></i>
                                        @endfor
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Sort Order</label>
                        <input type="number" class="form-control" name="sort_order" 
                               value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0">
                        <small class="form-text text-muted">Lower numbers appear first</small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" 
                                   id="is_active" value="1" 
                                   {{ old('is_active', $testimonial->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary me-2">
                            <i class="fe fe-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fe fe-save"></i> {{ $buttonText }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Profile Image</h4>
            </div>
            <div class="card-body">
                <div class="form-group text-center">
                    @if($isEdit && $testimonial->image_url)
                        <img src="{{ asset('storage/' . $testimonial->image_url) }}" 
                             class="img-fluid mb-3" 
                             style="max-height: 200px;"
                             alt="{{ $testimonial->name }}">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px; border: 2px dashed #ddd; border-radius: 4px; margin-bottom: 15px;">
                            <div class="text-center">
                                <i class="fe fe-image" style="font-size: 48px; color: #ccc;"></i>
                                <p class="mt-2">No image selected</p>
                            </div>
                        </div>
                    @endif
                    
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image" 
                               onchange="previewImage(this)">
                        <label class="custom-file-label" for="image">Choose image</label>
                    </div>
                    <small class="form-text text-muted">Recommended size: 400x400px (JPG, PNG, GIF, SVG, max 2MB)</small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Preview image before upload
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = input.closest('.form-group').querySelector('img');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    const previewDiv = input.closest('.form-group').querySelector('div.bg-light');
                    if (previewDiv) {
                        previewDiv.innerHTML = `<img src="${e.target.result}" class="img-fluid" style="max-height: 200px;" alt="Preview">`;
                    }
                }
                
                // Update file label
                const fileName = input.files[0].name;
                const label = input.nextElementSibling;
                if (label) {
                    label.textContent = fileName;
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Initialize file input labels
    document.addEventListener('DOMContentLoaded', function() {
        const fileInputs = document.querySelectorAll('.custom-file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0] ? this.files[0].name : 'Choose file';
                const label = this.nextElementSibling;
                if (label) {
                    label.textContent = fileName;
                }
            });
        });
    });
</script>
@endpush