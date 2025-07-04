@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')
    <div class="flex flex-wrap -mx-3 mb-3">
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
            <div class="relative flex items-center space-x-3 p-4 bg-white shadow-soft-xl rounded-2xl">
                <input id="datepicker-actions" type="text" datepicker datepicker-buttons datepicker-autoselect-today
                    class="flex-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                    placeholder="Select date">
                <div
                    class="w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-wrap -mx-3">
        @foreach ($businessData as $business)
            <!-- Card untuk setiap bisnis -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-2/4">
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
                                            <tr class="bg-white  hover:bg-gray-50 ">
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
                        <h5 class="mt-4 bottom-0 font-bold">
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
