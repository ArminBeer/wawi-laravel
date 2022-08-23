<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
           {{ __('Lieferant erstellen') }}
        </div>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => 'LieferantController@store', 'method' => 'POST']) !!}
                    @csrf
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('lieferant_name', 'Name')}}
                                {{Form::text('lieferant_name', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Name'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('email', 'E-Mail-Adresse')}}
                                {{Form::text('email', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'E-Mail-Adresse'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('ansprechpartner', 'Ansprechpartner')}}
                                {{Form::text('ansprechpartner', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Ansprechpartner'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('telefon', 'Telefon')}}
                                {{Form::text('telefon', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Telefon'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('plz', 'PLZ')}}
                                {{Form::number('plz', null, ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  border-gray-700  focus:shadow-outline', 'placeholder' => 'PLZ'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('ort', 'Ort')}}
                                {{Form::text('ort', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Ort'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('strasse', 'Strasse')}}
                                {{Form::text('strasse', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Strasse'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('land', 'Land')}}
                                {{Form::text('land', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Land'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::submit('Speichern',  ['class' => 'h-10 px-5 mt-2 text-white bg-strizzi'] )}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
