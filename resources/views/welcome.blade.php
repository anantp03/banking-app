<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>{{ __("Banking App!") }}</h1>
                </div>

                <x-goto-link :href="route('login')">
                    {{ __('Log in') }}
                </x-goto-link>
            </div>
        </div>
    </div>
</x-guest-layout>
