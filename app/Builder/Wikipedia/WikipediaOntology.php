<?php
namespace App\Models\Wikipedia;

// We'll use Wikipedia for creating an alternative ontology

use App\Lib\WordFunctions;
use App\Lib\Functions;

class WikipediaOntology {

    /** WIKIPEDIA ONTOLOGY **/
    // Retrieve
    function getWordsWikipedia() {

        $path = base_path() . "/data/" . LANGUAGE . "/ontology/final/words.json";
        if (file_exists($path)) {
            $words = json_decode(file_get_contents($path),true);
        } else {
            $words = $this->mergeOntologies();
        }

        // Let's sort by frequency
        arsort($words);

        return $words;
    }

    // Merge
    function mergeOntologies() {

        $path = base_path() . "/data/" . LANGUAGE . "/ontology/partials";
        $words = array();
        $dir = new DirectoryIterator($path);
        foreach ($dir as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $fileName = $fileInfo->getFilename();

                Functions::log("Adding " . $fileName);

                $ontologyFile = json_decode(file_get_contents($path . "/" . $fileName));

                foreach ($ontologyFile as $ontologyWord=>$frequency) {

                    if (!WordFunctions::isValidWordOntology($ontologyWord)) continue;
                    $ontologyWord = WordFunctions::getValidWordOntology($ontologyWord);

                    if (!isset($words[$ontologyWord])) {
                        $words[$ontologyWord] = $frequency;
                    } else {
                        $words[$ontologyWord] += $frequency;
                    }

                }
            }
        }

        // Let's save it
        file_put_contents(base_path() . "/data/" . LANGUAGE . "/ontology/final/words.json", json_encode($words));
        return $words;

    }

}