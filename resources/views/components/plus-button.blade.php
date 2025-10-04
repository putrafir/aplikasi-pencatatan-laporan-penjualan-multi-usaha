@props(['buttonAction'])

@if ($buttonAction)
    <button onclick="{!! $buttonAction !!}">
        <svg class="cursor-pointer" width="20" height="20" viewBox="0 0 17 17" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M8.48082 1V16M1 8.5H15.9616" stroke="black" stroke-width="2.28571" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
@endif
