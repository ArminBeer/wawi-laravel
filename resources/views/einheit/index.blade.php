<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Einheiten und Umrechnungen') }}
        </div>
        <div></div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="flex flex-col">
                    <div class="flex justify-between flex-wrap mb-5">
                        <span class="font-bold text-xl">{{ __('Alle Einheiten') }}</span>
                        <div id="addEinheit" class="inline-flex items-center h-10 px-5 transition-colors duration-150 bg-strizzi cursor-pointer">
                            <span class="text-white">{{ __('Neue Einheit hinzufügen') }}</span>
                            <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
                        </div>
                    </div>
                    <div class="flex justify-center items-center flex-row flex-wrap">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Name')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Kürzel')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Grundeinheit')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Benötigt individuelle Umrechnung')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (count($einheiten) > 0)
                                    @foreach ($einheiten as $einheit)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{$einheit['name']}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{$einheit['kuerzel']}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if ($einheit['grundeinheit'])
                                                        <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                    @else
                                                        <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    @if ($einheit['conversion_needed'])
                                                        <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                    @else
                                                        <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap flex justify-end items-center">
                                                <div class="einheit_edit cursor-pointer inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi">
                                                    <div class="hidden einheit_name">{{$einheit->name}}</div>
                                                    <div class="hidden einheit_kuerzel">{{$einheit->kuerzel}}</div>
                                                    <div class="hidden einheit_grundeinheit">{{$einheit->grundeinheit}}</div>
                                                    <div class="hidden einheit_conversion">{{$einheit->conversion_needed}}</div>
                                                    <div class="hidden einheit_id">{{$einheit->id}}</div>
                                                    <svg class=" w-4 h-4 fill-current text-white" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                                                </div>
                                                <div class="text-sm text-gray-900">
                                                    {{Form::open(array('route' => array( 'einheiten.destroy', $einheit['id'] ), 'method' => 'delete', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie diese Einheit wirklich löschen?')"))}}
                                                    <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi-red" >
                                                        <svg class="w-4 h-4 fill-current text-white" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
                                                    </button>
                                                    {{Form::close()}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{__('Keine Einheiten vorhanden!')}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"></td>
                                @endif


                            </tbody>
                        </table>
                    </div>
                    <!-- Add new einheit -->
                    <div id="einheit_form" class="hidden">
                        {!! Form::open(array('action' => 'EinheitController@store', 'method' => 'POST')) !!}
                        @csrf
                            <div class="w-full flex justify-center items-center py-4 px-4 bg-white border">
                                <div class="w-1/3 flex justify-center items-center">
                                    {{Form::text('einheiten_name', null, ['class' => 'e_name w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Name der Einheit'])}}
                                </div>
                                <div class="w-1/3 flex justify-center items-center mx-2">
                                    {{Form::text('kuerzel', null, ['class' => 'e_kuerzel w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Kürzel'])}}
                                </div>
                                <div class="w-1/3 flex justify-center items-center mx-2">
                                    {{Form::label('grundeinheitlabel', 'Grundeinheit')}}
                                    {{Form::checkbox('grundeinheit', 1, null, ['class ' => 'e_grundeinheit my-2 ml-2 h-5 w-5 text-blue-600']) }}
                                </div>
                                <div class="w-1/3 flex justify-center items-center mx-2">
                                    {{Form::label('conversionlabel', 'Benötigt individuelle Umrechnung')}}
                                    {{Form::checkbox('conversion_needed', 1, null, ['class ' => 'e_conversion my-2 ml-2 h-5 w-5 text-blue-600']) }}
                                </div>
                                <div class="w-1/3 flex justify-center items-center mx-2">
                                    {!! Form::hidden('einheit_id', null, ['class' => 'e_id']) !!}
                                    {{Form::submit('Speichern',  ['class' => 'h-12 px-5 text-white bg-strizzi'] )}}
                                </div>
                                <div class="w-1/5 flex justify-center items-center mx-2">
                                    <div id="einheit_close" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red">
                                        <span class="text-white">{{ __('Abbrechen') }}</span>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="flex flex-col">
                    <div class="flex justify-between flex-wrap mb-5">
                        <span class="font-bold text-xl">{{ __('Alle Umrechnungen') }}</span>
                        <div id="addUmrechnung" class="inline-flex items-center h-10 px-5 bg-strizzi cursor-pointer">
                            <span class="text-white">{{ __('Neue Umrechnung hinzufügen') }}</span>
                            <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
                        </div>
                    </div>
                    <div class="flex justify-center items-center flex-row flex-wrap">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Umrechnung von Einheit')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('zu Einheit')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Faktor')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (count($umrechnungen) > 0)
                                    @foreach ($umrechnungen as $umrechnung)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{$allEinheiten[$umrechnung['ist_einheit']]}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{$allEinheiten[$umrechnung['soll_einheit']]}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{$umrechnung['faktor']}}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap flex justify-end items-center">
                                                <div class="umrechnung_edit cursor-pointer inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi">
                                                    <div class="hidden umrechnung_ist">{{$umrechnung['ist_einheit']}}</div>
                                                    <div class="hidden umrechnung_soll">{{$umrechnung['soll_einheit']}}</div>
                                                    <div class="hidden umrechnung_faktor">{{$umrechnung['faktor']}}</div>
                                                    <div class="hidden umrechnung_id">{{$umrechnung['id']}}</div>
                                                    <svg class=" w-4 h-4 fill-current text-white" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                                                </div>
                                                <div class="text-sm text-gray-900">
                                                    {{Form::open(array('route' => array( 'einheiten.destroyUmrechnung', $umrechnung['id'] ), 'method' => 'delete', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie diese Umrechnung wirklich löschen?')"))}}
                                                    <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi-red" >
                                                        <svg class="w-4 h-4 fill-current text-white" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
                                                    </button>
                                                    {{Form::close()}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{__('Keine Umrechnungen eingepflegt!')}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap"></td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Add new umrechnung -->
                    <div id="umrechnung_form" class="hidden">
                        {!! Form::open(array('action' => 'EinheitController@storeUmrechnung', 'method' => 'POST')) !!}
                        @csrf
                            <div class="w-full flex justify-center items-end py-4 px-4 bg-white border">
                                <div class="w-1/5 flex flex-col justify-center items-center mx-2">
                                    {{__('Umrechnungseinheit')}}
                                    <div class="flex w-full flex-row justify-center items-center">
                                        <p class="w-1/5">1</p>
                                        {{Form::select('ist_einheit', $noSpezialEinheiten, null, ['class' => 'u_ist w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline'])}}
                                    </div>
                                </div>
                                <div class="w-1/5 flex justify-center items-center">
                                    <svg class="w-5 h-5 mb-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 42 42"><path d="M4.941 18H37.059C39.776 18 42 15.718 42 13s-2.224-5-4.941-5H4.941C2.224 8 0 10.282 0 13s2.224 5 4.941 5zM37.059 24H4.941C2.224 24 0 26.282 0 29s2.224 5 4.941 5H37.059C39.776 34 42 31.718 42 29s-2.224-5-4.941-5z"/></svg>
                                </div>
                                <div class="w-1/5 flex flex-col justify-center items-center mx-2">
                                    {{__('Faktor')}}
                                    {{Form::text('factor', null, ['class' => 'u_faktor w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline', 'placeholder' => 'Umrechnungsfaktor'])}}
                                </div>
                                <div class="w-1/5 flex flex-col justify-center items-center mx-2">
                                    {{__('Grundeinheit')}}
                                    {{Form::select('soll_einheit', $grundeinheiten, null, ['class' => 'u_soll w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border focus:shadow-outline'])}}
                                </div>
                                <div class="w-1/5 flex justify-center items-end mx-2">
                                    {!! Form::hidden('umrechnung_id', null, ['class' => 'u_id']) !!}
                                    {{Form::submit('Speichern',  ['class' => 'h-12 px-5 text-white bg-strizzi'] )}}
                                </div>
                                <div class="w-1/5 flex justify-center items-center mx-2">
                                    <div id="umrechnung_close" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red">
                                        <span class="text-white">{{ __('Abbrechen') }}</span>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- end -->
                </div>
            </div>
        </div>
    </div>

@push('js_after')
<!-- Adding custom scripts -->
<script src="/js/einheit.custom.js"></script>
@endpush
</x-app-layout>
