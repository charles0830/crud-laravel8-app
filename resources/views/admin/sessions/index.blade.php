<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browser Sessions') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">

            @if (count($sessions) > 0)
                <div class="mt-5 space-y-6">
                    <!-- Other Browser Sessions -->
                    @foreach ($sessions as $session)
                        <div class="w-full">
                            <div class="text-sm text-gray-800">
                                #{{ $session->user_id }}

                                @if (empty($session->users->name))
                                    Conta excluída
                                @else
                                    ({{ $session->users->name }})
                                @endif

                                {{ $session->last_login }}
                            </div>
                            <div class="ml-3">
                                <div class="text-sm text-gray-600">
                                    <div>
                                        <div class="text-xs text-gray-500">
                                            {{ $session->ip_address }},
                                            {{ $session->user_agent }},
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
