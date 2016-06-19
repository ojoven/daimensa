<?php

namespace App\Builder\Wiktionary;
use App\Lib\Functions;
use App\Lib\WordFunctions;
use App\Lib\DomFunctions;

class WiktionaryWordFormVerb extends WiktionaryWord {

    /** GET INFO SUSTANTIVE **/
    public function getInfoFormVerb($word) {

        $wordHtml = new WiktionaryWordHtml();
        $html = $wordHtml->getHtmlWordWiktionary($word);

        // MEANINGS
        $info['verb'] = $this->getVerbFromFormVerb($html, $word);

        return $info;
    }

    public function getVerbFromFormVerb($html) {

        $verb = false;
        $formOl = DomFunctions::getNextFromParent($html, 'ol', 'h3', WIKTIONARY_VERB_FORM);
        if ($formOl) {
            $verbLink = $formOl->find('a', 0);
            if ($verbLink) {
                $verb = $verbLink->plaintext;
            }
        }

        return $verb;

    }

}