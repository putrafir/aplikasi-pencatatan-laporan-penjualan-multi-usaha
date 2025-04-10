@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    <!-- row 1 -->
    <div class="flex flex-wrap -mx-3">
        <!-- card1 -->
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

        <!-- card2 -->
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

    <!-- cards row 3 -->

    <div class="flex flex-wrap mt-6 -mx-3">
        <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-5/12 lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="flex-auto p-4">
                    <h6 class=" mb-0 ml-2">Tambah Menu</h6>
                    {{-- <form class="max-w-sm mx-auto">
                        <div class="flex mt-2">
                            <button id="dropdown-usaha-button" data-dropdown-toggle="dropdown-usaha"
                                class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 "
                                type="button">
                                Usaha <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="dropdown-usaha"
                                class=" absolute z-10 hidden bg-white divide-y divide-gray-100 mt-12 rounded-lg shadow-sm w-52 ">
                                <!-- Tambahkan hidden input untuk menyimpan nilai dropdown -->
                                <input type="hidden" name="usaha" id="usaha-value">
                                <input type="hidden" name="kategori" id="kategori-value">

                                <!-- Dropdown Usaha -->
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdown-phone-button">
                                    @foreach ($businesses as $business)
                                        <li>
                                            <button type="button"
                                                class="dropdown-usaha inline-flex w-full px-4 py-2 hover:bg-gray-100"
                                                data-value="{{ $business->name }}">
                                                <span class="inline-flex items-center">{{ $business->name }}</span>
                                            </button>
                                        </li>
                                    @endforeach


                                </ul>


                            </div>
                            <label for="phone-input" class="text-sm font-medium sr-only text-gray-900 ">Nama Menu</label>
                            <div class="relative w-full">
                                <input type="text" id="menu-input" aria-describedby="helper-text-explanation"
                                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-e-0 border-s-0 border border-gray-300 focus:ring-blue-500 focus:border-blue-500  "
                                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="Nama Menu" required />
                            </div>
                            <button id="dropdown-kategori-button" data-dropdown-toggle="dropdown-kategori-option"
                                class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 "
                                type="button">
                                Kategori <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="dropdown-kategori-option"
                                class=" absolute mt-12 right-0 z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 ">
                                <!-- Dropdown Kategori -->
                                <ul class="py-2 text-sm text-gray-700"
                                    aria-labelledby="dropdown-verification-option-button">
                                    <li>
                                        <button type="button"
                                            class="dropdown-kategori inline-flex w-full px-4 py-2 hover:bg-gray-100"
                                            data-value="SMS">
                                            Send SMS
                                        </button>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2 ">Tambah
                            Menu</button>
                    </form> --}}

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

                    <form class="max-w-sm mx-auto" action="{{ route('admin.kategori.add') }}" method="POST">
                        <div class="flex  mt-2">
                            <button id="dropdown-usaha-kategori-button" data-dropdown-toggle="dropdown-usaha-kategori"
                                class=" shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 "
                                type="button">
                                Usaha <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <div id="dropdown-usaha-kategori"
                                class="absolute mt-12 z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-52 ">
                                <input type="hidden" name="usaha" id="usaha-kategori-value">

                                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdown-phone-button">
                                    <li>
                                        <button type="button"
                                            class=" dropdown-usaha-kategori inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 "
                                            data-value="United States (+1)">
                                            <span class="inline-flex items-center">

                                                United States (+1)
                                            </span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                            class="dropdown-usaha-kategori inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 "
                                            data-value="United Kingdom (+44)">
                                            <span class="inline-flex items-center">

                                                United Kingdom (+44)
                                            </span>
                                        </button>
                                    </li>

                                </ul>
                            </div>
                            <label for="phone-input" class="mb-2 text-sm font-medium text-gray-900 sr-only ">Phone
                                number:</label>
                            <div class="relative w-full">
                                <input type="text" id="kategori-input"
                                    class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-e-lg border-s-0 border border-gray-300 focus:ring-blue-500 focus:border-blue-500  "
                                    placeholder="Nama Kategori" required />
                            </div>
                        </div>

                        <button type="submit"
                            class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4 me-2 mb-2  focus:outline-none ">Send
                            verification code</button>
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
    </script>


@endsection
