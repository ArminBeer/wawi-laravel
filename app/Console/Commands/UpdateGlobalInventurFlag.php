<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventur;
use App\Models\Global_Inventurflag;

class UpdateGlobalInventurFlag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'globalflag:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the global stocktaking flag';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $inventuren = Inventur::all();
        $globalFlag = Global_Inventurflag::first();
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

        return 0;
    }
}
