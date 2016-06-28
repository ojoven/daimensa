<?php

namespace App\Builder\Wiktionary;

use App\Builder\FileManager;
use App\Lib\Functions;
use App\Lib\WordFunctions;
use Log;

class WiktionaryForm {

    /** WORD FORMS **/
    function getWordForms($words) {

        $path = base_path() . "/data/" . LANGUAGE . "/jsons/wordForms.json";
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }

        $wordsAndForms = array();

        $wiktionaryWordHtml = new WiktionaryWordHtml();
        $wiktionaryForm = new WiktionaryForm();
        $wiktionarySustantive = new WiktionaryWordSustantive();
        $wiktionaryVerb = new WiktionaryWordVerb();
        $wiktionaryAdjective = new WiktionaryWordAdjective();

        $numWords = count($words);

        foreach ($words as $index => $word) {

            Log::info($index . "/" . $numWords . ": " . $word);

            $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

            // Name Forms
            $isName = ($wiktionaryForm->isFormInWord(WIKTIONARY_COMMON_NAME, $html)) ? true : false;
            if ($isName) {
                $forms = Functions::getLeafs($wiktionarySustantive->getFormsSustantive($html));
                $wordsAndForms = $this->_addFormsToWordsAndForms($forms, $word, $wordsAndForms);
            }

            // Adjective Forms
            $isAdjective = ($wiktionaryForm->isFormInWord(WIKTIONARY_ADJECTIVE, $html)) ? true : false;
            if ($isAdjective) {
                $forms = Functions::getLeafs($wiktionaryAdjective->getFormsAdjective($html));
                $wordsAndForms = $this->_addFormsToWordsAndForms($forms, $word, $wordsAndForms);
            }

            // Verb Conjugations
            $isVerb = ($wiktionaryForm->isFormInWord(WIKTIONARY_VERB, $html)) ? true : false;
            if ($isVerb) {
                $conjugations = $wiktionaryVerb->getConjugations($word);
                $forms = array();
                if (!empty($conjugations)) {
                    $forms = $wiktionaryVerb->getFormsFromConjugations($conjugations);
                }
                $wordsAndForms = $this->_addFormsToWordsAndForms($forms, $word, $wordsAndForms);
            }

            $isAdverb = ($wiktionaryForm->isFormInWord(WIKTIONARY_ADVERBE, $html)) ? true : false;

            // The word belongs to himself
            if ($isAdverb || $isAdjective || $isName || $isVerb) {
                $wordsAndForms[$word] = $word;
            }


        }

        file_put_contents($path, json_encode($wordsAndForms));

        return $words;
    }

    private function _addFormsToWordsAndForms($forms, $word, $wordsAndForms) {

        foreach ($forms as $form) {
            if ($this->_isValidForm($form)) {
                $wordsAndForms[$form] = $word;
            }
        }

        return $wordsAndForms;
    }

    private function _isValidForm($form) {

        if (strpos($form, '/')!==FALSE) {
            return false;
        }

        return true;

    }

    /** BASE WORDS **/
    public function isBaseWord($wordHTML) {

        // We'll just retrieve: names, verbs, adjectives,
        // adverbs, prepositions and pronouns, leaving out all the others

        if ($wordHTML) {

            if ($this->isFormInWord(WIKTIONARY_COMMON_NAME, $wordHTML)
                || $this->isFormInWord(WIKTIONARY_VERB, $wordHTML)
                || $this->isFormInWord(WIKTIONARY_ADJECTIVE, $wordHTML)
                || $this->isFormInWord(WIKTIONARY_ADVERBE, $wordHTML)
                || $this->isFormInWord(WIKTIONARY_PREPOSITION, $wordHTML)
                || $this->isFormInWord(WIKTIONARY_PRONOUN_PERSONAL, $wordHTML)) {
                return true;
            } else {
                return false;
            }
        }

    }

    /** IS FORM IN WORD? **/
    public function isFormInWord($idDom, $html) {

        if ($html) {
            $form = $html->find("span[id=" . $idDom . "]");
            return ($form) ? true : false;
        }

        return false;
    }

    /** QUARANTINE: GET FORMS (RETRIEVE ONLY FORMS THAT EXIST) FOR EACH WORD **/
    public function getWordFormsRetrieveForms($word) {

        $wiktionaryWordHtml = new WiktionaryWordHtml();
        $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

        $forms = array();

        // We'll just retrieve: names and forms, verbs and forms, adjectives and forms,
        // adverbs and prepositions, leaving out all the others

        if ($html) {

            if ($this->isFormInWord(WIKTIONARY_COMMON_NAME, $html)) array_push($forms, 'name');
            if ($this->isFormInWord(WIKTIONARY_COMMON_NAME_FORM, $html)) array_push($forms, 'form_name');
            if ($this->isFormInWord(WIKTIONARY_VERB, $html)) array_push($forms, 'verb');
            if ($this->isFormInWord(WIKTIONARY_VERB_FORM, $html)) array_push($forms, 'form_verb');
            if ($this->isFormInWord(WIKTIONARY_ADJECTIVE, $html)) array_push($forms, 'adjective');
            if ($this->isFormInWord(WIKTIONARY_ADJECTIVE_FORM, $html)) array_push($forms, 'form_adjective');
            if ($this->isFormInWord(WIKTIONARY_ADVERBE, $html)) array_push($forms, 'adverb');
            if ($this->isFormInWord(WIKTIONARY_PREPOSITION, $html)) array_push($forms, 'preposition');

        }

        return $forms;

    }

}