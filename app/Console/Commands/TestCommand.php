<?php

namespace App\Console\Commands;

use App\Models\Words\Sustantive;
use Log;
use App\Models\Word;
use App\Models\Bunch;
use Illuminate\Console\Command;
require_once app_path() . '/Lib/Vendor/simple_html_dom.php';
require_once base_path() . '/config/settings.php';

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing models purposes';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->_test_extract_texts_from_xml();
        /**
        Log::useFiles('php://stdout', 'info');
        $frequentWords = json_decode(file_get_contents(base_path() . "/data/fr/jsons/frequentwords.json"), true);
        $keys = array_keys($frequentWords);
        $word = $keys[rand(0,count($keys))];
        echo $word . " " . $frequentWords[$word]. PHP_EOL;

        $wordModel = new Word();
        $_SESSION['fromLanguage'] = "fr";
        $_SESSION['toLanguage'] = "es";
        $info = $wordModel->getAllInfoWord($word);
        print_r($info);

        $_SESSION['fromLanguage'] = "fr";
        $_SESSION['toLanguage'] = "es";
        $bunch = new Bunch();
        $params['numCards'] = 5;
        $params['numWords'] = 2;
        $result = $bunch->getBunchCards($params);
        print_r($result);
         * **/
    }

    private function _test_extract_texts_from_xml() {

        $url = 'http://video.google.com/timedtext?lang=fr&v=COL_Ty6MWjs';
        $xml = file_get_contents($url);
        $xml = str_replace('<text',' <text', $xml); // we add spaces for the next strip tags
        $cleanWords = strip_tags($xml);

        $arrayStopWords = array(',', '.', '!', ':', ';', '(', ')', '¡', '?', '¿', '*', '|', '@', '#');
        $cleanWords = str_replace(PHP_EOL, ' ', $cleanWords);
        $cleanWords = str_replace($arrayStopWords, '', $cleanWords);
        $cleanWords = strtolower($cleanWords);

        $wordsAndFrequency = array();

        $words = explode(' ', $cleanWords);
        foreach ($words as $word) {

            $word = trim($word);

            if ($word != "") {

                if (isset($wordsAndFrequency[$word])) {
                    $wordsAndFrequency[$word] = $wordsAndFrequency[$word] + 1;
                } else {
                    $wordsAndFrequency[$word] = 1;
                }

            }

        }

        echo $cleanWords . PHP_EOL . PHP_EOL;

        // Sort the words by frequency
        arsort($wordsAndFrequency);
        print_r($wordsAndFrequency);
    }
}
