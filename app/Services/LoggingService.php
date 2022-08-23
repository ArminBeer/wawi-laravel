<?php

namespace App\Services;
use App\Models\Log;
use App\Models\User;

class LoggingService
{
    public function saveLog($model, $type)
    {

        if($model->isDirty()){

            $logChanges = serialize('Neu erstellt');
            $changes = array();


            if (auth()->user()){
                $user = auth()->user()->id;
            }
            elseif(array_key_exists('password', $changes) && array_key_exists('remember_token', $changes)) {
                $user = $model->id;
            }
            else {
                $user = 1;
            }

            if ($type == 'updated'){

                $changes = (array_diff_assoc($model->getAttributes(), $model->getOriginal()));
                unset($changes['created_at']);
                unset($changes['updated_at']);

                if (count($changes) == 1 && array_key_exists('remember_token', $changes)){
                    return;
                }

                if (auth()->user()){
                    $logChanges = serialize($changes);
                }
                elseif(array_key_exists('password', $changes) && array_key_exists('remember_token', $changes)) {
                    $logChanges = serialize('Passwort geändert');
                }
                else {
                    $changes = array('API' => 'Lagerbestandsänderung durch Kassensystem') + $changes;
                    $logChanges = serialize($changes);
                }
            }

            if(!array_key_exists('deleted_by', $changes))
            {
                $log = new Log;
                $log->verknuepfung_id = $model->id;
                $log->verknuepfung_type = get_class($model);
                $log->changes = $logChanges;
                $log->user = $user;
                $log->save();
            }

        } else if ($type == 'delete'){
            $user = User::where('id', $model->deleted_by)->first();
            $log = new Log;
            $log->verknuepfung_id = $model->id;
            $log->verknuepfung_type = get_class($model);
            $log->changes = serialize('Gelöscht von ' . $user->name);
            $log->user = auth()->user()->id;
            $log->save();
        }
    }
}
