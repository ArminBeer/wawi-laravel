<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventur;
use App\Models\Inventur_Activity;
use App\Models\Lagerort;
use App\Models\User;
use App\Models\Global_Inventurflag;
use App\Models\Zutat;
use Illuminate\Support\Facades\Auth;

/**
 * Status Roadmap:
 * $inventur->completed == 0 -> Inventur started
 * $inventur->completed == 1 -> Inventur ready for check
 * $inventur->completed == 2 -> Inventur completed
 * $inventur->completed == 3 -> Inventur aborted
 */

class InventurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        if ($type == 1)
            $lagerorte = Lagerort::where('id', '!=', 1)->orderBy('name', 'ASC')->get();
        else
            $lagerorte = Lagerort::where('id', 1)->orderBy('name', 'ASC')->get();

        $globalInventurFlag = Global_Inventurflag::where('id', $type)->first()->active;

        return view('inventur.index', array (
            'lagerorte' => $lagerorte,
            'globalInventurFlag' => $globalInventurFlag,
            'type' => $type
        ));
    }

    /**
     * Start global stocktaking action.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function startGlobal($type)
    {
        $users = User::pluck('name', 'id')->toArray();
        if ($type == 1)
            $lagerorte = Lagerort::all();
        else
            $lagerorte = Lagerort::where('id', 1)->get();

        return view('inventur.createglobal', array (
            'type' => $type,
            'users' => $users,
            'lagerorte' => $lagerorte,
        ));
    }

    /**
     * Stop global stocktaking action.
     *
     * @param  int  $type
     * @return \Illuminate\Http\Response
     */
    public function stopGlobal($type)
    {
        $inventuren = Inventur::where('completed', 0)->orWhere('completed', 1)->get();

        foreach ($inventuren as $inventur){
            $inventur->completed = 3;
            $inventur->save();
        }

        $this->deactivateStocktaking($type);
        $this->updateGlobalInventurFlag($type);

        return redirect()->route('inventuren.index', $type)->with('success', 'Globale Inventur gestoppt');
    }
    /**
     * Show the form for creating a single new resource.
     *
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createSingle($type, $id)
    {
        $users = User::pluck('name', 'id')->toArray();

        // Show Modal to ask which user should do single stocktaking
        return redirect()->route('inventuren.index', [$type])->with('type', $type)->with('createSingle', $id)->with('users', $users);

    }


    /**
     * Show the form for creating a single new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function startSingle(Request $request, $type, $id)
    {

        $inventur = new Inventur;
        $inventur->lagerort = $id;
        $inventur->user = $request->input('user');
        $inventur->completed = 0;
        $inventur->save();

        foreach (Lagerort::where('id', $id)->first()->zutaten()->get() as $zutat){
            $inventurActivity = new Inventur_Activity;
            $inventurActivity->inventur = $inventur->id;
            $inventurActivity->zutat = $zutat->id;
            $inventurActivity->old_value = $zutat->lagerbestand;
            $inventurActivity->new_value = 0;
            $inventurActivity->save();
        }

        $this->activateStocktaking($type);

        return redirect('/inventuren/' . $type)->with('success', 'Die Inventur wurde gestartet');
    }

    /**
     * Show the form for creating a single new resource.
     *
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stopSingle($type, $id)
    {
        $inventur = Inventur::where('id', $id)->first();
        $inventur->completed = 3;
        $inventur->save();

        $this->updateGlobalInventurFlag($type);

        // Man könnte hier alle zugehörigen Inventur_Activities löschen

        return redirect()->route('inventuren.index', $type)->with('success', 'Ausgewählte Inventur wurde gestoppt. Änderungen wurden nicht gespeichert');
    }

    /**
     * Display the history specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function history($id)
    {
        $lagerort = Lagerort::where('id', $id)->first();
        $inventuren = $lagerort->inventuren()->orderBy('updated_at', 'DESC')->get();
        $stati = ['beauftragt', 'durchgeführt', 'erfolgreich abgeschlossen', 'abgebrochen'];
        if ($lagerort->id == 1)
            $type = 2;
        else
            $type = 1;

        return view('inventur.history', array (
            'type' => $type,
            'lagerort' => $lagerort,
            'inventuren' => $inventuren,
            'stati' => $stati
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeGlobal(Request $request, $type)
    {
        $this->activateStocktaking($type);

        foreach ($request->input('users') as $key => $value){
            $inventur = new Inventur;
            $inventur->lagerort = $key;
            $inventur->user = $value;
            $inventur->completed = 0;
            $inventur->save();

            foreach (Lagerort::where('id', $key)->first()->zutaten()->get() as $zutat){
                $inventurActivity = new Inventur_Activity;
                $inventurActivity->inventur = $inventur->id;
                $inventurActivity->zutat = $zutat->id;
                $inventurActivity->old_value = $zutat->lagerbestand;
                $inventurActivity->new_value = 0;
                $inventurActivity->save();
            }
        }

        return redirect('/inventuren/' . $type)->with('success', 'Globale Inventur gestartet');
    }

    /**
     * Deliver Form for the actual task when Inventur is running.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkStock($id)
    {

        $inventur = Inventur::where('id', $id)->first();
        $activities = $inventur->inventurActivities()->get();

        if ($activities->first() && $activities->first()->zutat()->first()->lagerort == 1)
            $type = 2;
        else
            $type = 1;

        return view('inventur.checksingle', array (
            'activities' => $activities,
            'inventur' => $inventur,
            'type' => $type
        ));
    }

    /**
     * Update inventur activities with new values.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeTask(Request $request, $type, $id)
    {
        $inventur = Inventur::where('id', $id)->first();

        foreach ($inventur->inventurActivities()->get() as $task){
            $task->new_value = floatval(str_replace(',', '.', $request->input('new_value')[$task->id]));;
            $task->save();
        }

        $inventur->completed = 1;
        $inventur->save();

        if (auth()->user()->stocktaking_right == 1)
            return redirect('/inventuren/' . $type)->with('success', 'Inventur erfolgreich durchgeführt');
        else
            return redirect('/dashboard')->with('success', 'Inventur erfolgreich durchgeführt');
    }

    /**
     * Deliver Form for the actual task when Inventur is running.
     *
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkSingle($type, $id)
    {
        $inventur = Inventur::where('id', $id)->first();
        $activities = $inventur->inventurActivities()->get();

        return view('inventur.checksingle', array (
            'activities' => $activities,
            'inventur' => $inventur,
            'type' => $type
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeSingle(Request $request, $type, $id)
    {
        $inventur = Inventur::where('id', $id)->first();

        foreach ($inventur->inventurActivities()->get() as $task){
            $task->new_value = floatval($request->input('new_value')[$task->id]);
            $task->save();

            $zutat = $task->zutat()->first();
            $zutat->lagerbestand = floatval(str_replace(',', '.', $request->input('new_value')[$task->id]));;
            $zutat->save();
        }

        $inventur->completed = 2;
        $inventur->save();

        $this->updateGlobalInventurFlag($type);

        return redirect('/inventuren/'. $type)->with('success', 'Inventur erfolgreich abgeschlossen und Lagerbestände aktualisiert!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $type
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type, $id)
    {
        $inventur = Inventur::where('id', $id)->first();
        $activities = $inventur->inventurActivities()->get();
        $stati = ['beauftragt', 'durchgeführt', 'erfolgreich abgeschlossen', 'abgebrochen'];
        $zutaten = Zutat::withTrashed()->get();

        return view('inventur.show', array (
            'inventur' => $inventur,
            'activities' => $activities,
            'stati' => $stati,
            'zutaten' => $zutaten,
            'type' => $type,
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventur = Inventur::where('id', $id)->first();
        $lagerort = $inventur->lagerort()->first();
        $inventur->delete();

        return redirect()->route('inventuren.history', [$lagerort->id])->with('success', 'Inventuraufzeichnung gelöscht');
    }

    // Activate stocktacking mode
    public function activateStocktaking($type) {
        $globalFlag = Global_Inventurflag::where('id', $type)->first();
        $globalFlag->active = 1;
        $globalFlag->user = Auth::user()->id;
        $globalFlag->save();
    }

    // Deactivate stocktacking mode
    public function deactivateStocktaking($type) {
        $globalFlag = Global_Inventurflag::where('id', $type)->first();
        $globalFlag->active = 0;
        $globalFlag->user = Auth::user()->id;
        $globalFlag->save();
    }

    // Update global stocktaking flag
    public function updateGlobalInventurFlag($type){

        $inventuren = Inventur::all();
        $globalFlag = Global_Inventurflag::where('id', $type)->first();
        $indicator = false;

        foreach ($inventuren as $inventur){
            if ($inventur->completed == 0 || $inventur->completed == 1){
                $indicator = true;
                break;
            }
        }

        if ($indicator)
            $globalFlag->active = 1;
        else
            $globalFlag->active = 0;

        $globalFlag->save();
    }
}
