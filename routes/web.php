<?php

use App\Models\Einheit;
use App\Models\Zutat;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', 'DashboardController@index')->middleware(['auth', 'redirectSpecialUser'])->name('dashboard');


require __DIR__.'/auth.php';

// Custom Routes
Route::group(['middleware' => ['auth']], function () {

    // User Routes
    Route::resource('user', UserController::class)->middleware('permission:staff_right');

    // Zutaten Routes
    Route::resource('zutaten', ZutatController::class, ['except' => ['index', 'show']])->middleware(['inventurFlag:1', 'permission:stocktaking_right']);
    Route::resource('zutaten', ZutatController::class, ['only' => ['index', 'show']])->middleware('permission:warehouse_right');
    Route::get('/zutaten/add/{zutaten}', 'ZutatController@add')->middleware(['inventurFlag:1', 'permission:stocktaking_right'])->name('zutaten.add');
    Route::put('/zutaten/addstore/{zutaten}', 'ZutatController@addstore')->middleware(['inventurFlag:1', 'permission:stocktaking_right'])->name('zutaten.addstore');

    // Lieferanten Routes
    Route::resource('lieferanten', LieferantController::class)->middleware('permission:warehouse_right');

    //Naehrwerte Routes
    Route::resource('naehrwerte', NaehrwertController::class)->middleware('permission:warehouse_right');

    // Allergene Routes
    Route::resource('allergene', AllergenController::class)->middleware('permission:warehouse_right');

    // Rezepte Routes
    Route::resource('rezepte', RezeptController::class, ['except' => ['index', 'show', 'create', 'store']])->middleware(['inventurFlag:1', 'permission:kitchen_edit_right']);
    Route::resource('rezepte', RezeptController::class, ['only' => ['show']])->middleware('permission:kitchen_watch_right');
    Route::get('{type}/rezepte', 'RezeptController@index')->middleware('permission:kitchen_watch_right')->name('rezepte.index');
    Route::get('{type}/rezepte/create', 'RezeptController@create')->middleware(['inventurFlag:1', 'permission:kitchen_edit_right'])->name('rezepte.create');
    Route::put('{type}/rezepte/store', 'RezeptController@store')->middleware(['inventurFlag:1', 'permission:kitchen_edit_right'])->name('rezepte.store');
    Route::get('/rezepte/order/{rezepte}', 'RezeptController@order')->middleware(['inventurFlag:1', 'permission:kitchen_watch_right'])->name('rezepte.order');

    // Produkte Routes
    Route::resource('produkte', ProduktController::class, ['except' => ['index', 'show', 'create', 'store']])->middleware(['inventurFlag:1', 'permission:kitchen_edit_right']);
    Route::resource('produkte', ProduktController::class, ['only' => ['show']])->middleware('permission:kitchen_watch_right');
    Route::get('{type}/produkte', 'ProduktController@index')->middleware('permission:kitchen_watch_right')->name('produkte.index');
    Route::get('{type}/produkte/create', 'ProduktController@create')->middleware(['inventurFlag:1', 'permission:kitchen_edit_right'])->name('produkte.create');
    Route::put('{type}/produkte/store', 'ProduktController@store')->middleware(['inventurFlag:1', 'permission:kitchen_edit_right'])->name('produkte.store');
    Route::get('/produkte/{produkte}/quantity', 'ProduktController@quantity')->middleware(['inventurFlag:1', 'permission:kitchen_watch_right'])->name('produkte.quantity');
    Route::post('/produkte/{produkte}/craft', 'ProduktController@craft')->middleware(['inventurFlag:1', 'permission:kitchen_watch_right'])->name('produkte.craft');

    // Bestellungen Routes
    Route::get('/bestellungen/neu', 'BestellungController@new')->middleware('permission:order_right')->name('bestellungen.new');
    Route::get('/bestellungen/{lieferant}/create', 'BestellungController@create')->middleware('permission:order_right')->name('bestellungen.add');
    Route::get('/bestellungen/{bestellung}/history', 'BestellungController@history')->middleware('permission:order_right')->name('bestellungen.history');
    Route::get('/bestellungen/{bestellung}/confirm', 'BestellungController@confirm')->middleware(['permission:order_right', 'order.triggered'])->name('bestellungen.confirm');
    Route::put('/bestellungen/{bestellung}/sendsave', 'BestellungController@sendsave')->middleware(['permission:order_right', 'order.triggered'])->name('bestellungen.sendsave');
    Route::get('/bestellungen/{bestellung}/reorder', 'BestellungController@reorder')->middleware('permission:order_right')->name('bestellungen.reorder');
    Route::get('/bestellungen/{bestellung}/showAccept', 'BestellungController@showAccept')->middleware('permission:order_right')->name('bestellungen.showAccept');
    Route::put('/bestellungen/{bestellung}/accept', 'BestellungController@accept')->middleware('permission:order_right')->name('bestellungen.accept');
    Route::get('/bestellungen/{bestellung}/partialdelivery', 'BestellungController@partialDelivery')->middleware('permission:warehouse_right')->name('bestellungen.partialdelivery');
    Route::resource('bestellungen', BestellungController::class, ['except' => ['edit']])->middleware('permission:order_right');
    Route::get('/bestellungen/{bestellung}/edit', 'BestellungController@edit')->middleware('order.triggered')->name('bestellungen.triggered');

    // Anlieferungen Routes
    Route::get('/anlieferungen/{bestellung}/confirm', 'AnlieferungController@confirm')->middleware(['inventurFlag:1', 'permission:warehouse_right'])->name('anlieferungen.confirm');
    Route::resource('anlieferungen', AnlieferungController::class)->except(['index'])->middleware(['inventurFlag:1', 'permission:warehouse_right']);
    Route::resource('anlieferungen', AnlieferungController::class)->only(['index'])->middleware('permission:warehouse_right');
    // Einheiten Routes
    Route::post('/einheiten/storeUmrechnung', 'EinheitController@storeUmrechnung')->middleware('permission:warehouse_right')->name('einheiten.storeUmrechnung');
    Route::delete('/einheiten/{umrechnung}/destroy', 'EinheitController@destroyUmrechnung')->middleware('permission:warehouse_right')->name('einheiten.destroyUmrechnung');
    Route::resource('einheiten', EinheitController::class)->middleware('permission:warehouse_right');

    // Ajax Api Get Einheiten Route
    Route::get('/einheiten/{zutat}/get','ApiEinheitenController@index')->name('einheiten.get');
    Route::get('/einheiten/{einheit}/check','ApiEinheitenController@checkConversion')->name('einheiten.check');

    // Lagerorte Routes
    Route::resource('lagerorte', LagerortController::class)->middleware('permission:warehouse_right');

    // Inventuren Routes
    Route::get('/produkte/{type}/{lagerort}/createsingle', 'InventurController@createSingle')->middleware('permission:stocktaking_right')->name('inventuren.createsingle');
    Route::put('inventuren/{type}/{inventur}/startsingle', 'InventurController@startSingle')->middleware('permission:stocktaking_right')->name('inventuren.startsingle');
    Route::put('inventuren/{type}/{inventur}/stopsingle', 'InventurController@stopSingle')->middleware('permission:stocktaking_right')->name('inventuren.stopsingle');
    Route::get('/inventuren/{type}/startglobal', 'InventurController@startGlobal')->middleware('permission:stocktaking_right')->name('inventuren.startglobal');
    Route::get('/inventuren/{type}/stopglobal', 'InventurController@stopGlobal')->middleware('permission:stocktaking_right')->name('inventuren.stopglobal');
    Route::post('/inventuren/{type}/storeglobal', 'InventurController@storeGlobal')->middleware('permission:stocktaking_right')->name('inventuren.storeglobal');
    Route::get('/inventuren/{type}/{inventur}/check', 'InventurController@checkSingle')->middleware('permission:stocktaking_right')->name('inventuren.checksingle');
    Route::get('/inventuren/{inventur}/checkstock', 'InventurController@checkStock')->middleware('permission:warehouse_right')->name('inventuren.checkStock');
    Route::put('/inventuren/{type}/{inventur}/storeTask', 'InventurController@storeTask')->middleware('permission:warehouse_right')->name('inventuren.storeTask');
    Route::put('/inventuren/{type}/{inventur}/storesingle', 'InventurController@storeSingle')->middleware('permission:stocktaking_right')->name('inventuren.storesingle');
    Route::get('/inventuren/{lagerort}/history', 'InventurController@history')->middleware('permission:stocktaking_right')->name('inventuren.history');
    Route::get('/inventuren/{type}', 'InventurController@index')->middleware('permission:stocktaking_right')->name('inventuren.index');
    Route::get('inventuren/{type}/{inventuren}/details', 'InventurController@show')->middleware('permission:stocktaking_right')->name('inventuren.show');
    Route::resource('inventuren', InventurController::class)->only('destroy')->middleware('permission:stocktaking_right');

    // Log Routes
    Route::resource('logs', LogController::class)->only(['index'])->middleware('permission:staff_right');

    // Kategorie Routes
    Route::resource('kategorien', KategorieController::class)->middleware('permission:warehouse_right');
    Route::post('/kategorien/storeTag', 'KategorieController@storeTag')->middleware('permission:warehouse_right')->name('kategorien.storeTag');
    Route::delete('/kategorien/{tag}/destroy', 'KategorieController@destroyTag')->middleware('permission:warehouse_right')->name('kategorien.destroyTag');

    // Inventar Routes
    Route::get('/inventare/add/{inventare}', 'InventarController@add')->middleware(['inventurFlag:2','permission:stocktaking_right'])->name('inventare.add');
    Route::put('/inventare/addstore/{inventare}', 'InventarController@addstore')->middleware(['inventurFlag:2','permission:stocktaking_right'])->name('inventare.addstore');
    Route::resource('inventare', InventarController::class, ['except' => ['index', 'show']])->middleware(['inventurFlag:2','permission:warehouse_right']);
    Route::resource('inventare', InventarController::class, ['only' => ['index', 'show']])->middleware('permission:warehouse_right');

    Route::resource('kassenOrders', KassenOrderController::class, ['only' => ['index', 'show']])->middleware('permission:warehouse_right');
    Route::post('/kassenOrders/sync/{$periodId}', 'KassenOrderController@sync')->middleware('permission:warehouse_right')->name('kassenOrder.sync');


    // Tagesbar Routes
    Route::get('/tagesbar', 'TagesbarController@index')->middleware('permission:staff_right')->name('tagesbar.index');
    Route::get('/tagesbar/counter', 'TagesbarController@counter')->name('tagesbar.counter');
    Route::get('/tagesbar/set/{type}/{amount}/{price}', 'TagesbarController@setItem')->name('tagesbar.setItem');
});

// Custom Auth Routes
Route::put('/user/{user}/{token}', 'UserController@resetPassword')->middleware(['auth', 'permission:staff_right'])->name('user.resetPassword');
