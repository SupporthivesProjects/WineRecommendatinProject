@csrf

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $testimonial->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="testimonial">Testimonial <span class="text-danger">*</span></label>
            <textarea name="testimonial" id="testimonial" rows="4" 
                     class="form-control @error('testimonial') is-invalid @enderror" required>{{ old('testimonial', $testimonial->testimonial ?? '') }}</textarea>
            @error('testimonial')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="position">Position</label>
                    <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror" 
                           value="{{ old('position', $testimonial->position ?? '') }}">
                    @error('position')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" name="company" id="company" class="form-control @error('company') is-invalid @enderror" 
                           value="{{ old('company', $testimonial->company ?? '') }}">
                    @error('company')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="rating">Rating <span class="text-danger">*</span></label>
                    <select name="rating" id="rating" class="form-select @error('rating') is-invalid @enderror" required>
                        @for($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ (old('rating', $testimonial->rating ?? 5) == $i) ? 'selected' : '' }}>
                                {{ $i }} {{ Str::plural('Star', $i) }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sort_order">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" min="0" 
                           class="form-control @error('sort_order') is-invalid @enderror" 
                           value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}">
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                   {{ (old('is_active') ?? ($testimonial->is_active ?? true)) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Profile Image</h5>
            </div>
            <div class="card-body text-center">
                @if(isset($testimonial) && $testimonial->image_url)
                    <img id="image-preview" src="{{ asset('storage/' . $testimonial->image_url) }}" 
                         class="img-fluid mb-3" style="max-height: 200px; border-radius: 4px;">
                @else
                    <div id="image-preview" class="d-none">
                        <img src="#" class="img-fluid mb-3" style="max-height: 200px; border-radius: 4px;">
                    </div>
                @endif
                
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" 
                           onchange="previewImage(this)">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Recommended size: 200x200px (will be cropped to square)</small>
                </div>

                <div class="form-group mt-3">
                    <label for="initials">Initials (if no image) <span class="text-danger">*</span></label>
                    <input type="text" name="initials" id="initials" maxlength="2" 
                           class="form-control text-center @error('initials') is-invalid @enderror" 
                           value="{{ old('initials', $testimonial->initials ?? '') }}" 
                           style="width: 60px; margin: 0 auto; text-transform: uppercase;" required>
                    @error('initials')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <button type="submit" class="btn btn-primary">
            <i class="fe fe-save"></i> {{ isset($testimonial) ? 'Update' : 'Create' }} Testimonial
        </button>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">
            <i class="fe fe-x"></i> Cancel
        </a>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            if (preview.classList.contains('d-none')) {
                preview.classList.remove('d-none');
                preview.style.display = 'block';
            }
            preview.querySelector('img').src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else if (preview) {
            preview.classList.add('d-none');
        }
    }

    // Auto-generate initials from name
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const initialsInput = document.getElementById('initials');
        
        if (nameInput && initialsInput) {
            nameInput.addEventListener('blur', function() {
                const nameValue = this.value.trim();
                
                if (nameValue && (!initialsInput.value || initialsInput.value.length === 0)) {
                    const names = nameValue.split(' ');
                    let initials = '';
                    
                    if (names.length >= 2) {
                        initials = (names[0].charAt(0) + names[names.length - 1].charAt(0)).toUpperCase();
                    } else if (nameValue.length >= 2) {
                        initials = nameValue.substring(0, 2).toUpperCase();
                    }
                    
                    initialsInput.value = initials;
                }
            });
        }
    });
</script>
@endpush
