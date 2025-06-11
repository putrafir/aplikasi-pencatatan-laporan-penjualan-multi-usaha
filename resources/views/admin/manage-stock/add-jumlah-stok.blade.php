@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')

    <div class="p-6">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full">
            <h2 class="text-xl font-bold mb-6 text-white p-4 rounded-t-lg text-center"
                style="background: linear-gradient(to right, #ff0066, #8000ff);">
                Tambah Jumlah Stok
            </h2>

            <form action="{{ route('admin.stock.store.jumlah_stok') }}" method="POST">
                @csrf
                <input type="hidden" name="business_id" value="{{ $business_id }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($stocks as $stock)
                        <div class="border border-gray-300 rounded-lg bg-gray-50 shadow p-4">
                            <label for="jumlah_stok_{{ $stock->id }}" class="block text-md font-semibold text-gray-700 mb-2">{{ $stock->nama }}</label>
                            <div class="flex items-center gap-2">
                                <input id="jumlah_stok_{{ $stock->id }}" type="number" name="jumlah_stok[{{ $stock->id }}]" placeholder="Jumlah"
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
