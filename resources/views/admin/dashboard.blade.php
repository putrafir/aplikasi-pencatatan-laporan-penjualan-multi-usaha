@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Dashboard')
@section('admin')


    <div class="grid grid-cols-1 gap-6">



        <div class="max-w-sm md:max-w-full bg-white rounded-lg shadow-sm ">
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
                        <input type="hidden" name="filter_pendapatan" id="filterInputPendapatan"
                            value="{{ request('filter_pendapatan', 'minggu') }}">
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-0">

            <div class="max-w-sm md:max-w-lg w-full bg-white rounded-lg shadow-sm ">
                <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                    <div>
                        <h5 class="leading-none text-3xl font-bold text-gray-900 pb-2">
                            Stok Keluar</h5>
                        <p class="text-sm font-normal text-gray-500 ">
                            {{ $filterStok == 'bulan' ? 'Bulan Ini: ' : 'Minggu Ini: ' }}{{ $totalStokKeluar }}</p>
                    </div>
                    <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500  text-center">
                        <form id="filterFormStok" method="get">
                            <button id="dropdownDefaultButtonStok" data-dropdown-toggle="dropdownStokMenu"
                                data-dropdown-placement="bottom" type="button"
                                class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200  ">
                                {{ request('filter_stok', 'minggu') == 'bulan' ? 'Bulan Ini' : 'Minggu Ini' }}
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <input type="hidden" name="filter_stok" id="filterInputStok"
                                value="{{ request('filter_stok', 'minggu') }}">
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
            <div class="max-w-sm md:max-w-lg w-full bg-white rounded-lg shadow-sm ">
                <div class="flex justify-between p-4 md:p-6 pb-0 md:pb-0">
                    <div>
                        <h5 class="leading-none text-3xl font-bold text-gray-900 pb-2">
                            Menu Terjual</h5>
                        <p class="text-sm font-normal text-gray-500 ">
                            {{ $filterMenu == 'bulan' ? 'Bulan Ini: ' : 'Minggu Ini: ' }}{{ $totalMenuTerjual }}</p>
                    </div>
                    <div class="flex items-center px-2.5 py-0.5 text-base font-semibold text-green-500  text-center">
                        <form id="filterFormMenu" method="get">
                            <button id="dropdownDefaultButtonMenu" data-dropdown-toggle="dropdownMenuMenu"
                                data-dropdown-placement="bottom" type="button"
                                class="px-3 py-2 inline-flex items-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200  ">
                                {{ request('filter_menu', 'minggu') == 'bulan' ? 'Bulan Ini' : 'Minggu Ini' }}
                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </button>
                            <input type="hidden" name="filter_menu" id="filterInputMenu"
                                value="{{ request('filter_menu', 'minggu') }}">
                            <div id="dropdownMenuMenu"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 ">
                                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                                    <li>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('filterInputMenu').value='minggu'; document.getElementById('filterFormMenu').submit();"
                                            class="block px-4 py-2 hover:bg-gray-100 ">
                                            Minggu Ini
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            onclick="event.preventDefault(); document.getElementById('filterInputMenu').value='bulan'; document.getElementById('filterFormMenu').submit();"
                                            class="block px-4 py-2 hover:bg-gray-100 ">
                                            Bulan Ini
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="menu-terjual-chart" class="px-2.5 "></div>
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

                // 🎨 Palet warna dasar — bisa kamu ubah sesuai tema
                const baseColors = [
                    "#1C64F2", "#16BDCA", "#FDBA8C", "#8B5CF6", "#10B981",
                    "#F59E0B", "#EF4444", "#EC4899", "#6366F1", "#14B8A6"
                ];

                // 🗺️ Peta warna global (disimpan per nama usaha)
                const colorMap = new Map();

                // 🔁 Fungsi untuk ambil warna konsisten berdasarkan nama usaha
                function getColorForName(name) {
                    if (!colorMap.has(name)) {
                        const color = baseColors[colorMap.size % baseColors.length];
                        colorMap.set(name, color);
                    }
                    return colorMap.get(name);
                }

                // ===================================
                // === Fungsi bantu bikin chart umum ===
                // ===================================
                function makeChart(elementId, rawSeries, categories, dataKey, valueFormatter, unit = '') {
                    if (!document.getElementById(elementId)) return;

                    const options = {
                        series: rawSeries.map((s) => ({
                            name: s.name,
                            data: s.data.map(d => Number(d[dataKey]) || 0),
                            color: getColorForName(s.name)
                        })),
                        chart: {
                            height: 300,
                            type: "area",
                            toolbar: {
                                show: false
                            },
                            fontFamily: "Inter, sans-serif"
                        },
                        xaxis: {
                            categories: categories,
                            labels: {
                                style: {
                                    fontFamily: "Inter, sans-serif",
                                    cssClass: 'text-xs fill-gray-500'
                                },
                                formatter: function(value) {
                                    // Jika format YYYY-MM-DD → ubah ke d MMM
                                    if (/^\d{4}-\d{2}-\d{2}$/.test(value)) {
                                        const [y, m, d] = value.split('-');
                                        const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul",
                                            "Agu", "Sep", "Okt", "Nov", "Des"
                                        ];
                                        return `${parseInt(d)} ${monthNames[parseInt(m) - 1]}`;
                                    }

                                    // Jika formatnya sudah seperti "1 - 7 Okt" atau teks lain, tampilkan langsung
                                    return value;
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: function(value) {
                                    return valueFormatter ? valueFormatter(value) : value.toLocaleString(
                                        'id-ID');
                                }
                            }
                        },
                        tooltip: {
                            shared: true,
                            custom: function({
                                dataPointIndex,
                                w
                            }) {
                                let html =
                                    `<div class="bg-gray-800 text-white p-2 rounded-lg shadow-md text-sm">`;
                                rawSeries.forEach((s, i) => {
                                    const color = getColorForName(s.name);
                                    const dataObj = s.data[dataPointIndex] || {};
                                    const val = dataObj[dataKey] ?? 0;
                                    html += `
                            <div class="flex items-center space-x-2">
                                <span style="background:${color}" class="w-3 h-3 rounded-full inline-block"></span>
                                <span>${s.name}: <b>${unit}${new Intl.NumberFormat('id-ID').format(val)}</b></span>
                            </div>`;
                                });
                                return html + `</div>`;
                            }
                        },
                        fill: {
                            type: "gradient",
                            gradient: {
                                opacityFrom: 0.55,
                                opacityTo: 0
                            }
                        },
                        stroke: {
                            width: 6
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                        grid: {
                            show: true
                        },
                    };

                    new ApexCharts(document.getElementById(elementId), options).render();
                }

                // ===========================
                // === Render semua chart ===
                // ===========================

                makeChart(
                    "labels-chart",
                    @json($seriesPendapatan),
                    @json($categoriesPendapatan),
                    "pendapatan",
                    (v) => "Rp" + v.toLocaleString("id-ID"),
                    "Rp"
                );

                makeChart(
                    "stok-keluar-chart",
                    @json($stokSeries),
                    @json($categoriesStok),
                    "stok_keluar"
                );

                makeChart(
                    "menu-terjual-chart",
                    @json($menuSeries),
                    @json($categoriesMenu),
                    "jumlah_menu"
                );

            });
        </script>

    @endsection
