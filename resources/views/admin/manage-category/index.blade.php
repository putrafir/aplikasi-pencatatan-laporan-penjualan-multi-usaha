@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    {{-- tombol pindah Daftar --}}
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

    {{-- table kategori --}}
    <div class="w-full max-w-full px-3 mt-6 lg:mb-0">
        <div
            class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex items-center justify-between mb-4">
                    <h6 class="text-lg font-bold ml-2">Daftar Kategori</h6>
                    <button onclick="togglePopup('popup-add-kategori')"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 mr-4 rounded">
                        + Tambah Kategori
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                        <thead class="bg-gradient-to-t from-purple-700 to-pink-500 text-white">
                            <tr>
                                <th class="px-4 py-2 border w-10 text-center">No</th>
                                <th class="px-4 py-2 border">Nama kategori</th>
                                <th class="px-4 py-2 border">Usaha</th>
                                <th class="px-4 py-2 border w-10 text-center">Delete</th>
                                <th class="px-4 py-2 border w-10 text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $index => $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $category->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $category->business->name ?? '-' }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button"
                                            class="text-red-500 hover:text-red-700 mx-auto block delete-button"
                                            data-id="{{ $category->id }}" data-nama="{{ $category->datanama }}">
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
                                        <form id="delete-form-{{ $category->id }}"
                                            action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button"
                                            class="text-blue-500 hover:text-blue-700 mx-auto block edit-button"
                                            data-id="{{ $category->id }}" data-nama="{{ $category->nama }}"
                                            data-business-id="{{ $category->business_id }}" onclick="openEditPopup(this)">
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
                                    <td colspan="5" class="text-center py-4">Belum ada kategori.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit kategori -->
    <div id="popup-edit" class="fixed inset-0 items-center flex justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-semibold mb-4 text-center">Edit Kategori</h2>
            <form id="editKategoriForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4 text-left">
                    <label for="edit-kategori-usaha" class="block text-sm mb-1">Usaha</label>
                    <select id="edit-kategori-usaha" name="business_id" class="w-full border rounded-lg p-2" required>
                        <option value="">-- Pilih Usaha --</option>
                        @foreach ($businesses as $business)
                            <option value="{{ $business->id }}">{{ $business->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 text-left">
                    <label for="edit-kategori-nama" class="block text-sm mb-1">Nama Kategori</label>
                    <input type="text" id="edit-kategori-nama" name="nama" class="w-full border rounded-lg p-2"
                        placeholder="Nama Kategori" required>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 me-2">
                        Simpan
                    </button>
                    <button type="button" onclick="togglePopup('popup-edit')"
                        class="w-full text-gray-800 hover:text-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 mt-2 me-2 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- popup add kategori --}}
    <div id="popup-add-kategori" class="fixed inset-0 items-center flex justify-center z-50 hidden">
        <div class="w-96 max-w-full px-3 mt-0 mb-6 bg-white rounded-2xl shadow-xl">
            <div class="flex-auto p-4">
                <h6 class="mb-0 ml-2 text-center">Tambah Kategori</h6>
                <form action="{{ route('admin.kategori.add') }}" method="POST" class="max-w-sm pt-2 mx-auto">
                    @csrf
                    <div class="mb-4">
                        <label for="usaha" class="block mb-1 text-sm">Usaha</label>
                        <select name="business_id" id="usahaSelectKategori" class="w-full border rounded-lg p-2" required>
                            <option value="">-- Pilih Usaha --</option>
                            @foreach ($businesses as $business)
                                <option value="{{ $business->id }}">{{ $business->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="nama" class="block mb-1 text-sm">Nama Kategori</label>
                        <input type="text" name="nama" class="w-full border rounded-lg p-2"
                            placeholder="Nama Kategori" required>
                    </div>

                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2">
                        Tambah Kategori
                    </button>
                </form>

                <div class="flex justify-center mt-4">
                    <button onclick="togglePopup('popup-add-kategori')"
                        class="w-full text-gray-700 hover:text-gray-900 font-semibold py-2 px-4 border rounded-lg bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePopup(id) {
            const popup = document.getElementById(id);
            popup.classList.toggle('hidden');
        }
    </script>

    <script>
        function openEditPopup(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const usahaId = button.getAttribute('data-business-id');

            // Isi nilai input
            document.getElementById('edit-kategori-nama').value = nama;
            document.getElementById('edit-kategori-usaha').value = usahaId;

            // Set action form
            const form = document.getElementById('editKategoriForm');
            form.action = `/admin/kategori/${id}`;

            // Tampilkan popup
            togglePopup('popup-edit');
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
