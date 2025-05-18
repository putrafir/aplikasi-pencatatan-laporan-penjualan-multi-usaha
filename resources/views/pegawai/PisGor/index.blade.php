@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div>
        <!-- Search -->
        <div class="p-4">
            <input type="text" id="search-input" placeholder="Cari Produk"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Dropdown Filter Kategori -->
        <div class="px-4 mb-4">
            <label for="dropdown-kategori" class="block mb-1 text-sm">Pilih Kategori</label>
            <select id="dropdown-kategori" class="w-full border rounded-lg p-2" onchange="loadMenus(this.value)">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option id="symbol" value="{{ $category->id }}">{{ $category->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Daftar Menu -->
        <div id="menu-list" class="grid grid-cols-2 gap-4 px-4 justify-items-center">
            <!-- Menu akan di-load dengan AJAX -->
        </div>

        <!-- Tombol Keranjang -->
        <div id="floating-cart"
            class="fixed ring-2 ring-white bottom-12 right-4 w-14 h-14 rounded-full bg-gradient-to-tl from-purple-700 to-pink-500 shadow-lg flex items-center justify-center z-50">
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
    </div>

    <script>
        function loadMenus(kategoriId) {
            // setActiveButton('kategori-buttons', kategoriId);

            fetch(`/pegawai/pisgor/get-menus/${kategoriId}`)
                .then(res => res.json())
                .then(response => {
                    const menuList = document.getElementById('menu-list');
                    menuList.innerHTML = '';

                    const {
                        menus
                    } = response;

                    if (menus.length === 0) {
                        menuList.innerHTML = '<p>Tidak ada menu dalam kategori ini.</p>';
                        return;
                    }

                    menus.forEach(menu => {
                        let html = `
                    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between items-center text-center">
                        <a href="#">
                            <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                        </a>
                        <div class="px-2 mb-5 flex flex-col justify-between flex-grow items-center">
                            <h5 class="font-semibold text-3 tracking-tight text-gray-900">${menu.nama}</h5>
                            <p class="text-sm text-gray-600">${menu.deskripsi || ''}</p>
                            <p class="font-bold mt-3 text-gray-800">Rp ${parseInt(menu.harga).toLocaleString('id-ID')}</p>
                            <button onclick="tambahKeKeranjang(${menu.id}, ${menu.business_id}, ${menu.harga})" class="mt-4 text-white bg-gradient-to-b from-blue-600 to-purple-500 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Tambah
                            </button>
                        </div>
                    </div>`;

                        menuList.innerHTML += html;
                    });
                });
        }

        function updateHarga(selectEl) {
            const harga = selectEl.value;
            const hargaDisplay = selectEl.parentElement.querySelector('.harga-display');
            if (harga) {
                hargaDisplay.textContent = `Rp ${parseInt(harga).toLocaleString('id-ID')}`;
            } else {
                hargaDisplay.textContent = 'Rp -';
            }
        }

        document.getElementById('search-input').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const menuItems = document.querySelectorAll('#menu-list > div');

            menuItems.forEach(item => {
                const nama = item.querySelector('h5').textContent.toLowerCase();
                if (nama.includes(query)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            fetch('/pegawai/pisgor/get-all-menus')
                .then(res => res.json())
                .then(response => {
                    const menuList = document.getElementById('menu-list');
                    menuList.innerHTML = '';

                    const menus = response.menus;

                    if (menus.length === 0) {
                        menuList.innerHTML = '<p>Tidak ada menu untuk bisnis Pisgor.</p>';
                        return;
                    }

                    menus.forEach(menu => {
                        let html = `
                <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-between items-center text-center">
                    <a href="#">
                        <img class="p-8 rounded-t-lg" src="/docs/images/products/apple-watch.png" alt="product image" />
                    </a>
                    <div class="px-2 mb-5 flex flex-col justify-between flex-grow items-center">
                        <h5 class="font-semibold text-3 tracking-tight text-gray-900">${menu.nama}</h5>
                        <p class="text-sm text-gray-600">${menu.deskripsi || ''}</p>
                        <p class="font-bold mt-3 text-gray-800">Rp ${parseInt(menu.harga).toLocaleString('id-ID')}</p>
                        <button onclick="tambahKeKeranjang(${menu.id}, ${menu.business_id}, ${menu.harga})" class="mt-4 text-white bg-gradient-to-b from-blue-600 to-purple-500 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Tambah
                        </button>
                    </div>
                </div>`;
                        menuList.innerHTML += html;
                    });
                });
        });

        let jumlahItemDiKeranjang = 0;
        let keranjang = [];

        function tambahKeKeranjang(menuId, businessId, hargaSatuan) {
            const parentDiv = event.target.closest(".w-full.max-w-sm");
            const selectEl = parentDiv.querySelector("select");
            const ukuran = selectEl ? selectEl.value : null;
            const hargaText = selectEl ? selectEl.selectedOptions[0].textContent : hargaSatuan;
            const hargaParsed = selectEl ? parseInt(hargaText.replace(/[^\d]/g, '')) : hargaSatuan;

            const dataKeranjang = {
                menu_id: menuId,
                business_id: businessId,
                jumlah: 1,
                harga_satuan: hargaParsed,
                ukuran: ukuran,
                total_harga: hargaParsed * 1
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
