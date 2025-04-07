@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="px-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($menus as $menu)
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col">
                {{-- Gambar Produk --}}
                <a href="#">
                    <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                </a>

                {{-- Informasi Produk --}}
                <div class="px-5 pb-5 flex flex-col flex-grow">
                    <a href="#">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900">
                            {{ $menu->nama }}
                        </h5>
                    </a>
                    <div class="flex items-center mt-2.5 mb-5">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm ms-3">
                            5.0
                        </span>
                    </div>

                    {{-- Form Tambah ke Keranjang --}}
                    <form action="{{ route('pegawai.pisgor.keranjang.add', $menu->id) }}" method="POST"
                        class="flex flex-col flex-grow">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                        <div class="flex items-center justify-between mt-4">
                            {{-- Harga Produk --}}
                            <span class="text-3xl font-bold text-gray-900">
                                @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                            </span>

                            {{-- Extra Topping (Opsional) --}}
                            @if ($menu->kategori_id == 4)
                                <label class="ml-4 text-sm text-gray-700">
                                    <input type="checkbox" name="extra_topping" value="1" class="mr-1">
                                    ➕ Extra Topping (+3.000)
                                </label>
                            @endif

                            {{-- Tombol Tambah --}}
                            <button type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-4">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection
