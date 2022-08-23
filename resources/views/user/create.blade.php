<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800 transition-colors duration-150 border-gray-800 border-2 rounded-lg hover:bg-gray-50 hover:text-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Neuen Mitarbeiter anlegen') }}
        </div>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {!! Form::open(['action' => 'UserController@store', 'method' => 'POST', 'files' => true]) !!}
                    @csrf
                    <div class="table w-full">
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('user_name_label', 'Name')}}
                                <x-input id="name" class="block mt-1 mb-4 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::label('user_email_label', 'E-Mail-Adresse')}}
                                <x-input id="email" class="w-full px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border rounded-lg focus:shadow-outline" type="email" name="email" :value="old('email')" required />
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="mb-4">
                                <span>Bild</span>
                                <div class="relative rounded-lg bg-blue-100 flex justify-center items-center">
                                    <div class="absolute">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                            </svg>
                                            <span class="block text-gray-400 font-normal">Hier Browser öffnen</span>
                                        </div>
                                    </div>
                                    <input type="file" id="InputImg" class="opacity-0 h-full w-full custom-h-40 cursor-pointer" name="image">
                                    <img class="m-2 custom-h-36 hidden absolute top-0 left-0" id="uploaded_img" src="#" alt="Bisher kein Logo ausgewählt" />
                                </div>
                            </div>
                        </div>
                        <!-- Berechtigung -->
                        <div class="flex flex-col border-solid border-indigo-800 border-2 sm:rounded-lg mb-5">
                            <div class="flex justify-center pt-5 pb-5 text-white bg-indigo-800 mb-5 ">
                                {{ __('Berechtigungen hinzufügen') }}
                            </div>
                            <div class="table-row-group p-5">
                                <div class="grid grid-cols-12 gap-4 pb-2">
                                    <div class="col-span-2">
                                        {{Form::label('user_rights_label', 'Personal Zugriff', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('rezept_watch_rights_label', 'Küche Einsehen', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('rezept_edit_rights_label', 'Küche Verwalten', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('zutat_rights_label', 'Lager Zugriff', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('stocktaking_rights_label', 'Inventur Erstellung', ['class' => 'font-bold'])}}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::label('bestellung_rights_label', 'Bestellung Zugriff', ['class' => 'font-bold'])}}
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-4">
                                    <div class="col-span-2">
                                        {{Form::checkbox('staff_right', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::checkbox('kitchen_watch_right', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::checkbox('kitchen_edit_right', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::checkbox('warehouse_right', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::checkbox('stocktaking_right', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                    </div>
                                    <div class="col-span-2">
                                        {{Form::checkbox('order_right', 1, 0, ['class ' => 'h-5 w-5 text-blue-600']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-row-group">
                            <div class="table-row">
                                {{Form::submit('Speichern',  ['class' => 'h-10 px-5 text-indigo-700 transition-colors duration-150 border border-indigo-500 rounded-lg focus:shadow-outline hover:bg-indigo-500 hover:text-indigo-100'] )}}
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('js_after')
    <!-- Adding custom scripts -->
    <script src="/js/user.custom.js"></script>
@endpush
</x-app-layout>
