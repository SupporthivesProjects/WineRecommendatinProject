{{-- Suggestions for the store State field (create and edit forms). Maharashtra and West Bengal
     stores show those states' wine prices; "Kolkata", "WB", "Mumbai" etc. are saved as the
     state name (see App\Models\Store::canonicalState()). --}}
<datalist id="store-state-options">
    <option value="{{ \App\Models\Store::PRICE_REGION_WEST_BENGAL }}">
    <option value="{{ \App\Models\Store::PRICE_REGION_MAHARASHTRA }}">
    @foreach (['Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jammu and Kashmir', 'Jharkhand', 'Karnataka', 'Kerala', 'Ladakh', 'Madhya Pradesh', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand'] as $stateOption)
        <option value="{{ $stateOption }}">
    @endforeach
</datalist>
<small class="text-muted d-block mt-1">
    Stores in {{ \App\Models\Store::PRICE_REGION_MAHARASHTRA }} or {{ \App\Models\Store::PRICE_REGION_WEST_BENGAL }} show that state's wine prices.
</small>
