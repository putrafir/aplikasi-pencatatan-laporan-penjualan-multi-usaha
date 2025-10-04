@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">



        <div class="max-w-sm w-full bg-white rounded-lg shadow-sm ">
            <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                <div>
                    <h5 class="leading-none text-3xl font-bold text-gray-900 pb-2">
                        Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                    <p class="text-sm font-normal text-gray-500 ">
                        {{ $filterPendapatan == 'bulan' ? 'Pendapatan Bulan Ini' : 'Pendapatan Minggu Ini' }}</p>
                </div>
                <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500  text-center">
                    <form id="filterFormPendapatan" method="get">
                        <button id="dropdownDefaultButtonPendapatan" data-dropdown-toggle="dropdownPendapatanMenu"
                            data-dropdown-placement="bottom" type="button"
                            class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200  ">
                            {{ request('filter_pendapatan', 'minggu') == 'bulan' ? 'Bulan Ini' : 'Minggu Ini' }}
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <input type="hidden" name="filter_pendapatan" id="filterInputPendapatan" value="{{ request('filter_pendapatan', 'minggu') }}">
                        <div id="dropdownPendapatanMenu"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 ">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('filterInputPendapatan').value='minggu'; document.getElementById('filterFormPendapatan').submit();"
                                        class="block px-4 py-2 hover:bg-gray-100 ">
                                        Minggu Ini
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('filterInputPendapatan').value='bulan'; document.getElementById('filterFormPendapatan').submit();"
                                        class="block px-4 py-2 hover:bg-gray-100 ">
                                        Bulan Ini
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div id="labels-chart" class="px-2.5"></div>
            <div class="grid grid-cols-1 items-center   justify-between mt-5 p-4 md:p-6 pt-0 md:pt-0">

                <div class="pt-5"></div>
            </div>
        </div>
        <div class="max-w-sm w-full bg-white rounded-lg shadow-sm ">
            <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                <div>
                    <h5 class="leading-none text-3xl font-bold text-gray-900 pb-2">
                        Total {{ $totalStokKeluar }}</h5>
                    <p class="text-sm font-normal text-gray-500 ">
                        {{ $filterStok == 'bulan' ? 'Stok Keluar Bulan Ini' : 'Stok Keluar Minggu Ini' }}</p>
                </div>
                <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500  text-center">
                    <form id="filterFormStok" method="get">
                        <button id="dropdownDefaultButtonStok" data-dropdown-toggle="dropdownStokMenu"
                            data-dropdown-placement="bottom" type="button"
                            class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200  ">
                            {{ request('filter_stok', 'minggu') == 'bulan' ? 'Bulan Ini' : 'Minggu Ini' }}
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <input type="hidden" name="filter_stok" id="filterInputStok" value="{{ request('filter_stok', 'minggu') }}">
                        <div id="dropdownStokMenu"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 ">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                <li>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('filterInputStok').value='minggu'; document.getElementById('filterFormStok').submit();"
                                        class="block px-4 py-2 hover:bg-gray-100 ">
                                        Minggu Ini
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('filterInputStok').value='bulan'; document.getElementById('filterFormStok').submit();"
                                        class="block px-4 py-2 hover:bg-gray-100 ">
                                        Bulan Ini
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <div id="stok-keluar-chart" class="px-2.5 "></div>
            <div class="grid grid-cols-1 items-center   justify-between mt-5 p-4 md:p-6 pt-0 md:pt-0">

                <div class="pt-5"></div>
            </div>
        </div>



        {{-- <pre>
{{ json_encode($series, JSON_PRETTY_PRINT) }}
</pre> --}}

        {{-- <pre>{{ json_encode($categories, JSON_PRETTY_PRINT) }}</pre>
        <pre>{{ json_encode($series, JSON_PRETTY_PRINT) }}</pre> --}}

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rawSeries = @json($seriesPendapatan);

            const options = {
                // set the labels option to true to show the labels on the X and Y axis
                xaxis: {
                    show: true,
                    categories: @json($categoriesPendapatan),
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 '
                        },
                        formatter: function(value) {
                            // Jika value mengandung ' - ', berarti label minggu (misal: "16 Sep - 22 Sep")
                            if (typeof value === 'string' && value.includes(' - ')) {
                                return value;
                            }
                            // Jika value format tanggal "YYYY-MM-DD"
                            if (typeof value === 'string' && value.includes('-')) {
                                const [year, month, day] = value.split('-');
                                const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu",
                                    "Sep", "Okt", "Nov", "Des"
                                ];
                                return `${day} ${monthNames[parseInt(month, 10) - 1]}`;
                            }
                            return value ?? '';
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: true,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 '
                        },
                        formatter: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                series: rawSeries.map(s => ({
                    name: s.name,
                    data: s.data.map(d => Number(d.transaksi) || 0)
                })),
                chart: {
                    sparkline: {
                        enabled: false
                    },
                    height: 300,
                    width: "100%",
                    type: "area",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false,
                    custom: function({
                        series,
                        dataPointIndex,
                        w

                    }) {
                        let tooltipHTML =
                            `<div class="bg-gray-800 text-white p-2 rounded-lg shadow-md text-sm">`;

                        rawSeries.forEach((s, i) => {
                            const color = s.color || w.globals.colors[i];
                            const name = s.name || `Series ${i + 1}`;
                            const dataObj = s.data[dataPointIndex] || {};
                            const transaksi = dataObj.transaksi ?? 0;
                            const pendapatan = dataObj.pendapatan ?? 0;
                            const formatter = new Intl.NumberFormat("id-ID");

                            tooltipHTML += `
             <div class="flex items-center space-x-2">
          <!-- Dot warna -->
          <span style="background:${color};" class="w-3 h-3 rounded-full inline-block"></span>
          <!-- Semua teks sejajar -->
          <span>
            <b>${name}</b>: Transaksi <b>${transaksi}</b>, Pendapatan <b>Rp${formatter.format(pendapatan)}</b>
          </span>
        </div>
        `;
                        });

                        tooltipHTML += `</div>`;
                        return tooltipHTML;
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                        shade: "#1C64F2",
                        gradientToColors: ["#1C64F2"],
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                legend: {
                    show: false

                },
                grid: {
                    show: true,
                },
            }

            if (document.getElementById("labels-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("labels-chart"), options);
                chart.render();
            }


        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rawSeries = @json($stokSeries);

            const options = {
                // set the labels option to true to show the labels on the X and Y axis
                xaxis: {
                    show: true,
                    categories: @json($categoriesStok),
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 '
                        },
                        formatter: function(value) {
                            // Jika value mengandung ' - ', berarti label minggu (misal: "16 Sep - 22 Sep")
                            if (typeof value === 'string' && value.includes(' - ')) {
                                return value;
                            }
                            // Jika value format tanggal "YYYY-MM-DD"
                            if (typeof value === 'string' && value.includes('-')) {
                                const [year, month, day] = value.split('-');
                                const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu",
                                    "Sep", "Okt", "Nov", "Des"
                                ];
                                return `${day} ${monthNames[parseInt(month, 10) - 1]}`;
                            }
                            return value ?? '';
                        }
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: true,
                    labels: {
                        show: true,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 '
                        },
                        formatter: function(value) {
                            return value.toLocaleString('id-ID');
                        }
                    }
                },
                series: rawSeries.map(s => ({
                    name: s.name,
                    data: s.data.map(d => Number(d.stok_keluar) || 0)
                })),
                chart: {
                    sparkline: {
                        enabled: false
                    },
                    height: 300,
                    width: "100%",
                    type: "area",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    shared: true,
                    intersect: false,
                    custom: function({
                        dataPointIndex,
                        w
                    }) {
                        let tooltipHTML =
                            `<div class="bg-gray-800 text-white p-2 rounded-lg shadow-md text-sm">`;

                        rawSeries.forEach((s, i) => {
                            const color = s.color || w.globals.colors[i];
                            const name = s.name || `Series ${i + 1}`;
                            const dataObj = s.data[dataPointIndex] || {};
                            const stokKeluar = dataObj.stok_keluar ?? 0;
                            const formatter = new Intl.NumberFormat("id-ID");

                            tooltipHTML += `
                <div class="flex items-center space-x-2">
                    <span style="background:${color};" class="w-3 h-3 rounded-full inline-block"></span>
                    <span>
                        <b>${name}</b>: Stok Keluar <b>${formatter.format(stokKeluar)}</b>
                    </span>
                </div>
            `;
                        });

                        tooltipHTML += `</div>`;
                        return tooltipHTML;
                    }
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                        shade: "#1C64F2",
                        gradientToColors: ["#1C64F2"],
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                legend: {
                    show: false

                },
                grid: {
                    show: true,
                },
            }

            if (document.getElementById("stok-keluar-chart") && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(document.getElementById("stok-keluar-chart"), options);
                chart.render();
            }


        });
    </script>


@endsection
