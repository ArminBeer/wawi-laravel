<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historie der Inventur: ') . $inventur->lagerort()->first()->name . ' vom ' .  date('d M Y', strtotime($inventur->created_at))}}
        </h2>
        <div></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white border-b border-gray-200 mb-5">
                <div class="flex flex-col mb-5">
                    <div class="flex text-xl font-bold mb-5">
                        {{ __('Allgemeine Inventur Infos') }}
                    </div>
                    <div class="table-row-group">
                        <div class="grid grid-cols-12 gap-4 pb-2">
                            <div class="col-span-2">
                                {{Form::label('', 'Durchgeführt von', ['class' => 'font-bold'])}}
                            </div>
                            <div class="col-span-3">
                                {{Form::label('', 'Zugewiesen am', ['class' => 'font-bold'])}}
                            </div>
                            <div class="col-span-3">
                                {{Form::label('', 'Letzte Statusänderung', ['class' => 'font-bold'])}}
                            </div>
                            <div class="col-span-2">
                                {{Form::label('', 'Status', ['class' => 'font-bold'])}}
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-2">
                                {{$inventur->user()->first()->name}}
                            </div>
                            <div class="col-span-3">
                                {{ date('d M Y - H:i:s', strtotime($inventur->created_at)) }}
                            </div>
                            <div class="col-span-3">
                                {{ date('d M Y - H:i:s', strtotime($inventur->updated_at)) }}
                            </div>
                            <div class="col-span-2">
                                {{$stati[$inventur->completed]}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Zutat')}}
                        </th>
                        @if ($type != 2)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{__('Einheit')}}
                            </th>
                        @endif
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Menge laut Warenwirtschaftssystem')}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Tatsächliche Menge')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if (count($activities) > 0)
                        @foreach ($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{$zutaten->where('id', $activity->zutat)->first()->name}}
                                    </div>
                                </td>
                                @if ($type != 2)
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{$zutaten->where('id', $activity->zutat)->first()->einheit()->first()->name}}</div>
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$activity->old_value}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$activity->new_value}}</div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Historie zu dieser Inventur vorhanden!')}}</td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
