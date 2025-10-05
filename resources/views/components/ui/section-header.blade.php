@props(['title', 'buttonAction' => null, 'business_id', 'label', 'showLabel' => false])

<div class="flex my-9 items-center justify-between gap-2 mb-4">
    <h1 class="text-2xl text-slate-700 font-bold">{{ $title }}</h1>

    <x-plus-button buttonAction="{{ $buttonAction }}" label="{{ $label }}" :showLabel="$showLabel" />
</div>
