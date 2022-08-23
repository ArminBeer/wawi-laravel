<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bestellung bei ') . $bestellung->lieferant()->first()->name }}
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-2 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => ['AnlieferungController@update', $bestellung->id], 'method' => 'POST', 'class' =>"overflow-x-auto"]) !!}
                    @csrf
                    @method('PUT')
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{__('Name')}}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{__('Aktueller Lagerbestand')}}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{__('Mindestbestand')}}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{__('Einheit')}}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{__('Bestellte Menge')}}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{__('Angelieferte Menge (nur ausfüllen bei falscher Lieferung)')}}
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Lieferung korrekt (abhacken falls korrekt geliefert')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if (count($zutaten) > 0)
                                @foreach ($zutaten as $zutat)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{$zutat->name}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-900">{{$zutat->lagerbestand}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-900">{{$zutat->mindestbestand}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="text-sm text-gray-900">{{$zutat->einheit()->first()->name}}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            {{ $activeZutatenMengen[$zutat['id']] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($zutat->pivot->bestellmenge != $zutat->pivot->liefermenge)
                                                {{Form::number('liefermengen[' . $zutat->id . ']', $zutat->pivot->liefermenge, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Gelieferte Menge'])}}
                                            @else
                                                {{$zutat->pivot->liefermenge}}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            @if ($zutat->pivot->bestellmenge != $zutat->pivot->liefermenge)
                                                {{Form::checkbox('fit[' . $zutat->id . ']', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td class="px-6 py-4 whitespace-nowrap">{{__('Kein Lieferant vorhanden!')}}</td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                                <td class="px-6 py-4 whitespace-nowrap"></td>
                            @endif
                        </tbody>
                    </table>

                    <div class="flex flex-col bg-gray-100 p-5 mb-4">
                        <div class="font-bold pb-5">{{ __('Anlieferungsnotiz hinzufügen')}}</div>
                        {{Form::textarea('lagernotiz', null,['class' => 'w-full p-5 mb-2 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Hier kannst du eine Info zur Anlieferung hinzufügen'])}}
                    </div>

                    <div class="flex justify-between items-center flex-row-reverse">
                            {{Form::submit('Weiter',  ['class' => 'cursor-pointer h-10 px-5 text-white bg-strizzi'] )}}
                            {!! Form::close() !!}
                            <a href="/bestellungen" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red">
                                <span class="text-white">{{ __('Abbrechen') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
