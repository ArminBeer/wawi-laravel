<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nährwert erstellen') }}
        </h2>
        <div></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => 'NaehrwertController@store', 'method' => 'POST']) !!}
                    @csrf
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('naehrwert_name', 'Name')}}
                                {{Form::text('naehrwert_name', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Name'])}}
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                    {{Form::label('einheit', 'Einheit')}}
                                    {{Form::text('einheit', null, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Einheit'])}}
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
