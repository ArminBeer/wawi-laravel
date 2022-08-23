<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alle Logs') }}
        </div>
        <div></div>
    </x-slot>

    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto sm:px-1">
                <div class="flex justify-end">
                    <div class="filter-opener inline-flex items-center h-10 px-5 mb-2 text-white bg-strizzi cursor-pointer">
                        Filter
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 971.986 971.986" class="ml-1 w-4 h-4 fill-current text-white" ><path d="M370.216 459.3c10.2 11.1 15.8 25.6 15.8 40.6v442c0 26.601 32.1 40.101 51.1 21.4l123.3-141.3c16.5-19.8 25.6-29.601 25.6-49.2V500c0-15 5.7-29.5 15.8-40.601L955.615 75.5c26.5-28.8 6.101-75.5-33.1-75.5h-873c-39.2 0-59.7 46.6-33.1 75.5l353.801 383.8z"/></svg>
                    </div>
                </div>
                <div class="filter-wrapper mb-4 hidden">
                    <div class="filter-date">
                        {{Form::label('dateLabel', 'Datum')}}<br />
                        <input type="date" id="datepicker" name="trip-start">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full sm:px-1">
                <table class="shadow overflow-hidden border-b border-gray-200 min-w-full divide-y divide-gray-200 js-dataTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Datum')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Änderung an')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Mitarbeiter')}}
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Änderungen')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if (count($logs) > 0)
                        @foreach ($logs as $log)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="hidden">{{ strtotime($log['updated_at'])}}</p>
                                    {{ gmdate('d.m.Y h:m:s', strtotime($log['updated_at'])) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{$models[$log->verknuepfung_type] . ': '}}
                                    @if ($log->model($log->verknuepfung_type)->withTrashed()->first())
                                        @if ($log->model($log->verknuepfung_type)->withTrashed()->first()->name)
                                            {{$log->model($log->verknuepfung_type)->withTrashed()->first()->name}}
                                        @else
                                            {{$log->model($log->verknuepfung_type)->withTrashed()->first()->id}}
                                        @endif
                                    @else
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($log->user()->withTrashed()->first())
                                        {{$log->user()->withTrashed()->first()->name}}
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if (is_array(unserialize($log->changes)))
                                        <ul>
                                        @foreach (unserialize($log->changes) as $key => $value)
                                            <li>{{ $key . ': ' . $value }}</li>
                                        @endforeach
                                        </ul>
                                    @else
                                        {{ unserialize($log->changes) }}
                                    @endif
                                </td>
                        @endforeach
                    @else
                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Logs vorhanden!')}}</td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('js_after')
        <script src="{{ asset('js/datatables.min.js') }}" defer></script>
        <script src="{{ asset('js/datatables-log.custom.js') }}" defer></script>
    @endpush
</x-app-layout>
