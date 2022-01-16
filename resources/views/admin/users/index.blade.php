<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="w-full mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                @include("admin.users.table", ['users' => $users])
            </div>

        </div>
    </div>



</x-app-layout>
