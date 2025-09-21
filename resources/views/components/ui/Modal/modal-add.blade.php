@props([
    'id' => 'default-modal',
    'title' => 'Default Title',
    'action' => '#',
    'method' => 'POST',
    'inputs' => [],
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden flex items-center justify-center">
    {{-- Overlay --}}
    <div class="absolute inset-0 bg-black bg-opacity-40" onclick="togglePopup('{{ $id }}')"></div>

    {{-- Modal content --}}
    <div class="relative z-10 w-96 max-w-full px-3 bg-white rounded-2xl shadow-xl">
        <div class="flex-auto p-4">
            <h6 class="mb-4 ml-2 text-xl font-semibold text-center">{{ $title }}</h6>

            <form action="{{ $action }}" method="{{ strtolower($method) === 'get' ? 'GET' : 'POST' }}"
                enctype="multipart/form-data" class="max-w-sm pt-2 mx-auto">
                @csrf
                @if (!in_array(strtoupper($method), ['GET', 'POST']))
                    @method($method)
                @endif

                @foreach ($inputs as $input)
                    <div class="mb-4">
                        {{-- Label tampil kecuali kalau hidden --}}
                        @if (($input['type'] ?? 'text') !== 'hidden')
                            <label for="{{ $input['name'] }}" class="block mb-1 text-sm">
                                {{ $input['label'] ?? ucfirst($input['name']) }}
                            </label>
                        @endif

                        @php
                            $inputName = $input['name'];
                            $inputType = $input['type'] ?? 'text';
                            $inputValue = old($inputName, $input['value'] ?? '');
                        @endphp

                        @if ($inputType === 'select')
                            <select name="{{ $inputName }}" id="{{ $inputName }}"
                                class="w-full border rounded-lg p-2" {{ !empty($input['required']) ? 'required' : '' }}>
                                <option value="">-- Pilih {{ $input['label'] ?? ucfirst($inputName) }} --
                                </option>
                                @foreach ($input['options'] ?? [] as $option)
                                    <option value="{{ $option['value'] }}"
                                        {{ $inputValue == $option['value'] ? 'selected' : '' }}>
                                        {{ $option['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif ($inputType === 'hidden')
                            <input type="hidden" name="{{ $inputName }}" value="{{ $inputValue }}">
                        @else
                            <input type="{{ $inputType }}" name="{{ $inputName }}" id="{{ $inputName }}"
                                class="w-full border rounded-lg p-2" placeholder="{{ $input['placeholder'] ?? '' }}"
                                value="{{ $inputValue }}" {{ !empty($input['required']) ? 'required' : '' }}>
                        @endif
                    </div>
                @endforeach

                {{-- Slot extra content kalau mau --}}
                {{ $slot }}

                <div class="flex justify-center gap-2 mt-4">
                    <button type="submit"
                        class="text-white w-full bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mt-4">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePopup(popupId) {
        const popup = document.getElementById(popupId);
        popup.classList.toggle('hidden');
    }
</script>
