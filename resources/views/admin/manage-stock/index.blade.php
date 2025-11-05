@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Kelola Stok ' . $business_name->name)
@section('admin')
    <div class="grid grid-cols-1 lg:grid-cols-3 -mx-3">

        <x-form-stok :stocks="$stocks" mode="tambah" />

        <div class="w-full max-w-full px-3 ">
            <color:div
                class="relative flex flex-col  min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Riwayat Stok</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <button type="button" onclick="window.location.href = '{{ route('admin.stock-history') }}'"
                                class="inline-block px-8 py-2 mb-0 font-bold text-center uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer leading-pro ease-soft-in text-xs bg-150 active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 border-fuchsia-500 text-fuchsia-500 hover:opacity-75">Lihat
                                Semua</button>
                        </div>
                    </div>
                </div>
                <div class="flex-auto p-4 pb-0">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        @foreach ($riwayatStok as $riwayat)
                            <li
                                class="relative flex justify-between px-4 py-2 pl-0 mb-2 bg-white border-0 rounded-t-inherit text-inherit rounded-xl">
                                <div class="flex flex-col">
                                    <h6 class="mb-1 font-semibold leading-normal text-sm text-slate-700">
                                        {{ $riwayat->created_at }}</h6>
                                    <span class="leading-tight text-xs">{{ $riwayat->stock->nama }}</span>
                                </div>
                                <div class="flex items-center text-left leading-normal text-sm">
                                    {{ $riwayat->status }}
                                    <div
                                        class="inline-block px-0 py-3 mb-0 ml-6 font-bold leading-normal text-center uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer ease-soft-in bg-150 text-sm active:opacity-85 hover:scale-102 tracking-tight-soft bg-x-25 text-slate-700">
                                        <i class="mr-1 fas fa-file-pdf text-lg"></i> {{ $riwayat->jumlah }}
                                    </div>
                                </div>
                            </li>
                        @endforeach


                    </ul>
                </div>
            </color:div>
        </div>
    </div>
@endsection
