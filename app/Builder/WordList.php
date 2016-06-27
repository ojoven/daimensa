<?php

namespace App\Builder;
use Log;

class WordList {

	// Name of the JSON generated in this step
	protected $wordListJson = 'word_list.json';
	protected $baseWordListJson = 'basewords.json';

	/** PATH WORD LIST **/
	public function getPathWordList() {

		$pathFileWordList = base_path() . '/data/' . LANGUAGE . '/jsons/' . $this->wordListJson;
		return $pathFileWordList;
	}

	/** GET WORD LIST **/
	public function getWordList() {

		// First, we check if the file exists
		$pathFileWordList = base_path() . '/data/' . LANGUAGE . '/jsons/' . $this->wordListJson;
		$file = FileManager::getFile($pathFileWordList);

		if (!$file) {
			Log::info('The word list is not generated for ' . LANGUAGE . '. Please generate it first with "php artisan builder save_word_list ' . LANGUAGE . '" command');
			die();
		} else {
			return json_decode($file, true);
		}

	}

	/** GET BASE WORD LIST **/
	public function getBaseWordList() {

		// First, we check if the file exists
		$pathFileWordList = base_path() . '/data/' . LANGUAGE . '/jsons/' . $this->baseWordListJson;
		$file = FileManager::getFile($pathFileWordList);

		if (!$file) {
			Log::info('The base word list is not generated for ' . LANGUAGE . '. Please generate it first with "php artisan builder save_word_base_list ' . LANGUAGE . '" command');
			die();
		} else {
			return json_decode($file, true);
		}

	}

}