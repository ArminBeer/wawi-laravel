<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $lieferant['name'] }} {{ __('bearbeiten') }}
        </div>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => ['LieferantController@update', $lieferant['id']], 'method' => 'POST']) !!}
                    @csrf
                    @method('PUT')
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('lieferant_name', 'Name')}}
                                {{Form::text('lieferant_name', $lieferant['name'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Name'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('email', 'E-Mail-Adresse')}}
                                {{Form::text('email', $lieferant['email'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'E-Mail-Adresse'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('ansprechpartner', 'Ansprechpartner')}}
                                {{Form::text('ansprechpartner',  $lieferant['ansprechpartner'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Ansprechpartner'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('telefon', 'Telefon')}}
                                {{Form::text('telefon', $lieferant['telefon'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Telefon'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('plz', 'PLZ')}}
                                {{Form::number('plz', $lieferant['plz'], ['step' => 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border border-gray-700 focus:shadow-outline', 'placeholder' => 'PLZ'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('ort', 'Ort')}}
                                {{Form::text('ort',  $lieferant['ort'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Ort'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('strasse', 'Strasse')}}
                                {{Form::text('strasse', $lieferant['strasse'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Strasse'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('land', 'Land')}}
                                {{Form::text('land', $lieferant['land'], ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Land'])}}
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
</x-app-layout>
