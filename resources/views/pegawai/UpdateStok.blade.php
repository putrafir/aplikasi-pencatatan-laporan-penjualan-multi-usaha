@extends('components.layout.PegawaiLayout.body.index')

@section('pegawai')
    <div class="p-6">
        <div class="relative overflow-hidden max-w-sm h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">
            <img src="{{ asset('img/illustrations/pegawai.svg') }}" class="w-30 absolute bottom-0" alt="">
            <x-right-motif />
            <x-left-motif />

            <div class="pl-[12rem] text-white mr-auto pb-5 z-10">
                <h2 class="text-2xl text-white font-bold ">{{ $user->name }}</h2>
                <p class="text-sm ">Usaha {{ $business->name }}</p>
                <p class="text-sm ">{{ $transaksi->count() }} Transaksi</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 w-full">
            <h2 class="text-xl font-bold mb-6 text-purple-700 rounded-t-lg text-center">
                Update Sisa Jumlah Stok
            </h2>

        
            @if ($alreadyUpdated)
                {{-- Kalau sudah update, hanya tampilkan teks --}}
                <div class="text-center py-10">
                    <p class="text-lg font-semibold">
                        Sisa stok berhasil diperbarui.
                    </p>


            <form action="{{ route('pegawai.update.stock.store') }}" method="POST">
                @csrf
                <label for="business_id"></label>


                <input type="hidden" name="business_id" value="{{ $business->id }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($stocks as $stock)
                        <div class="border border-gray-300 rounded-lg bg-gray-50 shadow p-4">
                            <label class="block text-md font-semibold text-gray-700 mb-2">{{ $stock->stocks->nama }}</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah_stok[{{ $stock->stocks->id }}]"
                                    value="{{ $stock->stocks->jumlah_stok }}"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                <span class="text-gray-600 font-medium">{{ $stock->satuan }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit"
                        class="bg-gradient-fuchsia text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                        Simpan Semua
                    </button>

                </div>
            @else
                {{-- Form utama untuk input stok --}}
                <form id="form-update-stok" method="POST" action="{{ route('pegawai.update.stock.store') }}">
                    @csrf
                    <input type="hidden" name="business_id" value="{{ $business->id }}">
        
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($stocks as $stock)
                            <div class="border border-gray-300 rounded-lg bg-gray-50 shadow p-4">
                                <label class="block text-md font-semibold text-gray-700 mb-2">{{ $stock->stocks->nama }}</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" name="jumlah_stok[{{ $stock->stocks->id }}]"
                                        value="{{ $stock->stocks->jumlah_stok }}"
                                        class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    <span class="text-gray-600 font-medium">{{ $stock->satuan }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
        
                    <div class="flex justify-end mt-8">
                        {{-- Tombol ini tidak submit form, hanya buka modal --}}
                        <button type="button" onclick="togglePopup('update-modal')"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                            Simpan Semua
                        </button>
                    </div>
                </form>
        
                {{-- Modal konfirmasi --}}
                <x-modal-update-stok id="update-modal" :action="route('pegawai.update.stock.store')" />
            @endif
        </div>
        
    </div>

    <script>
        // override supaya modal submit form utama
        document.addEventListener("DOMContentLoaded", () => {
            const modalForm = document.querySelector("#update-stok-form");
            const mainForm = document.querySelector("#form-update-stok");

            modalForm.addEventListener("submit", function(e) {
                e.preventDefault(); 
                mainForm.submit(); // submit form utama
            });
        });
    </script>
@endsection
