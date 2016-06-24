<?php

namespace App\Builder;

use App\Builder\Steps\SaveNGram;
use Log;
use Illuminate\Database\Eloquent\Model;

// Steps
use App\Builder\Steps\SaveWordList;
use App\Builder\Steps\SaveWordsHTML;
use App\Builder\Steps\SaveConjugationsHTML;
use App\Builder\Steps\SaveWordBaseList;

class Builder extends Model {

    // Build cards for a word
    public function build($task, $language) {

        // Get Language Builder
        $languageBuilder = LanguageBuilderFactory::getLanguageBuilder($language);

        // Load Settings
        $languageBuilder->loadSettings();

        // TASKS / STEPS
        switch ($task) {

            case 'save_word_list':
                $step = new SaveWordList();
                $step->saveWordList($languageBuilder);
                break;
            case 'save_words_html':
                $step = new SaveWordsHTML();
                $step->saveWordsHTML();
                break;
            case 'save_conjugations_html':
                $step = new SaveConjugationsHTML();
                $step->saveConjugationsHTML();
                break;
            case 'save_word_base_list':
                $step = new SaveWordBaseList();
                $step->saveWordBaseList();
                break;
            case 'save_ngram':
                $step = new SaveNGram();
                $step->saveNGram();
                break;
            case 'save_to_db':
                // TODO: We'll save the words, frequencies, ontologies, etc. into the database
            case 'test':
                echo Log::info('Woks OK');
                break;
        }

    }

    /** AUXILIAR FUNCTIONS **/
    // LOAD SETTINGS
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

    // GET LANGUAGE
    public function getLanguage() {
        return $this->language;
    }

}
