<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800 transition-colors duration-150 border-gray-800 border-2  hover:bg-gray-50 hover:text-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zuweisung Inventuraufträge') }}
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {!! Form::open(['action' => ['InventurController@storeGlobal', $type], 'method' => 'POST']) !!}
            @csrf
            <table class="min-w-full divide-y divide-gray-200 mb-5">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Lagerort')}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Letzte Inventur')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if (count($lagerorte) > 0)
                        @foreach ($lagerorte as $lagerort)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$lagerort->name}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{Form::select('users[' . $lagerort->id . ']',[null => 'Bitte wählen'] + $users, null, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline'])}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Lagerorte vorhanden!')}}</td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                    @endif
                </tbody>
            </table>
            {{Form::submit('Starten',  ['class' => 'cursor-pointer h-10 px-5 text-white bg-strizzi'] )}}
            {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>
