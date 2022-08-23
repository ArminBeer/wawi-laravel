<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bestellung bei ') . $lieferant['name'] }}
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <div class="overflow-hidden">
                {!! Form::open(['action' => 'BestellungController@store', 'method' => 'POST']) !!}
                @csrf
                <table class="min-w-full bg-white shadow-sm mb-4">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Zutat')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Lagerbestand')}}
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
                    <tbody class="bg-white">
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
                                        {{Form::number('bestellmengen[' . $zutat['id'] . ']', null, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border focus:outline-none', 'placeholder' => 'Bestellmenge'])}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td class="px-6 py-4 whitespace-nowrap">{{__('Diesem Lieferanten sind keine Zutaten zugewiesen!')}}</td>
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                            <td class="px-6 py-4 whitespace-nowrap"></td>
                        @endif
                    </tbody>
                </table>

                <div class="flex justify-between items-center flex-row-reverse">
                        {!! Form::hidden('lieferant', $lieferant['id']) !!}
                        {{Form::submit('Weiter',  ['class' => 'cursor-pointer h-10 px-5 text-white bg-strizzi focus:outline-none'] )}}
                        {!! Form::close() !!}
                        <a href="/bestellungen" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red">
                            <span class="text-white">{{ __('Abbrechen') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
