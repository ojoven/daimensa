<?php

namespace App\Builder\Steps;

use Log;

use App\Builder\Wiktionary\WiktionaryCategory;
use Illuminate\Database\Eloquent\Model;
use App\Builder\FileManager;

class SaveWordList extends Model {


	/** 1st step, get words **/
	public function saveWordList($languageBuilder) {

		// First, we check if the file exists
		$nameJson = 'word_list.json';
		$pathFileWordList = base_path() . '/data/' . $languageBuilder->getLanguage() . '/jsons/' . $nameJson;
		$file = FileManager::getFile($pathFileWordList);
		if (!$file) {

			// We initialize the variables
			$words = array();
			$nonValidWords = array();

			// We get the categories (based on the language)
			$categories = $languageBuilder->getCategories();
			$nonValidCategories = $languageBuilder->getInvalidCategories();

			// We'll use WiktionaryCategoryModel to scrape all the words from these categories
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
			Log::info(count($validWords) . ' total words');

			// Ok, now we have the valid words, let's save them
			FileManager::saveFile($pathFileWordList, json_encode($validWords));

		} else {
			Log::info('The word list for ' . $languageBuilder->getLanguage() . ' is already built');
			$validWords = json_decode($file, true);
		}

		return $validWords;

	}

	private function _getParamsFromCategory($category) {

		$params['category'] = $category;
		$params['cache_path'] = base_path() . "/data/" . LANGUAGE . "/categories/" . $category . ".json";
		$params['url_base'] = 'http://' . $this->lang . '.wiktionary.org'; // We'll be using the FR version of Wiktionary as it was the first language scrapped
		$params['url_first_page'] = WIKTIONARY_CATEGORY_URL_BASE . $category;
		$params['next_page'] = WIKTIONARY_NEXT_PAGE;

		return $params;
	}

}