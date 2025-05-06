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

    {{-- table menu --}}
    <div class="w-full max-w-full px-3 mt-6 lg:mb-0">
        <div
            class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
            <div class="flex-auto p-4">
                <div class="flex items-center justify-between mb-4">
                    <h6 class="text-lg font-bold ml-2">Daftar Kategori</h6>
                    <a href="" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 mr-4 rounded">
                        + Tambah Kategori
                    </a>
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
                                            data-id="{{ $category->id }}">
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
                                        <form id="delete-form-{{ $category->id }}"
                                            action="{{ route('admin.menus.destroy', $category->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <button type="button" class="text-blue-500 hover:text-blue-700 mx-auto block">
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

    {{-- delet --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data kategori ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#e3342f',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'bg-red-600 text-white',
                            cancelButton: 'bg-gray-300 text-gray-800'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + categoryId).submit();
                        }
                    });
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
