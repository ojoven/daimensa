<?php

namespace App\Models\Words;
use App\Models\Wiktionary\WiktionaryWordFormVerb;

class FormVerb {

    /** GET INFO FORM VERB **/
    public function getInfoFormVerb($word) {

        // Get verb info from Wiktionary
        $wiktionaryFormVerb = new WiktionaryWordFormVerb();
        $info = $wiktionaryFormVerb->getInfoFormVerb($word);

        return $info;

    }


}