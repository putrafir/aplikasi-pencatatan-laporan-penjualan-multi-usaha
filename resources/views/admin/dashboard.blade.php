@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    <div class="flex flex-wrap justify-between -mx-3 mb-3">
        <!-- card1 -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="w-2/3 px-3">
                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Pendapatan Hari Ini</p>
                            <h5 class="mb-0 font-bold">Rp{{ number_format($totalPendapatanHariIni, 0, ',', '.') }}</h5>
                        </div>
                        <div class="w-1/3 px-3 text-right">
                            <div
                                class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                <i class="ni ni-money-coins text-white text-lg relative top-3.5 leading-none"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card2 -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="w-2/3 px-3">
                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Pendapatan Minggu Ini</p>
                            <h5 class="mb-0 font-bold">Rp{{ number_format($totalPendapatanMingguIni, 0, ',', '.') }}</h5>
                        </div>
                        <div class="w-1/3 px-3 text-right">
                            <div
                                class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                <i class="ni ni-world text-white text-lg relative top-3.5 leading-none"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card3 -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="w-2/3 px-3">
                            <p class="mb-0 font-sans font-semibold leading-normal text-sm">Total Pendapatan Bulan Ini</p>
                            <h5 class="mb-0 font-bold">Rp{{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}</h5>
                        </div>
                        <div class="w-1/3 px-3 text-right">
                            <div
                                class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                <i class="ni ni-paper-diploma text-white text-lg relative top-3.5 leading-none"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card4: datepicker -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 xl:w-1/4">
            <label for="tanggal" class="text-sm font-semibold text-gray-700">Filter Tanggal:</label>

            <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-2 mb-6">
                <input type="date" id="tanggal" name="tanggal" value="{{ request('tanggal') }}"
                    class="border border-purple-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-400 focus:border-purple-500 transition">
                <button type="submit"
                    class="bg-gradient-to-tl from-purple-700 to-pink-500 text-white px-4 py-2 rounded-lg font-semibold shadow hover:opacity-90 transition">
                    Filter
                </button>
                @if (request('tanggal'))
                    <a href="{{ url()->current() }}"
                        class="ml-2 text-sm text-red-500 hover:underline font-semibold transition">Reset</a>
                @endif
            </form>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3">
        @foreach ($businessData as $business)
            <!-- Card untuk setiap bisnis -->
            <div class="w-full h-72 justify-between flex-col max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4">
                <div
                    class="relative flex h-full flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-4">
                        <h5 class="mb-0 font-bold">{{ $business['business_name'] }}</h5>
                        <!-- Bagian transaksi dengan scroll -->
                        {{-- <div class="mt-4 overflow-y-auto max-h-40">

                            <ul>
                                @if (count($business['transactions']) > 0)
                                    @foreach ($business['transactions'] as $transaction)
                                        <li class="mb-2">
                                            <p class="text-sm">
                                                {{ $transaction['quantity'] }} x {{ $transaction['menu_name'] }}
                                                @if (!empty($transaction['size']))
                                                    ({{ $transaction['size'] }})
                                                @endif


                                                Rp {{ number_format($transaction['subtotal'], 0, ',', '.') }}
                                            </p>





                                        </li>
                                    @endforeach
                                @else
                                    <li class="mb-2 h-40 flex items-center justify-center">
                                        <p class="text-sm text-gray-500">Belum ada pembeli hari ini</p>
                                    </li>
                                @endif
                            </ul>
                        </div> --}}
                        <div class="relative overflow-y-auto  max-h-40 border-b border-gray-200">
                            <table class="w-full text-sm text-left rtl:text-right ">

                                <tbody>
                                    @if (count($business['transactions']) > 0)
                                        @foreach ($business['transactions'] as $transaction)
                                            <tr class="bg-white hover:bg-gray-50 ">
                                                <th scope="row" class=" font-medium text-sm ">
                                                    {{ $transaction['quantity'] }} x {{ $transaction['menu_name'] }}
                                                    @if (!empty($transaction['size']))
                                                        ({{ $transaction['size'] }})
                                                    @endif
                                                </th>

                                                <td class="px-6 py-2">
                                                    Rp {{ number_format($transaction['subtotal'], 0, ',', '.') }}
                                                </td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <li class="mb-2 h-40  flex items-center justify-center">
                                            <p class="text-sm text-gray-500">Belum ada pembeli hari ini</p>
                                        </li>
                                    @endif


                                </tbody>
                            </table>
                        </div>

                        <!-- Bagian total pendapatan -->
                        <h5 class="mt-4  bottom-0 font-bold">
                            Total Pendapatan: Rp {{ number_format($business['total_profit'], 0, ',', '.') }}
                        </h5>
                    </div>
                </div>
            </div>
        @endforeach


        <div class="w-full max-w-full mt-4 px-3 mb-6 ">
            <div
                class="relative flex h-full flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <!-- Stok yang dimasukkan hari ini -->
                    <h5 class=" mb-2 font-bold ">Stok yang Dimasukkan Hari Ini</h5>
                    <div class=" flex pb-4 border-b border-gray-200">
                        @foreach ($stocksAddedToday as $businessId => $stocks)
                            <div class="w-1/2">
                                <h6 class="font-semibold">
                                    {{ $stocks->first()->stocks->business->name ?? 'Unknown Business' }}
                                </h6>
                                <ul>
                                    @foreach ($stocks as $stock)
                                        <li class="mb-2">
                                            <p class="text-sm">
                                                {{ $stock->stocks->nama }}: {{ $stock->quantity }} unit
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    <!-- Stok yang habis hari ini -->

                    <h5 class="my-2 font-bold">Sisa Stok</h5>

                    <div class=" flex ">
                        @foreach ($remainingStocks as $businessId => $stocks)
                            <div class="w-1/2">

                                <h6 class="font-semibold">{{ $stocks->first()->business->name ?? 'Unknown Business' }}
                                </h6>
                                <ul>
                                    @foreach ($stocks as $stock)
                                        <li class="mb-2">
                                            <p class="text-sm">
                                                {{ $stock->nama }}: {{ $stock->jumlah_stok }} unit
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite-datepicker@1.2.2/dist/datepicker.min.js"></script>

@endsection
