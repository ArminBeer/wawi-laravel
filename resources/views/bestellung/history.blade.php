<x-app-layout>
    <x-slot name="header">
        @include('bestellung.acceptordermodal')
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historie der Bestellung mit Bestellnummer ') . $bestellung->id }}
        </h2>
        @if ($bestellung->latestActivity()->status == "Problem")
            <div class="flex items-center px-2">
                <a href="{{ route('bestellungen.showAccept', ['bestellung' => $bestellung->id]) }}" class="cursor-pointer wun-card-order" id="orderAccept">
                    <span class="text-white">{{ __('Akzeptieren') }}</span>
                    <svg class="w-4 h-4 fill-current text-white ml-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        viewBox="0 0 474.8 474.801" style="enable-background:new 0 0 474.8 474.801;"
                        xml:space="preserve"><g><g><path d="M396.283,257.097c-1.14-0.575-2.282-0.862-3.433-0.862c-2.478,0-4.661,0.951-6.563,2.857l-18.274,18.271
                                c-1.708,1.715-2.566,3.806-2.566,6.283v72.513c0,12.565-4.463,23.314-13.415,32.264c-8.945,8.945-19.701,13.418-32.264,13.418
                                H82.226c-12.564,0-23.319-4.473-32.264-13.418c-8.947-8.949-13.418-19.698-13.418-32.264V118.622
                                c0-12.562,4.471-23.316,13.418-32.264c8.945-8.946,19.7-13.418,32.264-13.418H319.77c4.188,0,8.47,0.571,12.847,1.714
                                c1.143,0.378,1.999,0.571,2.563,0.571c2.478,0,4.668-0.949,6.57-2.852l13.99-13.99c2.282-2.281,3.142-5.043,2.566-8.276
                                c-0.571-3.046-2.286-5.236-5.141-6.567c-10.272-4.752-21.412-7.139-33.403-7.139H82.226c-22.65,0-42.018,8.042-58.102,24.126
                                C8.042,76.613,0,95.978,0,118.629v237.543c0,22.647,8.042,42.014,24.125,58.098c16.084,16.088,35.452,24.13,58.102,24.13h237.541
                                c22.647,0,42.017-8.042,58.101-24.13c16.085-16.084,24.134-35.45,24.134-58.098v-90.797
                                C402.001,261.381,400.088,258.623,396.283,257.097z"/><path d="M467.95,93.216l-31.409-31.409c-4.568-4.567-9.996-6.851-16.279-6.851c-6.275,0-11.707,2.284-16.271,6.851
                                L219.265,246.532l-75.084-75.089c-4.569-4.57-9.995-6.851-16.274-6.851c-6.28,0-11.704,2.281-16.274,6.851l-31.405,31.405
                                c-4.568,4.568-6.854,9.994-6.854,16.277c0,6.28,2.286,11.704,6.854,16.274l122.767,122.767c4.569,4.571,9.995,6.851,16.274,6.851
                                c6.279,0,11.704-2.279,16.274-6.851l232.404-232.403c4.565-4.567,6.854-9.994,6.854-16.274S472.518,97.783,467.95,93.216z"/>
                        </g></g><g></g><g></g><g></g><g></<g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                    </svg>
                </a>
                <a href="{{ route('bestellungen.partialdelivery', ['bestellung' => $bestellung->id]) }}" class="ml-2 inline-flex items-center h-10 px-5 text-white bg-gray-800">
                    <span>{{ __('Teillieferung') }}</span>
                    <svg class=" w-4 h-4 ml-3 fill-current" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                </a>
                <a href="{{ route('bestellungen.reorder', ['bestellung' => $bestellung->id]) }}" class="ml-2 inline-flex items-center h-10 px-5 text-white bg-gray-800">
                    <span class="text-white">{{ __('Nachbestellen') }}</span>
                    <svg class=" w-4 h-4 ml-3 fill-current" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                </a>
            </div>
            @elseif ($bestellung->latestActivity()->status == "bestellt" || $bestellung->latestActivity()->status == "Teillieferung")
                <a href="{{ route('anlieferungen.confirm', ['bestellung' => $bestellung['id']]) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi">
                    <span>{{ __('Waren annehmen') }}</span>
                    <svg class="ml-2 w-4 h-4 fill-current text-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m23.685 8.139-11.25-8c-.26-.185-.609-.185-.869 0l-11.25 8c-.198.14-.316.368-.316.611v3.5c0 .281.157.538.406.667.25.128.549.107.778-.055l.816-.581v10.719c0 .552.448 1 1 1h2v-12h14v12h2c.552 0 1-.448 1-1v-10.719l.815.58c.13.092.282.139.435.139.118 0 .235-.028.344-.083.249-.129.406-.386.406-.667v-3.5c0-.243-.118-.471-.315-.611z"/><path d="m6.5 21.5h11v2.5h-11z"/><path d="m6.5 17.5h11v2.5h-11z"/><path d="m6.5 13.5h11v2.5h-11z"/></svg>
                </a>
        @endif
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col mb-5">
                <div class="text-xl font-bold mb-5">
                    {{ __('Allgemeine Bestellinfo') }}
                </div>
                <div class="table-row-group p-5 bg-white">
                    <div class="grid grid-cols-12 gap-4 pb-2">
                        <div class="col-span-2">
                            {{Form::label('', 'Bestellnummer', ['class' => 'font-bold'])}}
                        </div>
                        <div class="col-span-3">
                            {{Form::label('', 'Lieferant', ['class' => 'font-bold'])}}
                        </div>
                        <div class="col-span-2">
                            {{Form::label('', 'Aktueller Status', ['class' => 'font-bold'])}}
                        </div>
                        <div class="col-span-3">
                            {{Form::label('', 'Aktueller Lieferinhalt/Bestellinhalt', ['class' => 'font-bold'])}}
                        </div>
                        <div class="col-span-2">
                            {{Form::label('', 'Letzte Änderung', ['class' => 'font-bold'])}}
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-2">
                            {{$bestellung->id}}
                        </div>
                        <div class="col-span-3">
                            {{$bestellung->lieferant()->first()->name}}
                        </div>
                        <div class="col-span-2">
                            {{$latestActivity->status}}
                        </div>
                        <div class="col-span-3 flex flex-col justify-start items-start">
                            @foreach ($bestellung->zutaten()->with('einheit')->get()->toArray() as $zutat)
                                <div>
                                    {{$zutat['name'] . ' ' . ($zutat['pivot']['liefermenge'] ? $zutat['pivot']['liefermenge'] : $zutat['pivot']['bestellmenge']) . ' ' . $zutat['einheit']['name']}}
                                </div>
                            @endforeach
                        </div>
                        <div class="col-span-2">
                            {!! nl2br($latestActivity['changes']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Zeitpunkt der Änderung')}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Status')}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Durchgeführt von')}}
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{__('Änderungen')}}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                        $i = 1;
                        $len = count($activities);
                    ?>
                    @if ($len > 0)
                        @foreach ($activities as $activity)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{date('d M Y - H:i:s', strtotime($activity->created_at))}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$activity->status}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{$activity->user()->withTrashed()->first()->name}}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 flex flex-col justify-start items-start">
                                        @if ($i == 1 && $bestellung->childOrParent() == 'child')
                                            <a href="/bestellungen/{{$bestellung->parent()->first()->id}}/history" class="mb-2 cursor-pointer inline-flex items-center h-10 px-5 py-0 transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-600">
                                                <span class="text-white">{{ __('Zur Hauptbestellung') }}</span>
                                            </a>
                                        @elseif ($i == $len && $bestellung->childOrParent() == 'parent')
                                            <a href="/bestellungen/{{$bestellung->child_id}}/history" class="mb-2 cursor-pointer inline-flex items-center h-10 px-5 py-0 transition-colors duration-150 bg-green-500 rounded-lg focus:shadow-outline hover:bg-green-600">
                                                <span class="text-white">{{ __('Zur Nachbestellung') }}</span>
                                            </a>
                                        @endif
                                        {!! nl2br($activity['changes']) !!}
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    @else
                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Historie zu dieser Bestellung vorhanden!')}}</td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                        <td class="px-6 py-4 whitespace-nowrap"></td>
                    @endif
                </tbody>
            </table>
            @if($bestellung->lagernotiz)
                <div class="bg-gray-50 mt-4 flex flex-col justify-start items-start px-6 py-4">
                    <p class="mb-4 font-bold">Lagernotiz</p>
                    <p class="px-6 py-4 bg-white w-full border">{{$bestellung->lagernotiz}}</p>
                </div>
            @endif
            @if($bestellung->endnotiz)
                <div class="bg-gray-50 mt-4 flex flex-col justify-start items-start px-6 py-4">
                    <p class="mb-4 font-bold">Notiz zur Akzeptierung</p>
                    <p class="px-6 py-4 bg-white w-full border">{{$bestellung->endnotiz}}</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
