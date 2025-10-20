@props([
    'route' => null,
    'label' => '',
    'icon' => null,
    'dropdownItems' => null, // kalau ada dropdown
])

@php
    // Cek active untuk route utama
    $isActive = Request::routeIs(is_array($route) ? $route[0] . '*' : $route . '*');

    // Cek active untuk dropdown
    $isDropdownActive = false;
    if ($dropdownItems) {
        foreach ($dropdownItems as $item) {
            if (Request::fullUrlIs(route($route, $item->id) . '*')) {
                $isDropdownActive = true;
                break;
            }
        }
    }
@endphp

<li
    @if ($dropdownItems) x-data="{ open: {{ $isDropdownActive ? 'true' : 'false' }} }" class="relative"
    @else
        class="mt-0.5 w-full" @endif>
    {{-- Kalau ada dropdown --}}
    @if ($dropdownItems)
        <button @click="open = !open"
            class="flex items-center w-full px-8 py-3 text-sm font-semibold transition-all duration-200 ease-nav-brand rounded-lg
                {{ $isDropdownActive ? 'bg-white text-slate-700 shadow-soft-xl' : 'text-slate-700 hover:bg-gray-100' }}">

            @if ($icon)
                <i class="fa {{ $icon }} mr-3"></i>
            @else
                <div
                    class="{{ $isDropdownActive
                        ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg'
                        : 'bg-white text-slate-800 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg' }}">
                    {{ $slot }}
                </div>
            @endif

            <span>{{ $label }}</span>
            <svg class="ml-auto w-3 h-3 transition-transform duration-200" :class="{ 'rotate-180': open }"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- Dropdown items --}}
        <ul x-show="open" x-transition class="pl-12 space-y-1 bg-gray-50 rounded-md py-2">
            @foreach ($dropdownItems as $item)
                @php
                    $isItemActive = Request::fullUrlIs(route($route, $item->id) . '*');
                @endphp
                <li>
                    <a href="{{ route($route, $item->id) }}"
                        class="block px-4 py-2 text-sm rounded-md transition
                            {{ $isItemActive ? 'bg-blue-100 text-blue-600 font-semibold' : 'text-gray-700 hover:text-blue-600' }}">
                        {{ $item->name ?? $item->nama_usaha }}
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Kalau bukan dropdown --}}
    @else
        <a href="{{ is_array($route) ? route($route[0], $route[1]) : route($route) }}"
            class="{{ $isActive
                ? 'py-2.7 shadow-soft-xl text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg bg-white px-4 font-semibold text-slate-700 transition-colors'
                : 'py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors' }}">

            @if ($icon)
                <i class="fa {{ $icon }} mr-3"></i>
            @else
                <div
                    class="{{ $isActive
                        ? 'bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-white'
                        : 'shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-white text-slate-800' }}">
                    {{ $slot }}
                </div>
            @endif

            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease-soft">{{ $label }}</span>
        </a>
    @endif
</li>
