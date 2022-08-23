<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mitarbeiter') }}
        </div>
        <x-nav-link :href="route('user.create')" class="inline-flex items-center h-10 px-5 bg-strizzi">
            <span class="text-white">{{ __('Neuen Mitarbeiter hinzufügen') }}</span>
            <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
        </x-nav-link>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Name')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('E-Mail-Adresse')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Personal verwalten')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Küche Einsehen')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Küche verwalten')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Lager verwalten')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Inventur verwalten')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                {{__('Bestellungen verwalten')}}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @if (count($users) > 0)
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{$user['name']}}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{$user['email']}}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            @if ($user['staff_right'])
                                                                <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            @if ($user['kitchen_watch_right'])
                                                                <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            @if ($user['kitchen_edit_right'])
                                                                <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            @if ($user['warehouse_right'])
                                                                <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            @if ($user['stocktaking_right'])
                                                                <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            @if ($user['order_right'])
                                                                <svg class="w-4 h-4 ml-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 408.576 408.576"><path fill="#006d39" d="M204.288 0C91.648 0 0 91.648 0 204.288s91.648 204.288 204.288 204.288 204.288-91.648 204.288-204.288S316.928 0 204.288 0zm114.176 150.528l-130.56 129.536c-7.68 7.68-19.968 8.192-28.16.512L90.624 217.6c-8.192-7.68-8.704-20.48-1.536-28.672 7.68-8.192 20.48-8.704 28.672-1.024l54.784 50.176L289.28 121.344c8.192-8.192 20.992-8.192 29.184 0s8.192 20.992 0 29.184z"/></svg>
                                                            @else
                                                                <svg class="w-4 h-4 ml-3" id="Capa_1" enable-background="new 0 0 515.556 515.556" height="512" viewBox="0 0 515.556 515.556" width="512" xmlns="http://www.w3.org/2000/svg"><path fill="#b80015" d="m257.778 0c-142.137 0-257.778 115.641-257.778 257.778s115.641 257.778 257.778 257.778 257.778-115.641 257.778-257.778-115.642-257.778-257.778-257.778zm113.926 326.141-45.564 45.564-68.362-68.362-68.362 68.362-45.564-45.564 68.362-68.362-68.362-68.362 45.564-45.564 68.362 68.362 68.362-68.362 45.564 45.564-68.362 68.362s68.362 68.362 68.362 68.362z"/></svg>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap flex justify-center items-center">
                                                        {!! Form::open(['action' => ['UserController@resetPassword', $user['id'], csrf_token()], 'method' => 'POST']) !!}
                                                            @method('PUT')
                                                            <input type="hidden" id="email" name="email" value="{{$user['email']}}">
                                                            <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi" >
                                                                <svg class=" w-4 h-4 fill-current text-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="m13.75 7h-.75v-2c0-2.757-2.243-5-5-5s-5 2.243-5 5v2h-.75c-1.24 0-2.25 1.01-2.25 2.25v8.5c0 1.24 1.01 2.25 2.25 2.25h9.8c.1-.57.39-1.08.79-1.48-.66-.9-.8-2.14-.23-3.19.77-1.43 1.97-2.53 3.39-3.17v-2.91c0-1.24-1.01-2.25-2.25-2.25zm-8.75-2c0-1.654 1.346-3 3-3s3 1.346 3 3v2h-6z"/><path d="m23.226 19.88c-.486-.262-1.092-.082-1.355.403-.574 1.059-1.674 1.717-2.871 1.717-.611 0-1.19-.185-1.696-.494l.476-.476c.214-.214.279-.537.163-.817s-.39-.463-.693-.463h-2.5c-.414 0-.75.336-.75.75v2.5c0 .303.183.577.463.693.093.039.19.057.287.057.195 0 .387-.076.53-.22l.573-.573c.899.671 1.998 1.043 3.147 1.043 1.932 0 3.706-1.059 4.629-2.764.263-.486.083-1.092-.403-1.356z"/><path d="m23.537 13.807c-.28-.116-.603-.052-.817.163l-.573.573c-.899-.671-1.998-1.043-3.147-1.043-1.936 0-3.71 1.064-4.631 2.776-.261.487-.079 1.093.407 1.354.151.081.313.119.473.119.356 0 .701-.191.882-.526.571-1.063 1.671-1.723 2.869-1.723.611 0 1.19.185 1.696.494l-.476.476c-.214.214-.279.537-.163.817s.39.463.693.463h2.5c.414 0 .75-.336.75-.75v-2.5c0-.303-.183-.577-.463-.693z"/></svg>
                                                            </button>
                                                        {{Form::close()}}
                                                        <x-nav-link :href="route('user.edit', ['user' => $user['id']])" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-gray-800">
                                                            <svg class=" w-4 h-4 fill-current text-white" viewBox="0 0 512 511" xmlns="http://www.w3.org/2000/svg"><path d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/><path d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/><path d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/></svg>
                                                        </x-nav-link>
                                                        {{Form::open(array('route' => array( 'user.destroy', $user['id'] ), 'method' => 'delete', 'style' => 'display:inline', 'onsubmit' => "return confirm('Möchten Sie diesen Mitarbeiter wirklich löschen?')"))}}
                                                        <button type="submit" class="inline-flex items-center h-10 px-5 mx-1 text-white bg-strizzi-red" >
                                                            <svg class="w-4 h-4 fill-current text-white" id="Layer_1" enable-background="new 0 0 512 512" height="512" viewBox="0 0 512 512" width="512" xmlns="http://www.w3.org/2000/svg"><g><path d="m424 64h-88v-16c0-26.51-21.49-48-48-48h-64c-26.51 0-48 21.49-48 48v16h-88c-22.091 0-40 17.909-40 40v32c0 8.837 7.163 16 16 16h384c8.837 0 16-7.163 16-16v-32c0-22.091-17.909-40-40-40zm-216-16c0-8.82 7.18-16 16-16h64c8.82 0 16 7.18 16 16v16h-96z"/><path d="m78.364 184c-2.855 0-5.13 2.386-4.994 5.238l13.2 277.042c1.22 25.64 22.28 45.72 47.94 45.72h242.98c25.66 0 46.72-20.08 47.94-45.72l13.2-277.042c.136-2.852-2.139-5.238-4.994-5.238zm241.636 40c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16zm-80 0c0-8.84 7.16-16 16-16s16 7.16 16 16v208c0 8.84-7.16 16-16 16s-16-7.16-16-16z"/></g></svg>
                                                        </button>
                                                        {{Form::close()}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">{{__('Kein Mitarbeiter vorhanden!')}}</td>
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
    </div>
</x-app-layout>
