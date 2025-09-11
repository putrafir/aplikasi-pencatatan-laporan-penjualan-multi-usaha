<li class="mt-0.5 w-full">
    <a href="{{ route($route) }}"
        class="{{ Request::routeIs($route)
            ? 'py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors'
            : 'py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors' }}">

        <div
            class="{{ Request::routeIs($route)
                ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5'
                : 'shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5' }}">

            {{ $slot }}
        </div>

        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">{{ $label }}</span>
    </a>
</li>
