<?php

namespace App\Models\Words;
use App\Models\Wiktionary\WiktionaryWordVerb;

class Verb {

    public function getInfoVerb($word) {

        // Get verb info from Wiktionary
        $wiktionaryVerb = new WiktionaryWordVerb();
        $info = $wiktionaryVerb->getInfoVerb($word);

        return $info;

    }


}