<?php

namespace App\Builder\Wiktionary;
use App\Lib\DomFunctions;

/** Common functions for the different kind of words **/
class WiktionaryWord {

    public function getMeaningsAndExamples($html, $id) {

        $meanings = array();

        // First we have to find the OL where the meanings are stored
        if (!$html->find("#" . $id,0)) return $meanings;
        $h3 = $html->find("#" . $id,0)->parent();
        while ($h3->next_sibling() && $h3->next_sibling()->tag!="ol") {
            $h3 = $h3->next_sibling();
        }

        if ($h3->next_sibling() && $h3->next_sibling()->tag=="ol") { // we found it!
            $ol = $h3->next_sibling();

            // For every meaning found
            foreach ($ol->children() as $meaning) {

                $meaningUl = $meaning->find('ul', 0);
                $textMeaning = str_replace(DomFunctions::getAttributeDom($meaningUl, 'plaintext'),"", DomFunctions::getAttributeDom($meaning, 'plaintext'));
                $textMeaning = str_replace(" ) ", ")", $textMeaning);

                $meaningObject = $this->_extractTextAndFeatures($textMeaning);

                // Let's add, too, some examples
                $meaningObject['examples'] = array();

                if ($meaningUl) {
                    foreach ($meaningUl->find('li') as $example) {
                        $source = DomFunctions::getAttributeDom($example->find("." . WIKTIONARY_ID_SOURCES, 0), 'plaintext');
                        $allText = $example->plaintext;
                        $textMeaning = str_replace(" )", ")", str_replace($source, "", $allText));

                        $exampleObject = $this->_extractTextAndFeatures($textMeaning);
                        $exampleObject['highlighted'] = DomFunctions::getAttributeDom($example->find("b", 0), 'plaintext');
                        $exampleObject['source'] = $this->_cleanSource($source);
                        array_push($meaningObject['examples'], $exampleObject);
                    }
                }

                array_push($meanings, $meaningObject);
            }
        }

        return $meanings;
    }

    private function _extractTextAndFeatures($initialText) {

        $features = array();

        $lastBracket = strrpos($initialText, "(");

        // We extract features only if there are '('s, but just before the first part of the string
        if ($lastBracket && $lastBracket<(strlen($initialText)/2)) {

            $pieces = explode(')', $initialText);
            $text = array_pop($pieces);
            foreach ($pieces as $piece) {
                $piece = trim(str_replace("(","",$piece));
                array_push($features, trim($piece));
            }
            $object['text'] = trim($text);

        } else {

            $object['text'] = trim($initialText);
        }

        $object['features'] = $features;

        return $object;

    }

    private function _cleanSource($source) {

        $source = str_replace("—  (", "", $source);
        $source = str_replace(")", "", $source);
        $source = str_replace("  ", " ", $source);
        $source = str_replace(" ,", ",", $source);
        $source = str_replace(" .", ".", $source);
        return $source;

    }

    public function getSynonyms($html) {

        $synonyms = array();

        $ulSynonyms = DomFunctions::getNextFromParent($html, 'ul', 'h4', WIKTIONARY_SYNONYMS);
        if ($ulSynonyms) {
            foreach ($ulSynonyms->find('li') as $synonymList) {

                $a = $synonymList->find('a', 0);
                if ($a) {
                    $synonym = $a->plaintext;
                    array_push($synonyms, $synonym);
                }

            }
        }

        return $synonyms;

    }

    public function getAntonyms($html) {

        $synonyms = array();

        $ulSynonyms = DomFunctions::getNextFromParent($html, 'ul', 'h4', WIKTIONARY_ANTONYMS);
        if ($ulSynonyms) {
            foreach ($ulSynonyms->find('li') as $synonymList) {

                $synonym = $synonymList->plaintext;
                $synonym = explode(" ", $synonym);
                $synonym = array_shift($synonym);
                array_push($synonyms, $synonym);

            }
        }

        return $synonyms;

    }

    public function getGenere($html) {

        $ligneDeForme = $html->find("." . WIKTIONARY_FORM_OF, 0);
        $genere = false;
        if ($ligneDeForme) {
            if (trim($ligneDeForme->plaintext)==WIKTIONARY_FORM_FEMENINE) {
                $genere = "femenine";
            } elseif (trim($ligneDeForme->plaintext)==WIKTIONARY_FORM_FEMENINE_PLURAL) {
                $genere = "femenine plural";
            } elseif (trim($ligneDeForme->plaintext)==WIKTIONARY_FORM_MASCULINE) {
                $genere = "masculine";
            } elseif (trim($ligneDeForme->plaintext)==WIKTIONARY_FORM_MASCULINE_PLURAL) {
                $genere = "masculine plural";
            } elseif (trim($ligneDeForme->plaintext)==WIKTIONARY_FORM_MASCULINE_FEMENINE) {
                $genere = "masculine and femenine";
            }
        }

        return $genere;

    }

    public function getPronunciation($word) {

        $pronunciation = false;

        $wiktionaryWordHtml = new WiktionaryWordHtml();
        $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

        $arrayOptions = array(
            WIKTIONARY_VERB,
            WIKTIONARY_ADJECTIVE,
            WIKTIONARY_COMMON_NAME,
            WIKTIONARY_ADVERBE,
        );

        foreach ($arrayOptions as $option) {
            $dom = DomFunctions::getNextFromParent($html, 'p', 'h3', $option);
            if ($dom) break;
        }

        if ($dom) {
            $span = $dom->find('span', 0);
            if ($span) {
                $pronunciation = $span->plaintext;
            }
        }

        return $pronunciation;

    }


}