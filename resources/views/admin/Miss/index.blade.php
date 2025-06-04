@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Catatan')
@section('admin')

    <div class="flex flex-wrap my-6 -mx-3">
        <!-- Card untuk bisnis Miss -->
        <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 md:w-1/2 md:flex-none lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                    <h6>Transaksi Usaha Miss</h6>
                </div>
                <!-- Bagian konten card dengan scroll -->
                <div class="flex-auto h-120 p-6 px-0 pb-2 overflow-y-auto max-h-120">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Waktu
                                </th>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Pegawai
                                </th>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Total Bayar
                                </th>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missTransaksis as $transaksi)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 leading-normal text-sm">
                                                    {{ $transaksi->created_at->format('d M Y H:i') }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                        <span class="font-semibold leading-tight text-xs"> {{ $transaksi->user->name }}
                                        </span>
                                    </td>
                                    <td
                                        class="p-2 leading-normal text-center align-middle bg-transparent border-b text-sm whitespace-nowrap">
                                        <span class="font-semibold leading-tight text-xs"> @php echo number_format($transaksi->total_bayar, 0, ',', '.'); @endphp</span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap">
                                        <button type="button" onclick="showDetail({{ $transaksi->id }})"
                                            class="text-xs font-semibold leading-tight text-slate-400"> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Card untuk bisnis Pisgor -->
        <div class="w-full max-w-full px-3 mt-0 mb-6 md:mb-0 md:w-1/2 md:flex-none lg:flex-none">
            <div
                class="border-black/12.5 shadow-soft-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid bg-white p-6 pb-0">
                    <h6>Transaksi Usaha Pisgor</h6>
                </div>
                <!-- Bagian konten card dengan scroll -->
                <div class="flex-auto h-120 p-6 px-0 pb-2 overflow-y-auto max-h-120">
                    <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                        <thead class="align-bottom">
                            <tr>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Waktu
                                </th>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-left uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Pegawai
                                </th>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Total Bayar
                                </th>
                                <th
                                    class="px-6 py-3 font-bold tracking-normal text-center uppercase align-middle bg-transparent border-b letter border-b-solid text-xxs whitespace-nowrap border-b-gray-200 text-slate-400 opacity-70">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pisgorTransaksis as $transaksi)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 leading-normal text-sm">
                                                    {{ $transaksi->created_at->format('d M Y H:i') }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap">
                                        <span class="font-semibold leading-tight text-xs"> {{ $transaksi->user->name }}
                                        </span>
                                    </td>
                                    <td
                                        class="p-2 leading-normal text-center align-middle bg-transparent border-b text-sm whitespace-nowrap">
                                        <span class="font-semibold leading-tight text-xs"> @php echo number_format($transaksi->total_bayar, 0, ',', '.'); @endphp</span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap">
                                        <button type="button" onclick="showDetail({{ $transaksi->id }})"
                                            class="text-xs font-semibold leading-tight text-slate-400"> Detail
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-modal="true" role="dialog">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative w-full max-w-sm p-6 bg-white rounded-md shadow-lg">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Detail Transaksi</h3>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 focus:outline-none"
                        aria-label="Tutup modal">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="modalContent" class="text-sm text-gray-700 font-mono">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDetail(id) {
            fetch(`/admin/transaksi/${id}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const modalContent = document.getElementById('modalContent');
                    const tanggal = new Date(data.created_at).toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric'
                    });
                    const kasir = data.user.name;
                    const totalBayar = data.total_bayar;
                    const uangDibayarkan = data.uang_dibayarkan;
                    const kembalian = data.kembalian;

                    let detailHtml = `
                        <hr class="border-t border-gray-500 my-2 border-dashed">
                        <div class="text-center mb-2">
                            <h4 class="text-lg font-semibold">MISS</h4>
                            <p class="text-xs">${tanggal}</p>
                            <p class="text-xs">Kasir: ${kasir}</p>
                        </div>
                        <hr class="border-t border-gray-500 my-2 border-dashed">
                    `;

                    data.details.forEach(detail => {
                        const namaProduk = detail.nama + (detail.ukuran ? ` (${detail.ukuran})` : '') + (detail
                            .extra_topping ? ' (Extra)' : '');
                        const hargaSatuan = formatNumber(detail.harga);
                        const subtotal = formatNumber(detail.subtotal);
                        detailHtml += `
                            <div class="flex justify-between mb-1">
                                <span class="truncate">${detail.jumlah} x ${namaProduk}</span>
                                <span class="text-right">Rp ${subtotal}</span>
                            </div>
                        `;
                    });

                    detailHtml += `
                        <hr class="border-t border-gray-500 my-2 border-dashed">
                        <div class="flex justify-between font-semibold mb-1">
                            <span>Total:</span>
                            <span>Rp ${totalBayar}</span>
                        </div>
                        <div class="flex justify-between mb-1">
                            <span>Bayar:</span>
                            <span>Rp ${uangDibayarkan}</span>
                        </div>
                        <div class="flex justify-between font-semibold">
                            <span>Kembali:</span>
                            <span>Rp ${kembalian}</span>
                        </div>
                        <hr class="border-t border-gray-500 my-2 border-dashed">
                        <p class="text-center text-xs">TERIMA KASIH</p>
                    `;

                    modalContent.innerHTML = detailHtml;
                    document.getElementById('detailModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Terjadi masalah saat mengambil detail transaksi:', error);
                    alert('Gagal mengambil detail transaksi. Silakan coba lagi.');
                });
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
@endsection
