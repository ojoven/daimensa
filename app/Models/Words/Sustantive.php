<?php

namespace App\Models\Words;
use App\Models\Wiktionary\WiktionaryWordSustantive;

class Sustantive {

    public function getInfoSustantive($word) {

        // Get sustantive info from Wiktionary
        $wiktionarySustantive = new WiktionaryWordSustantive();
        $info = $wiktionarySustantive->getInfoSustantive($word);

        return $info;

    }


}