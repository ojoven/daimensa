<?php

namespace App\Builder\Wiktionary;
use App\Lib\WordFunctions;

class WiktionaryRetriever {

    /** GET **/
    public function getWordsFromFrequencyUrls($params) {

        //$params['cache_path'] = base_path() . "/data/wiktionary/words.json";
        /**
        $params['urls'] = array(
        'http://en.wiktionary.org/wiki/Wiktionary:French_frequency_lists/1-2000',
        'http://en.wiktionary.org/wiki/Wiktionary:French_frequency_lists/2001-4000',
        'http://en.wiktionary.org/wiki/Wiktionary:French_frequency_lists/4001-6000',
        'http://en.wiktionary.org/wiki/Wiktionary:French_frequency_lists/6001-8000',
        'http://en.wiktionary.org/wiki/Wiktionary:French_frequency_lists/8001-10000'
        );
         **/

        if (!file_exists($params['cache_path'])) {

            $words = array();

            foreach ($params['urls'] as $url) {

                $html = file_get_html($url);

                // Let's go to the li's
                $table = $html->find('#mw-content-text',0);
                foreach ($table->find('li') as $li) {
                    $plaintext = $li->plaintext;
                    $exploded = explode(". ", $plaintext);
                    $word = $exploded[1];
                    array_push($words, $word);
                }

                $words = WordFunctions::parseWordsRemoveQuote($words);
                $words = WordFunctions::filterWordsByLength($words);
                $words = WordFunctions::filterWordsByUppercase($words);

            }

            file_put_contents($params['cache_path'], json_encode($words));

        } else {

            $words = json_decode(file_get_contents($params['cache_path']), true);

        }

        return $words;

    }

}
