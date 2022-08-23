<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($inventur->completed == 1)
                {{ __('Überprüfung Inventur') }}
            @else
                {{ __('Durchführung Inventur') }}
            @endif
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($inventur->completed == 1)
                {!! Form::open(['action' => ['InventurController@storeSingle', $type, $inventur->id], 'method' => 'POST']) !!}
            @else
                {!! Form::open(['action' => ['InventurController@storeTask', $type, $inventur->id], 'method' => 'POST']) !!}
            @endif
            @csrf
            @method('PUT')
            <table class="min-w-full divide-y divide-gray-200 mb-5">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Zutat')}}
                        </th>
                        @if ($type == 1)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Einheit')}}
                            </th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Bestand laut Warenwirtschaft')}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Tatsächlicher Bestand')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if (count($activities) > 0)
                        @foreach ($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$activity->zutat()->first()->name}}</div>
                                </td>
                                @if ($type == 1)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{$activity->zutat()->first()->einheit()->first()->name}}
                                        </div>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$activity->old_value}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{Form::text('new_value[' . $activity->id . ']', $activity->new_value, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline'])}}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Zutaten vorhanden!')}}</td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        @if ($type == 1)
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                        @endif
                    @endif
                </tbody>
            </table>
            {{Form::submit('Speichern',  ['class' => 'cursor-pointer h-10 px-5 text-white bg-strizzi'] )}}
            {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>
