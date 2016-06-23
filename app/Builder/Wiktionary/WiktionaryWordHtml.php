<?php

namespace App\Builder\Wiktionary;
use App\Lib\WordFunctions;
use App\Builder\SimpleHtmlDom;

class WiktionaryWordHtml {

    public function getHtmlWordWiktionary($word) {

        // First we check if we've already saved it
        $path = base_path() . "/data/" . LANGUAGE . "/htmls/" . WordFunctions::getFirstCharacter($word) . "/" . $word . ".html";
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $html = SimpleHtmlDom::str_get_html($content);
            return ($html) ? $html : false;

        } else {

            $params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";
            $wiktionaryLanguageSection = new WiktionaryLanguageSection();
            $html = $wiktionaryLanguageSection->saveWordJustLanguage($word, $params);

            return $html;
        }

    }

}