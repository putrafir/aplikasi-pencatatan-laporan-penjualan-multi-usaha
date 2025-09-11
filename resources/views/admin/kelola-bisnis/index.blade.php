@extends('components.layout.OwnerLayout.body.index')
@section('title', 'Kelola Bisnis')
@section('admin')

    <div class="md:grid md:grid-cols-3 grid grid-cols-1 gap-4">
        @foreach ($business as $bisnis)
            <div class="relative overflow-hidden max-w-sm h-full bg-gray-100 rounded-2xl shadow-md flex items-center p-4">

                <img src="{{ asset('img/illustrations/toko.svg') }}" class="w-50 absolute bottom-0" alt=""
                    srcset="">
                <x-right-motif />

                <x-left-motif />

                <div class="pl-[12rem] text-white mr-auto z-10">
                    <h2 class="text-4xl text-white font-bold ">{{ $bisnis->name }}</h2>
                    <p class="text-sm ">2 Pegawai</p>
                    <p class="text-sm ">10 Menu</p>
                    <x-button-inside class="mt-4"> Kelola</x-button-inside>
                </div>
                {{-- onclick="window.location='{{ route('admin.kelola-bisnis.show', $bisnis->id) }}'"> --}}
            </div>
        @endforeach
    @endsection
</div>
