@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Laporan')
@section('admin')

    <div class="px-4 md:px-8">
        {{-- Card Info Pegawai --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div
                class="relative flex flex-col md:flex-row items-center md:items-start p-6 space-y-4 md:space-y-0 md:space-x-6">
                <div class="bg-gray-100 rounded-2xl w-full md:w-1/3 h-48 flex items-center justify-center">
                    <img src="{{ $pegawai->avatar ?? asset('img/illustrations/user.svg') }}" alt=""
                        class="h-40 object-contain">
                </div>
                <div class="flex-1">
                    <!-- Bagian ini yang kita ubah -->
                    <div class="flex justify-between space-x-20 w-full mb-1">
                        <p class="font-bold text-sm">Transaksi {{ $pegawai->name }}</p>
                        <p class="font-bold text-sm">{{ $jumlahTransaksi }} Transaksi</p>
                    </div>
                    <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Tabel Transaksi --}}
        <div class="bg-white rounded-2xl shadow mt-6 p-6 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-500 border-b">
                        <th class="py-2">Waktu</th>
                        <th class="py-2">Jumlah Item</th>
                        <th class="py-2">Total Harga</th>
                        <th class="py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $transaksi->created_at->format('H:i') }}</td>
                            <td class="py-3">{{ $transaksi->jumlah_item }}</td>
                            <td class="py-3">{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                            <td class="py-3 text-center">
                                <button href="" class="text-blue-600 hover:underline font-medium">Detail</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
