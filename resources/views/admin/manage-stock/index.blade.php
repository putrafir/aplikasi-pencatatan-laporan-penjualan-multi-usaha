@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Kelola Stok')
@section('admin')
    <div class="grid grid-cols-1 lg:grid-cols-3 -mx-3">
        <div class=" col-span-2 w-full max-w-full px-3">
            <div
                class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">


                <div class=" px-6 flex my-9 items-center justify-between gap-2 mb-4">

                    <h6>Tambah Stok</h6>
                </div>
                <form action="{{ route('admin.stock.store.jumlah_stok') }}" method="POST">
                    @csrf
                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto overflow-y-auto max-h-80">
                            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Name</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Jumlah Saat Ini</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Tambah</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($stocks as $key => $item)
                                        <tr>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <div class="flex px-4 py-1">

                                                    <div class="flex flex-col justify-center">
                                                        <h6 class="mb-0 text-sm leading-normal">{{ $item->nama }}</h6>
                                                        <p class="mb-0 text-xs leading-tight text-slate-400">
                                                            {{ $item->satuan }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <p class="mb-0 text-xs leading-tight text-slate-400">
                                                    {{ $item->jumlah_stok }}</p>
                                            </td>




                                            <td
                                                class="flex justify-center px-2 py-3 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                                <input type="hidden" name="stock[{{ $item->id }}][id]"
                                                    value="{{ $item->id }}">
                                                <input type="number" name="stock[{{ $item->id }}][jumlah_tambah]"
                                                    min="1"
                                                    class="w-20  text-center border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                                    placeholder="0">

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                    </div>
                    <div class="py-4 flex justify-center">
                        <button type="submit"
                            class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Tambah Semua
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-full max-w-full px-3 ">
            <color:div
                class="relative flex flex-col  min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex flex-wrap -mx-3">
                        <div class="flex items-center flex-none w-1/2 max-w-full px-3">
                            <h6 class="mb-0">Riwayat Stok</h6>
                        </div>
                        <div class="flex-none w-1/2 max-w-full px-3 text-right">
                            <button
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
