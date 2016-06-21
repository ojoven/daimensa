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

            // We get it from the URL
            $urlBase = "http://" . LANGUAGE . ".wiktionary.org/wiki/";
            $url = $urlBase . $word;

            // Retrieve and return
            $content = @file_get_contents($url);
            $html = SimpleHtmlDom::str_get_html($content);
            if ($html) {
                // TODO: Save it
                return $html;
            }
            return false;

        }

    }

}