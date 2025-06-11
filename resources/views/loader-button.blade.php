@props([
    'type' => 'button',
    'loadingText' => 'Loading...',
    'showSpinner' => true,
    'disableButton' => true,
    'pulseAnimation' => true,
    'minLoadingTime' => 500,
    'spinnerPosition' => 'left'
])

<button 
    {{ $attributes->merge(['type' => $type, 'class' => 'btn']) }}
    data-loader
    data-loading-text="{{ $loadingText }}"
    @if(!$showSpinner) data-no-spinner @endif
    @if(!$disableButton) data-no-disable @endif
    @if(!$pulseAnimation) data-no-pulse @endif
    data-min-loading-time="{{ $minLoadingTime }}"
    data-spinner-position="{{ $spinnerPosition }}"
>
    {{ $slot }}
</button>