@if(session('createSingle'))
    <div class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center bg-black bg-opacity-75">
        {!! Form::open(['action' => ['InventurController@startSingle', session('type'), session('createSingle')], 'method' => 'POST']) !!}
        @csrf
        @method('PUT')
        <div class="p-6 bg-gray-100">
            <div class="font-bold text-gray-900 text-center">
                <p class="text-gray-900 mt-2 mb-4">Welcher Mitarbeiter soll diese Inventur durchführen?</p>
                {{Form::select('user',[null => 'Bitte wählen'] + @session('users'), null, ['class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline'])}}
            </div>
            <div class="mt-8 flex justify-between items-center">
                <a href="/inventuren/{{@session('type')}}" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red">
                    <span class="text-white">{{ __('Abbrechen') }}</span>
                </a>
                {{Form::submit('Zuweisen',  ['class' => 'h-10 px-5 text-white bg-strizzi'] )}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endif
