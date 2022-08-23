<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gericht:') }} {{ $rezept->name }}
        </div>
        <div class="flex">
            @if(Auth::user()->kitchen_edit_right)
                <a href="{{ route('rezepte.edit', ['rezepte' => $rezept->id]) }}" class="inline-flex items-center h-10 px-5 text-white bg-gray-800">
                    <svg class=" w-4 h-4 fill-current" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                </a>
                {{Form::open(array('route' => array( 'rezepte.destroy', $rezept->id ), 'method' => 'delete', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie dieses Rezept wirklich löschen?')"))}}
                    <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi-red" >
                        <svg class="w-4 h-4 fill-current text-white" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
                    </button>
                {{Form::close()}}
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex rezept">
                <div class="text-col">
                    <div class="shadow overflow-hidden border-b border-gray-200 rezept-box">
                        <div class="min-w-full divide-y divide-gray-200">
                            <div class="text-header">
                                <div class="text-gray-900">{{ __('Zubereitung') }}</div>
                            </div>
                            <div class="text-body">
                                <div class="text-gray-900">{!! nl2br($rezept->zubereitung()->first()->description_long) !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 rezept-box">
                        <div class="min-w-full divide-y divide-gray-200">
                            <div class="text-header">
                                <div class="text-gray-900">{{ __('Beschreibung') }}</div>
                            </div>
                            <div class="text-body">
                                <div class="text-gray-900">{!! nl2br($rezept->zubereitung()->first()->description_short) !!}</div>
                            </div>
                        </div>
                    </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 rezept-box">
                        <div class="min-w-full divide-y divide-gray-200">
                            <div class="text-header">
                                <div class="text-gray-900">{{ __('Allergene') }}</div>
                            </div>
                            <div class="text-body">
                                <ul>
                                    @foreach ($allergene as $allergen)
                                            <li>{{ $allergen }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="zutat-col">
                    <div class="shadow overflow-hidden border-b border-gray-200 rezept-box">
                        <div class="min-w-full divide-y divide-gray-200">
                            <div class="text-header">
                                <div class="text-gray-900">{{ __('Verlinkung') }}</div>
                            </div>
                            @if ($rezept->articles()->exists())
                                <div class="text-body text-white bg-strizzi">
                                    {{__('Lightspeed SKU: ') . $rezept->articles()->first()->sku}}<br />
                                </div>
                            @else
                                <div class="text-body text-white bg-strizzi-red">
                                    {{__('Lightspeed SKU bitte nachtragen!')}}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="shadow overflow-hidden border-b border-gray-200 rezept-box">
                        <div class="min-w-full divide-y divide-gray-200">
                            <div class="text-header">
                                <div class="text-gray-900">{{ __('Zutaten') }}</div>
                            </div>

                            <div class="text-body">
                                <ul>
                                    @foreach ($zutaten as $zutat)
                                        <li class="flex justify-between items-center py-1">
                                            {{$zutat->pivot->menge . ' ' . $einheiten[$zutat->pivot->einheit] . ' ' . $zutat->name}}
                                            @if ($zutat->isProdukt())
                                                <a href="{{ route('produkte.show', ['produkte' => $zutat->selfmadeProdukt()->first()->id ] ) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi">
                                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            class="w-4 h-4 fill-current text-white" viewBox="0 0 310.42 310.42" style="enable-background:new 0 0 310.42 310.42;"
                                                            xml:space="preserve"><g><g><path d="M273.587,214.965c49.11-49.111,49.109-129.021,0-178.132c-49.111-49.111-129.02-49.111-178.13,0
                                                                    C53.793,78.497,47.483,140.462,76.51,188.85c0,0,2.085,3.498-0.731,6.312c-16.065,16.064-64.263,64.263-64.263,64.263
                                                                    c-12.791,12.79-15.836,30.675-4.493,42.02l1.953,1.951c11.343,11.345,29.229,8.301,42.019-4.49c0,0,48.096-48.097,64.128-64.128
                                                                    c2.951-2.951,6.448-0.866,6.448-0.866C169.958,262.938,231.923,256.629,273.587,214.965z M118.711,191.71
                                                                    c-36.288-36.288-36.287-95.332,0.001-131.62c36.288-36.287,95.332-36.288,131.619,0c36.288,36.287,36.288,95.332,0,131.62
                                                                    C214.043,227.996,155,227.996,118.711,191.71z"/><g><path d="M126.75,118.424c-1.689,0-3.406-0.332-5.061-1.031c-6.611-2.798-9.704-10.426-6.906-17.038
                                                                        c17.586-41.559,65.703-61.062,107.261-43.476c6.611,2.798,9.704,10.426,6.906,17.038c-2.799,6.612-10.425,9.703-17.039,6.906
                                                                        c-28.354-11.998-61.186,1.309-73.183,29.663C136.629,115.445,131.815,118.424,126.75,118.424z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>

                                                </a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
