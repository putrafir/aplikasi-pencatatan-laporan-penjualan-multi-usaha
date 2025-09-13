@props(['title', 'buttonAction' => null, 'business_id'])

<div class="flex items-center justify-between gap-2 mb-4">
    <h1 class="text-2xl text-slate-700 font-bold">{{ $title }}</h1>

    @if ($buttonAction)
        <button onclick="{{ $buttonAction }}">
            <svg class="cursor-pointer" width="20" height="20" viewBox="0 0 17 17" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M8.48082 1V16M1 8.5H15.9616" stroke="black" stroke-width="2.28571" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    @endif
</div>

<div id="popup-add" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    <div class="absolute inset-0 bg-black bg-opacity-40" onclick="togglePopup('popup-add')"></div>

    <div class="relative z-10 w-96 max-w-full px-3 bg-white rounded-2xl shadow-xl">
        <div class="flex-auto p-4">
            <h6 class="mb-4 ml-2 text-xl font-semibold text-center">Tambah Data Stok</h6>
            <form action="{{ route('admin.stock.add') }}" method="POST" enctype="multipart/form-data"
                class="max-w-sm pt-2 mx-auto">
                @csrf
                <input type="hidden" name="business_id" value="{{ $business_id }}">
                <div class="mb-4">
                    <label for="nama" class="block mb-1 text-sm">Nama Barang</label>
                    <input type="text" name="nama" class="w-full border rounded-lg p-2" placeholder="Nama Menu"
                        required>
                </div>
                <div class="mb-4">
                    <label for="harga" class="block mb-1 text-sm">Harga</label>
                    <input type="number" name="harga" class="w-full border rounded-lg p-2" placeholder="Harga"
                        required>
                </div>
                <div class="mb-4">
                    <label for="satuan" class="block mb-1 text-sm">Satuan</label>
                    <input type="text" name="satuan" class="w-full border rounded-lg p-2"
                        placeholder="Contoh: pcs, kg, bungkus" required>
                </div>


                <div class="flex justify-center gap-2 mt-4">

                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4">
                        Tambah
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function togglePopup(popupId) {
        const popup = document.getElementById(popupId);
        popup.classList.toggle('hidden');
    }
</script>
