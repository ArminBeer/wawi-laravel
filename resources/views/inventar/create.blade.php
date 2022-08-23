<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventar erstellen') }}
        </h2>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => 'InventarController@store', 'method' => 'POST', 'files' => true]) !!}
                    @csrf
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('label', 'Name')}}
                                {{Form::text('inventar_name', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Name'])}}
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
                                    <img class="m-2 hidden custom-h-36 absolute top-0 left-0" id="uploaded_img" src="#" alt="Bisher kein Logo ausgewählt" />
                                </div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('lagerbestand', 'Lagerbestand')}}
                                {{Form::number('lagerbestand', null, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700 focus:shadow-outline', 'placeholder' => 'Menge'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('mindestbestand', 'Mindestbestand')}}
                                {{Form::number('mindestbestand', null, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700 focus:shadow-outline', 'placeholder' => 'Menge'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('kategorie', 'Kategorien')}}
                                {{Form::select('kategorien[]', $kategorien, null, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline select-2', 'multiple' => 'multiple'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('tags', 'Tags')}}
                                {{Form::select('tags[]', $tags, null, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline select-2', 'multiple' => 'multiple'])}}
                            </div>
                        </div>

                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::submit('Speichern',  ['class' => 'h-10 px-5 text-white bg-strizzi'] )}}
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
<script src="/js/inventar.custom.js"></script>
@endpush
</x-app-layout>
