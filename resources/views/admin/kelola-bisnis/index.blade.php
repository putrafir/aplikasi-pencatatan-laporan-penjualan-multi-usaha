@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Kelola Bisnis')
@section('admin')

    <div class="md:grid md:grid-cols-3 grid grid-cols-1 gap-4">

        {{-- Searching --}}
        <div class="flex items-center gap-4">
            <input type="text" id="search-input" placeholder="Cari Usaha"
                class="flex-1 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            
            <x-plus-button buttonAction="togglePopup('popup-add-bisnis')" />
        </div>

        <x-modal-add id="popup-add-bisnis" title="Tambah Bisnis" action="{{ route('admin.kelola-bisnis.add') }}" method="POST"
        :inputs="[
            [
                'label' => 'Nama',
                'name' => 'name',
                'type' => 'text',
                'placeholder' => 'Nama Bisnis',
                'required' => true,
            ],
            [
                'label' => 'Lokasi',
                'name' => 'lokasi',
                'type' => 'text',
                'placeholder' => 'Nama Lokasi',
                'required' => true,
            ],
        ]" />

        @foreach ($business as $bisnis)
            <div class="relative overflow-hidden max-w-sm h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">

                <img src="{{ asset('img/illustrations/toko.svg') }}" class="w-50 absolute bottom-0" alt=""
                    srcset="">
                <x-right-motif />

                <x-left-motif />

                <div class="pl-[12rem] text-white mr-auto z-10">
                    <h2 class="text-2xl text-white font-bold ">{{ $bisnis->name }}</h2>
                    <p class="text-sm ">{{ $bisnis->users_count }} Pegawai</p>
                    <p class="text-sm ">{{ $bisnis->menus_count }} Menu</p>
                    <x-button-inside onclick="window.location='{{ route('admin.kelola-bisnis.kelola', $bisnis->id) }}'"
                        class="mt-4"> Kelola</x-button-inside>
                </div>
                {{-- onclick="window.location='{{ route('admin.kelola-bisnis.show', $bisnis->id) }}'"> --}}
            </div>
        @endforeach
    @endsection
</div>
