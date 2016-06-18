<?php

namespace App\Models\Google;

class NGram {

    /** GOOGLE N-GRAM ONTOLOGY **/
// Retrieve
    function getWordsNgram($ngram) {

        $path = base_path() . "/data/" . LANGUAGE . "/n-grams/final/" . $ngram . "gram/words.json";
        if (file_exists($path)) {
            $words = json_decode(file_get_contents($path),true);
        } else {
            $words = $this->mergeNgrams($ngram);
        }

        // Let's sort by frequency
        arsort($words);

        return $words;
    }

    function mergeNgrams($ngram) {

        $words = array();
        $pathPartials = base_path() . "/data/" . LANGUAGE . "/n-grams/partials/" . $ngram . "gram/";
        $pathFinal = base_path() . "/data/" . LANGUAGE . "/n-grams/final/" . $ngram . "gram/words.json";

        $dir = new DirectoryIterator($pathPartials);
        foreach ($dir as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $fileName = $fileInfo->getFilename();
                $words = array_merge($words, json_decode(file_get_contents($pathPartials . "/" . $fileName), true));
            }
        }

        file_put_contents($pathFinal, json_encode($words));

        return $words;

    }


}