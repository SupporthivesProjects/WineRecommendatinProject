@csrf

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $product->name ?? '') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" 
                     class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="price">Price <span class="text-danger">*</span></label>
            <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" name="price" id="price" step="0.01" min="0" 
                       class="form-control @error('price') is-invalid @enderror" 
                       value="{{ old('price', $product->price ?? '') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-check form-switch mt-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" 
                   {{ (old('is_active') ?? ($product->is_active ?? true)) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Product Image</h5>
            </div>
            <div class="card-body text-center">
                @if(isset($product) && $product->image)
                    <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" 
                         class="img-fluid mb-3" style="max-height: 200px;">
                @else
                    <div id="image-preview" class="d-none">
                        <img src="#" class="img-fluid mb-3" style="max-height: 200px;">
                    </div>
                @endif
                
                <div class="form-group">
                    <input type="file" name="image" id="image" class="form-control-file @error('image') is-invalid @enderror" 
                           onchange="previewImage(this)">
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Recommended size: 600x600px</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <button type="submit" class="btn btn-primary">
            {{ isset($product) ? 'Update' : 'Create' }} Cheese Product
        </button>
        <a href="{{ route('admin.cheese-products.index') }}" class="btn btn-light">Cancel</a>
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
            }
            preview.querySelector('img').src = e.target.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
