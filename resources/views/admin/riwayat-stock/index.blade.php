@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    <div class="w-full max-w-full px-3 mt-6 lg:mb-0">
        <div class="flex justify-between  items-center   mb-4">
            <form class="max-w-md w-full lg:w-1/2" method="GET">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" name="search" id="default-search" value="{{ request('search') }}"
                        class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search Nama Stock, Tanggal, deskripsi..." />
                    <button type="submit"
                        class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
                </div>
            </form>
            <div class="flex items-center gap-2">
                <form method="GET" id="usahaForm" class=" ">
                    <label for="filter_usaha" class="block mb-2 text-sm font-medium text-gray-700">Filter Jenis
                        Usaha:</label>
                    <select name="usaha_id" id="filter_usaha" class="border rounded-lg py-2 px-4"
                        onchange="document.getElementById('usahaForm').submit();">
                        <option value="">-- Semua Jenis Usaha --</option>
                        @foreach ($stocks->pluck('business')->filter()->unique('id') as $business)
                            <option value="{{ $business->id }}"
                                {{ request('usaha_id') == $business->id ? 'selected' : '' }}>
                                {{ $business->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <form method="GET" id="namaStockForm" class=" ">
                    <label for="filter_usaha" class="block mb-2 text-sm font-medium text-gray-700">Filter sesuai Nama
                        Stock:</label>
                    <select name="stock_id" id="filter_usaha" class="border rounded-lg py-2 px-4"
                        onchange="document.getElementById('namaStockForm').submit();">
                        <option value="">-- Semua Stock --</option>
                        @foreach ($stocks->unique('id') as $stock)
                            <option value="{{ $stock->id }}" {{ request('stock_id') == $stock->id ? 'selected' : '' }}>
                                {{ $stock->nama }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div
            class="border-black/12.5 shadow-soft-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
            <div class="flex-auto p-4">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                        <thead class="bg-gradient-to-t from-purple-700 to-pink-500 text-white">
                            <tr>
                                <th class="px-4 py-2 border w-10 text-center">No</th>
                                <th class="px-4 py-2 border w-12 text-center">id Stok</th>
                                <th class="px-4 py-2 border">
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => 'created_at',
                                        'sort_dir' => request('sort_by') === 'created_at' && request('sort_dir') === 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="flex items-center gap-1">
                                        Tanggal
                                        @if (request('sort_by') === 'created_at')
                                            @if (request('sort_dir') === 'asc')
                                                ▲
                                            @else
                                                ▼
                                            @endif
                                        @endif
                                    </a>
                                </th>
                                <th class="px-4 py-2 border">Nama Stock</th>
                                <th class="px-4 py-2 border">deskripsi</th>
                                <th class="px-4 py-2 border w-10 text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stocksLog as $index => $stocksLog)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $stocksLog->stock_id }}</td>
                                    <td class="px-4 py-2 border">{{ $stocksLog->created_at->format('H:i:s d-m-Y') }}</td>
                                    <td class="px-4 py-2 border">{{ $stocksLog->stocks->nama ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $stocksLog->deskripsi }}</td>
                                    <td class="px-4 py-2 border">{{ $stocksLog->quantity }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Belum ada Stok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
