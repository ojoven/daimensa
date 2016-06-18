<?php

namespace App\Models;

class WordList {

    /** Load all words **/
    public function getAllWords() {

        $path = base_path() . "/data/" . LANGUAGE . "/categories";
        $words = array();
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $fileInfo) {
            if (!$fileInfo->isDot()) {
                $fileName = $fileInfo->getFilename();
                $category = str_replace(".json","",$fileName); // We remove the extension
                $words[$category] = json_decode(file_get_contents($path . "/" . $fileName));
            }
        }

        return $words;
    }

    /** Words and forms **/
    function getWordsAndForms($justFrequent) {

        $suffix = $justFrequent ? "_freq" : "";
        $path = base_path() . "/data/" . LANGUAGE . "/forms/wordsAndForms" . $suffix . ".json";
        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true);
        }

        $words = $allWords = $this->getAllWords();
        $words = ($justFrequent)? $this->mergeJustFrequentCategoryWords($words) : $this->mergeAllCategoryWords($words);
        $invalidCategories = getInvalidCategories();

        $wordsAndForms = array();

        $wiktionaryWordHtml = new WiktionaryWordHtml();
        $wiktionaryForm = new WiktionaryForm();
        $wiktionarySustantive = new WiktionaryWordSustantive();
        $wiktionaryVerb = new WiktionaryWordVerb();
        $wiktionaryAdjective = new WiktionaryWordAdjective();

        $wordModel = new Word();

        $numWords = count($words);

        foreach ($words as $index=>$word) {

            Functions::log($index . "/" . $numWords . ": " . $word);

            if ($this->wordBelongsToInvalidCategory($word, $allWords, $invalidCategories)) continue;

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

            // Ver Conjugations
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
            if ($isAdverb || $isAdjective || $isName || $isVerb || !$justFrequent) {
                $wordsAndForms[$word] = $word;
            }

        }

        file_put_contents($path, json_encode($wordsAndForms));

        return $words;
    }

    /** Category **/
    public function wordBelongsToInvalidCategory($word, $words, $invalidCategories) {

        foreach ($invalidCategories as $category) {
            if (in_array($word, $words[$category])) {
                Functions::log($word . " is not valid word");
                return true;
            }
        }

        return false;

    }

    public function getAllFrequentWords() {

        $words = $this->getAllWords();
        $words = $this->mergeJustFrequentCategoryWords($words);
        return $words;

    }

    /** Mergers **/
    public function mergeJustFrequentCategoryWords($words) {

        $frequent = getFrequentCategories();
        $merged = array();
        foreach ($words as $category=>$categoryWords) {
            if (in_array($category, $frequent)) {
                $merged = array_merge($merged, $categoryWords);
            }
        }

        return $merged;

    }

    public function mergeAllCategoryWords($words) {

        $merged = array();
        foreach ($words as $category=>$categoryWords) {
            $merged = array_merge($merged, $categoryWords);
        }

        return $merged;

    }

    /** Auxiliar **/
    public function renderWordsSummary($words) {
        $count = 0;
        foreach ($words as $category=>$categoryWords) {
            Functions::log($category . " -> " . count($categoryWords) . " words");
            $count += count($categoryWords);
        }

        Functions::log($count . " total words and expressions");
    }

    private function _addFormsToWordsAndForms($forms, $word, $wordsAndForms) {

        foreach ($forms as $form) {
            $wordsAndForms[$form] = $word;
        }

        return $wordsAndForms;
    }

}