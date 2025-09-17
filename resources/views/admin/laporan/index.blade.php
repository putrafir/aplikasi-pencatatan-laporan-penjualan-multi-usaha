@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Laporan')
@section('admin')

    <div id="datepicker-inline"
        style="[inline-datepicker] .datepicker-days {
    background-color: #ffffff !important;
    color: #000000 !important"
        inline-datepicker data-date="{{ \Carbon\Carbon::parse($tanggal)->format('m/d/Y') }}"
        data-max-date="{{ now()->format('m/d/Y') }}" data-date-format="mm/dd/yyyy">
    </div>

    @foreach ($business as $usaha)
        <div class="p-4 bg-white rounded shadow">
            <h2 class="font-bold text-xl">{{ $usaha->name }}</h2>
            <p>Pendapatan: Rp {{ number_format($usaha->transaksis->sum('total_bayar') ?? 0, 0, ',', '.') }}</p>
            <p>{{ $usaha->transaksis->count() }} Transaksi </p>
        </div>
    @endforeach

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let picker = document.getElementById("datepicker-inline");

            picker.addEventListener("changeDate", function(e) {
                console.log("event changeDate:", e.detail);

                if (!e.detail || !e.detail.date) return;

                let d = e.detail.date;
                let year = d.getFullYear();
                let month = String(d.getMonth() + 1).padStart(2, '0');
                let day = String(d.getDate()).padStart(2, '0');
                let dateStr = `${year}-${month}-${day}`;

                console.log("Tanggal dipilih:", dateStr);

                // reload halaman dengan ?date=YYYY-MM-DD
                window.location.href = `/admin/laporan?date=${dateStr}`;
            });
        });
    </script>

@endsection
