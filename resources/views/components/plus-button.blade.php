@props(['label', 'buttonAction', 'showLabel' => false])

@if ($buttonAction)
    <button onclick="{{!! $buttonAction !!}}"
        class="flex items-center gap-2 px-4 py-3 rounded-full bg-white text-gray-800 text-sm font-semibold 
        shadow-md border border-gray-200 hover:shadow-lg hover:bg-gray-50 transition">
        
        <span class="{{ $showLabel ? 'hidden md:inline' : '' }}">{{ $label }}</span>

        <svg class="w-4 h-4" fill="none" stroke="black" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 17 17"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M8.5 1V16M1 8.5H16" />
        </svg>
    </button>
@endif
