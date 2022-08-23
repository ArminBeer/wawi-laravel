<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $inventar->name }} {{ __('bearbeiten') }}
        </div>
        {{Form::open(array('route' => array( 'inventare.destroy', $inventar->id ), 'method' => 'delete', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie diese Objekt wirklich löschen?')"))}}
            <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi-red" >
                <svg class="w-4 h-4 fill-current text-white" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
            </button>
        {{Form::close()}}
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => ['InventarController@update', $inventar->id], 'method' => 'POST', 'files' => true]) !!}
                    @csrf
                    @method('PUT')
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row pt">
                            {{Form::label('inventar_label', 'Name')}}
                            {{Form::text('inventar_name', $inventar->name, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border', 'placeholder' => 'Name'])}}
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
                                    @if ($inventar->picture)
                                        <img class="m-2 custom-h-36 absolute top-0 left-0" id="existing_img" src="/storage{{$inventar->picture}}">
                                    @endif
                                    <img class="m-2 custom-h-36 hidden absolute top-0 left-0" id="uploaded_img" src="#" alt="Bisher kein Logo ausgewählt" />
                                </div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('kategorie', 'Kategorie')}}
                                {{Form::select('kategorien[]', $kategorien, $activeKategorien, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline select-2', 'multiple' => 'multiple'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('tags', 'Tags')}}
                                {{Form::select('tags[]', $tags, $activeTags, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline select-2', 'multiple' => 'multiple'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('lagerbestand', 'Lagerbestand')}}
                                {{Form::number('lagerbestand', $inventar->lagerbestand, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700  focus:shadow-outline', 'placeholder' => 'Menge'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('mindestbestand', 'Mindestbestand')}}
                                {{Form::number('mindestbestand',  $inventar->mindestbestand, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700 focus:shadow-outline', 'placeholder' => 'Menge'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::submit('Speichern',  ['class' => 'h-10 px-5 bg-strizzi text-white'] )}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 mt-4 flex flex-col justify-start items-start px-6 py-4">
                <p class="mb-4 font-bold">{{__('Lagerbestand Änderungen')}}</p>
                @if ($activities)
                    <ul class="px-6 py-4 bg-white w-full border">
                        @foreach ($activities as $activity)
                            <li>
                                @if ($activity->inventur == 0)
                                    {{__('Manuelle Anpassung')}}
                                @else
                                    {{__('Anpassung durch Inventur')}}
                                @endif
                                {{ 'von ' . $activity->old_value . ' zu ' . $activity->new_value }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    {{ __('Noch keine Änderungen vorgenommen')}}
                @endif
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
<script src="/js/inventar.custom.js"></script>
@endpush
</x-app-layout>
