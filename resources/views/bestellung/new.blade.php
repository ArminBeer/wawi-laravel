<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Für neue Bestellung bitte Lieferant wählen') }}
        </div>
        <div></div>
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
                                            {{__('Ansprechpartner')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if (count($lieferanten) > 0)
                                        @foreach ($lieferanten as $lieferant)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{$lieferant['name']}}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{$lieferant['ansprechpartner']}}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap flex justify-end items-center">
                                                    <x-nav-link :href="route('bestellungen.add', ['lieferant' => $lieferant['id']])" class="inline-flex items-center h-10 px-5 bg-strizzi">
                                                        <span class="text-white">{{ __('Hier bestellen') }}</span>
                                                        <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
                                                    </x-nav-link>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Lieferanten vorhanden!')}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
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
    </div>
</x-app-layout>
