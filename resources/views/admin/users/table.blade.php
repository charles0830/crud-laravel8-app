<!--Container-->
<div class="container w-full md:w-11/12 xl:w-3/5 p-5 mx-auto px-2">
    <!--Card-->
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white w-full">

        <table class="stripe hover w-full">
            <thead>
                <tr>
                    <th data-priority="1" class="w-2/12">Name</th>
                    <th data-priority="2">Email</th>
                    <th data-priority="3">Whats</th>
                    <th data-priority="4">CPF</th>
                    <th data-priority="5">Ações</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>Whats</td>
                        <td>61930303323</td>
                        <td>
                            <x-jet-button wire:loading.attr="disabled" wire:target="users.edit">
                                {{ __('Edit') }}
                            </x-jet-button>
                            <x-jet-secondary-button wire:loading.attr="disabled" wire:target="users.show">
                                {{ __('View') }}
                            </x-jet-secondary-button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <!--/Card-->

</div>
<!--/container-->
