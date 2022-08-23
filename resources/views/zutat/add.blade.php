<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lagerbestand anpassen für ') . $zutat['name'] }}
        </div>
        <div></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
                {!! Form::open(['action' => ['ZutatController@addstore', $zutat['id']], 'method' => 'POST']) !!}
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col">
                        <div class="mt-5 mb-5 mr-2 ml-2 text-xl">
                            {{ __('Aktueller Lagerbestand ') .  $zutat->name . ': ' . $zutat->lagerbestand . ' ' . $zutat->einheit()->first()->name  }}
                        </div>
                        <div class="table-row-group p-5 bg-white">
                            <div class="flex">
                                <div class="w-1/3">
                                    <div class="m-2">
                                        {{Form::label('', 'Menge', ['class' => 'font-bold'])}}
                                    </div>
                                </div>
                                <div class="w-5/12">
                                    <div class="m-2">
                                        {{Form::label('', 'Einheit', ['class' => 'font-bold'])}}
                                    </div>
                                </div>
                                <div class="w-1/4">
                                </div>
                            </div>
                            <div class="flex">
                                <div class="w-1/3">
                                    <div class="m-2">
                                        {{Form::number('addValue', null, ['step' => 'any', 'class' => ' w-full h-10 px-4 text-lg text-gray-700 border-gray-700 placeholder-gray-600 border', 'placeholder' => 'Menge'])}}
                                    </div>
                                </div>
                                <div class="w-5/12">
                                    <div class="m-2">
                                        {{Form::select('einheit',[null => 'Bitte wählen'] + $einheiten, $zutat->einheit, ['class' => 'w-full h-10 px-4 text-lg text-gray-700 placeholder-gray-600 border'])}}
                                    </div>
                                </div>
                                <div class="w-1/4 flex items-center">
                                    <div class="m-2">
                                        {{Form::submit('Speichern',  ['class' => 'h-10 px-5 text-white bg-strizzi'] )}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>
