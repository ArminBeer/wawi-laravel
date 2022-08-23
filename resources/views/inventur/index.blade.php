<x-app-layout>
    @include('inventur.createsinglemodal')
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Inventuren') }}
        </div>
        @if (Auth::user()->stocktaking_right)
            @if ($globalInventurFlag != 1)
                <x-nav-link :href="route('inventuren.startglobal', ['type' => $type])" class="inline-flex items-center h-10 px-5 bg-strizzi">
                    <span class="text-white">{{ __('Globale Inventur starten') }}</span>
                    <svg class="w-4 h-4 ml-3 fill-current text-white">
                        <path d="M8 0c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM6 12v-8l6 4-6 4z"></path>
                    </svg>
                </x-nav-link>
            @else
                <x-nav-link :href="route('inventuren.stopglobal', ['type' => $type])" class="inline-flex items-center h-10 px-5 bg-strizzi-red">
                    <span class="text-white">{{ __('Globale Inventur stoppen') }}</span>
                    <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512"><path d="M256,0C114.617,0,0,114.617,0,256s114.617,256,256,256s256-114.617,256-256S397.383,0,256,0z M336,320
                        c0,8.836-7.156,16-16,16H192c-8.844,0-16-7.164-16-16V192c0-8.836,7.156-16,16-16h128c8.844,0,16,7.164,16,16V320z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g</g><g</g><g></g><g></g><g</g>
                    </svg>
                </x-nav-link>
            @endif
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 ">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{__('Lagerort')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{__('Letzte Inventur')}}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if (count($lagerorte) > 0)
                                        @foreach ($lagerorte as $lagerort)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{$lagerort->name}}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($lagerort->inventuren()->first())
                                                        <div class="text-sm text-gray-900">{{'Durchgeführt am ' . date('d M Y - H:i:s', strtotime($lagerort->inventuren()->orderBy('updated_at', 'DESC')->first()->created_at)) . ' von ' . $lagerort->inventuren()->orderBy('updated_at', 'DESC')->first()->user()->first()->name }}</div>
                                                    @else
                                                        <div class="text-sm text-gray-900">{{ __('Bisher noch keine Inventur durchgeführt')}}</div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap flex justify-end items-center">
                                                    @if ($lagerort->inventuren()->first() && $lagerort->inventuren()->orderBy('updated_at', 'DESC')->first()->completed == 0)
                                                        {{Form::open(array('route' => array( 'inventuren.stopsingle', ['type' => $type, $lagerort->inventuren()->orderBy('updated_at', 'DESC')->first()->id]), 'method' => 'POST', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie diese Inventur wirklich beenden?')"))}}
                                                            @method('PUT')
                                                            <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white transition-colors duration-150 bg-strizzi-red" >
                                                                <svg class="w-4 h-4 fill-current text-white" viewBox="0 0 512 512"><path d="M256,0C114.617,0,0,114.617,0,256s114.617,256,256,256s256-114.617,256-256S397.383,0,256,0z M336,320
                                                                    c0,8.836-7.156,16-16,16H192c-8.844,0-16-7.164-16-16V192c0-8.836,7.156-16,16-16h128c8.844,0,16,7.164,16,16V320z"/><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g</g><g</g><g></g><g></g><g</g>
                                                                </svg>
                                                            </button>
                                                        {{Form::close()}}
                                                    @elseif ($lagerort->inventuren()->first() && $lagerort->inventuren()->orderBy('updated_at', 'DESC')->first()->completed == 1)
                                                        <a href="{{ route('inventuren.checksingle', ['type' => $type, 'inventur' => $lagerort->inventuren()->orderBy('updated_at', 'DESC')->first()->id]) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-gray-800">
                                                            <svg class="w-4 h-4 fill-current text-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
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
                                                    @else
                                                        <a href="{{ route('inventuren.createsingle', ['type' => $type, 'lagerort' => $lagerort['id']]) }}" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi">
                                                            <svg class="w-4 h-4 fill-current text-white">
                                                                <path d="M8 0c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zM6 12v-8l6 4-6 4z"></path>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    <a href="{{route('inventuren.history', ['lagerort' => $lagerort['id']])}}" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-gray-800">
                                                        <svg version="1.1" id="Capa_1" class="w-4 h-4 fill-current text-white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                            viewBox="0 0 438.891 438.891" style="enable-background:new 0 0 438.891 438.891;" xml:space="preserve">
                                                        <g><g><g><path d="M347.968,57.503h-39.706V39.74c0-5.747-6.269-8.359-12.016-8.359h-30.824c-7.314-20.898-25.6-31.347-46.498-31.347
                                                            c-20.668-0.777-39.467,11.896-46.498,31.347h-30.302c-5.747,0-11.494,2.612-11.494,8.359v17.763H90.923
                                                            c-23.53,0.251-42.78,18.813-43.886,42.318v299.363c0,22.988,20.898,39.706,43.886,39.706h257.045
                                                            c22.988,0,43.886-16.718,43.886-39.706V99.822C390.748,76.316,371.498,57.754,347.968,57.503z M151.527,52.279h28.735
                                                            c5.016-0.612,9.045-4.428,9.927-9.404c3.094-13.474,14.915-23.146,28.735-23.51c13.692,0.415,25.335,10.117,28.212,23.51
                                                            c0.937,5.148,5.232,9.013,10.449,9.404h29.78v41.796H151.527V52.279z M370.956,399.185c0,11.494-11.494,18.808-22.988,18.808
                                                            H90.923c-11.494,0-22.988-7.314-22.988-18.808V99.822c1.066-11.964,10.978-21.201,22.988-21.42h39.706v26.645
                                                            c0.552,5.854,5.622,10.233,11.494,9.927h154.122c5.98,0.327,11.209-3.992,12.016-9.927V78.401h39.706
                                                            c12.009,0.22,21.922,9.456,22.988,21.42V399.185z"/><path d="M179.217,233.569c-3.919-4.131-10.425-4.364-14.629-0.522l-33.437,31.869l-14.106-14.629
                                                            c-3.919-4.131-10.425-4.363-14.629-0.522c-4.047,4.24-4.047,10.911,0,15.151l21.42,21.943c1.854,2.076,4.532,3.224,7.314,3.135
                                                            c2.756-0.039,5.385-1.166,7.314-3.135l40.751-38.661c4.04-3.706,4.31-9.986,0.603-14.025
                                                            C179.628,233.962,179.427,233.761,179.217,233.569z"/><path d="M329.16,256.034H208.997c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449H329.16
                                                            c5.771,0,10.449-4.678,10.449-10.449S334.931,256.034,329.16,256.034z"/><path d="M179.217,149.977c-3.919-4.131-10.425-4.364-14.629-0.522l-33.437,31.869l-14.106-14.629
                                                            c-3.919-4.131-10.425-4.364-14.629-0.522c-4.047,4.24-4.047,10.911,0,15.151l21.42,21.943c1.854,2.076,4.532,3.224,7.314,3.135
                                                            c2.756-0.039,5.385-1.166,7.314-3.135l40.751-38.661c4.04-3.706,4.31-9.986,0.603-14.025
                                                            C179.628,150.37,179.427,150.169,179.217,149.977z"/><path d="M329.16,172.442H208.997c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449H329.16
                                                            c5.771,0,10.449-4.678,10.449-10.449S334.931,172.442,329.16,172.442z"/><path d="M179.217,317.16c-3.919-4.131-10.425-4.363-14.629-0.522l-33.437,31.869l-14.106-14.629
                                                            c-3.919-4.131-10.425-4.363-14.629-0.522c-4.047,4.24-4.047,10.911,0,15.151l21.42,21.943c1.854,2.076,4.532,3.224,7.314,3.135
                                                            c2.756-0.039,5.385-1.166,7.314-3.135l40.751-38.661c4.04-3.706,4.31-9.986,0.603-14.025
                                                            C179.628,317.554,179.427,317.353,179.217,317.16z"/><path d="M329.16,339.626H208.997c-5.771,0-10.449,4.678-10.449,10.449s4.678,10.449,10.449,10.449H329.16
                                                            c5.771,0,10.449-4.678,10.449-10.449S334.931,339.626,329.16,339.626z"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <td class="px-6 py-4 whitespace-nowrap">{{__('Keine Lagerorte vorhanden!')}}</td>
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
