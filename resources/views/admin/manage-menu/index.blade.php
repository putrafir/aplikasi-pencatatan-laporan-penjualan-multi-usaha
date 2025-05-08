@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    {{-- tombol Daftar --}}
    <div class="flex justify-between px-4 mb-4 space-x-2">
        <a href="{{ route('admin.manage-menu') }}"
            class="flex-1 px-3 py-2 border rounded-md text-sm
              {{ request()->is('admin/manage-menu*') ? 'bg-purple-500 text-white' : 'bg-white text-gray-700' }}">
            Daftar Menu
        </a>
        <a href="{{ route('admin.manage-category') }}"
            class="flex-1 px-3 py-2 border rounded-md text-sm
              {{ request()->is('admin/manage-category*') ? 'bg-purple-500 text-white' : 'bg-white text-gray-700' }}">
            Daftar Kategori
        </a>
        <a href="{{ route('admin.manage-size') }}"
            class="flex-1 px-3 py-2 border rounded-md text-sm
              {{ request()->is('admin/manage-size*') ? 'bg-purple-500 text-white' : 'bg-white text-gray-700' }}">
            Daftar Size
        </a>
    </div>

    {{-- table menu --}}
    <div class="w-full max-w-full px-3 mt-6 lg:mb-0">
        <div
            class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex items-center justify-between mb-4">
                    <h6 class="text-lg font-bold ml-2">Daftar Menu</h6>
                    <a href="javascript:void(0);" onclick="togglePopup('popup-add')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 mr-4 rounded">
                        + Tambah Menu
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                        <thead class="bg-gradient-to-t from-purple-700 to-pink-500 text-white">
                            <tr>
                                <th class="px-4 py-2 border w-10 text-center">No</th>
                                <th class="px-4 py-2 border">Nama Menu</th>
                                <th class="px-4 py-2 border">Harga</th>
                                <th class="px-4 py-2 border">Kategori</th>
                                <th class="px-4 py-2 border">Usaha</th>
                                <th class="px-4 py-2 border w-10 text-center">Delete</th>
                                <th class="px-4 py-2 border w-10 text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $index => $menu)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $menu->nama }}</td>
                                    <td class="px-4 py-2 border">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border">{{ $menu->kategori->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $menu->business->name ?? '-' }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button"
                                            class="text-red-500 hover:text-red-700 mx-auto block delete-button"
                                            data-id="{{ $menu->id }}" data-nama="{{ $dataName }}">
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
                                        <form id="delete-form-{{ $menu->id }}"
                                            action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button"
                                            class="text-blue-500 hover:text-blue-700 mx-auto block edit-button"
                                            data-id="{{ $menu->id }}" data-nama="{{ $menu->nama }}"
                                            data-harga="{{ $menu->harga }}" data-business-id="{{ $menu->business_id }}"
                                            data-kategori-id="{{ $menu->kategori_id }}" onclick="openEditPopup(this)">
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Belum ada menu.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit -->
    <div id="popup-edit" class="fixed inset-0 items-center flex justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold mb-4 text-center">Edit Menu</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4 text-left">
                    <label for="edit-usaha" class="block text-sm mb-1">Usaha</label>
                    <select id="edit-usaha" name="business_id" class="w-full border rounded-lg p-2" required>
                        <option value="">-- Pilih Usaha --</option>
                        @foreach ($businesses as $business)
                            <option value="{{ $business->id }}">{{ $business->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 text-left">
                    <label for="edit-kategori" class="block text-sm mb-1">Kategori</label>
                    <select id="edit-kategori" name="kategori_id" class="w-full border rounded-lg p-2" required>
                        <option value="">-- Pilih Kategori --</option>
                    </select>
                </div>
                <div class="mb-4 text-left">
                    <label for="edit-nama" class="block text-sm mb-1">Nama Menu</label>
                    <input id="edit-nama" name="nama" class="w-full border rounded-lg p-2" placeholder="Nama Menu"
                        required>
                </div>
                <div class="mb-4 text-left">
                    <label for="edit-harga" class="block text-sm mb-1">Harga</label>
                    <input type="number" id="edit-harga" name="harga" class="w-full border rounded-lg p-2"
                        placeholder="Harga" required>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 me-2">
                        Save
                    </button>
                    <button type="button" onclick="togglePopup('popup-edit')"
                        class="w-full text-gray-800 hover:text-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 me-2 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- modal add -->
    <div id="popup-add" class="fixed inset-0 items-center flex justify-center z-50 hidden">
        <div class="w-96 max-w-full px-3 mt-0 mb-6 bg-white rounded-2xl shadow-xl">
            <div class="flex-auto p-4">
                <h6 class="mb-0 ml-2 text-center">Tambah Menu</h6>
                <form action="{{ route('admin.menu.add') }}" method="POST" class="max-w-sm pt-2 mx-auto">
                    @csrf
                    <div class="mb-4">
                        <label for="usaha" class="block mb-1 text-sm">Usaha</label>
                        <select name="business_id" id="usahaSelect" class="w-full border rounded-lg p-2" required>
                            <option value="">-- Pilih Usaha --</option>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}">{{ $business->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="kategori" class="block mb-1 text-sm">Kategori</label>
                        <select name="kategori_id" id="kategoriSelect" class="w-full border rounded-lg p-2" required>
                            <option value="">-- Pilih Kategori --</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="nama" class="block mb-1 text-sm">Nama Menu</label>
                        <input type="text" name="nama" class="w-full border rounded-lg p-2"
                            placeholder="Nama Menu" required>
                    </div>
                    <div class="mb-4">
                        <label for="harga" class="block mb-1 text-sm">Harga</label>
                        <input type="number" name="harga" class="w-full border rounded-lg p-2" placeholder="Harga"
                            required>
                    </div>
                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2">
                        Tambah Menu
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#usahaSelect').on('change', function() {
            var usahaId = $(this).val();
            if (usahaId) {
                $.ajax({
                    url: '/admin/kategori/by-business/' + usahaId,
                    type: 'GET',
                    success: function(data) {
                        $('#kategoriSelect').empty();
                        $('#kategoriSelect').append('<option value="">-- Pilih Kategori --</option>');
                        $.each(data, function(key, value) {
                            $('#kategoriSelect').append('<option value="' + value.id + '">' +
                                value.nama + '</option>');
                        });
                    }
                });
            } else {
                $('#kategoriSelect').empty().append('<option value="">-- Pilih Kategori --</option>');
            }
        });
        $('#usahaSelectKategori').on('change', function() {
            var usahaId = $(this).val();
            if (usahaId) {
                $.ajax({
                    url: '/admin/kategori/by-business/' + usahaId,
                    type: 'GET',
                    success: function(data) {
                        $('#kategoriSelectKategori').empty();
                        $('#kategoriSelectKategori').append(
                            '<option value="">-- Pilih Kategori --</option>');
                        $.each(data, function(key, value) {
                            $('#kategoriSelectKategori').append('<option value="' + value.id +
                                '">' +
                                value.nama + '</option>');
                        });
                    }
                });
            } else {
                $('#kategoriSelectKategori').empty().append('<option value="">-- Pilih Kategori --</option>');
            }
        });
    </script>

    <script>
        function openEditPopup(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const harga = button.getAttribute('data-harga');
            const usahaId = button.getAttribute('data-business-id');
            const kategoriId = button.getAttribute('data-kategori-id');

            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-harga').value = harga;
            document.getElementById('edit-usaha').value = usahaId;

            const form = document.getElementById('editForm');
            form.action = `/admin/menus/${id}`;
            if (usahaId) {
                $.ajax({
                    url: '/admin/kategori/by-business/' + usahaId,
                    type: 'GET',
                    success: function(data) {
                        const kategoriSelect = $('#edit-kategori');
                        kategoriSelect.empty();
                        kategoriSelect.append('<option value="">-- Pilih Kategori --</option>');
                        $.each(data, function(key, value) {
                            kategoriSelect.append('<option value="' + value.id + '">' + value.nama +
                                '</option>');
                        });
                        kategoriSelect.val(kategoriId);
                    }
                });
            }
            togglePopup('popup-edit');
        }
        $('#edit-usaha').on('change', function() {
            const usahaId = $(this).val();
            if (usahaId) {
                $.ajax({
                    url: '/admin/kategori/by-business/' + usahaId,
                    type: 'GET',
                    success: function(data) {
                        const kategoriSelect = $('#edit-kategori');
                        kategoriSelect.empty();
                        kategoriSelect.append('<option value="">-- Pilih Kategori --</option>');
                        $.each(data, function(key, value) {
                            kategoriSelect.append('<option value="' + value.id + '">' + value
                                .nama + '</option>');
                        });
                    }
                });
            } else {
                $('#edit-kategori').empty().append('<option value="">-- Pilih Kategori --</option>');
            }
        });
    </script>

    <script>
        function togglePopup(popupId) {
            const popup = document.getElementById(popupId);
            popup.classList.toggle('hidden');
        }
    </script>

    {{-- delet --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="{{ asset('js/modal/delete/menu.js') }}"></script> --}}
@endsection
