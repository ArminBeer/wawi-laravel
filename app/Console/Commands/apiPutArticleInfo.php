<?php

namespace App\Console\Commands;

use App\Traits\GastrofixArticles;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class apiPutArticleInfo extends Command
{
    use GastrofixArticles;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:putArticleInfo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds additional Info to Articles in Lightspeed';

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

        try {
            // Do trait function
            $response = $this->setArticleInfo();
        } catch (GuzzleException $e) {
            Log::emergency("Could not connect to articles API: " . $e->getMessage());
            return -1;
        }


        return 0;
    }
}
