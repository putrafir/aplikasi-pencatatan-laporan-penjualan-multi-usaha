@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Kelola Bisnis')
@section('admin')
    <div class="relative mb-9 overflow-hidden w-full h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">

        <img src="{{ asset('img/illustrations/toko.svg') }}" class="w-50 absolute bottom-0" alt="" srcset="">
        <x-right-motif />

        <x-left-motif />

        <div class="pl-[12rem] text-white pb-4 mr-auto z-10 md:text-slate-700">
            <h2 class="text-2xl text-white md:text-slate-700 font-bold ">{{ $business->name }}</h2>
            <p class="text-sm ">{{ $business->stocks_count }} Stok</p>
            <p class="text-sm ">{{ $business->categories_count }} Kategori</p>
            <p class="text-sm ">{{ $business->menus_count }} Menu</p>

        </div>
    </div>


    <x-section-header title=Stok buttonAction="togglePopup('popup-add')" :business_id="$business->id" />

    <x-modal-add id="popup-add" title="Tambah Stok" :isEdit="false" action="{{ route('admin.stock.add') }}" method="POST"
        :inputs="[
            ['label' => 'Nama', 'name' => 'nama', 'type' => 'text', 'placeholder' => 'Nama Stok', 'required' => true],
            ['label' => 'Jumlah Stok', 'name' => 'jumlah_stok', 'type' => 'number', 'placeholder' => 'Jumlah Stok'],
            ['label' => 'Harga', 'name' => 'harga', 'type' => 'number', 'placeholder' => 'Harga'],
            [
                'label' => 'Satuan',
                'name' => 'satuan',
                'type' => 'text',
                'placeholder' => 'Contoh: pcs, kg, bungkus',
                'required' => true,
            ],
            ['label' => '', 'name' => 'business_id', 'type' => 'hidden', 'value' => $business->id],
        ]" />

    <x-table :headers="[
        'Nama' => 'nama',
        'Harga' => 'harga_formatted',
        'Satuan' => 'satuan',
    ]" :rows="$stocks" :total="$total" data-id="{{ $stocks->pluck('id') }}" :perPage="$perPage"
        :currentPage="$currentPage">
        {{-- <x-slot name="actions"> --}}
        {{-- <x-partials.table-action buttonAction="togglePopup('popup-edit-stock')" :stocks="$business->stocks" /> --}}


        {{-- </x-slot> --}}


    </x-table>

    <x-modal-add id="popup-edit-stock" title="Edit Stok" method="PUT" :isEdit="true" :inputs="[
        [
            'label' => 'Nama',
            'name' => 'nama',
            'type' => 'text',
            'placeholder' => 'Nama Stok',
            'required' => true,
        ],
    
        ['label' => 'Harga', 'name' => 'harga', 'type' => 'number', 'placeholder' => 'Harga'],
        [
            'label' => 'Satuan',
            'name' => 'satuan',
            'type' => 'text',
            'placeholder' => 'Contoh: pcs, kg, bungkus',
            'required' => true,
        ],
        ['label' => '', 'name' => 'stock_id', 'type' => 'hidden'],
    ]" />

    <x-modal-delete id="popup-edit-stock-delete" action="{{ route('admin.stock.destroy', ':id') }}" />

    <x-section-header title="Kategori" buttonAction="togglePopup('popup-add-kategori')" />

    <x-modal-add id="popup-add-kategori" title="Tambah Kategori" :isEdit="false"
        action="{{ route('admin.category.add') }}" method="POST" :inputs="[
            [
                'label' => 'Nama',
                'name' => 'nama',
                'type' => 'text',
                'placeholder' => 'Nama Kategori',
                'required' => true,
            ],
            ['label' => '', 'name' => 'business_id', 'type' => 'hidden', 'value' => $business->id],
        ]" />

    <div class="w-full text-sm overflow-x-auto">
        <div class="flex gap-3 px-2 py-2">

            @foreach ($business->categories as $category)
                <button data-id="{{ $category->id }}" data-nama="{{ $category->nama }}"
                    data-business_id="{{ $category->business_id }}" onclick="openEditCategoryPopup(this)"
                    class="px-3 py-1 rounded-full bg-[#F4586B] text-white whitespace-nowrap">
                    {{ $category->nama }}
                </button>
            @endforeach
        </div>
    </div>

    <x-modal-add id="popup-edit-kategori" title="Edit Kategori" method="PUT" :isEdit="true" :inputs="[
        [
            'label' => 'Nama',
            'name' => 'nama',
            'type' => 'text',
            'placeholder' => 'Nama Kategori',
            'required' => true,
        ],
        ['label' => '', 'name' => 'business_id', 'type' => 'hidden', 'value' => $business->id],
    ]" />

    <x-modal-delete id="popup-edit-kategori-delete" action="{{ route('admin.kategori.destroy', ':id') }}" />

    <x-section-header title="Menu" buttonAction="togglePopup('popup-add-menu')" />

    <x-modal-add id="popup-add-menu" title="Tambah Menu" :isEdit="false" action="{{ route('admin.menu.add') }}"
        method="POST" :inputs="[
            ['label' => 'Nama', 'name' => 'nama', 'type' => 'text', 'placeholder' => 'Nama Menu', 'required' => true],
            ['label' => 'Foto', 'name' => 'foto', 'type' => 'file'],
            ['label' => 'Harga', 'name' => 'harga', 'type' => 'number', 'placeholder' => 'Harga'],
            [
                'label' => 'Kategori',
                'name' => 'kategori_id',
                'type' => 'select',
                'options' => $business->categories
                    ->map(function ($category) {
                        return ['value' => $category->id, 'label' => $category->nama];
                    })
                    ->toArray(),
                'required' => true,
            ],
            ['label' => '', 'name' => 'business_id', 'type' => 'hidden', 'value' => $business->id],
        ]" />

    @foreach ($business->categories as $category)
        @if ($category->menus->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-3">{{ $category->nama }}</h2>

                <div class="w-full overflow-x-auto">
                    <div class="flex gap-4 pb-2">
                        @foreach ($category->menus as $product)
                            <div class="relative min-w-[180px] bg-white border border-gray-200 rounded-lg shadow-sm ">
                                <button data-id="{{ $product->id }}" data-nama="{{ $product->nama }}"
                                    data-harga="{{ $product->harga }}" data-category_id="{{ $product->kategori_id }}"
                                    data-business_id="{{ $product->business_id }}" onclick="openEditMenuPopup(this)"
                                    class="absolute text-sm flex items-center  text-white top-2 right-0 py-1 pr-1 pl-2 bg-[#F4586B] rounded-s-20">
                                    <p>Edit</p>
                                    <svg class="w-5 h-5  text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.1"
                                            d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
                                    </svg>
                                </button>
                                @if ($product->foto && file_exists(public_path($product->foto)))
                                    <img class="rounded-t-lg h-[11rem] w-full object-cover"
                                        src="{{ asset($product->foto) }}" alt="" />
                                @else
                                    <img class="rounded-t-lg h-[11rem] w-full object-cover"
                                        src="{{ asset('img/illustrations/no-image.png') }}" alt="" />
                                @endif

                                <div class="py-2 text-sm px-2">
                                    <a href="#">
                                        <h5 class="mb-2 text-md text-center font-bold tracking-tight text-gray-900 ">
                                            {{ $product->nama }}</h5>
                                    </a>
                                    <p class="mb-3 bottom-0  font-semibold text-center text-gray-700 ">Rp
                                        {{ number_format($product->harga, 0, ',', '.') }} <area shape="rect"
                                            coords="" href="" alt=""></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <x-modal-add id="popup-edit-menu" title="Edit Menu" method="PUT" :isEdit="true" :inputs="[
        ['label' => 'Nama', 'name' => 'nama', 'type' => 'text', 'placeholder' => 'Nama Menu', 'required' => true],
        ['label' => 'Foto', 'name' => 'foto', 'type' => 'file'],
        ['label' => 'Harga', 'name' => 'harga', 'type' => 'number', 'placeholder' => 'Harga'],
        [
            'label' => 'Kategori',
            'name' => 'kategori_id',
            'type' => 'select',
            'options' => $business->categories
                ->map(function ($category) {
                    return ['value' => $category->id, 'label' => $category->nama];
                })
                ->toArray(),
            'required' => true,
        ],
        ['label' => '', 'name' => 'business_id', 'type' => 'hidden', 'value' => $business->id],
    ]" />

    <x-modal-delete id="popup-edit-menu-delete" action="{{ route('admin.menus.destroy', ':id') }}" />

    <script>
        function openEditStockPopup(button) {
            const stockId = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const harga = button.getAttribute('data-harga');
            const satuan = button.getAttribute('data-satuan');

            const modal = document.getElementById('popup-edit-stock');
            const form = modal.querySelector('form');

            const actionTemplate = "{{ route('admin.stock.update', ':id') }}";
            form.action = actionTemplate.replace(':id', stockId);

            form.querySelector('input[name="nama"]').value = nama ?? '';
            form.querySelector('input[name="harga"]').value = harga ?? '';
            form.querySelector('input[name="satuan"]').value = satuan ?? '';

            togglePopup('popup-edit-stock');

            const deleteModal = document.getElementById('popup-edit-stock-delete');
            const deleteForm = deleteModal.querySelector('form');
            const deleteTemplate = "{{ route('admin.stock.destroy', ':id') }}";
            deleteForm.action = deleteTemplate.replace(':id', stockId);
        }

        function openEditCategoryPopup(button) {
            const kategoriId = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const businessId = button.getAttribute('data-business_id');

            const modal = document.getElementById('popup-edit-kategori');
            const form = modal.querySelector('form');

            const actionTemplate = "{{ route('admin.kategori.update', ':id') }}";
            form.action = actionTemplate.replace(':id', kategoriId);

            form.querySelector('input[name="nama"]').value = nama ?? '';
            form.querySelector('input[name="business_id"]').value = businessId ?? '';

            togglePopup('popup-edit-kategori');

            const deleteModal = document.getElementById('popup-edit-kategori-delete');
            const deleteForm = deleteModal.querySelector('form');
            const deleteTemplate = "{{ route('admin.kategori.destroy', ':id') }}";
            deleteForm.action = deleteTemplate.replace(':id', kategoriId);
        }

        function openEditMenuPopup(button) {
            const menuId = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const harga = button.getAttribute('data-harga');
            const categoryId = button.getAttribute('data-category_id');
            const businessId = button.getAttribute('data-business_id');

            const modal = document.getElementById('popup-edit-menu');
            const form = modal.querySelector('form');

            const actionTemplate = "{{ route('admin.menus.update', ':id') }}";
            form.action = actionTemplate.replace(':id', menuId);

            form.querySelector('input[name="nama"]').value = nama ?? '';
            form.querySelector('input[name="harga"]').value = harga ?? '';
            form.querySelector('input[name="business_id"]').value = businessId ?? '';

            const categorySelect = form.querySelector('select[name="kategori_id"]');
            if (categorySelect) {
                categorySelect.value = categoryId ?? '';
            }

            togglePopup('popup-edit-menu');

            const deleteModal = document.getElementById('popup-edit-menu-delete');
            const deleteForm = deleteModal.querySelector('form');
            const deleteTemplate = "{{ route('admin.menus.destroy', ':id') }}";
            deleteForm.action = deleteTemplate.replace(':id', menuId);
        }
    </script>
@endsection
