@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Catatan')
@section('admin')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Daftar Transaksi</h1>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Pegawai</th>
                    <th class="border border-gray-300 px-4 py-2">Total Bayar</th>
                    <th class="border border-gray-300 px-4 py-2">Uang Dibayarkan</th>
                    <th class="border border-gray-300 px-4 py-2">Kembalian</th>
                    <th class="border border-gray-300 px-4 py-2">Tanggal</th>
                    <th class="border border-gray-300 px-4 py-2">Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $transaksi->user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">@php echo number_format($transaksi->total_bayar, 0, ',', '.'); @endphp</td>
                        <td class="border border-gray-300 px-4 py-2">@php echo number_format($transaksi->uang_dibayarkan, 0, ',', '.'); @endphp</td>
                        <td class="border border-gray-300 px-4 py-2">@php echo number_format($transaksi->kembalian, 0, ',', '.'); @endphp</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <ul>
                                @foreach (json_decode($transaksi->details) as $detail)
                                    <li>{{ $detail->nama }} - {{ $detail->jumlah }} x @php echo number_format($detail->harga, 0, ',', '.'); @endphp</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
