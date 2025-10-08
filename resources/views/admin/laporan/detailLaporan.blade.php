@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Detail Laporan')
@section('admin')

    {{-- Header --}}
    <x-ui.bg-pink class="hidden md:block"/>
    <div class="md:-mt-16 relative mb-9 overflow-hidden w-full md:max-w-md md:mx-auto h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">
        <img src="{{ asset('img/illustrations/toko.svg') }}" class="w-40 z-10 absolute bottom-0" alt="">
        <x-right-motif class="md:scale-150" />
        <x-left-motif />

        <div class="pl-56 text-white pb-2 mr-auto z-10">
            <h2 class="text-4xl font-bold text-white">{{ $business->name }}</h2>
            <p class="text-sm">Pendapatan Pada</p>
            {{-- Tanggal sesuai pilihan dari index --}}
            <p class="text-sm">{{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</p>
            <p class="text-2xl font-bold">
                Rp {{ number_format($business->transaksis->sum('total_bayar'), 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Stok --}}
    <h3 class="text-lg font-bold mb-2">Stok</h3>
    <div class="overflow-x-auto mb-6">
        <x-table :headers="[
            'Nama Stok' => 'stocks.nama',
            'Stok Awal' => 'stok_awal',
            'Stok Akhir' => 'stok_akhir',
            'Stok Keluar' => 'stok_keluar',
        ]" :rows="$stocks" :total="$total" :perPage="$perPage" :currentPage="$currentPage" />
    </div>

    {{-- Pegawai --}}
    <h3 class="text-lg font-bold mb-2">Pegawai</h3>
    <div class="space-y-3 mb-6">
        @forelse ($business->users ?? [] as $pegawai)
            @php
                // Hitung transaksi pegawai ini pada tanggal yang difilter
                $jumlahTransaksi = $business->transaksis->where('user_id', $pegawai->id)->count();
            @endphp

            <a href="{{ route('admin.laporan.pegawai', $pegawai->id) }}?date={{ $tanggal }}">
                <div class="flex items-center justify-between bg-white rounded-2xl shadow p-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ $pegawai->avatar ?? asset('img/illustrations/Group 1.svg') }}"
                            class="w-12 h-12 rounded-full" alt="">
                        <div>
                            <p class="font-bold">{{ $pegawai->name }}</p>
                            <p class="text-xs text-gray-500">Transaksi: {{ $jumlahTransaksi }}</p>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <svg class="w-6 h-6 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m9 5 7 7-7 7" />
                    </svg>
                </div>
            </a>
        @empty
            <p class="text-gray-500 text-sm">Tidak ada pegawai</p>
        @endforelse
    </div>

    {{-- Terjual --}}
    <h3 class="text-lg font-bold mb-2">Terjual</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
            <thead class="bg-gradient-to-t from-purple-700 to-pink-500 text-white">
                <tr>
                    <th class="px-4 py-2 border text-center">Nama Menu</th>
                    <th class="px-4 py-2 border text-center">Jumlah Terjual</th>
                    <th class="px-4 py-2 border text-center">Harga Satuan</th>
                    <th class="px-4 py-2 border text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $adaItem = false;
                @endphp

                @forelse ($business->transaksis as $transaksi)
                    @php
                        // decode details JSON jadi array PHP
                        $items = json_decode($transaksi->details, true) ?? [];
                    @endphp

                    @foreach ($items as $item)
                        @php $adaItem = true; @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $item['nama'] ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">{{ $item['jumlah'] ?? 0 }}</td>
                            <td class="px-4 py-2 border text-center">
                                Rp {{ number_format((float) $item['harga'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 border text-center">
                                Rp
                                {{ number_format(((float) $item['harga'] ?? 0) * ((int) $item['jumlah'] ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                @empty
                    {{-- tidak ada transaksi --}}
                @endforelse

                @if (!$adaItem)
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada transaksi</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
