@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    <div class="flex flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Today's Money
                                </p>
                                <h5 class="mb-0 font-bold">
                                    $53,000
                                    <span class="leading-normal text-sm font-weight-bolder text-lime-500">+55%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div
                                class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Today's Users
                                </p>
                                <h5 class="mb-0 font-bold">
                                    2,300
                                    <span class="leading-normal text-sm font-weight-bolder text-lime-500">+3%</span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div
                                class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-5/12 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="flex-auto p-4">
                    <h6 class=" mb-0 ml-2">Tambah Menu</h6>

                    <form action="{{ route('admin.menu.add') }}" method="POST" class="max-w-sm pt-2 mx-auto">
                        @csrf
                        <div class="mb-4">
                            <label for="usaha" class="block mb-1 text-sm">Usaha</label>
                            <select name="business_id" id="usahaSelect" class="w-full border rounded-lg p-2" required>
                                <option value="">-- Pilih Usaha --</option>
                                @foreach ($businesses as $business)
                                    <option value="{{ $business->id }}">{{ $business->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="kategori" class="block mb-1 text-sm">Kategori</label>
                            <select name="kategori_id" id="kategoriSelect" class="w-full border rounded-lg p-2" required>
                                <option value="">-- Pilih Kategori --</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="nama" class="block mb-1 text-sm">Nama Menu</label>
                            <input type="text" name="nama" class="w-full border rounded-lg p-2"
                                placeholder="Nama Menu" required>
                        </div>
                        <div class="mb-4">
                            <label for="harga" class="block mb-1 text-sm">Harga</label>
                            <input type="number" name="harga" class="w-full border rounded-lg p-2" placeholder="Harga"
                                required>
                        </div>
                        <button type="submit"
                            class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2 ">Tambah
                            Menu</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-5/12 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="flex-auto p-4">
                    <h6 class=" mb-0 ml-2">Tambah Kategori</h6>

                    <form action="{{ route('admin.kategori.add') }}" method="POST" class="max-w-sm pt-2 mx-auto">
                        @csrf
                        <div class="mb-4">
                            <label for="usaha" class="block mb-1 text-sm">Usaha</label>
                            <select name="business_id" id="usahaSelectKategori" class="w-full border rounded-lg p-2"
                                required>
                                <option value="">-- Pilih Usaha --</option>
                                @foreach ($businesses as $business)
                                    <option value="{{ $business->id }}">{{ $business->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="nama" class="block mb-1 text-sm">Nama Kategori</label>
                            <input type="text" name="nama" class="w-full border rounded-lg p-2"
                                placeholder="Nama Kategori" required>
                        </div>

                        <button type="submit"
                            class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2 ">Tambah
                            Kategori</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="w-full max-w-full px-3 mt-6 lg:mb-0 lg:w-5/12 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="flex-auto p-4">
                    <h6 class=" mb-0 ml-2">Tambah Ukuran Smoothies</h6>

                    <form action="{{ route('admin.ukuran.add') }}" method="POST" class="max-w-sm pt-2 mx-auto">
                        @csrf
                        <div class="mb-4">
                            <label for="ukuran" class="block mb-1 text-sm">Ukuran</label>
                            <input type="text" name="nama" class="w-full border rounded-lg p-2"
                                placeholder="Contoh: M, L, XL" required>
                        </div>

                        <div class="mb-4">
                            <label for="harga_ukuran" class="block mb-1 text-sm">Harga Ukuran</label>
                            <input type="number" name="harga" class="w-full border rounded-lg p-2" placeholder="Harga Ukuran"
                                required>
                        </div>

                        <button type="submit"
                            class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2 ">Tambah
                            Ukuran</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    {{-- Tambahkan JQuery CDN jika belum --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#usahaSelect').on('change', function() {
            var usahaId = $(this).val();

            if (usahaId) {
                $.ajax({
                    url: '/admin/kategori/by-business/' + usahaId,
                    type: 'GET',
                    success: function(data) {
                        $('#kategoriSelect').empty();
                        $('#kategoriSelect').append('<option value="">-- Pilih Kategori --</option>');
                        $.each(data, function(key, value) {
                            $('#kategoriSelect').append('<option value="' + value.id + '">' +
                                value.nama + '</option>');
                        });
                    }
                });
            } else {
                $('#kategoriSelect').empty().append('<option value="">-- Pilih Kategori --</option>');
            }
        });

        $('#usahaSelectKategori').on('change', function() {
            var usahaId = $(this).val();

            if (usahaId) {
                $.ajax({
                    url: '/admin/kategori/by-business/' + usahaId,
                    type: 'GET',
                    success: function(data) {
                        $('#kategoriSelectKategori').empty();
                        $('#kategoriSelectKategori').append('<option value="">-- Pilih Kategori --</option>');
                        $.each(data, function(key, value) {
                            $('#kategoriSelectKategori').append('<option value="' + value.id + '">' +
                                value.nama + '</option>');
                        });
                    }
                });
            } else {
                $('#kategoriSelectKategori').empty().append('<option value="">-- Pilih Kategori --</option>');
            }
        });
    </script>
@endsection