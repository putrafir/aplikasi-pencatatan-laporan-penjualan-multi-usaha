@extends('components.layout.PegawaiLayout.body.index')
@section('pegawai')
    <div class="p-6">
        <div class="relative overflow-hidden max-w-sm h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">

            <img src="{{ asset('img/illustrations/toko.svg') }}" class="w-50 absolute bottom-0" alt="" srcset="">
            <x-right-motif />

            <x-left-motif />

            <div class="pl-[12rem] text-white mr-auto z-10">
                <h2 class="text-2xl text-white font-bold ">{{ $user->name }}</h2>
                <p class="text-sm ">{{ $business->users_count }} Pegawai</p>
                <p class="text-sm ">{{ $business->menus_count }} Menu</p>
             
            </div>
            {{-- onclick="window.location='{{ route('admin.kelola-bisnis.show', $bisnis->id) }}'"> --}}
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 w-full">
            <h2 class="text-xl font-bold mb-6 text-white p-4 rounded-t-lg text-center"
                style="background: linear-gradient(to right, #ff0066, #8000ff);">
                Update Sisa Jumlah Stok
            </h2>

            <form action="{{ route('pegawai.update.stock') }}" method="POST">
                @csrf
                <input type="hidden" name="business_id" value="{{ $business->id }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($stocks as $stock)
                        <div class="border border-gray-300 rounded-lg bg-gray-50 shadow p-4">
                            <label class="block text-md font-semibold text-gray-700 mb-2">{{ $stock->nama }}</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="jumlah_stok[{{ $stock->id }}]" placeholder="Jumlah"
                                    class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                <span class="text-gray-600 font-medium">{{ $stock->satuan }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700">
                        Simpan Semua
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
