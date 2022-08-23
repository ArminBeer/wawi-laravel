<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tagesbar Auswertung') }}
        </div>
        <div></div>
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
                                        {{__('Tag')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Gesamt')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('+ 0,10€')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('+ 0,50€')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('+ 1,00€')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('+ 5,00€')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Bier')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Cappuccino')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Eis')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Espresso')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Smoothie')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Spezi')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Spritz')}}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{__('Waffel/Sahne')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if (count($counters) > 0)
                                    @foreach($daily_revenue as $day)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{ date('d M Y', strtotime($day->day)) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{number_format($day->total_revenue, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'ten_cent')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'ten_cent')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'fifty_cent')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'fifty_cent')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'one_euro')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'one_euro')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'fife_euro')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'fife_euro')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'bier')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'bier')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'cappuccino')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'cappuccino')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'eis')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'eis')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'espresso')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'espresso')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'smoothie')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'smoothie')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'spezi')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'spezi')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'spritz')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'spritz')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                {{$counters->where('day', $day->day)->where('type', 'waffel')->first()->total ?? 0}} Stück<br/>
                                                {{number_format($counters->where('day', $day->day)->where('type', 'waffel')->first()->total_revenue ?? 0, 2 , "," , "." )}} €
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{__('Kein Counter vorhanden!')}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                        <td class="px-6 py-4 whitespace-nowrap"></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
