<?php

namespace App\Builder\Wiktionary;
use App\Lib\WordFunctions;

class WiktionaryLanguageSection {

    public function saveWordHtmlJustLanguage($words, $params) {

        $numWords = count($words);

        foreach ($words as $index=>$word) {

            if (WordFunctions::isValidWord($word)) {
                $this->saveWordJustLanguage($word, $params);
                echo $index . "/" . $numWords . ": " . $word . PHP_EOL;
            }
        }

    }

    public function saveWordJustLanguage($word, $params) {

        $firstCharacter = WordFunctions::getFirstCharacter($word);
        $pathWordDirectory = $params['cache'] . $firstCharacter;
        $pathWord = $pathWordDirectory . "/" . $word . ".html";

        if (!file_exists($pathWord)) {

            $wiktionaryWordHtml = new WiktionaryWordHtml();
            $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

            if ($html) {

                $justLanguageHtml = $this->getJustHtmlFromLanguage(WIKTIONARY_ID_LANGUAGE, $html);

                // If not folder, we create it
                if (!is_dir($pathWordDirectory)) {
                    mkdir($pathWordDirectory);
                }

                file_put_contents($pathWord, $justLanguageHtml);
            }

        }

    }

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