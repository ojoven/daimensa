<?php

namespace App\Builder;

use Log;

use App\Builder\Wiktionary\WiktionaryCategory;
use App\Builder\Wiktionary\WiktionaryLanguageSection;
use Illuminate\Database\Eloquent\Model;

class Builder extends Model {

    // Build cards for a word
    public function build($task, $language) {

        // Get Language Builder
        $languageBuilder = LanguageBuilderFactory::getLanguageBuilder($language);

        // Load Settings
        $languageBuilder->loadSettings();

        switch ($task) {

            case 'save_words':
                $languageBuilder->saveWords();
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

    /** TASK 1: SAVE WORDS TO DATABASE **/
    public function saveWords() {

        $words = $this->getAllWordsFromCategories();
        //$this->_saveWords($words);

    }

    /** 1st step, get words **/
    protected function getAllWordsFromCategories() {

        $categories = $this->getCategories();
        $words = array();

        $nonValidCategories = $this->getInvalidCategories();
        $nonValidWords = array();

        $wiktionaryCategory = new WiktionaryCategory();

        // Retrieve valid categories
        foreach ($categories as $category) {

            $params = $this->_getParamsFromCategory($category);
            $wordsCategory = $wiktionaryCategory->getWordsCategory($params);
            Log::info(count($wordsCategory) . " words for " . $category);

            $words = array_merge($words, $wordsCategory);
        }

        // Retrieve invalid category words
        foreach ($nonValidCategories as $category) {
            $params = $this->_getParamsFromCategory($category);
            $wordsCategory = $wiktionaryCategory->getWordsCategory($params);
            Log::info(count($wordsCategory) . " words for " . $category);

            $nonValidWords = array_merge($nonValidWords, $wordsCategory);
        }

        // Remove non valid words from valid words
        $validWords = array_diff($words, $nonValidWords);

        //WordFunctions::printWords($validWords);
        echo count($validWords) . PHP_EOL;
        return $validWords;

    }

    /** 2nd step, save words **/
    public function _saveWords($words) {

        $wiktionaryLanguageSection = new WiktionaryLanguageSection();
        $params['cache'] = base_path() . "/data/" . LANGUAGE . "/htmls/";
        $wiktionaryLanguageSection->saveWordHtmlJustLanguage($words, $params);

    }

    /** AUXILIAR **/
    private function _getParamsFromCategory($category) {

        $params['category'] = $category;
        $params['cache_path'] = base_path() . "/data/" . LANGUAGE . "/categories/" . $category . ".json";
        $params['url_base'] = "http://" . LANGUAGE . ".wiktionary.org";
        $params['url_first_page'] = WIKTIONARY_CATEGORY_URL_BASE . $category;
        $params['next_page'] = WIKTIONARY_NEXT_PAGE;

        return $params;
    }

}
