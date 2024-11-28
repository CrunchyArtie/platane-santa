<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200">
                <table class="table-auto">
                    @foreach($questions as $question)
                        <tr>
                            <td class="p-2">
                            <form action="{{route('questions.update', $question->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{$question->id}}">
                                <input type="text" name="question" value="{{$question->question}}" class="text-black">
                                <button type="submit" class="bg-zinc-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit</button>
                            </form>
                            </td>
                            <td>
                                <form action="{{route('questions.destroy', $question->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{$question->id}}">
                                    <button type="submit" class="bg-zinc-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                        <tr>
                            <td class="p-2">
                                <form action="{{ route('questions.store') }}" method="POST">
                                    @csrf
                                    <input type="text" name="question" class="p-2 text-black">
                                    <button type="submit" class="bg-zinc-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add</button>
                                </form>
                        </tr>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
