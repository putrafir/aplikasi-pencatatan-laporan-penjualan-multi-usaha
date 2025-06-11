@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    {{-- Halaman Management Stok --}}
    <div class="flex justify-between px-4 mb-4 space-x-2">
        <a href="{{ route('admin.manage-stock', ['business_id' => 2]) }}"
            class="flex-1 px-3 py-2 border rounded-md text-sm {{ $business_id == 2 ? 'bg-purple-500 text-white' : '' }}">
            Stock Miss
        </a>
        <a href="{{ route('admin.manage-stock', ['business_id' => 1]) }}"
            class="flex-1 px-3 py-2 border rounded-md text-sm {{ $business_id == 1 ? 'bg-purple-500 text-white' : '' }}">
            Stock Pisgor
        </a>
    </div>

    <div class="flex items-center px-3 mt-6 lg:mb-0">
        <button type="button" onclick="togglePopup('popup-add')"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            + Tambah Data Master
        </button>
    </div>

    {{-- table stock --}}
    <div class="w-full max-w-full px-3 mt-6 lg:mb-0">
        <div
            class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex items-center justify-between mb-4">
                    <h6 class="text-lg font-bold ml-2">Daftar Stok</h6>
                    <a href="{{ route('admin.stock.add.jumlah_stok', ['business_id' => $business_id]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                        + Tambah Stok
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                        <thead class="bg-gradient-to-t from-purple-700 to-pink-500 text-white">
                            <tr>
                                <th class="px-4 py-2 border w-10 text-center">No</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Jumlah Stok</th>
                                <th class="px-4 py-2 border">satuan</th>
                                <th class="px-4 py-2 border w-10 text-center">Edit</th>
                                <th class="px-4 py-2 border w-10 text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocks as $index => $stock)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $stock->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $stock->jumlah_stok }}</td>
                                    <td class="px-4 py-2 border">{{ $stock->satuan }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button"
                                            class="text-blue-500 hover:text-blue-700 mx-auto block edit-stock-button"
                                            data-id="{{ $stock->id }}" data-nama="{{ $stock->nama }}"
                                            data-satuan="{{ $stock->satuan }}" onclick="openEditStockPopup(this)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                <path fill-rule="evenodd"
                                                    d="M4 16a1 1 0 001 1h10a1 1 0 100-2H5a1 1 0 00-1 1z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button"
                                            class="text-red-500 hover:text-red-700 mx-auto block delete-button"
                                            data-id="{{ $stock->id }}" data-nama="{{ $datanama }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M6 8a1 1 0 012 0v5a1 1 0 11-2 0V8zm4 0a1 1 0 112 0v5a1 1 0 11-2 0V8z"
                                                    clip-rule="evenodd" />
                                                <path fill-rule="evenodd"
                                                    d="M4 5a1 1 0 011-1h10a1 1 0 011 1v1H4V5zm2 3a1 1 0 00-1 1v7a2 2 0 002 2h6a2 2 0 002-2V9a1 1 0 00-1-1H6z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <!-- Form tersembunyi -->
                                        <form id="delete-form-{{ $stock->id }}"
                                            action="{{ route('admin.stock.destroy', $stock->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada Stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit Stok --}}
    <div id="popup-edit-stock" class="fixed inset-0 items-center flex justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold mb-4 text-center">Edit Stok</h2>
            <form id="editStockForm" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4 text-left">
                    <label for="edit-stock-nama" class="block text-sm mb-1">Nama Barang</label>
                    <input id="edit-stock-nama" name="nama" class="w-full border rounded-lg p-2"
                        placeholder="Nama Barang" required>
                </div>

                <div class="mb-4 text-left">
                    <label for="edit-stock-satuan" class="block text-sm mb-1">Satuan</label>
                    <input id="edit-stock-satuan" name="satuan" class="w-full border rounded-lg p-2"
                        placeholder="Contoh: pcs, kg, bungkus" required>
                </div>

                <div class="mt-4">
                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-2">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="togglePopup('popup-edit-stock')"
                        class="w-full text-gray-800 hover:text-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Add Stock --}}
    <div id="popup-add" class="fixed inset-0 items-center flex justify-center z-50 hidden">
        <div class="w-96 max-w-full px-3 mt-0 mb-6 bg-white rounded-2xl shadow-xl">
            <div class="flex-auto p-4">
                <h6 class="mb-0 ml-2 text-center">Tambah data master</h6>
                <form action="{{ route('admin.stock.add') }}" method="POST" enctype="multipart/form-data"
                    class="max-w-sm pt-2 mx-auto">
                    @csrf
                    <input type="hidden" name="business_id" value="{{ $business_id }}">
                    <div class="mb-4">
                        <label for="nama" class="block mb-1 text-sm">Nama Barang</label>
                        <input type="text" name="nama" class="w-full border rounded-lg p-2"
                            placeholder="Nama Menu" required>
                    </div>
                    <div class="mb-4">
                        <label for="satuan" class="block mb-1 text-sm">Satuan</label>
                        <input type="text" name="satuan" class="w-full border rounded-lg p-2"
                            placeholder="Contoh: pcs, kg, bungkus" required>
                    </div>
                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2">
                        Tambah data master
                    </button>
                </form>
                <div class="flex justify-center mt-4">
                    <button onclick="togglePopup('popup-add')"
                        class="w-full text-gray-700 hover:text-gray-900 font-semibold py-2 px-4 border rounded-lg bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openEditStockPopup(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const satuan = button.getAttribute('data-satuan');

            document.getElementById('edit-stock-nama').value = nama;
            document.getElementById('edit-stock-satuan').value = satuan;

            const form = document.getElementById('editStockForm');
            form.action = `/admin/stock/${id}`;

            togglePopup('popup-edit-stock');
        }
    </script>

    <script>
        function togglePopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.classList.toggle('hidden');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
