<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $lagerort->name }} {{ __('bearbeiten') }}
        </div>
        <div></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm">
                {!! Form::open(['action' => ['LagerortController@update', $lagerort->id], 'method' => 'POST']) !!}                    @csrf
                @method('PUT')
                <div class="table w-full">
                    <div class="table-row-group">
                        <div class="table-row text-xl">
                            {{Form::label('label_name', 'Name')}}
                        </div>
                        <div class="table-row">
                            {{Form::text('lagerort_name', $lagerort->name, ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Name'])}}
                        </div>
                    </div>
                    <div class="table-row-group">
                        <div class="table-row text-xl">
                            {{Form::label('label_name', 'Bild')}}
                        </div>
                        <div class="table-row">
                            {{Form::text('picture', $lagerort->picture, ['class' => 'w-full h-12 px-4 mb-4 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Name'])}}
                        </div>
                    </div>
                </div>
                <div class="table-row">
                    <div class="table-cell">
                        {{Form::submit('Speichern',  ['class' => 'h-10 px-5 text-white bg-strizzi'] )}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
