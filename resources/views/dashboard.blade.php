<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg">
                <div class="p-6 bg-strizzi text-center text-xl font-bold text-white">
                    Willkommen im Warenwirtschaftssystem von Strizzi!
                </div>
            </div>
        </div>
    </div>

    @if ($globalInventurFlag == 1)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
                <div class="bg-white overflow-hidden shadow-lg">
                    <div class="p-6 bg-strizzi-red text-center text-xl font-bold text-white">
                        <p>Aktuell ist eine Inventur ausgelöst worden!</p>
                        <p>Alle Aktivitäten die das Lager beeinflussen sind gesperrt!</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($openInventuren->first() && count($openInventuren) > 0)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
                <div class="flex flex-col">
                    <div class="mt-5 mb-5 mr-2 ml-2 text-xl">
                        <span class="font-bold">{{ __('Inventuraufträge') }}</span>
                    </div>
                    <div class="flex justify-around items-center flex-wrap">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Lagerort')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Beauftragt am')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($openInventuren as $openInventur)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $openInventur->lagerort()->first()->name}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{date('d M Y', strtotime($openInventur->created_at))}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('inventuren.checkStock', ['inventur' => $openInventur->id]) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white transition-colors duration-150 bg-strizzi">
                                                <span>{{ __('Inventur starten') }}</span>
                                                <svg class="ml-2 w-4 h-4 fill-current text-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m23.685 8.139-11.25-8c-.26-.185-.609-.185-.869 0l-11.25 8c-.198.14-.316.368-.316.611v3.5c0 .281.157.538.406.667.25.128.549.107.778-.055l.816-.581v10.719c0 .552.448 1 1 1h2v-12h14v12h2c.552 0 1-.448 1-1v-10.719l.815.58c.13.092.282.139.435.139.118 0 .235-.028.344-.083.249-.129.406-.386.406-.667v-3.5c0-.243-.118-.471-.315-.611z"/><path d="m6.5 21.5h11v2.5h-11z"/><path d="m6.5 17.5h11v2.5h-11z"/><path d="m6.5 13.5h11v2.5h-11z"/></svg>
                                            </a>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if (Auth::user()->order_right && count($problemBestellungen) > 0)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
                <div class="flex flex-col">
                    <div class="mt-5 mb-5 mr-2 ml-2 text-xl">
                        <span class="font-bold">{{ __('Problem Bestellungen') }}</span>
                    </div>
                    <div class="flex justify-around items-center flex-wrap">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Bestellnr')}}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Lieferant')}}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Annahmedatum')}}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($problemBestellungen as $problem)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $problem->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $problem->lieferant()->first()->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ date('d M Y', strtotime($problem['updated_at'])) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('bestellungen.history', ['bestellung' => $problem->id]) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white transition-colors duration-150 bg-strizzi-red">
                                                <span>{{ __('zur Historie') }}</span>
                                            </a>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif




    @if (Auth::user()->order_right && count($openBestellungen) > 0)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
                <div class="flex flex-col">
                    <div class="mt-5 mb-5 mr-2 ml-2 text-xl">
                        <span class="font-bold">{{ __('Bestellungen in der Anlieferung') }}</span>
                    </div>
                    <div class="shadow-md">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Bestellnr')}}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Lieferant')}}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Bestelldatum')}}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($openBestellungen as $order)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            {{$order->id}}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                        {{$order->lieferant()->first()->name}}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap">
                                        {{ date('d M Y', strtotime($order['updated_at'])) }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right">
                                            <a href="{{ route('anlieferungen.confirm', ['bestellung' => $order->id]) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white transition-colors duration-150 bg-strizzi">
                                                <span>{{ __('Annehmen') }}</span>
                                                <svg class="ml-2 w-4 h-4 fill-current text-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m23.685 8.139-11.25-8c-.26-.185-.609-.185-.869 0l-11.25 8c-.198.14-.316.368-.316.611v3.5c0 .281.157.538.406.667.25.128.549.107.778-.055l.816-.581v10.719c0 .552.448 1 1 1h2v-12h14v12h2c.552 0 1-.448 1-1v-10.719l.815.58c.13.092.282.139.435.139.118 0 .235-.028.344-.083.249-.129.406-.386.406-.667v-3.5c0-.243-.118-.471-.315-.611z"/><path d="m6.5 21.5h11v2.5h-11z"/><path d="m6.5 17.5h11v2.5h-11z"/><path d="m6.5 13.5h11v2.5h-11z"/></svg>
                                            </a>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="mt-5 mb-5 mr-2 ml-2 text-xl">
                        <h2 class="font-bold">{{ __('Niedriger Lagerbestand') }}</h2>
                    </div>
                    <div class="flex items-center flex-wrap">
                        @if ($rebuyZutaten)
                            @foreach ($rebuyZutaten as $zutat)
                                @if ($zutat->lieferant == 1)
                                    <a class="w-1/3 flex flex-col sm:rounded-lg" href="{{ route('produkte.quantity', ['produkte' => $zutat->selfmadeProdukt()->first()->id ] ) }}" class=" m-2 cursor-pointer inline-flex items-center h-10 px-5 py-0 transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-600">
                                @elseif ($zutat->lieferant == 0)
                                    <a class="w-1/3 flex flex-col sm:rounded-lg" href="{{ route('zutaten.edit', ['zutaten' => $zutat->id ] ) }}" class=" m-2 cursor-pointer inline-flex items-center h-10 px-5 py-0 transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-600">
                                @else
                                    <a class="w-1/3 flex flex-col sm:rounded-lg" href="{{ route('bestellungen.add', ['lieferant' => $zutat->lieferant ] ) }}" class="m-2 cursor-pointer inline-flex items-center h-10 px-5 py-0 transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-600">
                                @endif
                                    <div class="m-2 bg-white shadow-md">
                                        <div class="flex justify-center pt-5 pb-5 text-white bg-strizzi">
                                            {{ $zutat->name }}
                                        </div>
                                        <div class="m-2 mt-6">
                                            <p class="flex justify-between mb-2"><span>Aktueller Bestand:</span><span> {{ $zutat->lagerbestand}}{{ $zutat->einheit()->withTrashed()->first()->kuerzel}}</span></p>
                                            <p class="flex justify-between"><span>Mindestbestand:</span> <span>{{ $zutat->mindestbestand}} {{ $zutat->einheit()->withTrashed()->first()->kuerzel}}</span><p>
                                        </div>
                                        <div class="text-right mt-6">
                                            @if ($zutat->lieferant == 1)
                                                <p class="m-2 mb-4 arrow-right">Nachproduzieren</p>
                                            @elseif ($zutat->lieferant == 0)
                                                <p class="m-2 mb-4 arrow-right">Lieferant nachtragen</p>
                                            @else
                                                <p class="m-2 mb-4 arrow-right">Nachbestellen</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <span class="font-bold text-gray-800 mb-5">{{ __('Alle Zutaten ausreichend vorrätig.') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
