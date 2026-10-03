@extends('layouts.bootdashboard')

@section('admindashboardcontent')

<div class="main-content app-content">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center my-4">
            <h2>Print Product Information</h2>
        </div>

        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Select Fields for PDF</div>
            </div>

            <form
                action="{{ route('admin.products.print-info.generate') }}"
                method="POST"
                target="_blank"
                id="printInfoForm"
            >
                @csrf

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <button type="button"
                                class="btn btn-sm btn-secondary"
                                id="selectAllFields">
                            Select All
                        </button>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary"
                                id="clearAllFields">
                            Clear All
                        </button>
                    </div>

                    <div class="row">
                        @foreach ($fields as $key => $label)
                            <div class="col-md-4 col-lg-3 mb-3">
                                <div class="form-check">
                                    <input
                                        class="form-check-input field-checkbox"
                                        type="checkbox"
                                        name="fields[]"
                                        value="{{ $key }}"
                                        id="field_{{ $key }}"
                                        {{ in_array($key, [
                                            'wine_name',
                                            'type',
                                            'country',
                                            'winery',
                                            'vintage_year',
                                            'retail_price'
                                        ]) ? 'checked' : '' }}
                                    >

                                    <label
                                        class="form-check-label"
                                        for="field_{{ $key }}"
                                    >
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-file-text me-2"></i>
                        Generate PDF
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.field-checkbox');

    document.getElementById('selectAllFields').addEventListener('click', function () {
        checkboxes.forEach(checkbox => checkbox.checked = true);
    });

    document.getElementById('clearAllFields').addEventListener('click', function () {
        checkboxes.forEach(checkbox => checkbox.checked = false);
    });

    document.getElementById('printInfoForm').addEventListener('submit', function (event) {
        const selected = document.querySelectorAll('.field-checkbox:checked');

        if (selected.length === 0) {
            event.preventDefault();
            alert('Please select at least one field.');
        }
    });
});
</script>
@endpush