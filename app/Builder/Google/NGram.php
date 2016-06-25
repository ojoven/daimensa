<?php

namespace App\Builder\Google;

use App\Builder\FileManager;
use App\Builder\SimpleHtmlDom;
use Log;

class NGram {

    /** GOOGLE N-GRAM ONTOLOGY **/

    // Download and parse the NGrams
    function saveNGrams($ngram) {

        $pathNGramsFiles = base_path() . '/data/' . LANGUAGE . '/n-grams/files/';
        $pathNGramsHTML = base_path() . '/data/' . LANGUAGE . '/n-grams/htmls/' . $ngram . 'gram.html';
        if (!file_exists($pathNGramsHTML)) {
            Log::info('/data/' . LANGUAGE . '/n-grams/htmls/' . $ngram . 'gram.html file is missing');
            die();
        }

        $content = file_get_contents($pathNGramsHTML);

        $html = SimpleHtmlDom::str_get_html($content);
        if ($html) {

            // Let's go link by link retrieving the files and parsing the info downloaded
            foreach ($html->find('a') as $link) {

                // Vars and paths
                $char = $link->plaintext;
                $pathCompressed = $pathNGramsFiles . 'compressed/' . $char . '.gz';
                $pathUnCompressed = $pathNGramsFiles . 'uncompressed/' . $char . '.csv';

                Log::info('Retrieving file for ' . $char);

                // If the files are not downloaded
                if (!file_exists($pathUnCompressed)) {

                    if (!file_exists($pathCompressed)) {

                        // We get the compressed file from Google
                        $contentGz = file_get_contents($link->href);

                        // We save it to our system
                        FileManager::saveFile($pathCompressed, $contentGz);
                    }

                    // We uncompress it
                    FileManager::uncompressFile($pathCompressed, $pathUnCompressed);
                }

            }
        }

    }

    // Retrieve
    function getWordsNgram($ngram) {

        $path = base_path() . '/data/' . LANGUAGE . '/jsons/' . $ngram . 'grams.json';
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