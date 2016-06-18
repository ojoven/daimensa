<?php

namespace App\Models;

use App\Models\Twitter\Twitter;
use Log;
use App\Models\Wiktionary\WiktionaryCategory;
use App\Models\Wiktionary\WiktionaryLanguageSection;
use Illuminate\Database\Eloquent\Model;
require_once app_path() . '/Lib/Vendor/simple_html_dom.php';
require_once base_path() . '/config/settings.php';

class Builder extends Model {

    // Build cards for a word
    public function build($task, $language) {

        switch ($task) {

            case 'save_words':
                $this->_loadConfigurationFile($language);
                $this->saveWords();
                break;
            case 'save_conjugations':
                $this->_loadConfigurationFile($language);
                // TODO: save conjugations
                break;
            case 'save_words_and_forms':
                $this->_loadConfigurationFile($language);
                // TODO: save words and forms
                break;
            case 'create_ontology':
                $this->_loadConfigurationFile($language);
                // TODO: create ontology wikipedia
                break;
            case 'save_tweets':
                $this->_loadConfigurationFile($language);
                $this->saveTweets();
                break;
        }

    }

    /** TASK 1: SAVE WORD HTMLS **/
    public function saveWords() {

        $words = $this->_getAllWordsFromCategories();
        $this->_saveWords($words);

    }

    /** 1st step, get words **/
    private function _getAllWordsFromCategories() {

        $categories = getCategories();
        $words = array();

        $nonValidCategories = getInvalidCategories();
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

    /** Further step, save twits **/
    public function saveTweets() {

        $wordListModel = new WordList();
        $words = $wordListModel->getAllFrequentWords();

        $twitterModel = new Twitter();
        $twitterModel->getTweetsForWord('maison');

    }


    /** AUXILIAR **/
    private function _loadConfigurationFile($language) {

        $path = base_path('config/builder/' . $language . "_settings.php");
        if (file_exists($path)) {
            require_once $path;
        } else {
            Log::info('You must create a {lang}_settings.php file on /config/builder/ folder');
            die();
        }

    }

    private function _getParamsFromCategory($category) {

        $params['category'] = $category;
        $params['cache_path'] = base_path() . "/data/" . LANGUAGE . "/categories/" . $category . ".json";
        $params['url_base'] = "http://" . LANGUAGE . ".wiktionary.org";
        $params['url_first_page'] = WIKTIONARY_CATEGORY_URL_BASE . $category;
        $params['next_page'] = WIKTIONARY_NEXT_PAGE;

        return $params;
    }

}
