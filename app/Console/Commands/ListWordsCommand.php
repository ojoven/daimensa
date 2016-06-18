<?php

namespace App\Console\Commands;

use App\Models\Words\Sustantive;
use Log;
use App\Models\Word;
use App\Models\Bunch;
use Illuminate\Console\Command;
require_once base_path() . '/config/settings.php';

class ListWordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'listwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listing words';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //$json = file_get_contents(base_path() . "/data/fr/forms/wordsAndForms.json");
        $json = file_get_contents(base_path() . "/data/fr/n-grams/final/1gram/words.json");
        //$json = file_get_contents(base_path() . "/data/fr/ontology/final/words.json");
        $words = json_decode($json, true);

        echo count($words) . PHP_EOL;

        echo substr($json, 0, 300) . PHP_EOL;


        $count = 1;
        foreach ($words as $word => $frequency) {
            //echo $count . ': ' . $word . PHP_EOL;
            echo $count . ': ' . $word . ' -> ' . $frequency . PHP_EOL;
            $count++;
            if ($count==50) break;
        }
    }
}
