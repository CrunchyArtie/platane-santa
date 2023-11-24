<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200">
                <a href="{{route('santas.shuffle')}}"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Make Association</a>
                @if(request()->query('show'))
                    <a href="{{route('santas')}}"
                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Hide</a>
                @else
                    <a href="{{route('santas')}}?show=true"
                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Show</a>
                @endif

            </div>
        </div>
    </div>

    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200">
                <table class="table-auto">
                    <tr>
                        <th class="p-2">Name</th>
                        <th class="p-2">Images Count</th>
                        <th class="p-2">Santa</th>
                        <th class="p-2">Target</th>
                        <th class="p-2">Actions</th>
                    </tr>
                    @foreach($santas as $user)
                        <tr>
                            <td class="p-2">{{$user->anonyme_token}}</td>
                            <td class="p-2">
                                {{$user->images->count()}} / 2
                            </td>
                            <td class="p-2">
                                @if($user->santa)
                                    @if(request()->query('show'))
                                        {{$user->santa->anonyme_token}}
                                    @else
                                        HIDDEN
                                    @endif
                                @else
                                    None
                                @endif
                            </td>
                            <td class="p-2">
                                @if($user->target)
                                    @if(request()->query('show'))
                                        {{$user->target->anonyme_token}}
                                    @else
                                        HIDDEN
                                    @endif
                                @else
                                    None
                                @endif
                            </td>
                            <td class="p-2">
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</x-app-layout>
