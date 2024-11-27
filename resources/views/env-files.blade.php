<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Env_file') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg dark:text-gray-200 flex flex-row flex-wrap">
                @foreach($envFiles as $envFile)
                    <div class="p-2">
                        <form action="{{route('env_file.update')}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="env_file" value="{{$envFile}}">
                            <button type="submit" class="
                                {{$envFile === $currentEnvFile ? 'bg-green-500' : 'bg-blue-500'}}
                                hover:bg-green-700
                                text-white
                                font-bold
                                py-2
                                px-4
                                rounded
                            ">{{$envFile}}</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
