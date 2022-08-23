<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Allergene') }}
        </div>
        <div id="addAllergen" class="inline-flex items-center h-10 px-5 bg-strizzi">
            <span class="text-white">{{ __('Hinzufügen') }}</span>
            <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{__('Name')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{__('Tag')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if (count($allergene) > 0)
                                        @foreach ($allergene as $allergen)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{$allergen['name']}}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{$allergen['tag']}}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap flex justify-end items-center">
                                                    <div class="text-sm text-gray-900">
                                                        <x-nav-link :href="route('allergene.edit', ['allergene' => $allergen['id']])" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-gray-800">
                                                            <svg class=" w-4 h-4 fill-current text-white" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                                                        </x-nav-link>
                                                        {{Form::open(array('route' => array( 'allergene.destroy', $allergen['id'] ), 'method' => 'delete', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie dieses Allergen wirklich löschen?')"))}}
                                                        <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi-red" >
                                                            <svg class="w-4 h-4 fill-current text-white" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
                                                        </button>
                                                        {{Form::close()}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{__('Kein Allergen vorhanden!')}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 whitespace-nowrap"></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- Add new allergen -->
                            <div id="allergen_form" class="hidden">
                                {!! Form::open(array('action' => 'AllergenController@store', 'method' => 'POST')) !!}
                                @csrf
                                    <div class="w-full flex justify-center items-center px-6 py-4">
                                        <div class="w-1/2 flex justify-center items-center">
                                            {{Form::text('allergen_name', null, ['class' => 'w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Name des Allergens'])}}
                                        </div>
                                        <div class="w-1/3 flex justify-center items-center mx-2">
                                            {{Form::text('tag', null, ['class' => 'w-full h-12 px-4 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline', 'placeholder' => 'Tag'])}}
                                        </div>
                                        <div class="w-1/3 flex justify-center items-center mx-2">
                                            {{Form::submit('Speichern',  ['class' => 'h-12 px-5 text-white bg-strizzi'] )}}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            <!-- end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('js_after')
<!-- Adding custom scripts -->
<script src="/js/allergen.custom.js"></script>
@endpush
</x-app-layout>
