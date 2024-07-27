@props(['status'])

@if ($status)
    <div x-data="{ 'show':true }">
        <div x-show="show" {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600 p-4 ml-2 flex justify-between']) }}>
            {{ $status }}
            <div class="grid grid-cols-1 gap-4 place-items-center p-2 rounded-full bg-gray-500" @click="show = false">
                <button> X </button>
            </div>
        </div>
    </div>
@endif
