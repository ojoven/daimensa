<?php

namespace App\Builder\Wiktionary;

class WiktionaryForm {


    public function getWordsWithForms($words, $params) {

        //$params['cache_path'] = base_path() . "/data/wiktionary/wordforms.json";

        if (!file_exists($params['cache_path'])) {

            // Initialize
            $wordForms = array();

            // Retrieve the word forms for each word
            foreach ($words as $index=>$word) {

                $wordForm = $this->getWordForms($word);
                array_push($wordForms, $wordForm);

            }

            // Let's save into the cache
            file_put_contents($params['cache_path'], json_encode($wordForms));

        } else {

            // We already have the cache, let's retrieve the words with forms from there
            $wordForms = json_decode(file_get_contents($params['cache_path']), true);

        }

        return $wordForms;

    }

    /** GET FORMS (TRUE/FALSE) FOR EACH WORD **/
    public function getWordForms($word) {

        $wordForm = array();
        $wiktionaryWordHtml = new WiktionaryWordHtml();
        $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

        $wordForm['word'] = $word;

        // We'll just retrieve: names and forms, verbs and forms, adjectives and forms,
        // adverbs and prepositions, leaving out all the others

        if ($html) {

            $wordForm['name'] = ($this->isFormInWord(WIKTIONARY_COMMON_NAME, $html)) ? true : false;
            $wordForm['form_name'] = ($this->isFormInWord(WIKTIONARY_COMMON_NAME_FORM, $html)) ? true : false;
            $wordForm['verb'] = ($this->isFormInWord(WIKTIONARY_VERB, $html)) ? true : false;
            $wordForm['form_verb'] = ($this->isFormInWord(WIKTIONARY_VERB_FORM, $html)) ? true : false;
            $wordForm['adjective'] = ($this->isFormInWord(WIKTIONARY_ADJECTIVE, $html)) ? true : false;
            $wordForm['form_adjective'] = ($this->isFormInWord(WIKTIONARY_ADJECTIVE_FORM, $html)) ? true : false;
            $wordForm['adverb'] = ($this->isFormInWord(WIKTIONARY_ADVERBE, $html)) ? true : false;
            $wordForm['preposition'] = ($this->isFormInWord(WIKTIONARY_PREPOSITION, $html)) ? true : false;

        }

        return $wordForm;

    }

    /** GET FORMS (RETRIEVE ONLY FORMS THAT EXIST) FOR EACH WORD **/
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

    public function isFormInWord($idDom,$html) {

        if ($html) {
            $form = $html->find("span[id=" . $idDom . "]");
            return ($form) ? true : false;
        }

        return false;

    }

}