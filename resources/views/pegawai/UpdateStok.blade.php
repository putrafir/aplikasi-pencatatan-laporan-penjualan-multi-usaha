@extends('components.layout.PegawaiLayout.body.index')

@section('pegawai')
    <div class="p-6">
        <div class="relative overflow-hidden h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">
            <img src="{{ asset('img/illustrations/pegawai.svg') }}" class="w-30 absolute bottom-0" alt="">
            <x-right-motif />
            <x-left-motif />

            <div class="pl-[12rem] text-white mr-auto pb-5 z-10">
                <h2 class="text-2xl text-white font-bold md:text-slate-700">{{ $user->name }}</h2>
                <p class="text-sm md:text-slate-700">Usaha {{ $business->name }}</p>
                <p class="text-sm md:text-slate-700">{{ $transaksi->count() }} Transaksi</p>
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
                @else
                    {{-- Form utama untuk input stok --}}
                    <form id="form-update-stok" method="POST" action="{{ route('pegawai.update.stock.store') }}">
                        @csrf
                        <input type="hidden" name="business_id" value="{{ $business->id }}">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($stocks as $stock)
                                <div class="border border-gray-300 rounded-lg bg-gray-50 shadow p-4">
                                    <label
                                        class="block text-md font-semibold text-gray-700 mb-2">{{ $stock->stocks->nama }}</label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="jumlah_stok[{{ $stock->stocks->id }}]"
                                            value="{{ $stock->stocks->jumlah_stok }}"
                                            max="{{ $stock->stocks->jumlah_stok }}" min="0"
                                            data-max="{{ $stock->stocks->jumlah_stok }}"
                                            data-nama="{{ $stock->stocks->nama }}"
                                            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                        <span class="text-gray-600 font-medium">{{ $stock->satuan }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end mt-8">
                            {{-- Tombol ini tidak submit form langsung --}}
                            <button type="button" id="btn-save-stok"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                                Simpan Semua
                            </button>
                        </div>
                    </form>

                    {{-- Modal konfirmasi --}}
                    <x-modal-update-stok id="update-modal" :action="route('pegawai.update.stock.store')" />
                    {{-- Modal peringatan --}}
                    <div id="warning-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center">
                        <div class="absolute inset-0 bg-black bg-opacity-40" onclick="togglePopup('warning-modal')"></div>
                        <div class="relative z-10 w-96 max-w-full bg-white rounded-2xl shadow-xl p-6 text-center">
                            <h6 class="text-lg font-semibold text-red-600 mb-3">Peringatan</h6>
                            <p id="warning-text" class="text-sm text-gray-700 mb-5"></p>
                            <button onclick="togglePopup('warning-modal')"
                                class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                                Tutup
                            </button>
                        </div>
                    </div>
            @endif
        </div>

    </div>

    <script>
        function togglePopup(id) {
            const popup = document.getElementById(id);
            popup.classList.toggle("hidden");
        }

        document.getElementById("btn-save-stok").addEventListener("click", () => {
            let isValid = true;
            let warningText = "Ada data stok yang melebihi stok awal:<br>";

            document.querySelectorAll("input[name^='jumlah_stok']").forEach(input => {
                const max = parseInt(input.dataset.max);
                const val = parseInt(input.value);
                const nama = input.dataset.nama; // ambil nama stok

                input.classList.remove("border-red-500");

                if (val > max) {
                    isValid = false;
                    input.classList.add("border-red-500");
                    warningText += `- ${nama} (Maks: ${max}, Input: ${val})<br>`;
                }
            });

            if (!isValid) {
                document.getElementById("warning-text").innerHTML = warningText;
                togglePopup("warning-modal");
            } else {
                togglePopup("update-modal");
            }
        });

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
