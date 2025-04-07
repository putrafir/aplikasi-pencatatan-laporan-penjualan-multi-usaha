@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="px-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($menus as $menu)
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between">
                <a href="#">
                    <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                </a>
                <div class="px-5 pb-5 flex flex-col justify-between flex-grow">
                    <a href="#">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900">
                            {{ $menu->nama }}
                        </h5>
                    </a>
                    <div class="flex items-center mt-2.5 mb-5">
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm ms-3">5.0</span>
                    </div>
                    <div class="flex flex-col justify-between flex-grow">
                        <form action="{{ route('pegawai.pisgor.keranjang.add', $menu->id) }}" method="POST"
                            class="flex flex-col justify-between flex-grow">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <div class="flex items-center justify-between mt-4">
                                @if ($menu->business_id == 2 && $menu->kategori_id == 1)
                                    <select name="ukuran" id="ukuran" required
                                        class="block w-2/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        @foreach ($menu->kategori->sizePrices as $sizePrice)
                                            <option value="{{ $sizePrice->size->nama }}">
                                                {{ $sizePrice->size->nama }} - @php echo number_format($sizePrice->harga, 0, ',', '.'); @endphp
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <span class="text-3xl font-bold text-gray-900">
                                        @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                                    </span>
                                @endif
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-4">
                                    Tambah
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
