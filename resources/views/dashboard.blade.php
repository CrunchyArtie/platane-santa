<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-2.5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200">
                <table class="table-auto">
                    <tr>
                        <th class="p-2">Id</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Email</th>
                        <th class="p-2">Dernier santa (Indiqué/Appliqué)</th>
                        <th class="p-2">Joueur</th>
                        <th class="p-2">Restriction</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td class="p-2">{{$user->id}}</td>
                            <td class="p-2">{{$user->name}}</td>
                            <td class="p-2">{{$user->email}}</td>
                            <td class="p-2">{{$user->last_santa_name ?? '-Aucun-'}} / {{$user->lastSanta->santa->name ?? '-Aucun-'}}</td>
                            <td class="p-2">
                                {{$user->anonyme_token === null ? 'False' : 'True' }}
                                <form action="{{route('dashboard.update')}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <input type="hidden" name="action" value="activate">
                                    <button type="submit" class="bg-zinc-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Toggle activate</button>
                                </form>
                            </td>
                            <td class="p-2">
                                <form action="{{route('dashboard.update')}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <input type="hidden" name="action" value="last_target">
                                    <select class="text-black"  name="last_santa_id" id="last_target">
                                        @foreach($users as $other_user)
                                            <option value="{{$other_user->id}}">
                                                {{$other_user->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update restriction</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

</x-app-layout>
