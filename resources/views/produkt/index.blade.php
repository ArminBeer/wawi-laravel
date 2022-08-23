<x-app-layout>
    @include('produkt.quantitymodal')
    <x-slot name="header">
        <a href="{{ URL::previous() }}" class='h-10 px-5 flex justify-center items-center text-white bg-gray-800'>{{ __('Zurück')}}</a>
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($type == 1)
                {{ __('Mise en Place') }}
            @elseif ($type == 2)
                {{ __('Bar Mise en Place') }}
            @elseif ($type == 3)
                {{ __('Eis Mise en Place') }}
            @else
                {{ __('Alle Mise en Place') }}
            @endif
        </div>
        @if(Auth::user()->kitchen_edit_right)
            <x-nav-link :href="route('produkte.create', ['type' => $type])" class="inline-flex items-center h-10 px-5 bg-strizzi">
                <span class="text-white">{{ __('Hinzufügen') }}</span>
                <svg class="w-4 h-4 ml-3 fill-current text-white" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm112 277.332031h-90.667969v90.667969c0 11.777344-9.554687 21.332031-21.332031 21.332031s-21.332031-9.554687-21.332031-21.332031v-90.667969h-90.667969c-11.777344 0-21.332031-9.554687-21.332031-21.332031s9.554687-21.332031 21.332031-21.332031h90.667969v-90.667969c0-11.777344 9.554687-21.332031 21.332031-21.332031s21.332031 9.554687 21.332031 21.332031v90.667969h90.667969c11.777344 0 21.332031 9.554687 21.332031 21.332031s-9.554687 21.332031-21.332031 21.332031zm0 0"/></svg>
            </x-nav-link>
        @else
            <div></div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col justify-center w-1/3 mb-4 ml-3">
                {{__('Suche')}}
                {{Form::text('search', null, ['class' => 'search-input w-full h-12 px-4 mb-2 text-lg text-gray-700 placeholder-gray-600 border  focus:shadow-outline'])}}
            </div>
            <div class="flex">
                <div class="wun-card-wrapper flex flex-wrap">
                    @if (count($produkte) > 0)
                        @foreach ($produkte as $produkt)
                            <div class="wun-card">
                                <a class="wun-card-link" href="{{ route('produkte.show', ['produkte' => $produkt['id']]) }}">
                                    @if ($produkt['picture'] != null)
                                        <div class="wun-card-image" style="background-image:url(/storage{{ $produkt['picture'] }})" loading="lazy"></div>
                                    @else
                                        <div class="wun-card-image" style="background-image:url('/img/fumy.gif')" loading="lazy"></div>
                                    @endif
                                    <div class="wun-card-text">
                                        <p>{{$produkt['name']}}</p>
                                    </div>
                                </a>
                                <div class="wun-card-buttons">
                                    <a href="{{ route('produkte.quantity', ['produkte' => $produkt['id']]) }}" class="wun-card-order">
                                        <span class="text-white">{{ __('Herstellen') }}</span>
                                        <svg version="1.1" class=" w-4 h-4 ml-3 fill-current text-white" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><g><path d="M458.732,422.212l-22.862-288.109c-1.419-18.563-17.124-33.098-35.737-33.098h-45.164v66.917
                                                c0,8.287-6.708,14.995-14.995,14.995c-8.277,0-14.995-6.708-14.995-14.995v-66.917H187.028v66.917
                                                c0,8.287-6.718,14.995-14.995,14.995c-8.287,0-14.995-6.708-14.995-14.995v-66.917h-45.164c-18.613,0-34.318,14.535-35.737,33.058
                                                L53.265,422.252c-1.769,23.082,6.238,46.054,21.962,63.028C90.952,502.253,113.244,512,136.386,512h239.236
                                                c23.142,0,45.434-9.747,61.159-26.721C452.505,468.305,460.512,445.333,458.732,422.212z M323.56,275.493l-77.553,77.553
                                                c-2.929,2.929-6.768,4.398-10.606,4.398c-3.839,0-7.677-1.469-10.606-4.398l-36.347-36.347c-5.858-5.858-5.858-15.345,0-21.203
                                                c5.858-5.858,15.355-5.858,21.203,0l25.751,25.741l66.956-66.956c5.848-5.848,15.345-5.848,21.203,0
                                                C329.418,260.139,329.418,269.635,323.56,275.493z"/></g></g><g><g><path d="M256.004,0c-54.571,0-98.965,44.404-98.965,98.975v2.029h29.99v-2.029c0-38.037,30.939-68.986,68.976-68.986
                                                s68.976,30.949,68.976,68.986v2.029h29.989v-2.029C354.969,44.404,310.575,0,256.004,0z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="wun-card">{{__('Kein Rezept vorhanden!')}}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@push('js_after')
    <script src="/js/search.title.js"></script>
@endpush
</x-app-layout>
