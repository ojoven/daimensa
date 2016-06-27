<?php

namespace App\Builder\Wiktionary;
use App\Builder\FileManager;
use App\Builder\SimpleHtmlDom;
use App\Lib\Functions;
use App\Lib\WordFunctions;
use App\Lib\DomFunctions;

class WiktionaryWordVerb extends WiktionaryWord {

    /** GET INFO SUSTANTIVE **/
    public function getInfoVerb($word) {

        $wordHtml = new WiktionaryWordHtml();
        $html = $wordHtml->getHtmlWordWiktionary($word);

        // MEANINGS
        $info['meanings'] = $this->getMeaningsAndExamples($html, WIKTIONARY_ID_VERB);

        // RELATED WORDS
        $info['related'] = $this->getRelatedWords($html);

        // Synonyms
        $info['synonyms'] = $this->getSynonyms($html);

        // Conjugation
        $info['conjugation'] = $this->getConjugations($word);

        return $info;
    }

    /** CONJUGATIONS **/
    public function getConjugations($word) {

        $conjugations = array();
        $html = $this->getConjugationHtml($word);

        if ($html && $html->find('span[id=' . WIKTIONARY_VERBS_IMPERSONALS . ']')) { // valid conjugations page
            $conjugations = $this->_getImpersonalVerbsConjugations($conjugations, $html);
            $conjugations = $this->_getIndicativeVerbsConjugations($conjugations, $html);
            $conjugations = $this->_getSubjunctiveVerbsConjugations($conjugations, $html);
            $conjugations = $this->_getConditionalVerbsConjugations($conjugations, $html);
            $conjugations = $this->_getImperativeVerbsConjugations($conjugations, $html);
        }

        return $conjugations;

    }

    public function getConjugationHtml($word) {

        $pathDir = base_path() . "/data/" . LANGUAGE . "/conjugations/" . WordFunctions::getFirstCharacter($word);
        $path = $pathDir . "/" . $word;
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $html = SimpleHtmlDom::str_get_html($content);
            return ($html) ? $html : false;
        } else {

            $url = WIKTIONARY_CONJUGATIONS_URL_BASE . $word;
            $content = @file_get_contents($url);
            $html = SimpleHtmlDom::str_get_html($content);

            if ($html) {
                FileManager::saveFile($path, $content);
            }

            return ($html) ? $html : false;
        }

    }

    public function generateConjugationHtml($word) {

        $pathDir = base_path() . "/data/" . LANGUAGE . "/conjugations/" . WordFunctions::getFirstCharacter($word);
        $path = $pathDir . "/" . $word;
        if (!file_exists($path)) {

            $word = str_replace(" ", "_", $word); // To avoid errors on "se mallouser" style verbs

            $url = WIKTIONARY_CONJUGATIONS_URL_BASE . $word;
            $content = @file_get_contents($url);

            if ($content) {
                // Create the dir if not available
                if (!is_dir($pathDir)) {
                    mkdir($pathDir);
                }

                file_put_contents($path, $content);
            }
        }

    }

    public function getFormsFromConjugations($conjugations) {

        $forms = array();
        array_walk_recursive($conjugations, function($value, $key) use (&$forms) {
            if ($key=="verb") {
                array_push($forms, $value);
            }
        });

        $forms = array_unique($forms);
        return $forms;
    }


    function generateConjugationHtmls() {

        $wordList = new WordList();
        $words = $wordList->getAllWords();
        $verbs = $words[WIKTIONARY_CATEGORY_VERBS];

        $wiktionaryVerb = new WiktionaryWordVerb();

        $numVerbs = count($verbs);
        foreach ($verbs as $index=>$verb) {
            Functions::log($verb . " " . $index . "/" . $numVerbs);
            $wiktionaryVerb->generateConjugationHtml($verb); // stores the html for conjugation
        }

    }

    /** IMPERSONAL **/
    private function _getImpersonalVerbsConjugations($conjugations, $html) {

        $impersonals = DomFunctions::getNextFromParent($html, 'div', 'h3', WIKTIONARY_VERBS_IMPERSONALS);

        $conjugations = $this->_getImpersonalRowVerbsConjugations($conjugations, $impersonals->find('tr',1), 'infinitive');
        $conjugations = $this->_getImpersonalRowVerbsConjugations($conjugations, $impersonals->find('tr',2), 'gerundive');
        $conjugations = $this->_getImpersonalRowVerbsConjugations($conjugations, $impersonals->find('tr',3), 'participe');

        return $conjugations;

    }

    // INFINITIVE
    private function _getImpersonalRowVerbsConjugations($conjugations, $tr, $type) {

        if ($tr) {

            // Present
            $verb = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',2),'plaintext'));
            $conjugations['impersonals'][$type]['present']['conjugation'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',1),'plaintext'));
            $conjugations['impersonals'][$type]['present']['conjugation'] .= " " . $verb;
            $conjugations['impersonals'][$type]['present']['conjugation'] = trim($conjugations['impersonals'][$type]['present']['conjugation']);
            $conjugations['impersonals'][$type]['present']['verb'] = $verb;
            $conjugations['impersonals'][$type]['present']['pronunciation'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',3),'plaintext'));

            // Past
            $verb = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',5),'plaintext'));
            $conjugations['impersonals'][$type]['past']['conjugation'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',4),'plaintext'));
            $conjugations['impersonals'][$type]['past']['conjugation'] .= " " . $verb;
            $conjugations['impersonals'][$type]['past']['conjugation'] = trim($conjugations['impersonals'][$type]['past']['conjugation']);
            $conjugations['impersonals'][$type]['past']['verb'] = $verb;
            $conjugations['impersonals'][$type]['past']['pronunciation'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',6),'plaintext'));
        }

        return $conjugations;

    }

    private function _getIndicativeVerbsConjugations($conjugations, $html) {

        $indicative = DomFunctions::getNextFromParent($html, 'div', 'h3', WIKTIONARY_VERBS_INDICATIVE);
        $tense = 'indicative';

        $trNext = $indicative->find('tr', 0);
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'present');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'past composed');

        $trNext = $trNext->next_sibling();
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'imperfect');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'pluperfect');

        $trNext = $trNext->next_sibling();
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'past simple');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'past anterior');

        $trNext = $trNext->next_sibling();
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'future simple');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'future anterior');

        return $conjugations;

    }

    private function _getSubjunctiveVerbsConjugations($conjugations, $html) {

        $subjunctive = DomFunctions::getNextFromParent($html, 'div', 'h3', WIKTIONARY_VERBS_SUBJUNCTIVE);
        $tense = 'subjunctive';

        $trNext = $subjunctive->find('tr', 0);
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'present');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'past');

        $trNext = $trNext->next_sibling();
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'imperfect');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'pluperfect');

        return $conjugations;

    }

    private function _getConditionalVerbsConjugations($conjugations, $html) {

        $conditional = DomFunctions::getNextFromParent($html, 'div', 'h3', WIKTIONARY_VERBS_CONDITIONAL);
        $tense = 'conditional';

        $trNext = $conditional->find('tr', 0);
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'present');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'past 1');

        $trNext = $trNext->next_sibling();
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'past 2');

        return $conjugations;

    }

    private function _getImperativeVerbsConjugations($conjugations, $html) {

        $imperative = DomFunctions::getNextFromParent($html, 'div', 'h3', WIKTIONARY_VERBS_IMPERATIVE);
        $tense = 'imperative';

        $trNext = $imperative->find('tr', 0);
        $tdNext = $trNext->find('td', 0);
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext, $tense, 'present');
        $conjugations = $this->_getMainTableVerbsConjugations($conjugations, $tdNext->next_sibling(), $tense, 'past');
        if ($conjugations['imperative']['past']['1 Singular']['conjugation']=="—") unset($conjugations['imperative']['past']); // Some verbs don't have past imperative

        return $conjugations;

    }

    private function _getMainTableVerbsConjugations($conjugations, $td, $tense1, $tense2) {

        if ($td) {
            if (count($td->find('tr'))==4) { // Imperative has only 3 (+ header) tenses
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',1), $tense1, $tense2, '1 Singular');
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',2), $tense1, $tense2, '1 Plural');
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',3), $tense1, $tense2, '2 Plural');
            } else {
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',1), $tense1, $tense2, '1 Singular');
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',2), $tense1, $tense2, '2 Singular');
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',3), $tense1, $tense2, '3 Singular');

                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',4), $tense1, $tense2, '1 Plural');
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',5), $tense1, $tense2, '2 Plural');
                $conjugations = $this->_getMainRowVerbsConjugations($conjugations, $td->find('tr',6), $tense1, $tense2, '3 Plural');
            }
        }

        return $conjugations;


    }

    private function _getMainRowVerbsConjugations($conjugations, $tr, $tense1, $tense2, $tense3) {

        if ($tr) {
            $space = ($tense1=="imperative") ? "" : " "; // No space if imperative
            $conjugations[$tense1][$tense2][$tense3]['conjugation'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',0),'plaintext'));
            $conjugations[$tense1][$tense2][$tense3]['conjugation'] .= $space . WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',1),'plaintext'));
            $conjugations[$tense1][$tense2][$tense3]['conjugation'] = trim($conjugations[$tense1][$tense2][$tense3]['conjugation']);

            $isVerbInTd = ($tr->find('td',0)->find('a', 0)) ? 0 : 1; // Some imperative pronominal's verb is in td = 0 / usually in td = 1
            $conjugations[$tense1][$tense2][$tense3]['verb'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td', $isVerbInTd),'plaintext'));

            $conjugations[$tense1][$tense2][$tense3]['pronunciation'] = WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',2),'plaintext'));
            $conjugations[$tense1][$tense2][$tense3]['pronunciation'] .= $space . WordFunctions::specialtrim(DomFunctions::getAttributeDom($tr->find('td',3),'plaintext'));
            $conjugations[$tense1][$tense2][$tense3]['pronunciation'] = trim($conjugations[$tense1][$tense2][$tense3]['pronunciation']);
        }

        return $conjugations;
    }

    public function getSynonyms($html) {

        $ulOlOptions = array('ul','ol');

        $synonyms = array();

        foreach ($ulOlOptions as $ulOl) {

            $h4Child = $html->find("span[id=" . WIKTIONARY_SYNONYMS . "]", 0);
            if (!$h4Child) { return $synonyms; }
            $h4 = $h4Child->parent();


            // First we have to find the UL/OL where the related words are stored
            while ($h4->next_sibling() && $h4->next_sibling()->tag!=$ulOl) {
                $h4 = $h4->next_sibling();
                if ($h4->next_sibling()->tag=="h4") break;
            }

            if ($h4->next_sibling() && $h4->next_sibling()->tag==$ulOl) { // we found it!
                $ul = $h4->next_sibling();

                foreach ($ul->find("a") as $synonymLink) {

                    $synonymWord = DomFunctions::getAttributeDom($synonymLink, 'plaintext');
                    if ($synonymWord) {
                        array_push($synonyms, $synonymWord);
                    }

                }
            }

        }

        return $synonyms;

    }

    public function getFormsSustantive($html) {

        $forms = array();

        $h3 = $html->find("#" . WIKTIONARY_ID_COMMON_NAME,0)->parent();
        if ($h3->next_sibling() && $h3->next_sibling()->tag=="table") {
            $table = $h3->next_sibling();
            foreach ($table->find('td') as $index=>$form) {

                // Singular & Plural
                if ($index==0) {
                    $forms['singular'] = $form->plaintext;
                } elseif ($index==1) {
                    $forms['plural'] = $form->plaintext;
                }
            }
        }

        return $forms;

    }


    public function getRelatedWords($html) {

        $relatedWords = array();

        $h4Child = $html->find("span[id=" . WIKTIONARY_RELATED_WORDS . "]", 0);
        if (!$h4Child) { return $relatedWords; }
        $h4 = $h4Child->parent();


        // First we have to find the UL where the related words are stored
        while ($h4->next_sibling() && $h4->next_sibling()->tag!="ul") {
            $h4 = $h4->next_sibling();
        }

        if ($h4->next_sibling() && $h4->next_sibling()->tag=="ul") { // we found it!
            $ul = $h4->next_sibling();

            foreach ($ul->find("a") as $relatedLink) {

                $relatedWord = DomFunctions::getAttributeDom($relatedLink, 'plaintext');
                if ($relatedWord) {
                    array_push($relatedWords, $relatedWord);
                }

            }
        }

        return $relatedWords;

    }


}