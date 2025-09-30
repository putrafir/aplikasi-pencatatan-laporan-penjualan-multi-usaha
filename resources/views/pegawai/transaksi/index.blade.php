@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <!-- Search -->
    <form id="search-input" placeholder="Cari Produk" class="max-w-md px-4 pb-4 mx-auto">
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="default-search"
                class="block w-full py-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-3xl bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                placeholder="Cari Menu.." required />
            <button type="submit"
                class="text-white  absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-3xl text-sm px-4 py-1">Cari</button>
        </div>
    </form>

    <!-- CATEGORY FILTER -->
    <div class="flex gap-3 px-4 py-2 w-full text-sm overflow-x-auto" id="kategori-buttons">
        {{-- Tombol ALL --}}
        <button onclick="loadMenus('all', this)" class="kategori-btn px-3 py-1 rounded-full bg-pink-500 text-white">
            All
        </button>
        {{-- Tombol Kategori --}}
        @foreach ($categories as $category)
            <button onclick="loadMenus('{{ $category->id }}', this)"
                class="kategori-btn px-3 py-1 rounded-full bg-pink-500 text-gray-700">
                {{ $category->nama }}
            </button>
        @endforeach
    </div>

    <!-- LIST MENU -->
    <div id="menu-list" class="max-w-7xl mx-auto p-4 grid grid-cols-2 gap-4">
        <!-- Menu akan di-load dengan AJAX -->
    </div>

    {{-- tombol keranjang --}}
    <div id="floating-cart"
        class="fixed ring-2 ring-white bottom-10 right-4 w-14 h-14 rounded-full bg-gradient-to-tl from-purple-700 to-pink-500 shadow-lg flex items-center justify-center z-50">
        <a href="{{ route('pegawai.keranjang') }}" class="flex items-center justify-center w-full h-full relative">
            <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                    clip-rule="evenodd" />
            </svg>

            <!-- Badge jumlah item -->
            <span id="cart-badge"
                class="absolute top-0 right-0 w-5 h-5 text-xs text-white bg-red-500 rounded-full flex items-center justify-center hidden">
                0
            </span>
        </a>
    </div>

    <script src="{{ asset('js/loadMenu.js') }}"></script>
@endsection
