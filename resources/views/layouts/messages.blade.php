@if (count($errors) >0)
    <div id="messagebox">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="bg-white overflow-hidden shadow-sm">
                @foreach($errors->all() as $error)
                    <div class="p-6 bg-gray-800 absolute top-0 right-0 w-1/3 shadow-md animate-bounce">
                        <div class="font-bold text-white text-center">
                            {{$error}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div id="messagebox">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="bg-white overflow-hidden ">
                <div class="p-6 bg-strizzi absolute top-0 right-0 w-1/3 shadow-md animate-bounce">
                    <div class="font-bold text-white text-center">
                        {{session('success')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div id="messagebox">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 relative">
            <div class="bg-white overflow-hidden shadow-sm ">
                <div class="p-6 bg-strizzi-red absolute top-0 right-0 w-1/3 shadow-md animate-bounce">
                    <div class="font-bold text-white text-center">
                        {{session('error')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
