@props(['testimonial'])

<div class="testimonial-item bg-gray-50 p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
    <div class="flex items-center mb-4">
        @if($testimonial->image_url)
            <img src="{{ asset('storage/' . $testimonial->image_url) }}" 
                 alt="{{ $testimonial->name }}"
                 class="h-12 w-12 rounded-full object-cover">
        @else
            <div class="h-12 w-12 rounded-full bg-red-200 flex items-center justify-center text-red-700 font-bold text-xl">
                {{ $testimonial->initials }}
            </div>
        @endif
        <div class="ml-4">
            <h4 class="text-lg font-semibold text-gray-900">{{ $testimonial->name }}</h4>
            @if($testimonial->position || $testimonial->company)
                <p class="text-sm text-gray-500">
                    {{ $testimonial->position }}{{ $testimonial->position && $testimonial->company ? ', ' : '' }}
                    {{ $testimonial->company }}
                </p>
            @endif
            <div class="flex text-yellow-400 mt-1">
                @for($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        viewBox="0 0 20 20" fill="{{ $i <= $testimonial->rating ? 'currentColor' : '#E5E7EB' }}">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                @endfor
            </div>
        </div>
    </div>
    <p class="text-gray-600 italic">
        "{{ $testimonial->testimonial }}"
    </p>
</div>
