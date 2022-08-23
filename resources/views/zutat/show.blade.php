<x-app-layout>
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800 transition-colors duration-150 border-gray-800 border-2 rounded-lg hover:bg-gray-50 hover:text-gray-800'>{{ __('Zurück')}}</a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zutat:') }} {{ $zutat['name'] }}
        </h2>
        <div></div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="p-6 bg-white border-b border-gray-200">
                        <th>{{__('Name')}}</th>
                        <th>{{__('Lagerbestand')}}</th>
                        <th>{{__('Mindestbestand')}}</th>
                        <th>{{__('Lieferant')}}</th>
                        <th>{{__('Allergene')}}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="p-6 bg-white border-b border-gray-200">
                        <td class="d-none d-sm-table-cell">{{$zutat['name']}}</td>
                        <td class="d-none d-sm-table-cell">{{$zutat['lagerbestand']}} {{$zutat['einheit']}}</td>
                        <td class="d-none d-sm-table-cell">{{$zutat['mindestbestand']}} {{$zutat['einheit']}}</td>
                        <td class="d-none d-sm-table-cell">{{$zutat['lieferant']['name']}}</td>
                        <td class="d-none d-sm-table-cell">
                            @foreach ($zutat['allergene'] as $allergen)
                            {{ $allergen['name'] }}
                            @endforeach
                        </td>
                        <td class="d-none d-sm-table-cell"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
