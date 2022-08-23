@if(session('reorder'))
    <div id="reorder" class="fixed top-0 left-0 right-0 bottom-0 flex justify-center items-center bg-black bg-opacity-75">
        <div class="p-6 bg-gray-100 w-1/3">
            <svg class="w-14 h-14 mx-auto mb-4" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 512 512" xml:space="preserve">
                <g><g><path d="M501.362,383.95L320.497,51.474c-29.059-48.921-99.896-48.986-128.994,0L10.647,383.95
                c-29.706,49.989,6.259,113.291,64.482,113.291h361.736C495.039,497.241,531.068,433.99,501.362,383.95z M256,437.241
                c-16.538,0-30-13.462-30-30c0-16.538,13.462-30,30-30c16.538,0,30,13.462,30,30C286,423.779,272.538,437.241,256,437.241z
                M286,317.241c0,16.538-13.462,30-30,30c-16.538,0-30-13.462-30-30v-150c0-16.538,13.462-30,30-30c16.538,0,30,13.462,30,30
                V317.241z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
            </svg>
            <div class="font-bold text-gray-900 text-center">
                <p class="text-gray-900 mb-8">Da bei dieser Bestellung ein Problem besteht,
                    hast du hier die Möglichkeit eine Nachbestellung zu tätigen.</p>
                <p lass="text-gray-900">Möchtest du nachbestellen?</p>
            </div>
            <div class="mt-8 flex justify-between items-center">
                <x-nav-link :href="route('bestellungen.reorder', ['bestellung' => session('reorder')])" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi text-white">
                    <span class="text-white font-bold text-base">{{ __('Nachbestellen') }}</span>
                </x-nav-link>
                <a href="/bestellungen" id="close-reorder" class="cursor-pointer inline-flex items-center h-10 px-5 py-0 bg-strizzi-red text-white">
                    <span class="text-white">{{ __('Abbrechen') }}</span>
                </a>
            </div>
        </div>
    </div>
@endif
