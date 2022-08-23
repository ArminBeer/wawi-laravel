<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bestellung Zusammenfassung') }}
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-2 bg-white">

                    <div class="flex flex-col">
                        <div class="flex flex-row justify-between items-center p-5">
                            <div class="font-bold">{{ __('Bestellnummer: ')}}</div>
                            <div>{{ $bestellung['id']}}</div>
                        </div>
                        <div class="flex flex-row justify-between items-center p-5 bg-gray-100">
                            <div class="font-bold">{{ __('Lieferant: ')}}</div>
                            <div>{{ $bestellung['lieferant']['name'] }}</div>
                        </div>
                        <div class="flex flex-row justify-between items-center p-5">
                            <div class="font-bold">{{ __('Bestellte Waren: ')}}</div>
                            <ul>
                                @foreach ($zutaten as $zutat)
                                    <li>{{ $zutat['name'] . ' ' . $zutat['pivot']['bestellmenge'] . ' ' . $zutat['einheit']['name']}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="flex flex-row justify-between items-center p-5 bg-gray-100">
                            <div class="font-bold">{{ __('Erstelldatum: ')}}</div>
                            <div>{{ date('d M Y - H:i:s', strtotime($bestellung['updated_at'])) }}</div>
                        </div>
                        <div class="flex flex-row justify-between items-center p-5">
                            <div class="font-bold">{{ __('Bestellung zuletzt bearbeitet von: ')}}</div>
                            <div>{{$latestActivity->user()->withTrashed()->first()->name}}</div>
                        </div>

                        <div class="flex flex-col bg-gray-100 p-5">
                            <div class="font-bold pb-5">{{ __('Bestellnotiz hinzufügen')}}</div>
                            {!! Form::open(['action' => ['BestellungController@sendsave', $bestellung['id']], 'method' => 'POST']) !!}
                            @csrf
                            @method('PUT')
                            {{Form::textarea('bestellnotiz', $bestellung['bestellnotiz'], ['class' => 'w-full p-5 mb-2 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Hier kannst du der E-Mail eine Nachricht hinzufügen'])}}
                        </div>
                    </div>


                    <div class="flex justify-between items-center flex-row-reverse mt-5">

                            <button type='submit' name="action" value='send' class='cursor-pointer inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi'>
                                Bestellung abschicken
                            </button>

                            <button type='submit' name="action" value='edit' class='cursor-pointer inline-flex items-center h-10 px-5 mx-1 text-white bg-gray-800'>
                                Bearbeiten
                            </button>

                            <button name="action" type='submit' value='save' class='cursor-pointer text-white inline-flex items-center h-10 px-5 py-0 bg-gray-800'>
                                Entwurf speichern
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
