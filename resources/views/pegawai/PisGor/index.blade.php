@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <!-- Search -->
    <div class="p-4">
        <input type="text" id="search-input" placeholder="Cari Produk"
            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- CATEGORY FILTER -->
    <div class="flex gap-3 px-4 py-2 w-full text-sm overflow-x-auto" id="kategori-buttons">
        {{-- Tombol ALL --}}
        <button onclick="loadMenus('all', this)" class="kategori-btn px-3 py-1 rounded-full text-white">
            All
        </button>
        {{-- Tombol Kategori --}}
        @foreach ($categories as $category)
            <button onclick="loadMenus('{{ $category->id }}', this)"
                class="kategori-btn px-3 py-1 rounded-full bg-gray-200 text-gray-700">
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
        <a href="{{ route('pegawai.pisgor.keranjang.view') }}"
            class="flex items-center justify-center w-full h-full relative">
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

    <script>
        // Load semua menu saat pertama kali halaman dibuka
        document.addEventListener("DOMContentLoaded", () => {
            loadMenus('all', document.querySelector('.kategori-btn'));
        });

        //fungsi tombol Load
        function setActiveButton(button) {
            document.querySelectorAll('.kategori-btn').forEach(btn => {
                btn.classList.remove('bg-pink-500', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            button.classList.remove('bg-gray-200', 'text-gray-700');
            button.classList.add('bg-pink-500', 'text-white');
        }

        // fungsi tampilan menu
        function loadMenus(kategoriId, buttonElement) {
            if (buttonElement) {
                setActiveButton(buttonElement);
            }

            let url = kategoriId === 'all' ?
                '/pegawai/pisgor/get-all-menus' :
                `/pegawai/pisgor/get-menus/${kategoriId}`;

            fetch(url)
                .then(res => res.json())
                .then(response => {
                    const menuList = document.getElementById('menu-list');
                    menuList.innerHTML = '';

                    const menus = response.menus || [];

                    if (menus.length === 0) {
                        menuList.innerHTML =
                            '<p class="col-span-full text-center text-gray-500">Tidak ada menu dalam kategori ini.</p>';
                        return;
                    }

                    menus.forEach(menu => {
                        let fotoUrl = menu.foto ?
                            `/storage/${menu.foto}` :
                            '/img/illustrations/no-image.png';
                        let html = `
                        <div>
                            <div class=" h-80 bg-white rounded-xl shadow hover:shadow-lg transition relative">
                                <img class="w-full h-40 object-cover rounded-t-xl"
                                    src="${fotoUrl}" alt="" />
                                <div class="p-4 flex flex-col justify-between h-40">
                                    <h3 class="font-semibold text-base sm:text-lg">${menu.nama}</h3>
                                    <p class=" text-purple-700 font-bold">Rp ${parseInt(menu.harga).toLocaleString('id-ID')}</p>
                                    <button onclick="tambahKeKeranjang(event, ${menu.id}, ${menu.business_id}, ${menu.harga})"
                                    class="mt-3 w-full bg-gradient-to-tl from-purple-700 to-pink-500 hover:bg-green-600 text-white py-2 rounded-lg text-sm">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>`;
                        menuList.innerHTML += html;
                    });
                });
        }

        // fungsi tambah ke keranjang
        let jumlahItemDiKeranjang = 0;
        let keranjang = [];

        function tambahKeKeranjang(event, menuId, businessId, hargaSatuan) {
            // pastikan event di-passing
            event.preventDefault();

            // Jika nanti ada ukuran/opsi lain:
            const parentDiv = event.target.closest(".h-80"); // sesuai card menu
            const selectEl = parentDiv ? parentDiv.querySelector("select") : null;
            const ukuran = selectEl ? selectEl.value : null;

            const hargaText = selectEl ? selectEl.selectedOptions[0].textContent : hargaSatuan;
            const hargaParsed = selectEl ? parseInt(hargaText.replace(/[^\d]/g, '')) : hargaSatuan;

            const dataKeranjang = {
                menu_id: menuId,
                business_id: businessId,
                jumlah: 1,
                harga_satuan: hargaParsed,
                ukuran: ukuran,
                total_harga: hargaParsed
            };

            fetch('/pegawai/pisgor/keranjang/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(dataKeranjang)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        jumlahItemDiKeranjang++;
                        const badge = document.getElementById('cart-badge');
                        badge.textContent = jumlahItemDiKeranjang;
                        badge.classList.remove('hidden');
                        console.log('Item ditambahkan ke keranjang:', data);
                    } else {
                        alert('Gagal menambahkan item ke keranjang: ' + (data.message ?? ''));
                        if (data.errors) {
                            console.error('Error validasi:', data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error saat menambahkan ke keranjang:', error);
                });
        }
    </script>
@endsection
