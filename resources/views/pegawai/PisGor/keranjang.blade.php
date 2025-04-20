@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="container mx-auto">
        <div class=" justify-between flex">
            <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>
            <h1 class="text-2xl font-bold mb-4">Total @php echo number_format($totalBayar, 0, ',', '.'); @endphp</h1>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2">Subtotal</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keranjangs as $keranjang)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $keranjang->menu->nama }}
                            @if ($keranjang->extra_topping)
                                ➕ Extra Topping
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php echo number_format($keranjang->harga_satuan, 0, ',', '.'); @endphp
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $keranjang->jumlah }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @php echo number_format($keranjang->total_harga, 0, ',', '.'); @endphp
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <form action="{{ route('pegawai.keranjang.remove', $keranjang->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            <form action="{{ route('pegawai.keranjang.checkout') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="uang_dibayarkan" class="block text-sm font-medium text-gray-700">Jumlah Uang
                        Dibayarkan</label>
                    <input type="number" name="uang_dibayarkan" id="uang_dibayarkan" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <button type="submit"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Bayar
                </button>
            </form>
        </div>
    </div>
@endsection
