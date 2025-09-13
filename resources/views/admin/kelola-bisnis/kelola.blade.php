@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Kelola Bisnis')
@section('admin')
    <div class="relative mb-9 overflow-hidden w-full h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">

        <img src="{{ asset('img/illustrations/toko.svg') }}" class="w-50 absolute bottom-0" alt="" srcset="">
        <x-right-motif />

        <x-left-motif />

        <div class="pl-[12rem] text-white pb-4 mr-auto z-10 md:text-slate-700">
            <h2 class="text-4xl text-white md:text-slate-700 font-bold ">{{ $business->name }}</h2>
            <p class="text-sm ">{{ $business->stocks_count }} Stok</p>
            <p class="text-sm ">{{ $business->categories_count }} Kategori</p>
            <p class="text-sm ">{{ $business->menus_count }} Menu</p>

        </div>
    </div>


    <x-section-header title=Stok buttonAction="togglePopup('popup-add')" :business_id="$business->id" />

    <x-table :headers="[
        'Nama' => 'nama',
        'Harga' => 'harga_formatted',
        'Satuan' => 'satuan',
    ]" :rows="$stocks" :total="$total" :perPage="$perPage" :currentPage="$currentPage">
        <x-slot name="actions">
            <x-partials.table-action :stocks="$business->stocks" />
        </x-slot>
    </x-table>


@endsection
