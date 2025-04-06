@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="px-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($menus as $menu)
            <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm ">
                <a href="#">
                    <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                </a>
                <div class="px-5 pb-5">
                    <a href="#">
                        <h5 class="text-xl font-semibold tracking-tight text-gray-900 ">

                            {{ $menu->nama }}</h5>
                    </a>
                    <div class="flex items-center mt-2.5 mb-5">

                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-sm  ms-3">5.0</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-3xl font-bold text-gray-900 "> @php echo number_format($menu->harga, 0, ',', '.'); @endphp</span>
                        <a href="#"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Add
                            to cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
