<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <br><br>
                    <p class="text-lg">Halo, <strong> {{ Auth::user()->name }}</strong>!</p>
                    <p class="mt-2">
                        Role: <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold uppercase">{{ Auth::user()->role }}</span>
                    </p> 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
