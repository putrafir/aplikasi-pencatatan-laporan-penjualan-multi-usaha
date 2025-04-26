@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div>
        <!-- Search -->
        <div class="p-4">
            <form method="GET" action="{{ route('pegawai.pisgor.menu') }}">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Produk"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </form>
        </div>

        <!-- Dropdown Filter Kategori -->
        <div class="p-4 mb-4">
            <label for="filter_kategori" class="block mb-1 text-sm">Filter Kategori</label>
            <form method="GET" action="{{ route('pegawai.pisgor.menu') }}">
                @if (request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <select name="kategori_nama" id="filter_kategori" class="w-full border rounded-lg p-2"
                    onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori->nama }}"
                            {{ request('kategori_nama') == $kategori->nama ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-2 gap-4 px-4 justify-items-center">
            @foreach ($menus as $menu)
                <div
                    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between items-center text-center">
                    <a href="#">
                        <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                    </a>
                    <div class="px-2 mb-5 flex flex-col justify-between flex-grow items-center">
                        <a href="#">
                            <h5 class="font-semibold text-3 tracking-tight text-gray-900">
                                {{ $menu->nama }}
                            </h5>
                        </a>
                        <div class="flex flex-col justify-between flex-grow items-center">
                            <form action="{{ route('pegawai.pisgor.keranjang.add', $menu->id) }}" method="POST"
                                class="flex flex-col justify-between flex-grow items-center">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <div class="flex flex-col gap-2 mt-4 items-center">
                                    @if ($menu->business_id == 2 && $menu->kategori_id == 1)
                                        <select name="ukuran" id="ukuran" required
                                            class="block w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm text-center">
                                            @foreach ($menu->kategori->sizePrices as $sizePrice)
                                                <option value="{{ $sizePrice->size->nama }}">
                                                    {{ $sizePrice->size->nama }} - @php echo number_format($sizePrice->harga, 0, ',', '.'); @endphp
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <span class="text-m text-gray-900">
                                            @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                                        </span>
                                    @endif
                                    <button type="submit"
                                        class="text-white bg-gradient-to-b from-blue-600 to-purple-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                        Tambah
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Tombol Keranjang -->
        <div
            class="fixed ring-2 ring-white bottom-12 right-4 w-14 h-14 rounded-full bg-gradient-to-tl from-purple-700 to-pink-500 shadow-lg flex items-center justify-center z-50">
            <a href="{{ route('pegawai.pisgor.keranjang.view') }}"
                class="flex items-center justify-center w-full h-full relative">
                <svg class="w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                        clip-rule="evenodd" />
                </svg>

                {{-- Badge hanya ditampilkan jika jumlah item > 0 --}}
                @if ($jumlah_item > 0)
                    <span
                        class="absolute top-0 right-0 w-5 h-5 text-xs text-white bg-red-500 rounded-full flex items-center justify-center">
                        {{ $jumlah_item }}
                    </span>
                @endif
            </a>
        </div>
    </div>
@endsection
