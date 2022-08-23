<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $rezept['name'] }} {{ __('bearbeiten') }}
        </div>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => ['RezeptController@update', $rezept->id], 'method' => 'POST', 'files' => true]) !!}
                    @csrf
                    @method('PUT')
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row font-bold">
                                {{Form::label('rezept_name', 'Name')}}
                            </div>
                            <div class="table-row">
                                {{Form::text('rezept_name', $rezept->name, ['class' => 'w-full h-12 px-4 mb-5 text-lg text-gray-700 placeholder-gray-600 border', 'placeholder' => 'Rezeptname'])}}
                            </div>
                        </div>

                        <div class="flex flex-col border-solid border-indigo-800 border-2 sm:rounded-lg mb-5">
                            <div class="flex justify-center pt-5 pb-5 text-white bg-indigo-800 mb-5 ">
                                {{ __('Lightspeed Anbindung') }}
                            </div>
                            <div class="flex justify-between px-5 pt-5">
                                <div class="w-1/4">
                                    {{Form::label('business_label', 'Wird verkauft in:', ['class' => 'font-bold mb-2'])}}
                                </div>
                                <div class="w-full flex justify-around">
                                    <div>
                                        {{Form::checkbox('restaurant', 1, $restaurantArticle, ['class ' => 'h-5 w-5 text-blue-600 gastro_1']) }}
                                        {{Form::label('business_label', 'Restaurant', ['class' => 'font-bold'])}}
                                    </div>
                                    <div>
                                        {{Form::checkbox('eis', 1, $eiscafeArticle, ['class ' => 'h-5 w-5 text-blue-600 gastro_2']) }}
                                        {{Form::label('business_label', 'Eiscafé', ['class' => 'font-bold'])}}
                                    </div>
                                </div>
                            </div>
                            <div class="table-row-group p-5">
                                <div class="grid grid-cols-1 gap-4 pb-2">
                                    <div class="col-span-1">
                                        {{Form::label('sku_label', 'Lightspeed SKU', ['class' => 'mt-5 font-bold'])}}
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="col-span-1">
                                        {{Form::select('sku', $articles, $rezept->articles()->exists()? $rezept->articles()->first()->sku : null, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline select-2'])}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-row-group">
                            <div class="mb-4">
                                <span class="font-bold">Bild</span>
                                <div class="relative bg-blue-100 flex justify-center items-center">
                                    <div class="absolute">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg>
                                            <span class="block text-gray-400 font-normal">Hier Browser öffnen</span>
                                        </div>
                                    </div>
                                    <input type="file" id="InputImg" class="opacity-0 w-full custom-h-40 cursor-pointer" name="image">
                                    @if ($rezept['picture'])
                                        <img class="m-2 custom-h-36 absolute top-0 left-0" id="existing_img" src="/storage{{$rezept['picture']}}">
                                    @endif
                                    <img class="m-2 custom-h-36 hidden absolute top-0 left-0" id="uploaded_img" src="#" alt="Bisher kein Logo ausgewählt" />
                                </div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row font-bold">
                                {{Form::label('description_short', 'Zubereitung Kurzbeschreibung')}}
                            </div>
                            <div class="table-row">
                                {{Form::textarea('description_short',  $rezept->zubereitung()->first()->description_short, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border', 'placeholder' => 'Kurzbeschreibung'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row font-bold">
                                {{Form::label('description_long', 'Zubereitung Ausführlich Beschreibung')}}
                            </div>
                            <div class="table-row">
                                {{Form::textarea('description_long', $rezept->zubereitung()->first()->description_long, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border', 'placeholder' => 'Ausführliche Anleitung'])}}
                            </div>
                        </div>

                        <!-- Show Zutaten plus option to add new ones -->
                        <div class="flex flex-col mb-5">
                            <div class="flex font-bold pt-5 mb-5">
                                {{ __('Zutaten bearbeiten') }}
                            </div>

                            <div class="table-row-group">
                                <div class="grid grid-cols-12 gap-4 pb-2">
                                    <div class="col-span-3">
                                        {{Form::label('', 'Zutat', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-3">
                                        {{Form::label('', 'Menge', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('', 'Einheit', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('', 'Verschnitt in %', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('', '')}}
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-4">
                                    @if ($activeZutaten)
                                        @foreach ($activeZutaten as $activeZutat)
                                            <div class="col-span-10 grid grid-cols-10 gap-4 zutat-delete" id="active_zutat_form">
                                                <div class="col-span-3 zutat_element">
                                                    {{Form::select('zutaten[]',[null => 'Bitte wählen'] + $zutaten, $activeZutat['zutat'], ['class' => 'rezept_zutat w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border select-2'])}}
                                                </div>
                                                <div class="col-span-3 zutat_element">
                                                    {{Form::number('zutat_mengen[]', $activeZutat['menge'], ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 border-gray-700 placeholder-gray-600 border'])}}
                                                </div>
                                                <div class="col-span-2 zutat_element">
                                                    {{Form::select('zutat_einheiten[]',[null => 'Bitte wählen'] + $einheiten, $activeZutat['einheit'], ['class' => 'rezept_einheiten w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border '])}}
                                                </div>
                                                <div class="col-span-2 zutat_element">
                                                    {{Form::number('zutat_verluste[]', $activeZutat['verlust'], ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 border-gray-700 placeholder-gray-600 border '])}}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- Add New Zutaten -->
                                    <div class="col-span-10 grid grid-cols-10 gap-4 zutat-delete" id="zutat_form">
                                        <div class="col-span-3 zutat_element">
                                            {{Form::select('zutaten[]',[null => 'Bitte wählen'] + $zutaten, null, ['class' => 'rezept_zutat w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border select-2'])}}
                                        </div>
                                        <div class="col-span-3 zutat_element">
                                            {{Form::number('zutat_mengen[]', null, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700', 'placeholder' => 'Menge'])}}
                                        </div>
                                        <div class="col-span-2 zutat_element">
                                            {{Form::select('zutat_einheiten[]',[null => 'Bitte wählen'] + $einheiten, null, ['class' => 'rezept_einheiten w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border'])}}
                                        </div>
                                        <div class="col-span-2 zutat_element">
                                            {{Form::number('zutat_verluste[]', null, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700', 'placeholder' => 'Verschnitt'])}}
                                        </div>
                                    </div>
                                    <div class="col-span-2 grid grid-cols-2 gap-4 zutat-create flex justify-center items-center mb-2.5" id="zutaten">
                                        <div class="col-span-1 flex justify-center items-center cursor-pointer" id="zutat_neu">
                                            <svg class="w-7 h-7 ml-3 fill-current text-strizzi" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
                                        </div>
                                        <div class="col-span-1 flex justify-center items-center cursor-pointer" id="zutat_loeschen">
                                            <svg class="w-7 h-7 ml-3 fill-current text-strizzi-red" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {!! Form::hidden('zubereitung_id', $rezept->zubereitung()->first()->id) !!}
                                {{ Form::submit('Speichern',  ['class' => 'h-10 px-5 text-white bg-strizzi'] )}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('js_after')
    <!-- Adding custom css -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.custom.css') }}">
    <!-- Adding custom scripts -->
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="{{ asset('js/select2.custom.js') }}" defer></script>
    <script src="/js/rezept.custom.js"></script>
@endpush
</x-app-layout>
