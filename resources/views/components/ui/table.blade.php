@props([
    'headers' => [],
    'rows' => [],
    'perPage',
    'currentPage',
    'total',
    'actions' => false,
])

@php
    $perPage = $perPage > 0 ? $perPage : 10; // default 10 kalau 0/null
    $totalPages = $total > 0 ? ceil($total / $perPage) : 1;
    $currentPage = request()->get('page', 1);
    $start = ($currentPage - 1) * $perPage + 1;
    $end = min($start + $perPage - 1, $total);
@endphp

<div class="w-full max-w-full lg:mb-0">
    <div class="flex-auto">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                <thead class="bg-gradient-fuchsia text-white">
                    <tr>
                        <th class="py-2 border w-10 text-center">No</th>
                        @foreach ($headers as $label => $field)
                            <th class="px-4 py-2 border">{{ $label }}</th>
                        @endforeach

                        @if ($actions === true)
                            <th class="px-4 py-2 border text-center">Edit</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $index => $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $start - 1 + $index + 1 }}</td>
                            @foreach ($headers as $label => $field)
                                <td class="px-4 py-2 border">
                                    {{ data_get($row, $field) }}
                                </td>
                            @endforeach
                            @if ($actions === true)
                                <td class="px-4 py-2 border text-center">
                                    <button type="button"
                                        class="text-blue-500 hover:text-blue-700 mx-auto block edit-stock-button"
                                        data-id="{{ $row->id }}" data-nama="{{ $row->nama }}"
                                        data-satuan="{{ $row->satuan }}" data-jumlah_stok="{{ $row->jumlah_stok }}"
                                        data-harga="{{ $row->harga }}" onclick="openEditStockPopup(this)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd"
                                                d="M4 16a1 1 0 001 1h10a1 1 0 100-2H5a1 1 0 00-1 1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </td>
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($headers) + (isset($actions) ? 2 : 1) }}" class="text-center py-4">
                                Data tidak tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <nav class="flex items-center justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm text-slate-500">
                    Menampilkan <span class="font-semibold">{{ $start }}</span>
                    - <span class="font-semibold">{{ $end }}</span>
                    dari <span class="font-semibold">{{ $total }}</span>
                </span>

                <ul class="inline-flex -space-x-px text-sm h-8">
                    <li>
                        <a href="?page={{ max(1, $currentPage - 1) }}"
                            class="px-3 h-8 flex items-center justify-center border rounded-l-lg bg-gradient-fuchsia {{ $currentPage == 1 ? 'text-gray-300 cursor-not-allowed' : 'hover:bg-gray-100 text-gray-500' }}">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m15 19-7-7 7-7" />
                            </svg>

                        </a>
                    </li>

                    <li>
                        <a href=""
                            class="px-3 h-8 flex items-center justify-center border
                 text-slate-700">
                            {{ $currentPage }}
                        </a>
                    </li>

                    {{-- Next --}}
                    <li>
                        <a href="?page={{ min($totalPages, $currentPage + 1) }}"
                            class="px-3 h-8 flex items-center justify-center border rounded-e-lg bg-gradient-fuchsia-refresh {{ $currentPage == $totalPages ? 'text-gray-300 cursor-not-allowed' : 'hover:bg-gray-100 text-gray-500' }}">
                            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m9 5 7 7-7 7" />
                            </svg>

                        </a>
                    </li>
                </ul>
            </nav>
        </div>


    </div>
</div>
