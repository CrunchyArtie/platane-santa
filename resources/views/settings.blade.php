<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200 flex flex-row flex-wrap">
                <table >
                    @foreach ($settings as $setting)
                        <tr>
                            <td>{{ $setting->key }}</td>
                            <td class="text-black">
                                <form action="{{ route('settings.update', $setting->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="value" value="{{ $setting->value }}">
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                </form>
                            </td>
                            <td class="text-black">
                                <form action="{{ route('settings.destroy', $setting->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                        <form action="{{ route('settings.store') }}" method="POST" class="text-black">
                            @csrf
                            <tr>
                                <td><input type="text" name="key" placeholder="key"></td>
                                <td><input type="text" name="value" placeholder="Value"></td>
                                <td><button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add</button></td>
                            </tr>
                        </form>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
