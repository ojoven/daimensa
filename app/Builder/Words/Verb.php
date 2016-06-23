<?php

namespace App\Builder\Words;
use App\Builder\FileManager;
use App\Builder\Wiktionary\WiktionaryWordVerb;

class Verb {

    public function getVerbs() {

        $verbsJsonPath = base_path() . '/data/' . LANGUAGE . '/categories/' . WIKTIONARY_CATEGORY_VERBS . '.json';
        $verbsJson = FileManager::getFile($verbsJsonPath);
        $verbs = json_decode($verbsJson, true);

        return $verbs;
    }

    public function getInfoVerb($word) {

        // Get verb info from Wiktionary
        $wiktionaryVerb = new WiktionaryWordVerb();
        $info = $wiktionaryVerb->getInfoVerb($word);

        return $info;

    }


}