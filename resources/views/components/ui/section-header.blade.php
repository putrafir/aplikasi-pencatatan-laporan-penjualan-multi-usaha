@props(['title', 'buttonAction' => null, 'business_id'])

<div class="flex my-9 items-center justify-between gap-2 mb-4">
    <h1 class="text-2xl text-slate-700 font-bold">{{ $title }}</h1>

    @if ($buttonAction)
        <button onclick="{{ $buttonAction }}">
            <svg class="cursor-pointer" width="20" height="20" viewBox="0 0 17 17" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M8.48082 1V16M1 8.5H15.9616" stroke="black" stroke-width="2.28571" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    @endif
</div>

