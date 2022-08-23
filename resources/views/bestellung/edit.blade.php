<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bestellung bei ') . $lieferant }}
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {!! Form::open(['action' => ['BestellungController@update', $bestellung['id']], 'method' => 'POST']) !!}
            @csrf
            @method('PUT')
            <table class="min-w-full divide-y divide-gray-200 bg-white mb-5">
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
                            {{__('Bestellmenge')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if (count($zutaten) > 0)
                        @foreach ($zutaten as $zutat)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$zutat['name']}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900">{{$zutat['lagerbestand']}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900">{{$zutat['mindestbestand']}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900">{{$zutat['einheit']['name']}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    {{Form::number('bestellmengen[' . $zutat['id'] . ']', isset($activeZutatenMengen[$zutat['id']]) ? $activeZutatenMengen[$zutat['id']] : '', ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline', 'placeholder' => 'Bestellmenge'])}}
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
</x-app-layout>
