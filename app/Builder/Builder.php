<?php

namespace App\Builder;

use App\Builder\Steps\SaveWordList;
use Log;

use App\Builder\Wiktionary\WiktionaryCategory;
use App\Builder\Wiktionary\WiktionaryLanguageSection;
use Illuminate\Database\Eloquent\Model;

class Builder extends Model {

    protected $lang;

    // Build cards for a word
    public function build($task, $language) {

        // Get Language Builder
        $languageBuilder = LanguageBuilderFactory::getLanguageBuilder($language);

        // Load Settings
        $languageBuilder->loadSettings();

        switch ($task) {

            case 'save_word_list':
                $step = new SaveWordList();
                $step->saveWordList($languageBuilder);
                break;
            case 'save_words':
                $this->saveWords($languageBuilder);
                break;
            case 'save_conjugations':
                // TODO: save conjugations
                break;
            case 'save_words_and_forms':
                // TODO: save words and forms
                break;
            case 'save_ngrams':
                // TODO: create ontology wikipedia
                break;
            case 'test':
                echo Log::info('Woks OK');
                break;
        }

    }

    public function loadSettings() {

        // Common settings to all languages
        $pathCommonSettings = app_path('Builder/config/common_settings.php');
        require_once $pathCommonSettings;

        // Language custom settings
        $path = app_path('Builder/config/' . $this->language . '_settings.php');
        if (file_exists($path)) {
            require_once $path;
        } else {
            Log::info('You must create a ' . $this->language . '_settings.php file on /config/builder/ folder');
            die();
        }

    }

    public function getLanguage() {
        return $this->language;
    }

    /** TASK 1: SAVE WORDS TO DATABASE **/
    public function saveWords($languageBuilder) {

        $words = $this->getAllWordsFromCategories($languageBuilder);
        //$this->_saveWords($words);

    }



    /** 2nd step, save words **/
    public function _saveWords($words) {

        $wiktionaryLanguageSection = new WiktionaryLanguageSection();
        $params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";
        $wiktionaryLanguageSection->saveWordHtmlJustLanguage($words, $params);

    }

}
