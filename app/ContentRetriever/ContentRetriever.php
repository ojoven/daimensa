<?php

namespace App\ContentRetriever;

use App\Builder\Steps\SaveNGram;
use App\Builder\Wiktionary\WiktionaryWordHtml;
use Log;
use Illuminate\Database\Eloquent\Model;

class ContentRetriever extends Model {

    // Build cards for a word
    public function retrieve($task, $language, $additional = '') {

        // Get Language Builder
        $languageBuilder = LanguageBuilderFactory::getLanguageBuilder($language);

        // Load Settings
        $languageBuilder->loadSettings();

        // TASKS / STEPS
        switch ($task) {

            case 'youtube':
                $step = new SaveWordList();
                $step->saveWordList($languageBuilder);
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