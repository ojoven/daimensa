<?php

namespace App\Models;

use App\Models\Wiktionary\WiktionaryForm;
use App\Models\Google\GoogleTranslate;
use App\Models\Forvo\Forvo;
use App\Models\Wiktionary\WiktionaryWord;
use App\Models\Wiktionary\WiktionaryWordAdjective;
use App\Models\Wiktionary\WiktionaryWordFormVerb;
use App\Models\Wiktionary\WiktionaryWordHtml;
use App\Models\Wiktionary\WiktionaryWordSustantive;
use App\Models\Wiktionary\WiktionaryWordVerb;
use App\Models\Words\FormVerb;
use App\Models\Yahoo\YahooWord;
use App\Models\Others\Glosbe;
use App\Lib\Functions;

use App\Models\Words\Sustantive;
use App\Models\Words\Adjective;
use App\Models\Words\Verb;

use Illuminate\Database\Eloquent\Model;

class Word extends Model {

    const MAX_NUM_FREQUENT = 35000;

    public function getBunchWords($params) {

        $words = $this->_getBunchWordsSimple($params);
        $completeWords = array();
        foreach ($words as $word) {
            $completeWord = $this->getAllInfoWord($word);
            array_push($completeWords, $completeWord);
        }

        return $completeWords;

    }

    private function _getBunchWordsSimple($params) {

        // Here possible testing
        //$words = array('sorcière');
        //return $words;

        $words = array();
        $baseWords = json_decode(file_get_contents(base_path() . '/data/' . $_SESSION['fromLanguage'] . '/jsons/frequentwords.json'), true);
        $keys = array_keys($baseWords);

        $numWords = $params['numWords'];
        while (count($words)<$numWords) {

            $maxNum = min(self::MAX_NUM_FREQUENT, count($baseWords)-1);
            $random = rand(0, $maxNum);
            if (!isset($words[$keys[$random]])) {
                array_push($words, $keys[$random]);
            }

        }

        return $words;

    }

    // Get all info
    public function getAllInfoWord($word) {

        $info['word'] = $word;
        $info['forms'] = $this->getFormsWord($word);
        $info['general'] = $this->getGeneralInfoWord($word);
        foreach ($info['forms'] as $form) {
            $info[$form] = $this->getWordFormInfo($word, $form);
        }

        return $info;

    }

    public function getFormsWord($word) {

        $wiktionaryForm = new WiktionaryForm();
        $forms = $wiktionaryForm->getWordFormsRetrieveForms($word);

        // Adjective, verb, etc.
        return $forms;

    }

    public function getGeneralInfoWord($word) {

        $generalInfo = array();

        // Google Translations
        /**
        $googleTranslate = new GoogleTranslate();
        $generalInfo['translations']['google'] = $googleTranslate->getTranslation($_SESSION['fromLanguage'], $_SESSION['toLanguage'], $word);

        // Yahoo Searches
        $yahoo = new YahooWord();
        $generalInfo['searches']['yahoo'] = $yahoo->getInfoWordYahoo($word);
        **/

        // Wiktionary text pronunciation + Forvo pronunciations
        $wiktionaryWord = new WiktionaryWord();
        $forvo = new Forvo();
        $generalInfo['pronunciation']['text'] = $wiktionaryWord->getPronunciation($word);
        $generalInfo['pronunciation']['audios'] = $forvo->getPronunciationsWord($word, $_SESSION['fromLanguage']);

        // Glosbe Translations
        $glosbe = new Glosbe();
        $generalInfo['translations']['glosbe'] = $glosbe->getTranslations($word, $_SESSION['fromLanguage'], $_SESSION['toLanguage']);

        // Glosbe Examples
        $glosbe = new Glosbe();
        $generalInfo['examples']['glosbe'] = $glosbe->getExamples($word, $_SESSION['fromLanguage'], $_SESSION['toLanguage']);

        return $generalInfo;

    }

    public function getWordFormInfo($word, $form) {

        $info = array();

        switch ($form) {

            case 'verb':
                $verb = new Verb();
                $info = $verb->getInfoVerb($word);
                break;

            case 'name':
                $sustantive = new Sustantive();
                $info = $sustantive->getInfoSustantive($word);
                break;

            case 'adjective':
                $adjective = new Adjective();
                $info = $adjective->getInfoAdjective($word);
                break;

            case 'form_verb':
                $formVerb = new FormVerb();
                $info = $formVerb->getInfoFormVerb($word);
                break;

            // TODO: Missing: adverbs, articles, etc.

        }

        return $info;

    }

    public function getWordForms($word) {

        $forms = array();

        $wiktionaryWordHtml = new WiktionaryWordHtml();
        $wiktionaryForm = new WiktionaryForm();
        $wiktionarySustantive = new WiktionaryWordSustantive();
        $wiktionaryVerb = new WiktionaryWordVerb();
        $wiktionaryFormVerb = new WiktionaryWordFormVerb();
        $wiktionaryAdjective = new WiktionaryWordAdjective();

        $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

        $wordsToAnalyze = array($word);
        // First, let's add to the word its base
        $isFormVerb = ($wiktionaryForm->isFormInWord(WIKTIONARY_VERB_FORM, $html)) ? true : false;
        if ($isFormVerb) {
            $verb = $wiktionaryFormVerb->getVerbFromFormVerb($html);
            if ($verb) {
                array_push($wordsToAnalyze, $verb);
            }
        }

        foreach ($wordsToAnalyze as $word) {

            $html = $wiktionaryWordHtml->getHtmlWordWiktionary($word);

            // Name Forms
            $isName = ($wiktionaryForm->isFormInWord(WIKTIONARY_COMMON_NAME, $html)) ? true : false;
            if ($isName) {
                $forms = array_merge($forms, Functions::getLeafs($wiktionarySustantive->getFormsSustantive($html)));
            }

            // Adjective Forms
            $isAdjective = ($wiktionaryForm->isFormInWord(WIKTIONARY_ADJECTIVE, $html)) ? true : false;
            if ($isAdjective) {
                $forms = array_merge($forms, Functions::getLeafs($wiktionaryAdjective->getFormsAdjective($html)));
            }

            // Ver Conjugations
            $isVerb = ($wiktionaryForm->isFormInWord(WIKTIONARY_VERB, $html)) ? true : false;
            if ($isVerb) {
                $conjugations = $wiktionaryVerb->getConjugations($word);
                if (!empty($conjugations)) {
                    $forms = array_merge($forms, $wiktionaryVerb->getFormsFromConjugations($conjugations));
                }
            }

            // The word belongs to himself
            array_push($forms, $word);

        }


        $forms = array_unique($forms);

        return $forms;

    }
    
}