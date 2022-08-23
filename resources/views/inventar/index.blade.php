<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventar') }}
        </div>
        <div class="flex">
            @if (Auth::user()->stocktaking_right)
                <x-nav-link class="mr-2 inline-flex items-center h-10 px-5 text-white bg-gray-800" :href="route('inventuren.index', ['type' => 2])" :active="request()->routeIs('inventuren.*')">
                    <span class="text-white">{{ __('Inventur') }}</span>
                </x-nav-link>
            @endif
            <x-nav-link :href="route('inventare.create')" class="inline-flex items-center h-10 px-5 text-white bg-strizzi">
                <span class="text-white">{{ __('Hinzufügen') }}</span>
                <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
            </x-nav-link>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">

                        <table class="shadow overflow-hidden border-b border-gray-200 min-w-full divide-y divide-gray-200 js-dataTable">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Name')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Lagerbestand')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Mindestbestand')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (count($inventare) > 0)
                                    @foreach ($inventare as $inventar)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$inventar->name}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$inventar->lagerbestand}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$inventar->mindestbestand}}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap flex justify-end items-center">
                                                @if (auth()->user()->stocktaking_right)
                                                    <x-nav-link :href="route('inventare.add', ['inventare' => $inventar->id])" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-gray-800">
                                                        <svg class=" w-4 h-4 fill-current text-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m23.685 8.139-11.25-8c-.26-.185-.609-.185-.869 0l-11.25 8c-.198.14-.316.368-.316.611v3.5c0 .281.157.538.406.667.25.128.549.107.778-.055l.816-.581v10.719c0 .552.448 1 1 1h2v-12h14v12h2c.552 0 1-.448 1-1v-10.719l.815.58c.13.092.282.139.435.139.118 0 .235-.028.344-.083.249-.129.406-.386.406-.667v-3.5c0-.243-.118-.471-.315-.611z"/><path d="m6.5 21.5h11v2.5h-11z"/><path d="m6.5 17.5h11v2.5h-11z"/><path d="m6.5 13.5h11v2.5h-11z"/></svg>
                                                    </x-nav-link>
                                                    <x-nav-link :href="route('inventare.edit', ['inventare' => $inventar->id])" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi">
                                                        <svg class=" w-4 h-4 fill-current text-white" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                                                    </x-nav-link>
                                                @endif
                                            </td>
                                    @endforeach
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap">{{__('Kein Inventar vorhanden!')}}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"></td>
                                    <td class="px-6 py-4 whitespace-nowrap"></td>
                                    <td class="px-6 py-4 whitespace-nowrap"></td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('js_after')
    <!-- Adding custom css -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.custom.css') }}">
    <!-- Adding custom scripts -->
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="{{ asset('js/select2.custom.js') }}" defer></script>
@endpush
</x-app-layout>
