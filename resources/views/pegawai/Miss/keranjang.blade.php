@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="container mx-auto">
        <div class="mt-1 justify-between flex mb-3">
            <h1 class="font-bold">Keranjang Belanja</h1>
        </div>
        <!-- Summary -->
        <div class="bg-white p-4 rounded-lg shadow space-y-2 text-sm mb-4">
            <div class="flex justify-between font-semibold text-base">
                <span>Total: </span>
                <span id="total-bayar">@php echo number_format($totalBayar, 0, ',', '.'); @endphp</span>
            </div>
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

        <div class="space-y-4 overflow-y-auto mb-44 hide-scrollbar">
            <!-- Item -->
            @foreach ($keranjangs as $keranjang)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <img src="https://via.placeholder.com/60" alt="{{ $keranjang->menu->nama }}"
                                class="w-16 h-16 rounded object-cover">
                            <div>
                                <div class="text-sm font-semibold">{{ $keranjang->menu->nama }}</div>
                                <div class="text-xs text-gray-500">
                                    @if ($keranjang->ukuran)
                                        (Ukuran: {{ $keranjang->ukuran }})
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div id="total-harga-{{ $keranjang->id }}" class="text-md font-semibold">
                            @php echo number_format($keranjang->total_harga, 0, ',', '.'); @endphp
                        </div>

                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity('{{ $keranjang->id }}', 'decrement')"
                                class="border rounded-full w-7 h-7 flex items-center justify-center text-xl">-</button>
                            <span class="w-6 text-center" id="jumlah-{{ $keranjang->id }}">{{ $keranjang->jumlah }}</span>
                            <button onclick="updateQuantity('{{ $keranjang->id }}', 'increment')"
                                class="border rounded-full w-7 h-7 flex items-center justify-center text-xl">+</button>
                        </div>
                        <form action="{{ route('pegawai.keranjang.remove', $keranjang->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-white p-4">
            <form action="{{ route('pegawai.keranjang.checkout') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="uang_dibayarkan" class="block text-sm font-medium text-gray-700">Jumlah Uang
                        Dibayarkan</label>
                    <input type="number" name="uang_dibayarkan" id="uang_dibayarkan" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="">
                    <button type="submit"
                        class="w-full text-white bg-gradient-to-b from-blue-600 to-purple-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-base font-semibold py-3 rounded-full">Bayar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateQuantity(keranjangId, action) {
            fetch(`/pegawai/keranjang/update-quantity/${keranjangId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        action: action
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('jumlah-' + keranjangId).textContent = data.jumlah_baru;
                        document.getElementById('total-harga-' + keranjangId).textContent = data.total_harga_formatted;
                        document.getElementById('total-bayar').textContent = data.total_bayar_formatted;
                    } else {
                        alert('Gagal update keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
