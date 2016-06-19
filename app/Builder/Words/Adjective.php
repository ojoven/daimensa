<?php

namespace App\Models\Words;
use App\Models\Wiktionary\WiktionaryWordAdjective;

class Adjective {

    public function getInfoAdjective($word) {

        // Get adjective info from Wiktionary
        $wiktionaryAdjective = new WiktionaryWordAdjective();
        $info = $wiktionaryAdjective->getInfoAdjective($word);

        return $info;

    }


}