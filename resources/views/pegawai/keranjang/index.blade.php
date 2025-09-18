@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="container mx-auto space-y-4">
        {{-- Judul --}}
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold">Keranjang Belanja</h2>
            </div>
        </div>

        {{-- List Keranjang --}}
        <div class="space-y-4 overflow-y-auto pb-56 hide-scrollbar">
            @foreach ($keranjangs as $keranjang)
                <div class="bg-white rounded-xl shadow p-3 flex gap-3" id="cart-item-{{ $keranjang->id }}">
                    @if ($keranjang->menu && $keranjang->menu->foto)
                        <img class="rounded-lg w-16 h-16 object-cover" src="{{ asset($keranjang->menu->foto) }}"
                            alt="" />
                    @else
                        <img class="rounded-lg w-16 h-16 object-cover" src="{{ asset('img/illustrations/no-image.png') }}"
                            alt="" />
                    @endif
                    <div class="flex-1">
                        <p class="text-sm font-semibold">
                            {{ $keranjang->menu ? $keranjang->menu->nama : 'Menu Tidak Ditemukan' }}
                        </p>
                        <div id="total-harga-{{ $keranjang->id }}" class="text-purple-700 font-semibold text-sm mt-1">
                            @php echo 'Rp '.number_format($keranjang->total_harga, 0, ',', '.'); @endphp
                        </div>
                    </div>
                    {{-- Hapus elemen <form> dan ganti dengan <button> biasa --}}
                    <button type="button" class="text-red-500 remove-item-btn" data-id="{{ $keranjang->id }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                    <div class="flex flex-col items-center justify-between">
                        <button onclick="updateQuantity('{{ $keranjang->id }}', 'increment')"
                            class="bg-gray-200 w-6 h-6 flex items-center justify-center rounded">+</button>
                        <span id="jumlah-{{ $keranjang->id }}" class="text-sm">{{ $keranjang->jumlah }}</span>
                        <button onclick="updateQuantity('{{ $keranjang->id }}', 'decrement')"
                            class="bg-gray-200 w-6 h-6 flex items-center justify-center rounded">-</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="fixed bottom-0 left-0 right-0 bg-gray-50 p-4 z-10">
            {{-- Ringkasan --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <div class="flex justify-between text-base font-bold">
                    <span>Total</span>
                    <span id="total-bayar">Rp.@php echo number_format($totalBayar, 0, ',', '.'); @endphp</span>
                </div>
            </div>
            {{-- Tombol Pesan --}}
            <form action="{{ route('pegawai.keranjang.checkout') }}" method="POST">
                @csrf
                <div class="my-4">
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

    {{-- script lama tetap jalan --}}
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

        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-item-btn');

            removeButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const keranjangId = this.dataset.id;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');
                    const url = `/pegawai/keranjang/${keranjangId}`;

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const cartItemElement = document.getElementById('cart-item-' +
                                    keranjangId);
                                if (cartItemElement) {
                                    cartItemElement.remove();
                                }
                                document.getElementById('total-bayar').textContent = data
                                    .total_bayar_formatted;

                                // Show popup notification
                                showPopup(data.message);

                            } else {
                                showPopup('Gagal menghapus item: ' + (data.message ||
                                    'Terjadi kesalahan yang tidak diketahui.'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showPopup(
                                'Terjadi kesalahan jaringan atau server saat menghapus item.'
                            );
                        });
                });
            });

            // Popup function
            function showPopup(message) {
                let popup = document.createElement('div');
                popup.textContent = message;
                popup.style.position = 'fixed';
                popup.style.bottom = '80px';
                popup.style.left = '50%';
                popup.style.transform = 'translateX(-50%)';
                popup.style.background = '#4F46E5';
                popup.style.color = '#fff';
                popup.style.padding = '12px 24px';
                popup.style.borderRadius = '8px';
                popup.style.boxShadow = '0 2px 8px rgba(0,0,0,0.15)';
                popup.style.zIndex = '9999';
                popup.style.textAlign = 'center';
                document.body.appendChild(popup);
                setTimeout(() => {
                    popup.remove();
                }, 2000);
            }
        });
    </script>
@endsection
