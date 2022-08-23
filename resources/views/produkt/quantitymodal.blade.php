@if(session('quantity'))
    <div id="craftProduct" class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center bg-black bg-opacity-75">
        {!! Form::open(['action' => ['ProduktController@craft',  session('quantity')], 'method' => 'POST']) !!}
        @csrf
        <div class="p-6 bg-gray-100">
            <svg class="w-14 h-14 mx-auto mb-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 512 512" xml:space="preserve">
                <g><g><path d="M501.362,383.95L320.497,51.474c-29.059-48.921-99.896-48.986-128.994,0L10.647,383.95
                c-29.706,49.989,6.259,113.291,64.482,113.291h361.736C495.039,497.241,531.068,433.99,501.362,383.95z M256,437.241
                c-16.538,0-30-13.462-30-30c0-16.538,13.462-30,30-30c16.538,0,30,13.462,30,30C286,423.779,272.538,437.241,256,437.241z
                M286,317.241c0,16.538-13.462,30-30,30c-16.538,0-30-13.462-30-30v-150c0-16.538,13.462-30,30-30c16.538,0,30,13.462,30,30
                V317.241z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
            </svg>
            <div class="font-bold text-gray-900 text-center">
                <p class="text-gray-900 mt-2 mb-2">Wie oft hast du dieses Mise en Place zubereitet?</p>
                {{Form::number('multiplier', null, ['step'=> 'any', 'class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'x Fache Menge'])}}
                <p class="text-gray-900 mt-4 mb-2">Oder abgewogene Menge eingeben</p>
                {{Form::text('quantity', @session('produktErtrag'), ['class' => 'w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Menge'])}}
                {{Form::select('einheit',[null => 'Bitte wählen'] + @session('einheiten'), @session('produktEinheit'), ['step'=> 'any', 'class' => 'w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline'])}}
            </div>
            <div class="mt-8 flex justify-between items-center">
                <a href=<?= @session('link') ?> id="closeCrafting" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red">
                    <span class="text-white">{{ __('Abbrechen') }}</span>
                </a>
                {{Form::submit('Speichern',  ['class' => 'h-10 px-5 text-white bg-strizzi'] )}}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endif
