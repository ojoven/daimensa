<?php

namespace App\Builder\Wiktionary;
use App\Lib\WordFunctions;
use App\Builder\SimpleHtmlDom;
use Log;

class WiktionaryWordHtml {

    /** GET WORD HTML **/
    public function getHtmlWordWiktionary($word) {

        // First we check if we've already saved it
        $path = base_path() . "/data/" . LANGUAGE . "/htmls/" . WordFunctions::getFirstCharacter($word) . "/" . $word . ".html";

        if (file_exists($path)) {
            $content = file_get_contents($path);
            $html = SimpleHtmlDom::str_get_html($content);
            return ($html) ? $html : false;

        } else {
            $params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";
            $html = $this->saveWordHTML($word, $params);

            return $html;
        }

    }

    /** SAVE WORD HTMLS **/
    public function saveWordHtmls($words, $params) {

        $numWords = count($words);

        foreach ($words as $index=>$word) {

            if (WordFunctions::isValidWord($word)) {
                $result = $this->saveWordHTML($word, $params);
                $resultLog = ($result) ? "success" : "error";
                echo $index . '/' . $numWords . ': ' . $word . ' --> ' . $resultLog . PHP_EOL;
            }
        }

    }

    /** SAVE SINGLE WORD HTML **/
    public function saveWordHTML($word, $params) {

        $firstCharacter = WordFunctions::getFirstCharacter($word);
        $pathWordDirectory = $params['cache'] . $firstCharacter;
        $pathWord = $pathWordDirectory . "/" . $word . ".html";

        if (!file_exists($pathWord)) {

            $urlWiktionaryWord = 'http://' . LANGUAGE . '.wiktionary.org/wiki/' . WordFunctions::wordForURL($word);
            $html = SimpleHtmlDom::file_get_html($urlWiktionaryWord);

            if ($html && WordFunctions::isValidWord($word)) {

                $justLanguageHtml = $this->getJustHtmlFromLanguage(WIKTIONARY_ID_LANGUAGE, $html);

                // If no folder, we create it
                if (!is_dir($pathWordDirectory)) {
                    mkdir($pathWordDirectory);
                }

                file_put_contents($pathWord, $justLanguageHtml);

                return $html;
            }

        } else {
            return SimpleHtmlDom::str_get_html(file_get_contents($pathWord));
        }

    }

    /** GET JUST THE HTML FOR THE BELONGING LANGUAGE **/
    public function getJustHtmlFromLanguage($idLanguageTitleWiktionary, $html) {

        // Initialize
        $finalHtmlString = "";

        // Let's create a new HTML from just our language
        $identifier = $html->find("span[id=" . $idLanguageTitleWiktionary . "]", 0);
        if ($identifier) {
            $h2 = $identifier->parent();
            if ($h2) {
                $finalHtmlString .= $h2->outertext;
                while ($h2->next_sibling() && $h2->next_sibling()->tag!="h2") {
                    $h2 = $h2->next_sibling();
                    $finalHtmlString .= $h2->outertext;
                }
            }
        }

        // We add category links, too
        $categories = $html->find("#catlinks",0);
        if ($categories) {
            $finalHtmlString .= $categories->outertext;
        }

        // Let's create html from the new string
        if ($finalHtmlString!="") {
            $pre = '<html><head><meta charset="UTF-8" /></head><body>';
            $post = "</body></html>";
            $finalHtmlString = $pre . $finalHtmlString . $post;
        }

        return $finalHtmlString;
    }

}