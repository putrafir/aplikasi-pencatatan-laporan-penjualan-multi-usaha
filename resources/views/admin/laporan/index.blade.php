@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Laporan')
@section('admin')

    <div id="datepicker-inline" class="mb-4 flex justify-center"
        style="[inline-datepicker] .datepicker-days {
    background-color: #ffffff !important;
    color: #000000 !important}"
        inline-datepicker data-date="{{ \Carbon\Carbon::parse($tanggal)->format('m/d/Y') }}"
        data-max-date="{{ now()->format('m/d/Y') }}" data-date-format="mm/dd/yyyy"
        datepicker-max-date="{{ now()->format('m/d/Y') }}">
    </div>

    @foreach ($business as $usaha)
        <div class="relative flex items-center justify-between bg-white rounded-2xl shadow mb-4 overflow-hidden">
            <x-left-motif class="absolute left-0 top-0 h-full" />
            <div class="z-10 flex-1 px-6 py-4">
                <h2 class="font-bold text-2xl">{{ $usaha->name }}</h2>
            </div>
            <div class="z-10 py-4 mx-4 rounded-l-full">
                <p class="text-sm mb-2 text-white">Pendapatan: Rp
                    {{ number_format($usaha->transaksis->sum('total_bayar') ?? 0, 0, ',', '.') }}</p>
                <div class="flex space-x-3">
                    <button onclick="openModal('{{ $usaha->id }}')"
                        class="bg-white px-4 py-1 rounded-full shadow text-sm font-medium">
                        Masukkan Stok
                    </button>

                    <a href="{{ route('admin.laporan.detailLaporan', $usaha->id) }}?date={{ $tanggal }}" class="bg-white px-4 py-1 rounded-full shadow text-sm font-medium">

                        Lihat
                    </a>
                </div>
            </div>
            <x-right-motif class="absolute h-60 top-0 w-max" />
        </div>
    @endforeach

    <!-- Modal input stok -->
    <div id="stokModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl w-11/12 max-w-2xl p-6">
            <h2 class="text-center text-lg font-bold mb-4">Masukkan Stok</h2>

            <form action="{{ route('admin.stock.store.jumlah_stok') }}" method="POST">
                @csrf
                <input type="hidden" id="business_id_modal" name="business_id" value="{{ old('business_id') }}">

                <!-- stok akan dimasukkan via JS -->
                <div class="space-y-3 max-h-80 overflow-y-auto" id="stokList">
                    <!-- JS akan inject stok disini -->
                </div>

                <!-- Tombol Bawah -->
                <div class="flex justify-between mt-6">
                    <button type="button" onclick="closeModal()"
                        class="w-1/2 mr-2 py-2 bg-gray-200 rounded-xl text-gray-700 font-medium">
                        Batal
                    </button>
                    <button type="submit" class="w-1/2 ml-2 py-2 bg-blue-500 text-white rounded-xl font-medium">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let picker = document.getElementById("datepicker-inline");

            picker.addEventListener("changeDate", function(e) {
                console.log("event changeDate:", e.detail);

                if (!e.detail || !e.detail.date) return;

                let d = e.detail.date;
                let year = d.getFullYear();
                let month = String(d.getMonth() + 1).padStart(2, '0');
                let day = String(d.getDate()).padStart(2, '0');
                let dateStr = `${year}-${month}-${day}`;

                console.log("Tanggal dipilih:", dateStr);

                // reload halaman dengan ?date=YYYY-MM-DD
                window.location.href = `/admin/laporan?date=${dateStr}`;
            });
        });

        function openModal(businessId) {
            document.getElementById('business_id_modal').value = businessId;

            // kosongkan daftar stok
            const stokList = document.getElementById('stokList');
            stokList.innerHTML = '<p class="text-center">Loading...</p>';

            // tampilkan modal
            const modal = document.getElementById('stokModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // ambil data stok via ajax
            fetch(`/admin/business/${businessId}/stocks`)
                .then(res => res.json())
                .then(data => {
                    stokList.innerHTML = '';
                    data.forEach(item => {
                        stokList.innerHTML += `
                    <div class="border border-gray-300 rounded-lg bg-gray-50 shadow p-4">
                        <label for="jumlah_stok_${item.id}"
                            class="block text-md font-semibold text-gray-700 mb-2">${item.nama}</label>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="decreaseValue('${item.id}')"
                                class="px-3 py-1 bg-gray-300 rounded-l-xl text-lg font-bold">-</button>
                            <input id="jumlah_stok_${item.id}" type="number"
                                name="jumlah_stok[${item.id}]" value="${item.jumlah_stok ?? 0}"" placeholder="Jumlah"
                                class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                            <span class="text-gray-600 font-medium">${item.satuan ?? ''}</span>
                            <button type="button" onclick="increaseValue('${item.id}')"
                                class="px-3 py-1 bg-gray-300 rounded-r-xl text-lg font-bold">+</button>
                        </div>
                    </div>`;
                    });
                });
        }

        function closeModal() {
            const modal = document.getElementById('stokModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // klik luar modal menutup
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('stokModal');
            if (e.target === modal) {
                closeModal();
            }
        });

        // fungsi tambah/kurang
        function increaseValue(id) {
            let input = document.getElementById('jumlah_stok_' + id);
            input.value = parseInt(input.value || 0) + 1;
        }

        function decreaseValue(id) {
            let input = document.getElementById('jumlah_stok_' + id);
            let current = parseInt(input.value || 0);
            if (current > 0) input.value = current - 1;
        }
    </script>

@endsection
