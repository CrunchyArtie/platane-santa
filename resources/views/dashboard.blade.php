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
                        <th class="p-2">is active</th>
                        <th class="p-2">Actions</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td class="p-2">{{$user->id}}</td>
                            <td class="p-2">{{$user->name}}</td>
                            <td class="p-2">{{$user->email}}</td>
                            <td class="p-2">{{$user->anonyme_token === null ? 'False' : 'True' }}</td>
                            <td class="p-2">
                                <form action="{{route('dashboard.update')}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <input type="hidden" name="action" value="activate">
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Toggle activate</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    <div class="py-2.5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200">
                <table class="table-auto">
                    <tr>
                        <th class="p-2">Id</th>
                        <th class="p-2">Key</th>
                        <th class="p-2">Type</th>
                        <th class="p-2">Value</th>
                        <th class="p-2">Actions</th>
                    </tr>
                    @foreach($parameters as $parameter)
                        <tr>
                            <td class="p-2">{{$parameter->id}}</td>
                            <td class="p-2">{{$parameter->key}}</td>
                            <td class="p-2">{{$parameter->type}}</td>
                            <td class="p-2">{{$parameter->value}}</td>
                            <td class="p-2">
                                <form action="{{route('dashboard.update')}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="id" value="{{$parameter->id}}">
                                    <input type="hidden" name="action" value="parameter">
                                    <input type="text" name="value" value="{{old('value', $parameter->value)}}">
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
</x-app-layout>
